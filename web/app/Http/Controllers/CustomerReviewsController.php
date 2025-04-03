<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class CustomerReviewsController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'review_title' => 'required|string|max:255',
            'customer_review' => 'required|string',
            'customer_ratings' => 'required|numeric|min:1|max:5',
            'product_id' => 'required|exists:product,product_id', // Updated to match the product table
        ]);

        try {
            // Create a new customer review
            $review = new CustomerReview();
            $review->customer_name = $request->customer_name;
            $review->customer_email = $request->customer_email;
            $review->review_title = $request->review_title;
            $review->customer_review = $request->customer_review;
            $review->customer_ratings = $request->customer_ratings;
            $review->product_id = $request->product_id;
            $review->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you! Your review has been submitted successfully.',
                ]);
            }

            return redirect()->back()->with('success', 'Thank you! Your review has been submitted successfully.');
        } catch (\Exception $e) {Log::error('Review submission error: ' . $e->getMessage() . ' | Stack trace: ' . $e->getTraceAsString());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting the review: ' . $e->getMessage(),
                ]);
            }

            return redirect()->back()->with('error', 'An error occurred while submitting the review: ' . $e->getMessage());
        }
    }

    public function getProductReviews($productId)
    {
        $reviews = CustomerReview::where('product_id', $productId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'reviews' => $reviews,
            'count' => $reviews->count(),
        ]);
    }

    public function show($productId)
{
    $shopManagement = \App\Models\ShopManagement::where('product_id', $productId)->get();
    $customerreviews = \App\Models\CustomerReview::where('product_id', $productId)->get();
    return view('your-view-name', compact('shopManagement', 'customerreviews'));
}
}
