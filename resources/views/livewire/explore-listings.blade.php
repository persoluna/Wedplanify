<div class="bg-[#FAF9F7] min-h-screen pt-[100px] pb-20" x-data="{ quickView: null, mobileFiltersOpen: false }">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 lg:mb-12 gap-6 border-b border-black/5 pb-8">
            <div class="max-w-2xl">
                <h1 class="text-5xl md:text-6xl font-display text-navy-900 mb-4 tracking-tight leading-tight">Explore the Registry</h1>
                <p class="text-lg text-black/60 font-sans font-light">Curated professionals and agencies to realize your vision.</p>
            </div>
            <div class="flex items-center justify-between w-full md:w-auto gap-4">
                <p class="text-sm font-medium text-black/40 uppercase tracking-widest">{{ $listings->total() }} Curated Results</p>
                <!-- Mobile Filter Trigger -->
                <button @click="mobileFiltersOpen = true" class="lg:hidden flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-black/10 text-sm font-medium shadow-sm hover:shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    Filters
                </button>
            </div>
        </div>

        <!-- Backdrop for Mobile Filters -->
        <div x-show="mobileFiltersOpen" x-transition.opacity class="fixed inset-0 bg-navy-950/80 backdrop-blur-sm z-40 lg:hidden" @click="mobileFiltersOpen = false"></div>

        <div class="flex flex-col lg:flex-row gap-12 relative">
            <!-- LEFT: Sticky Sidebar (Desktop) / Drawer (Mobile) -->
            <aside class="fixed inset-y-0 left-0 z-50 w-[90%] max-w-sm bg-bg-primary shadow-2xl p-6 lg:p-0 lg:shadow-none lg:bg-transparent lg:sticky lg:top-28 h-full lg:h-fit overflow-y-auto lg:overflow-visible transition-transform duration-300 ease-in-out lg:translate-x-0 lg:flex flex-col gap-8"
                   :class="mobileFiltersOpen ? 'translate-x-0' : '-translate-x-full'">

                <div class="flex justify-between items-center lg:hidden mb-6">
                    <h2 class="font-display text-2xl text-navy-900">Filters</h2>
                    <button @click="mobileFiltersOpen = false" class="p-2 bg-white rounded-full shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Search -->
                <div class="group relative">
                    <input type="text" wire:model.live.debounce.400ms="search" placeholder="Search by name..." class="input-editorial w-full bg-transparent border-0 border-b border-black/10 px-0 py-3 text-navy-900 placeholder:text-black/30 focus:ring-0 focus:border-champagne-400 transition-colors duration-300 font-medium">
                    <svg class="absolute right-0 top-3.5 h-5 w-5 text-black/20 group-focus-within:text-champagne-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <!-- Location -->
                <div class="group relative">
                    <input type="text" wire:model.live.debounce.400ms="city" placeholder="Location..." class="input-editorial w-full bg-transparent border-0 border-b border-black/10 px-0 py-3 text-navy-900 placeholder:text-black/30 focus:ring-0 focus:border-champagne-400 transition-colors duration-300 font-medium">
                </div>

                <!-- Accordion Filters -->
                <div class="flex flex-col gap-2" x-data="{ expanded: 'category' }">

                    <!-- Category -->
                    <div class="border-b border-black/5">
                        <button @click="expanded = expanded === 'category' ? null : 'category'" class="w-full flex items-center justify-between py-4 text-left">
                            <span class="text-xs font-bold tracking-widest uppercase text-navy-900">Category</span>
                            <svg class="h-4 w-4 text-black/40 transition-transform duration-300" :class="expanded === 'category' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="expanded === 'category'" x-transition class="pb-4">
                            <select wire:model.live="category_id" class="w-full bg-[#f4f2ee] border-transparent rounded-xl focus:ring-0 focus:border-champagne-400 text-sm text-black/70 py-3 px-4 cursor-pointer">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="border-b border-black/5">
                        <button @click="expanded = expanded === 'type' ? null : 'type'" class="w-full flex items-center justify-between py-4 text-left">
                            <span class="text-xs font-bold tracking-widest uppercase text-navy-900">Listing Type</span>
                            <svg class="h-4 w-4 text-black/40 transition-transform duration-300" :class="expanded === 'type' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="expanded === 'type'" x-transition class="pb-4 flex flex-col gap-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" wire:model.live="type" value="all" class="text-champagne-500 focus:ring-champagne-400 border-black/20 bg-transparent rounded-full h-4 w-4">
                                <span class="text-sm font-medium text-black/70 group-hover:text-navy-900">All Listings</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" wire:model.live="type" value="vendor" class="text-champagne-500 focus:ring-champagne-400 border-black/20 bg-transparent rounded-full h-4 w-4">
                                <span class="text-sm font-medium text-black/70 group-hover:text-navy-900">Vendors</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" wire:model.live="type" value="agency" class="text-champagne-500 focus:ring-champagne-400 border-black/20 bg-transparent rounded-full h-4 w-4">
                                <span class="text-sm font-medium text-black/70 group-hover:text-navy-900">Agencies</span>
                            </label>
                        </div>
                    </div>

                    <!-- Style Tier -->
                    <div class="border-b border-black/5">
                        <button @click="expanded = expanded === 'style' ? null : 'style'" class="w-full flex items-center justify-between py-4 text-left">
                            <span class="text-xs font-bold tracking-widest uppercase text-navy-900">Aesthetic Style</span>
                            <svg class="h-4 w-4 text-black/40 transition-transform duration-300" :class="expanded === 'style' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="expanded === 'style'" x-transition class="pb-4 flex flex-wrap gap-2">
                            <button class="px-4 py-2 rounded-full border border-black/10 text-xs font-medium text-black/60 hover:border-champagne-400 hover:text-champagne-600 transition-colors">Modern</button>
                            <button class="px-4 py-2 rounded-full border border-black/10 text-xs font-medium text-black/60 hover:border-champagne-400 hover:text-champagne-600 transition-colors">Royal</button>
                            <button class="px-4 py-2 rounded-full border border-black/10 text-xs font-medium text-black/60 hover:border-champagne-400 hover:text-champagne-600 transition-colors">Minimal</button>
                            <button class="px-4 py-2 rounded-full border border-black/10 text-xs font-medium text-black/60 hover:border-champagne-400 hover:text-champagne-600 transition-colors">Editorial</button>
                        </div>
                    </div>

                    <!-- Budget Tier -->
                    <div class="border-b border-black/5">
                        <button @click="expanded = expanded === 'budget' ? null : 'budget'" class="w-full flex items-center justify-between py-4 text-left">
                            <span class="text-xs font-bold tracking-widest uppercase text-navy-900">Budget Tier</span>
                            <svg class="h-4 w-4 text-black/40 transition-transform duration-300" :class="expanded === 'budget' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="expanded === 'budget'" x-transition class="pb-4 flex flex-col gap-4">
                            <div class="grid grid-cols-2 gap-3">
                                <input type="number" wire:model.live.debounce.500ms="min_price" placeholder="Min ₹" class="w-full bg-[#f4f2ee] border-transparent rounded-xl focus:ring-0 focus:border-champagne-400 text-sm py-2">
                                <input type="number" wire:model.live.debounce.500ms="max_price" placeholder="Max ₹" class="w-full bg-[#f4f2ee] border-transparent rounded-xl focus:ring-0 focus:border-champagne-400 text-sm py-2">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clear Filters -->
                <button wire:click="clearFilters" class="text-xs font-bold uppercase tracking-widest text-black/40 hover:text-navy-900 transition-colors text-left mt-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Reset All
                </button>
            </aside>

            <!-- RIGHT: Results Grid -->
            <main class="w-full lg:w-3/4">
                @if($listings->isEmpty())
                    <div class="bg-white rounded-[24px] p-24 text-center border border-black/5 shadow-[0_8px_30px_rgba(0,0,0,0.04)] flex flex-col items-center">
                        <h3 class="text-2xl font-display text-navy-900 mb-2">No selections aligned with your vision</h3>
                        <p class="text-black/50 mb-8 max-w-md mx-auto font-light leading-relaxed">Consider broadening your parameters. Exquisite vendors await discovery.</p>
                        <button wire:click="clearFilters" class="btn-ghost">Clear Filters</button>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($listings as $listing)
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

                            <!-- Premium 5:6 Ratio Card (Adjusted for mobile) -->
                            <div class="group relative bg-[#1c1c1c] rounded-2xl overflow-hidden h-[400px] md:h-auto md:aspect-5/6 cursor-pointer shadow-[0_10px_30px_rgba(0,0,0,0.08)] hover:-translate-y-2 transition-all duration-500 ease-out"
                                 wire:key="listing-{{ $listing->listing_type }}-{{ $listing->id }}">

                                <!-- Background Image (Slideshow Placeholder) -->
                                <img src="{{ $imageUrl }}" alt="{{ $listing->business_name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-[cubic-bezier(0.25,0.46,0.45,0.94)]" />

                                <!-- Overlays -->
                                <div class="absolute inset-0 bg-linear-to-b from-black/20 via-transparent to-black/90"></div>
                                <div class="absolute inset-0 bg-navy-900/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                <!-- Top Actions -->
                                <div class="absolute top-4 w-full px-4 flex justify-between items-start z-20">
                                    @if($listing->featured || $listing->premium)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase bg-white/10 backdrop-blur-md border border-white/20 text-white">Featured</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase bg-white/10 backdrop-blur-md border border-white/20 text-white">{{ ucfirst($listing->listing_type) }}</span>
                                    @endif

                                    <div class="flex flex-col gap-2">
                                        <!-- Save -->
                                        <button @click.stop="$store.savedListings.toggle({ id:'{{$listing->id}}', type:'{{$listing->listing_type}}', title:@js($listing->business_name) })"
                                            class="w-9 h-9 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-champagne-500 hover:border-champagne-500 transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        </button>
                                        <!-- Quick View -->
                                        <button @click.prevent="quickView = { id: '{{$listing->id}}', name: @js($listing->business_name), image: @js($imageUrl), price: @js($listing->min_price), type: '{{$listing->listing_type}}', slug: '{{$listing->slug}}', city: @js($listing->city) }" class="w-9 h-9 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-white hover:text-navy-900 transition-all opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 duration-300 delay-75">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Bottom Content -->
                                <a href="{{ url('listing/' . $listing->listing_type . '/' . $listing->slug) }}" class="absolute inset-0 z-10"></a>
                                <div class="absolute bottom-0 w-full p-6 z-20 pointer-events-none">
                                    <div class="flex items-end justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-display text-2xl text-white mb-1 drop-shadow-md">{{ $listing->business_name }}</h3>
                                            <p class="text-sm text-white/80 font-medium flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                                {{ $listing->city ?? 'Remote' }}
                                            </p>
                                        </div>
                                        @if($listing->min_price)
                                            <div class="text-right">
                                                <span class="text-[9px] uppercase tracking-widest text-white/60 block mb-0.5">Starting</span>
                                                <span class="text-lg font-bold text-white">₹{{ number_format($listing->min_price) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center w-full">
                        {{ $listings->links('vendor.livewire.luxury-pagination') }}
                    </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div x-cloak x-show="quickView" class="fixed inset-0 z-[100] flex items-center justify-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div x-show="quickView" x-transition.opacity class="fixed inset-0 bg-navy-950/80 backdrop-blur-sm" @click="quickView = null"></div>

        <!-- Modal Panel -->
        <div x-show="quickView"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-[24px] shadow-2xl w-full max-w-4xl mx-4 overflow-hidden flex flex-col md:flex-row max-h-[90vh]">

            <!-- Close Button -->
            <button @click="quickView = null" class="absolute top-4 right-4 z-50 w-10 h-10 bg-white/20 hover:bg-white backdrop-blur-md rounded-full flex items-center justify-center transition-colors text-navy-900 group">
                <svg class="w-5 h-5 text-white md:text-navy-900" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <!-- Image Column -->
            <div class="w-full md:w-1/2 h-64 md:h-auto relative bg-stone-100">
                <template x-if="quickView?.image">
                    <img :src="quickView.image" class="w-full h-full object-cover" alt="Preview">
                </template>
            </div>

            <!-- Content Column -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-[#FAF9F7]">
                <span x-text="quickView?.type" class="uppercase tracking-widest text-[10px] font-bold text-champagne-600 mb-4 block"></span>
                <h2 x-text="quickView?.name" class="font-display text-4xl text-navy-900 mb-2 leading-tight"></h2>
                <p x-text="quickView?.city" class="text-black/60 font-sans text-sm mb-6 flex items-center gap-2"></p>

                <p class="text-navy-900/70 font-light leading-relaxed mb-8">This is a hand-selected professional offering premium services for your special day. Elevate your event with unparalleled expertise and refined elegance.</p>

                <div class="flex items-center justify-between border-t border-b border-black/5 py-4 mb-8">
                    <div>
                        <span class="text-[10px] uppercase tracking-widest text-black/40 block mb-1">Starting Investment</span>
                        <template x-if="quickView?.price">
                            <span class="text-2xl font-medium text-navy-900" x-text="`₹${quickView.price.toLocaleString()}`"></span>
                        </template>
                        <template x-if="!quickView?.price">
                            <span class="text-xl font-medium text-navy-900">Custom</span>
                        </template>
                    </div>
                </div>

                <a :href="`/listing/${quickView?.type}/${quickView?.slug}`" class="btn-primary w-full shadow-2xl">View Full Profile</a>
            </div>
        </div>
    </div>
</div>
