<x-layouts.app :transparent-nav="true">

    <!-- Hero Section -->
    <div class="relative min-h-screen w-full overflow-hidden flex items-center justify-center bg-stone-900 pt-20 pb-20">
        <!-- Background Video with Overlay -->
        <div class="absolute inset-0 z-0">
            <video autoplay loop muted playsinline class="w-full h-full object-cover scale-105 transition-transform duration-[20s] ease-linear">
                <source src="https://cdn.pixabay.com/video/2019/11/03/28811-370154865_large.mp4" type="video/mp4" />
            </video>
            <div class="absolute inset-0 bg-linear-to-b from-black/60 to-black/85"></div>
        </div>

        <div class="relative z-10 text-center w-full px-6 flex flex-col items-center">
            <div class="flex justify-center mb-8 animate-[fade-in-up_1s_ease-out]">
                <span class="inline-block py-1.5 px-4 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-white/90 text-xs tracking-[0.25em] uppercase shadow-2xl">
                    Exclusive Planning Companion
                </span>
            </div>

            <h1 class="font-display text-5xl md:text-7xl text-white mb-[24px] leading-[1.1] tracking-wide animate-[fade-in-up_1.2s_ease-out] font-medium max-w-[900px] mx-auto">
                Your Wedding, <br/> <span class="text-champagne-400">Thoughtfully Curated.</span>
            </h1>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-[40px] animate-[fade-in-up_1.4s_ease-out]">
                <a href="#guided-planning" class="bg-[#C8A97E] hover:bg-[#b8986c] text-black font-medium px-8 py-4 rounded-xl transition-all duration-300 hover:-translate-y-1 shadow-[0_10px_30px_rgba(200,169,126,0.25)] w-full sm:w-auto text-center">
                    Start Planning
                </a>
                <a href="/explore" class="bg-transparent border border-white/20 text-white hover:bg-white/10 font-medium px-8 py-4 rounded-xl transition-all duration-300 hover:-translate-y-1 w-full sm:w-auto text-center">
                    Explore Vendors
                </a>
            </div>

            <!-- Conversational Search Bar Powered By Livewire -->
            <livewire:ai-search-modal />
        </div>
    </div>    <!-- Guided Planning Section (NEW) -->
    <div id="guided-planning" class="bg-[#FAF9F7] py-[80px] px-6 md:px-12 relative z-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <span class="text-champagne-600 font-medium tracking-widest text-xs uppercase mb-3 block">Step by Step</span>
                <h2 class="font-display text-4xl md:text-5xl text-navy-900 font-medium tracking-wide">Start Your Journey</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <a href="/explore?category_id=8" class="group relative bg-[#ffffff] rounded-2xl p-8 shadow-[0_10px_30px_rgba(0,0,0,0.05)] hover:-translate-y-1 hover:bg-[#fffdf9] transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-full bg-[#F5F2EC] flex items-center justify-center text-champagne-600 mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <h3 class="font-serif text-xl text-navy-900 mb-3 font-medium">Find Venue</h3>
                    <p class="text-black/60 text-sm font-sans">Set the stage for your perfect celebration</p>
                </a>

                <!-- Card 2 -->
                <a href="/explore?category_id=2" class="group relative bg-[#ffffff] rounded-2xl p-8 shadow-[0_10px_30px_rgba(0,0,0,0.05)] hover:-translate-y-1 hover:bg-[#fffdf9] transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-full bg-[#F5F2EC] flex items-center justify-center text-champagne-600 mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle></svg>
                    </div>
                    <h3 class="font-serif text-xl text-navy-900 mb-3 font-medium">Book Photographer</h3>
                    <p class="text-black/60 text-sm font-sans">Capture memories that last a lifetime</p>
                </a>

                <!-- Card 3 -->
                <a href="/explore?category_id=26" class="group relative bg-[#ffffff] rounded-2xl p-8 shadow-[0_10px_30px_rgba(0,0,0,0.05)] hover:-translate-y-1 hover:bg-[#fffdf9] transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-full bg-[#F5F2EC] flex items-center justify-center text-champagne-600 mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"></path><path d="M4 12h16"></path><path d="m7.5 7.5 9 9"></path><path d="m16.5 7.5-9 9"></path></svg>
                    </div>
                    <h3 class="font-serif text-xl text-navy-900 mb-3 font-medium">Plan Decor</h3>
                    <p class="text-black/60 text-sm font-sans">Design an atmosphere of pure romance</p>
                </a>

                <!-- Card 4 -->
                <a href="/dashboard" class="group relative bg-[#ffffff] rounded-2xl p-8 shadow-[0_10px_30px_rgba(0,0,0,0.05)] hover:-translate-y-1 hover:bg-[#fffdf9] transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-full bg-[#F5F2EC] flex items-center justify-center text-champagne-600 mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                    </div>
                    <h3 class="font-serif text-xl text-navy-900 mb-3 font-medium">Manage Budget</h3>
                    <p class="text-black/60 text-sm font-sans">Keep your finances brilliantly organized</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Collections List -->
    <div class="py-[80px] bg-stone-50 transition-colors">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="max-w-xl">
                    <h2 class="font-display text-4xl md:text-5xl text-stone-900 font-medium mb-[12px] leading-tight">Featured Collections</h2>
                    <p class="text-black/60 font-sans text-lg">Handpicked by our editorial team to ensure your day is nothing short of extraordinary.</p>
                </div>
                <a href="/explore" class="group flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-900 hover:text-champagne-600 transition-colors">
                    <span>View All</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($featuredVendors ?? [] as $vendor)
                    <a href="/listing/vendor/{{ $vendor->slug }}" class="group relative bg-[#1c1c1c] rounded-[20px] h-[360px] overflow-hidden hover:-translate-y-[6px] hover:shadow-[0_20px_40px_rgba(0,0,0,0.2)] transition-all duration-500 cursor-pointer block border border-transparent">
                        <div class="relative w-full h-full overflow-hidden">
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
                            <img src="{{ $thumb }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $vendor->business_name }}" />
                            <div class="absolute inset-0 bg-linear-to-t from-black/70 to-black/10"></div>

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

                            <div class="absolute bottom-[20px] left-6 right-6">
                                <span class="block text-white/70 text-[12px] font-medium uppercase tracking-widest mb-1">
                                    {{ $vendor->category->name ?? 'Vendor' }}
                                </span>
                                <h3 class="font-serif text-[20px] text-white mb-1 font-medium">{{ $vendor->business_name }}</h3>
                                <p class="text-white/80 text-[13px] font-light flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $vendor->city }}, {{ $vendor->country }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    @for($i = 0; $i < 3; $i++)
                        <div class="group relative bg-[#1c1c1c] rounded-[20px] h-[360px] overflow-hidden border border-stone-200/20">
                            <div class="relative w-full h-full bg-stone-200">
                                <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover opacity-50" />
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>

    <!-- CTA Join Registry -->
    <div class="py-24 bg-stone-50 relative overflow-hidden">
        <!-- Background Ambient Blurs -->
        <div class="absolute top-0 right-0 -m-32 w-96 h-96 bg-champagne-100/50 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -m-32 w-96 h-96 bg-champagne-50/50 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="bg-black rounded-[40px] overflow-hidden shadow-2xl relative">

                <!-- Background Image & Gradient -->
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1511285560982-1351cdeb9821?auto=format&fit=crop&q=80" alt="Wedding Professional working" class="w-full h-full object-cover opacity-40 mix-blend-overlay transition-transform duration-[20s] hover:scale-105" />
                    <div class="absolute inset-0 bg-linear-to-r from-black via-black/80 to-black/20"></div>
                </div>

                <div class="relative flex flex-col md:flex-row items-center">

                    <!-- Text Content -->
                    <div class="p-10 md:p-20 text-white w-full md:w-1/2">
                        <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full border border-champagne-500/30 text-champagne-400 text-[10px] tracking-[0.25em] uppercase mb-8 bg-black/50 backdrop-blur-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-champagne-400 animate-pulse"></span>
                            For Professionals
                        </span>

                        <h2 class="font-display text-4xl md:text-5xl lg:text-6xl font-medium mb-6 leading-tight tracking-wide">
                            Join the <br/> <span class="text-champagne-400 italic font-serif pr-2">Registry</span>
                        </h2>

                        <p class="text-white/60 mb-10 font-light text-lg leading-relaxed max-w-md">
                            Elevate your business by joining our highly curated network of top-tier wedding agencies and industry creatives. Gain access to premium clientele and exclusive tools tailored for luxury professionals.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <a href="/join" class="bg-white text-black px-10 py-4 rounded-xl font-medium tracking-wide hover:bg-champagne-400 transition-all duration-300 shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:shadow-[0_0_30px_rgba(200,169,126,0.3)] hover:-translate-y-1 text-center w-full sm:w-auto">
                                Apply Now
                            </a>
                            <a href="/join#benefits" class="text-white/70 hover:text-white uppercase tracking-widest text-xs font-bold transition-colors w-full sm:w-auto text-center">
                                View Benefits
                            </a>
                        </div>
                    </div>

                    <!-- Decorative Floating Elements -->
                    <div class="hidden md:block w-1/2 p-12">
                        <div class="relative w-full h-[400px]">
                            <!-- Main Glass Card -->
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 w-[340px] bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-3xl shadow-[0_30px_60px_rgba(0,0,0,0.5)] transform -rotate-2 hover:rotate-0 transition-all duration-500">
                                <div class="flex items-center justify-between mb-8">
                                    <div class="w-12 h-12 rounded-full bg-linear-to-tr from-champagne-600 to-amber-200 flex items-center justify-center p-0.5">
                                        <div class="w-full h-full bg-black rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-champagne-400"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
                                        </div>
                                    </div>
                                    <span class="text-white/50 font-mono text-[10px] tracking-widest uppercase">Verified Partner</span>
                                </div>
                                <h4 class="text-2xl text-white font-serif mb-3 leading-tight">Grow Your Base</h4>
                                <p class="text-white/60 font-light text-sm leading-relaxed">
                                    Showcase your luxurious portfolio to thousands of engaged couples looking for exactly what you do.
                                </p>
                            </div>

                            <!-- Small Accent Element -->
                            <div class="absolute left-10 bottom-16 bg-[#1a1a1a]/80 backdrop-blur-md border border-white/10 py-4 px-5 rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-500 delay-100 flex items-center gap-4">
                                <div class="flex -space-x-3">
                                    <div class="w-8 h-8 rounded-full border-2 border-[#1a1a1a] bg-stone-200 overflow-hidden"><img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100&h=100" alt="Lead" class="w-full h-full object-cover"></div>
                                    <div class="w-8 h-8 rounded-full border-2 border-[#1a1a1a] bg-stone-300 overflow-hidden"><img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=100&h=100" alt="Lead" class="w-full h-full object-cover"></div>
                                    <div class="w-8 h-8 rounded-full border-2 border-[#1a1a1a] bg-champagne-400 flex items-center justify-center text-black text-[10px] font-bold">+12</div>
                                </div>
                                <div>
                                    <div class="text-white text-xs font-medium">New Inquiries</div>
                                    <div class="text-champagne-400 text-[10px] font-mono mt-0.5">This week</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
