<?php

namespace App\Http\Controllers;

use App\Models\MemberLoginDetail;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\ShopManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WebController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function shop($category_name = null, $category_id = null)
    {
        if ($category_id) {
            $category = ProductCategory::find($category_id);
            if (!$category) {
                abort(404, 'Category not found');
            }
            if ($category_name !== $category->slug) {
                return redirect()->route('shop', ['category_name' => $category->slug, 'category_id' => $category_id]);
            }
            $shopManagement = ShopManagement::where('category_id', $category_id)->get();
        } else {
            $shopManagement = ShopManagement::all();
            $category = null;
        }

        return view('pages.shop', compact('shopManagement', 'category'));
    }

    public function Product($product_name = null, $product_id = null)
    {
        if ($product_id) {
            $product = ShopManagement::with('category')->find($product_id);
            if (!$product) {
                abort(404, 'Product not found');
            }
            if ($product_name !== $product->slug) {
                return redirect()->route('product', ['product_name' => $product->slug, 'product_id' => $product_id]);
            }
            return view('pages.product', ['shopManagement' => [$product]]);
        } else {
            return redirect()->route('shop');
        }
    }

    public function myaccount()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your account');
        }

        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('pages.myAccount', compact('orders'));
    }

    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders');
        }

        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.my_orders', compact('orders'));
    }

    public function viewOrder($orderNumber)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders');
        }

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pages.order_detail', compact('order'));
    }

    public function testimonials()
    {
        return view('pages.testimonials');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'number' => 'required|numeric',
            'subject' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function track()
    {
        return view('pages.trackorder');
    }

    public function login()
    {
        return view('pages.loginpage');
    }

    public function signup()
    {
        return view('pages.signup');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:member_login_details',
            'phone_number' => 'required|digits:10|unique:member_login_details',
            'password' => 'required|string|min:8',
        ]);

        MemberLoginDetail::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
        $credentials = [$field => $request->login, 'password' => $request->password];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('myaccount')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function ReferandEarn()
    {
        return view('pages.referandearn');
    }

    public function wishlist()
    {
        return view('pages.wishlist');
    }

    public function search(Request $request)
    {
        $query = $request->input('s');
        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a search term');
        }

        $results = ShopManagement::where('product_name', 'LIKE', "%{$query}%")
            ->orWhere('product_description', 'LIKE', "%{$query}%")
            ->get();

        return view('pages.search-results', compact('results', 'query'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:member_login_details,email,' . Auth::id(),
            'phone_number' => 'required|digits:10|unique:member_login_details,phone_number,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('myaccount')->with('success', 'Profile updated successfully!');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('myaccount')->with('settings_success', 'Settings updated successfully!');
    }
}
