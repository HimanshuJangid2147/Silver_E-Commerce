<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShopManagement;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EcommerceController extends Controller
{
    public function cart()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        $total = $subtotal;

        return view('pages.myCart', compact('cart', 'subtotal', 'total'));
    }

    public function addToCart(Request $request, $product_id)
    {
        $product = ShopManagement::find($product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += 1;
        } else {
            $images = json_decode($product->product_image ?? '[]', true);
            $display_image = !empty($images) && is_array($images) ? $images[0] : 'images/no-image.jpg';

            $cart[$product_id] = [
                'id' => $product->product_id,
                'name' => $product->product_name,
                'price' => $product->product_ammount,
                'discount' => $product->discount,
                'quantity' => 1,
                'image' => $display_image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request, $product_id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] = $request->quantity;
            if ($cart[$product_id]['quantity'] <= 0) {
                unset($cart[$product_id]);
            }
            session()->put('cart', $cart);
            return redirect()->route('cart')->with('success', 'Cart updated successfully!');
        }

        return redirect()->route('cart')->with('error', 'Product not found in cart.');
    }

    public function removeFromCart($product_id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
            return redirect()->route('cart')->with('success', 'Product removed from cart successfully!');
        }

        return redirect()->route('cart')->with('error', 'Product not found in cart.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Add some products before checkout.');
        }

        $subtotal = $this->calculateSubtotal($cart);
        $appliedCoupon = session()->get('applied_coupon');
        $couponDiscount = $appliedCoupon ? $this->getCouponDiscount($subtotal) : 0;
        $total = $subtotal - $couponDiscount;

        return view('pages.checkout', compact('cart', 'subtotal', 'couponDiscount', 'total', 'appliedCoupon'));
    }

    public function applyCoupon(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('checkout')->with('coupon_error', 'Your cart is empty.');
        }

        $couponCode = $request->input('coupon_code');
        if (empty($couponCode)) {
            return redirect()->route('checkout')->with('coupon_error', 'Please enter a coupon code.');
        }

        $coupon = Coupon::where('coupon_code', $couponCode)
            ->where('coupon_status', 'Active')
            ->where('start_date', '<=', now())
            ->where('exp_date', '>=', now())
            ->first();

        if (!$coupon) {
            session()->forget('applied_coupon');
            return redirect()->route('checkout')->with('coupon_error', 'Invalid or expired coupon code.');
        }

        $subtotal = $this->calculateSubtotal($cart);
        if ($subtotal < $coupon->min_purchase_amount) {
            session()->forget('applied_coupon');
            return redirect()->route('checkout')->with('coupon_error', 'Minimum purchase amount of ₹' . number_format($coupon->min_purchase_amount, 2) . ' required.');
        }

        $couponDiscount = $this->calculateCouponDiscount($coupon, $subtotal);
        session()->put('applied_coupon', [
            'id' => $coupon->coupon_id,
            'code' => $coupon->coupon_code,
            'type' => $coupon->coupon_type,
            'discount_value' => $coupon->coupon_discount_value,
            'discount_amount' => $couponDiscount,
        ]);

        return redirect()->route('checkout')->with('coupon_success', 'Coupon "' . $coupon->coupon_code . '" applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        return redirect()->route('checkout')->with('coupon_success', 'Coupon removed successfully!');
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'payment_method' => 'required|in:cod,online',
            'notes' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->calculateSubtotal($cart);
        $couponDiscount = $this->getCouponDiscount($subtotal);
        $shipping = 0;
        $total = $subtotal - $couponDiscount + $shipping;

        $order = new Order();
        $order->order_number = 'ORD-' . strtoupper(Str::random(10));
        $order->user_id = Auth::id() ?? null;
        $order->first_name = $validated['first_name'];
        $order->last_name = $validated['last_name'];
        $order->email = $validated['email'];
        $order->phone = $validated['phone'];
        $order->address = $validated['address'];
        $order->city = $validated['city'];
        $order->zip = $validated['zip'];
        $order->notes = $validated['notes'];
        $order->subtotal = $subtotal;
        $order->shipping = $shipping;
        $order->discount = $couponDiscount;
        $order->total = $total;
        $order->payment_method = $validated['payment_method'];
        $order->payment_status = 'pending';
        $order->order_status = 'pending';
        $order->save();

        foreach ($cart as $product_id => $item) {
            $price = $item['price'];
            $discount = $item['discount'];
            $discounted_price = $price - ($price * $discount / 100);
            $item_total = $discounted_price * $item['quantity'];

            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product_id;
            $orderItem->product_name = $item['name'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $price;
            $orderItem->discount = $discount;
            $orderItem->total = $item_total;
            $orderItem->save();
        }

        session()->forget('cart');
        session()->forget('applied_coupon');

        return redirect()->route('order.confirmation', $order->order_number)
            ->with('success', 'Your order has been placed successfully!');
    }

    public function orderConfirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('pages.order_confirmation', compact('order'));
    }

    public function processPayment($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $order->payment_status = 'paid';
        $order->save();

        session()->forget('cart');
        return redirect()->route('order.confirmation', $order->order_number)
            ->with('success', 'Payment successful! Your order has been placed.');
    }

    private function calculateSubtotal($cart)
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $price = $item['price'];
            $discount = $item['discount'];
            $discounted_price = $price - ($price * $discount / 100);
            $subtotal += $discounted_price * $item['quantity'];
        }
        return $subtotal;
    }

    private function calculateCouponDiscount($coupon, $subtotal)
    {
        $discount = 0;
        // If coupon type is empty or invalid, default to using the fixed amount directly
        if (empty($coupon->coupon_type) || !in_array($coupon->coupon_type, ['Percentage', 'Fixed Amount', 'Free Shipping', 'Bonus'])) {
            // Use the discount_value directly as the discount amount
            $discount = min($coupon->coupon_discount_value, $subtotal);
        } elseif ($coupon->coupon_type === 'Percentage') {
            $discount = $subtotal * ($coupon->coupon_discount_value / 100);
        } elseif ($coupon->coupon_type === 'Fixed Amount') {
            $discount = min($coupon->coupon_discount_value, $subtotal);
        }
        return $discount;
    }

    private function getCouponDiscount($subtotal)
    {
        $appliedCoupon = session()->get('applied_coupon');
        if (!$appliedCoupon || !isset($appliedCoupon['id'])) {
            return 0;
        }

        // If we have a direct discount_amount already calculated, use it
        if (isset($appliedCoupon['discount_amount']) && $appliedCoupon['discount_amount'] > 0) {
            return $appliedCoupon['discount_amount'];
        }

        // Otherwise, find the coupon and calculate
        $coupon = Coupon::find($appliedCoupon['id']);
        if (!$coupon || $coupon->coupon_status !== 'Active' || $subtotal < $coupon->min_purchase_amount) {
            session()->forget('applied_coupon');
            return 0;
        }

        return $this->calculateCouponDiscount($coupon, $subtotal);
    }
}
