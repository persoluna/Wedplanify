<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Vendor;
use App\Models\Agency;

class InquiryController extends Controller
{
    public function store(Request $request, $type, $id)
    {
        // Enforce Authentication
        if (!auth()->check() || !auth()->user()->isClient()) {
            return back()->with('error', 'You must be logged in as a client to send an inquiry.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'event_date' => 'nullable|date',
            'event_location' => 'nullable|string|max:255',
            'guest_count' => 'nullable|integer|min:1',
            'message' => 'required|string',
        ]);

        $inquiry = new Inquiry();
        $inquiry->name = $validated['name'];
        $inquiry->email = $validated['email'];
        $inquiry->phone = $validated['phone'] ?? null;
        $inquiry->event_date = $validated['event_date'] ?? null;
        $inquiry->event_location = $validated['event_location'] ?? null;
        $inquiry->guest_count = $validated['guest_count'] ?? null;
        $inquiry->message = $validated['message'];
        $inquiry->status = 'new';
        $inquiry->source = 'Website Profile';

        // Connect Client ID
        if ($client = auth()->user()->client) {
            $inquiry->client_id = $client->id;
        } else {
            $client = auth()->user()->client()->create();
            $inquiry->client_id = $client->id;
        }

        if ($type === 'vendor') {
            $inquiry->vendor_id = $id;
        } else if ($type === 'agency') {
            $inquiry->agency_id = $id;
        }

        $inquiry->save();

        return back()->with('success', 'Your inquiry has been successfully sent!');
    }
}
