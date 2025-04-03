<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string'
        ]);

        // Use a database transaction to ensure single entry
        DB::beginTransaction();
        try {
            // Check if an identical enquiry already exists within the last 5 minutes
            $existingEnquiry = Enquiry::where([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'subject' => $validatedData['subject']
            ])->where('created_at', '>=', now()->subMinutes(5))->first();

            if ($existingEnquiry) {
                DB::rollBack();
                return redirect()->back()->with('error', 'You have already submitted a similar enquiry recently. Please wait before submitting again.');
            }

            // Create a new enquiry
            $enquiry = Enquiry::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'subject' => $validatedData['subject'],
                'message' => $validatedData['message'] ?? null,
                'is_read' => false
            ]);

            DB::commit();
            $request->session()->flash('success', 'Your enquiry has been submitted successfully. We will get back to you soon!');

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while submitting your enquiry. Please try again.');
        }
    }
}
