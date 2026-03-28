<?php

use App\Models\Vendor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Fetch top 3 featured vendors (or most reviewed/recent)
    $featuredVendors = Vendor::with(['media', 'category'])
        ->where('featured', true)
        ->orWhere('premium', true)
        ->inRandomOrder()
        ->take(3)
        ->get();

    // If we don't have featured, just grab top 3
    if ($featuredVendors->isEmpty()) {
        $featuredVendors = Vendor::with(['media', 'category'])
            ->latest()
            ->take(3)
            ->get();
    }

    $popularLocations = \App\Models\Vendor::select('city')
        ->whereNotNull('city')
        ->distinct()
        ->limit(20)
        ->pluck('city')
        ->map(fn($city) => $city . ', US') // Assuming US context, or leave empty. Can adjust based on real data
        ->toArray();
    return view('welcome', compact('featuredVendors', 'popularLocations'));
})->name('home');
use App\Http\Controllers\ExploreController;
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
use App\Http\Controllers\ListingController;
Route::get('/listing/{type}/{slug}', [ListingController::class, 'show'])->name('listing.show');
use App\Http\Controllers\InquiryController;
Route::post('/listing/{type}/{id}/inquire', [InquiryController::class, 'store'])->name('inquiry.store');

use App\Http\Controllers\AuthController;
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

use App\Http\Controllers\ClientController;
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
});

// Move Saved to essentially be public so LocalStorage can power it for guests as well
Route::get('/saved', function () {
    return view('client.saved');
})->name('saved.index');
