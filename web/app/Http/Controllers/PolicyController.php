<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy; // Assuming your model is named Policy

class PolicyController extends Controller
{
    public function show($policy)
    {
        // Map URL slugs to database column names
        $policyMap = [
            'about-us' => 'about_us',
            'privacy-policy' => 'privacy_policy',
            'terms-and-conditions' => 'terms_and_conditions',
            'shipping-and-return' => 'shipping_and_return',
            'refund-policy' => 'refund_policy',
            'contact-us' => 'contact_us',
        ];

        // Check if the policy slug exists in the map
        if (!array_key_exists($policy, $policyMap)) {
            abort(404); // Return a 404 error if the policy doesn't exist
        }

        // Get the corresponding column name
        $column = $policyMap[$policy];

        // Fetch the policy record (assuming there's only one record in the table)
        $policyData = Policy::first();

        if (!$policyData) {
            abort(404); // Return a 404 error if no data is found
        }

        // Get the content of the requested field
        $content = $policyData->$column;

        // Pass the content and the policy name to the view
        return view('policies.show', [
            'content' => $content,
            'policyName' => str_replace('-', ' ', $policy), // For display purposes (e.g., "about us")
        ]);
    }
}
