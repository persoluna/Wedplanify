<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Vendor;

class ListingController extends Controller
{
    public function show($type, $slug)
    {
        if ($type === 'vendor') {
            $listing = Vendor::with(['media', 'category', 'tags', 'reviews.client.user', 'availabilities'])
                ->where('slug', $slug)
                ->firstOrFail();
            $listing->listing_type = 'vendor';
        } else if ($type === 'agency') {
            $listing = Agency::with(['media', 'tags', 'reviews.client.user'])
                ->where('slug', $slug)
                ->firstOrFail();
            $listing->listing_type = 'agency';
        } else {
            abort(404);
        }

        return view('listing.show', compact('listing'));
    }
}
