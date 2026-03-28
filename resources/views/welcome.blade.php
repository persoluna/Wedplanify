<x-layouts.app :transparent-nav="true">

    <!-- Hero Section -->
    <div class="relative min-h-screen w-full overflow-hidden flex items-center justify-center bg-stone-900 pt-20">
        <!-- Background with Overlay -->
        <div class="absolute inset-0 z-0">
            <img
              src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=2000&auto=format&fit=crop"
              alt="Wedding Background"
              class="w-full h-full object-cover opacity-80"
            />
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-stone-900/90"></div>
        </div>

        <!-- Particle Effect Layer -->
        <div x-data="partyBg" class="absolute inset-0 z-0 pointer-events-none opacity-60">
            <canvas x-ref="canvas" class="w-full h-full"></canvas>
        </div>

        <div class="relative z-10 text-center max-w-5xl w-full px-6">
            <div class="flex justify-center mb-8 animate-[fade-in-up_1s_ease-out]">
                <span class="inline-block py-1.5 px-4 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-white text-xs tracking-[0.25em] uppercase shadow-2xl">
                    Curated for the modern couple
                </span>
            </div>

            <h1 class="font-display text-5xl md:text-7xl lg:text-[6rem] text-white mb-12 leading-[1.05] tracking-tight animate-[fade-in-up_1.2s_ease-out]">
                Design Your <br/> <span class="italic font-serif text-champagne-300 font-light">Perfect Day</span>
            </h1>

            <!-- Hero Search Form with Alpine.js -->
            <form action="/explore" method="GET" x-data="heroSearch({{ json_encode($popularLocations) }})" class="mt-8 relative z-50 flex flex-col md:flex-row items-center justify-between bg-white/95 backdrop-blur-xl rounded-3xl md:rounded-[2rem] p-3 md:p-4 w-full max-w-4xl mx-auto shadow-2xl shadow-black/40 border border-white/20 gap-4 md:gap-0 animate-[fade-in-up_1.4s_ease-out]">

                <input type="hidden" name="city" :value="selectedLocation ? selectedLocation.split(',')[0].trim() : locationQuery">
                <input type="hidden" name="available_on" :value="isoDate">

                <!-- Location Field -->
                <div class="w-full md:flex-1 px-4 md:px-8 border-b md:border-b-0 md:border-r border-stone-200 relative group pb-4 md:pb-0">
                    <div class="flex items-center gap-3 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-champagne-500"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <label class="block text-[11px] font-bold text-stone-500 uppercase tracking-widest">Location</label>
                    </div>
                    <div class="relative pl-7">
                        <input
                            type="text"
                            x-model="locationQuery"
                            x-on:focus="showLocationDropdown = true"
                            x-on:click.outside="showLocationDropdown = false"
                            :value="selectedLocation || locationQuery"
                            @input="selectedLocation = ''; showLocationDropdown = true;"
                            placeholder="Where is your dream wedding?"
                            class="w-full text-stone-900 text-base md:text-xl font-serif bg-transparent outline-none placeholder:text-stone-300"
                        />

                        <!-- Dropdown -->
                        <div x-cloak x-show="showLocationDropdown"
                             x-transition.opacity.duration.200ms
                             class="absolute top-12 left-0 w-full md:w-[120%] bg-white rounded-2xl shadow-2xl border border-stone-100 overflow-hidden pb-2 z-50 max-h-64 overflow-y-auto">

                            <div class="px-5 py-3 text-[10px] font-bold uppercase text-stone-500 tracking-wider bg-white/95 backdrop-blur sticky top-0 z-10 flex justify-between items-center border-b border-stone-100">
                                <span x-text="locationQuery.length >= 3 ? 'Search Results' : 'Popular Destinations'"></span>
                                <svg x-cloak x-show="isSearching" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="animate-spin text-champagne-500"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                            </div>

                            <template x-if="displayLocations.length > 0">
                                <div>
                                    <template x-for="loc in displayLocations" :key="loc">
                                        <div @click="selectedLocation = loc; locationQuery = loc; showLocationDropdown = false"
                                             class="px-5 py-3.5 hover:bg-champagne-50 cursor-pointer flex items-center gap-3 text-stone-700 hover:text-stone-900 transition-colors border-b border-stone-50 last:border-0">
                                            <div class="bg-champagne-100 p-2 rounded-full text-champagne-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                            </div>
                                            <span class="font-medium text-sm md:text-base truncate" x-text="loc"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <template x-if="displayLocations.length === 0">
                                <div class="px-5 py-4 text-sm text-stone-400 italic text-center">
                                    <span x-text="isSearching ? 'Finding locations...' : 'No locations found'"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Date Picker Field -->
                <div class="w-full md:flex-1 px-4 md:px-8 relative group pb-2 md:pb-0" x-on:click.outside="showDatePicker = false">
                    <div class="flex items-center gap-3 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-champagne-500"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <label class="block text-[11px] font-bold text-stone-500 uppercase tracking-widest">Date</label>
                    </div>
                    <div class="relative pl-7 cursor-pointer" @click="showDatePicker = !showDatePicker">
                        <input
                            type="text"
                            readonly
                            :value="formattedDate"
                            placeholder="When is the big day?"
                            class="w-full text-stone-900 text-base md:text-xl font-serif bg-transparent outline-none placeholder:text-stone-300 cursor-pointer truncate"
                        />
                    </div>

                    <!-- Date Dropdown -->
                    <div x-cloak x-show="showDatePicker"
                         x-transition.opacity.duration.200ms
                         class="absolute top-14 left-0 md:left-1/2 md:-translate-x-1/2 w-full md:w-[340px] bg-white rounded-3xl shadow-2xl border border-stone-100 p-6 z-50">
                        <div class="flex justify-between items-center mb-6">
                            <button type="button" @click.stop="currentMonth--" class="p-2 hover:bg-stone-100 rounded-full transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-stone-600"><path d="m15 18-6-6 6-6"/></button>
                            <span class="font-serif text-lg font-medium text-stone-900" x-text="months[realMonthIndex] + ' ' + realYear"></span>
                            <button type="button" @click.stop="currentMonth++" class="p-2 hover:bg-stone-100 rounded-full transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-stone-600"><path d="m9 18 6-6-6-6"/></button>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-3">
                            <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center">
                            <template x-for="i in Array.from({ length: firstDayOfMonth })">
                                <div></div>
                            </template>
                            <template x-for="d in Array.from({ length: daysInMonth }, (_, i) => i + 1)">
                                <button type="button"
                                    @click.stop="handleDateSelect(d)"
                                    :class="(date && date.getDate() === d && date.getMonth() === realMonthIndex && date.getFullYear() === realYear) ? 'bg-stone-900 text-white shadow-lg shadow-stone-900/30 scale-110' : 'hover:bg-champagne-100 text-stone-700 hover:text-stone-900'"
                                    class="w-9 h-9 mx-auto rounded-full flex items-center justify-center text-sm font-medium transition-all duration-300"
                                    x-text="d">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full md:w-16 md:h-16 bg-stone-900 hover:bg-stone-800 text-white py-4 md:p-0 rounded-2xl md:rounded-full transition-all duration-300 hover:scale-105 flex items-center justify-center gap-3 shadow-xl shadow-stone-900/20 mt-2 md:mt-0 shrink-0">
                    <span class="md:hidden font-bold tracking-widest uppercase text-sm">Search</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
            </form>

            <div class="mt-12 flex flex-col md:flex-row items-center justify-center gap-4 md:gap-8 text-white/80 text-sm font-medium animate-[fade-in-up_1.6s_ease-out]">
                <span class="flex items-center gap-2 bg-white/5 backdrop-blur-sm px-4 py-2 rounded-full border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-champagne-400"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                    Verified Agencies
                </span>
                <span class="flex items-center gap-2 bg-white/5 backdrop-blur-sm px-4 py-2 rounded-full border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-champagne-400"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                    Best Price Guarantee
                </span>
            </div>
        </div>
    </div>

    <!-- Featured Collections List -->
    <div class="py-32 bg-stone-50  transition-colors">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="max-w-xl">
                    <h2 class="font-display text-4xl md:text-5xl text-stone-900  mb-4 leading-tight">Featured Collections</h2>
                    <p class="text-stone-500  font-light text-lg">Handpicked by our editorial team to ensure your day is nothing short of extraordinary.</p>
                </div>
                <a href="/explore" class="group flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-900  hover:text-champagne-600 :text-champagne-400 transition-colors">
                    <span>View All</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($featuredVendors ?? [] as $vendor)
                    <a href="/listing/vendor/{{ $vendor->slug }}" class="group relative bg-white  rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-stone-200/50 :shadow-none transition-all duration-500 cursor-pointer border border-stone-100  block">
                        <div class="relative aspect-4/5 overflow-hidden">
                            @php
                                $thumb = null;
                                if (!empty($vendor->banner)) {
                                    $thumb = asset('storage/' . $vendor->banner);
                                } elseif (!empty($vendor->logo)) {
                                    $thumb = asset('storage/' . $vendor->logo);
                                } elseif ($vendor->hasMedia('gallery')) {
                                    $thumb = $vendor->getFirstMediaUrl('gallery');
                                } elseif ($vendor->hasMedia('avatar')) {
                                    $thumb = $vendor->getFirstMediaUrl('avatar');
                                }

                                if (!$thumb) {
                                    $thumb = "https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=800&auto=format&fit=crop";
                                }
                            @endphp
                            <img src="{{ $thumb }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $vendor->business_name }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-60 transition-opacity group-hover:opacity-70"></div>

                            <!-- Alpine Save Button -->
                            <div role="button" @click.prevent="$store.savedListings.toggle({
                                    id: '{{ $vendor->id }}',
                                    type: 'vendor',
                                    title: @js($vendor->business_name),
                                    image: @js($thumb),
                                    location: @js($vendor->city . ', ' . ($vendor->country ?? 'US')),
                                    rating: @js(number_format($vendor->avg_rating ?? 5.0, 1)),
                                    reviews: @js($vendor->review_count ?? 12),
                                    slug: @js($vendor->slug)
                                })"
                                class="absolute top-4 right-4 p-2.5 rounded-full backdrop-blur-md shadow-sm transition-all duration-300 z-10"
                                :class="$store.savedListings.has('{{ $vendor->id }}', 'vendor') ? 'bg-rose-50 border border-rose-200 text-rose-500' : 'bg-white/20 border border-white/40 text-white hover:text-rose-500 hover:bg-white'"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    :fill="$store.savedListings.has('{{ $vendor->id }}', 'vendor') ? 'currentColor' : 'none'"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                </svg>
                            </div>

                            <div class="absolute bottom-6 left-6 right-6">
                                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-white text-[10px] font-bold tracking-widest uppercase mb-3">
                                    {{ $vendor->category->name ?? 'Vendor' }}
                                </span>
                                <h3 class="font-serif text-3xl text-white mb-1">{{ $vendor->business_name }}</h3>
                                <p class="text-stone-200 text-sm font-light flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $vendor->city }}, {{ $vendor->country }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    @for($i = 0; $i < 3; $i++)
                        <div class="group relative bg-white  rounded-3xl overflow-hidden shadow-sm border border-stone-100 ">
                            <div class="relative aspect-[4/5] overflow-hidden bg-stone-200">
                                <img src="https://images.unsplash.com/photo-[something]?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover opacity-50" />
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>

    <!-- CTA Join Registry -->
    <div class="bg-stone-900 py-40 text-center text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1511285560982-1351cdeb9821?auto=format&fit=crop&q=80" class="w-full h-full object-cover grayscale" />
            <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-transparent to-stone-900"></div>
        </div>
        <div class="relative z-10 px-6 max-w-3xl mx-auto">
            <span class="inline-block py-1 px-4 rounded-full border border-champagne-500/30 text-champagne-400 text-[10px] tracking-[0.25em] uppercase mb-8">For Professionals</span>
            <h2 class="font-display text-5xl md:text-6xl mb-8 leading-tight">Join the Registry</h2>
            <p class="text-stone-300 mx-auto mb-12 font-light text-xl leading-relaxed">Are you a wedding professional? Apply to join our curated network of top-tier agencies and creatives.</p>
            <button class="bg-white text-stone-900 px-10 py-4 rounded-full font-bold tracking-widest uppercase text-sm hover:bg-champagne-100 transition-all duration-300 shadow-2xl hover:scale-105">Apply Now</button>
        </div>
    </div>

</x-layouts.app>
