<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Vendor;

class ListingController extends Controller
{
    public function show($type, $slug)
    {
        if ($type === 'vendor') {
            $listing = Vendor::with([
                'media', 'category', 'tags', 'reviews.client.user', 'availabilities',
                'bookings' => fn($q) => $q->whereIn('status', ['confirmed', 'completed']),
                'inquiries' => fn($q) => $q->where('status', 'booked')->whereNotNull('event_date')
            ])
                ->where('slug', $slug)
                ->firstOrFail();
            $listing->listing_type = 'vendor';
        } else if ($type === 'agency') {
            $listing = Agency::with([
                'media', 'tags', 'reviews.client.user',
                'bookings' => fn($q) => $q->whereIn('status', ['confirmed', 'completed']),
                'inquiries' => fn($q) => $q->where('status', 'booked')->whereNotNull('event_date')
            ])
                ->where('slug', $slug)
                ->firstOrFail();
            $listing->listing_type = 'agency';
        } else {
            abort(404);
        }

        // Build combined availability array for the calendar
        $availabilities = [];

        // 1. Add explicitly set vendor availabilities
        if ($listing->listing_type === 'vendor' && $listing->availabilities) {
            foreach ($listing->availabilities as $av) {
                $availabilities[$av->date->toDateString()] = [
                    'date' => $av->date->toDateString(),
                    'status' => $av->status,
                ];
            }
        }

        // 2. Add Bookings (MorphMany)
        if ($listing->bookings) {
            foreach ($listing->bookings as $booking) {
                $availabilities[$booking->event_date->toDateString()] = [
                    'date' => $booking->event_date->toDateString(),
                    'status' => 'fully_booked',
                ];
            }
        }

        // 3. Add Inquiries that are 'booked'
        if ($listing->inquiries) {
            foreach ($listing->inquiries as $inquiry) {
                $availabilities[$inquiry->event_date->toDateString()] = [
                    'date' => $inquiry->event_date->toDateString(),
                    'status' => 'fully_booked',
                ];
            }
        }

        $listing->mapped_availabilities = array_values($availabilities);

        return view('listing.show', compact('listing'));
    }
}
