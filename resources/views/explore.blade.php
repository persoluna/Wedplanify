<x-layouts.app title="Explore - Nuptial">
    <div class="bg-stone-50 min-h-screen pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-serif text-navy-900 mb-8">Explore Vendors & Agencies</h1>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="w-full lg:w-1/4">
                    <form method="GET" action="{{ route('explore') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 sticky top-24" id="filter-form">
                        <h2 class="text-lg font-medium text-navy-900 mb-6 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="21" y2="14"/><line x1="4" x2="20" y1="10" y2="3"/><line x1="12" x2="12" y1="21" y2="12"/><line x1="12" x2="12" y1="8" y2="3"/><path d="M15 14h6"/><path d="M15 10h6"/></svg>
                            Filters
                        </h2>

                        <div class="space-y-6">
                            <!-- Type Filter -->
                            <div>
                                <label class="block text-sm font-medium text-stone-700 mb-2">Listing Type</label>
                                <select name="type" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500 transition-colors" onchange="document.getElementById('filter-form').submit()">
                                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Listings</option>
                                    <option value="vendor" {{ request('type') == 'vendor' ? 'selected' : '' }}>Vendors Only</option>
                                    <option value="agency" {{ request('type') == 'agency' ? 'selected' : '' }}>Agencies Only</option>
                                </select>
                            </div>

                            <!-- Search Filter -->
                            <div>
                                <label class="block text-sm font-medium text-stone-700 mb-2">Search Name</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="e.g. Dream Weddings" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500 transition-colors" onblur="document.getElementById('filter-form').submit()">
                            </div>

                            <!-- City Filter -->
                            <div>
                                <label class="block text-sm font-medium text-stone-700 mb-2">City</label>
                                <input type="text" name="city" value="{{ request('city') }}" placeholder="Any location..." class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500 transition-colors" onblur="document.getElementById('filter-form').submit()">
                            </div>

                            @if(request('type') !== 'agency')
                            <!-- Category Filter (Vendors Only) -->
                            <div>
                                <label class="block text-sm font-medium text-stone-700 mb-2">Category</label>
                                <select name="category_id" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500 transition-colors" onchange="document.getElementById('filter-form').submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="pt-4 border-t border-stone-100">
                                <a href="{{ route('explore') }}" class="text-sm text-champagne-700 hover:text-champagne-800 transition-colors block text-center">Clear Filters</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Main Content Grid -->
                <div class="w-full lg:w-3/4">
                    <div class="mb-4 flex justify-between items-end">
                        <p class="text-stone-500">{{ $listings->total() }} results found</p>
                    </div>

                    @if($listings->isEmpty())
                        <div class="bg-white rounded-2xl p-12 text-center border border-stone-200">
                            <p class="text-stone-500 mb-4">No listings found matching your exact criteria.</p>
                            <a href="{{ route('explore') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full text-white bg-navy-900 hover:bg-navy-800 transition-all font-medium">Reset Search</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($listings as $listing)
                                <a href="{{ url('listing/' . $listing->listing_type . '/' . $listing->slug) }}" class="group block h-full">
                                    <div class="bg-white rounded-2xl overflow-hidden border border-stone-200 hover:border-champagne-300 transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1 h-full flex flex-col">
                                        <div class="relative h-48 sm:h-56 bg-stone-100 overflow-hidden">
                                            @php
                                                $imageUrl = null;
                                                if (!empty($listing->logo)) {
                                                    $imageUrl = asset('storage/' . $listing->logo);
                                                } elseif ($listing->hasMedia('logo')) {
                                                    $imageUrl = $listing->getFirstMediaUrl('logo');
                                                } elseif ($listing->hasMedia('avatar')) {
                                                    $imageUrl = $listing->getFirstMediaUrl('avatar');
                                                }

                                                if (!$imageUrl) {
                                                    $imageUrl = "https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=600";
                                                }
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $listing->business_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />

                                            <!-- Featured/Type Badges -->
                                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                                @if($listing->featured || $listing->premium)
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-champagne-500 text-white shadow-sm backdrop-blur-sm">
                                                        <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                                                        Featured
                                                    </span>
                                                @endif
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-black/60 text-white backdrop-blur-md">
                                                    {{ ucfirst($listing->listing_type) }}
                                                </span>
                                            </div>

                                            <!-- Alpine Save Button -->
                                            <div role="button" @click.prevent="$store.savedListings.toggle({
                                                    id: '{{ $listing->id }}',
                                                    type: '{{ $listing->listing_type }}',
                                                    title: @js($listing->business_name),
                                                    image: @js($imageUrl),
                                                    location: @js($listing->city . ', ' . ($listing->state ?? 'NY')),
                                                    rating: @js(number_format($listing->avg_rating ?? 5.0, 1)),
                                                    reviews: @js($listing->review_count ?? 12),
                                                    slug: @js($listing->slug)
                                                })"
                                                class="absolute top-4 right-4 p-2.5 rounded-full backdrop-blur-md shadow-sm transition-all duration-300 z-10"
                                                :class="$store.savedListings.has('{{ $listing->id }}', '{{ $listing->listing_type }}') ? 'bg-rose-50 border border-rose-200 text-rose-500' : 'bg-white/80 border border-white/40 text-stone-400 hover:text-rose-500 hover:bg-white'"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                                    :fill="$store.savedListings.has('{{ $listing->id }}', '{{ $listing->listing_type }}') ? 'currentColor' : 'none'"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="p-6 flex flex-col flex-grow">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="text-xl font-semibold text-navy-900 group-hover:text-champagne-700 transition-colors line-clamp-1 border-b border-transparent">
                                                    {{ $listing->business_name }}
                                                </h3>
                                                <div class="flex items-center bg-stone-50 px-2 py-1 rounded-lg">
                                                    <svg class="w-4 h-4 text-champagne-500 fill-champagne-500 mr-1" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                                    <span class="text-sm font-bold text-navy-900">{{ number_format($listing->avg_rating ?? 5.0, 1) }}</span>
                                                </div>
                                            </div>
                                            <p class="text-stone-500 text-sm mb-4 flex items-center gap-1.5 line-clamp-1">
                                                <svg class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                {{ $listing->city }}, {{ $listing->state ?? 'NY' }}
                                            </p>

                                            <div class="mt-auto pt-4 border-t border-stone-100 flex items-center justify-between">
                                                <div class="text-sm text-stone-500 line-clamp-1">
                                                    @if($listing->listing_type === 'vendor')
                                                        <span class="text-xs text-stone-400 block mb-0.5">Category</span>
                                                        <span class="font-medium text-navy-900">{{ $listing->category->name ?? 'Service' }}</span>
                                                    @else
                                                        <span class="text-xs text-stone-400 block mb-0.5">Rating</span>
                                                        <span class="font-medium text-navy-900">{{ $listing->review_count ?? 12 }} Reviews</span>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    @if($listing->listing_type === 'vendor' && $listing->min_price)
                                                        <span class="text-xs text-stone-400 block mb-0.5">Starting at</span>
                                                        <span class="font-medium text-champagne-600">${{ number_format($listing->min_price) }}</span>
                                                    @else
                                                        <span class="inline-flex items-center justify-center p-2 rounded-full bg-stone-50 text-stone-400 group-hover:bg-champagne-500 group-hover:text-white transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $listings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
