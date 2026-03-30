<div class="relative w-full max-w-[700px] mx-auto" x-data="{ isOpen: @entangle('isOpen') }" x-effect="document.body.style.overflow = isOpen ? 'hidden' : ''">
    <!-- The conversational search bar embedded exactly as it was in welcome.blade.php -->
    <form wire:submit.prevent="submit" class="relative {{ $isOpen ? 'z-0' : 'z-50' }} w-full animate-[fade-in-up_1.6s_ease-out]">
        <div class="relative group">
            <div class="relative flex items-center bg-white/10 backdrop-blur-[10px] rounded-full p-3.5 px-5 border border-white/10 shadow-2xl overflow-hidden focus-within:border-white/30 focus-within:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition-all duration-300">
                <div class="pl-2 pr-2 text-champagne-400 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="query"
                    placeholder="Describe your dream wedding vision to our AI..."
                    class="w-full bg-transparent border-none outline-none text-white placeholder-white/50 text-lg md:text-xl font-sans px-4 h-10 focus:ring-0"
                    autocomplete="off"
                >
                <button type="submit" class="bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors duration-300 backdrop-blur-md border border-white/10 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>

            <!-- Floating Powered by NVIDIA Badge -->
            <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-2 text-[10px] text-white/40 tracking-widest uppercase inline-block whitespace-nowrap">
                Powered by NVIDIA NIM
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#76b900]"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
            </div>
        </div>
    </form>

    <!-- Modal Popup Overlay -->
    @if($isOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6"
         x-data="{ show: false }"
         x-init="setTimeout(() => show = true, 50)">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity duration-500" :class="show ? 'opacity-100' : 'opacity-0'" wire:click="$set('isOpen', false)"></div>

        <!-- Modal Content -->
        <div class="relative w-full max-w-4xl flex flex-col transition-all duration-700 transform" :class="show ? 'translate-y-0 opacity-100 scale-100' : 'translate-y-12 opacity-0 scale-95'" style="max-height: 85vh;">

            <!-- Animated Border Glow -->
            <div class="absolute -inset-[1px] bg-gradient-to-r from-champagne-400 via-white/10 to-champagne-600 rounded-[24px] opacity-30 blur-[2px]"></div>

            <div class="relative flex flex-col h-full bg-[#111111]/95 border border-white/10 shadow-2xl rounded-3xl overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-white/10 flex items-center justify-between bg-black/40">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-champagne-600 to-amber-200 flex items-center justify-center text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-[#76b900] border-2 border-[#111111] rounded-full"></div>
                        </div>
                        <div>
                            <h3 class="text-white font-serif text-xl tracking-wide flex items-center gap-2">AI Concierge</h3>
                            <p class="text-white/40 text-xs flex items-center gap-1 font-mono uppercase tracking-widest mt-0.5">Powered by NVIDIA NIM</p>
                        </div>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="flex-1 overflow-y-auto p-6 space-y-6 scrollbar-hide bg-[#0a0a0a]/50" id="chat-container">
                    @foreach($messages as $msg)

                        @if($msg['type'] === 'user_message')
                            <div class="flex justify-end animate-[fade-in-up_0.3s_ease-out]">
                                <div class="bg-gradient-to-br from-champagne-600 to-champagne-700 text-white rounded-[20px] rounded-tr-sm px-6 py-4 max-w-[80%] shadow-lg">
                                    <p class="text-sm md:text-base font-light">{{ $msg['content'] }}</p>
                                </div>
                            </div>

                        @elseif($msg['type'] === 'system_message')
                            <div class="flex justify-center animate-[fade-in_0.3s_ease-out]">
                                <span class="bg-white/5 border border-white/10 text-white/40 text-[10px] uppercase tracking-widest px-4 py-1.5 rounded-full font-mono">
                                    {{ $msg['content'] }}
                                </span>
                            </div>

                        @elseif($msg['type'] === 'ai_message')
                            <div class="flex justify-start animate-[fade-in-up_0.5s_ease-out]">
                                <div class="flex gap-4 max-w-[95%] sm:max-w-[85%]">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-champagne-600 to-amber-200 flex items-center justify-center shrink-0 mt-1 shadow-[0_0_15px_rgba(200,169,126,0.3)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-black"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                                    </div>
                                    <div class="bg-[#1c1c1c] text-white border border-white/10 rounded-[20px] rounded-tl-sm px-6 py-5 shadow-2xl backdrop-blur-md">
                                        <p class="text-sm md:text-base leading-relaxed text-white/90 font-light">{{ $msg['content'] }}</p>
                                    </div>
                                </div>
                            </div>

                        @elseif($msg['type'] === 'results_block')
                            <div class="pl-12 w-full animate-[fade-in-up_0.6s_ease-out]">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($msg['items'] as $vendor)
                                        <a href="/listing/{{ is_array($vendor) ? ($vendor['listing_type'] ?? 'vendor') : 'vendor' }}/{{ is_array($vendor) ? $vendor['slug'] : $vendor->slug }}" class="group block bg-black rounded-2xl overflow-hidden border border-white/10 hover:border-champagne-400 transition-all duration-500 hover:shadow-[0_10px_30px_rgba(200,169,126,0.15)] hover:-translate-y-1">
                                            <div class="h-32 w-full overflow-hidden relative">
                                                @php
                                                    $thumb = "https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=800&auto=format&fit=crop";
                                                    if (is_array($vendor)) {
                                                        if (!empty($vendor['banner'])) {
                                                            $thumb = asset('storage/' . $vendor['banner']);
                                                        }
                                                    } else {
                                                        if (!empty($vendor->banner)) {
                                                            $thumb = asset('storage/' . $vendor->banner);
                                                        } elseif ($vendor->hasMedia('gallery')) {
                                                            $thumb = $vendor->getFirstMediaUrl('gallery');
                                                        }
                                                    }
                                                @endphp
                                                <img src="{{ $thumb }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                                <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/20 to-transparent"></div>

                                                <div class="absolute bottom-3 left-4 right-4">
                                                    <span class="text-[9px] text-champagne-400 font-medium uppercase tracking-widest mb-1 block">{{ is_array($vendor) ? ($vendor['category']['name'] ?? 'Service') : ($vendor->category->name ?? 'Service') }}</span>
                                                    <h4 class="text-white font-serif text-base leading-tight truncate">{{ is_array($vendor) ? $vendor['business_name'] : $vendor->business_name }}</h4>
                                                </div>
                                            </div>
                                            <div class="p-3 bg-[#111111] flex items-center justify-between text-xs font-light text-white/60">
                                                <span class="flex items-center gap-1"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>{{ is_array($vendor) ? $vendor['city'] : $vendor->city }}</span>
                                                <span class="text-white/90 font-medium font-sans">
                                                    @if(is_array($vendor) && ($vendor['listing_type'] ?? 'vendor') === 'agency')
                                                        Custom
                                                    @else
                                                        ₹{{ number_format(is_array($vendor) ? $vendor['min_price'] : $vendor->min_price, 0) }}
                                                    @endif
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    @endforeach

                    <!-- Loading Indicator for AI -->
                    @if($loadingAi)
                    <div class="flex justify-start animate-[fade-in-up_0.3s_ease-out]">
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-champagne-600 to-amber-200 flex items-center justify-center shrink-0 mt-1 shadow-[0_0_15px_rgba(200,169,126,0.5)]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="animate-pulse text-black"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                            </div>
                            <div class="bg-[#1c1c1c] text-white border border-white/10 rounded-[20px] rounded-tl-sm px-6 py-5 shadow-2xl flex items-center gap-2">
                                <div class="flex gap-1 ml-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-champagne-400 animate-[bounce_1s_infinite_0ms]"></div>
                                    <div class="w-1.5 h-1.5 rounded-full bg-champagne-400 animate-[bounce_1s_infinite_200ms]"></div>
                                    <div class="w-1.5 h-1.5 rounded-full bg-champagne-400 animate-[bounce_1s_infinite_400ms]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Input & Refinement UX -->
                <div class="p-5 border-t border-white/10 bg-black/60 backdrop-blur-md">

                    <!-- Suggestion Chips - Render only if we have active messages -->
                    @if(count($messages) > 0)
                    <div class="mb-4 flex flex-wrap gap-2 animate-[fade-in_0.5s_ease-out]">
                        <button wire:click.prevent="loadMorePrompt('Show me options under Rs 5L')" class="bg-[#1c1c1c] hover:bg-white/10 border border-white/10 text-white/70 hover:text-white text-[11px] px-3 py-1.5 rounded-full transition-colors cursor-pointer">[ Under ₹5L ]</button>
                        <button wire:click.prevent="loadMorePrompt('Only show OUTDOOR suggestions')" class="bg-[#1c1c1c] hover:bg-white/10 border border-white/10 text-white/70 hover:text-white text-[11px] px-3 py-1.5 rounded-full transition-colors cursor-pointer">[ Outdoor ]</button>
                        <button wire:click.prevent="loadMorePrompt('Are there any in Bangalore?')" class="bg-[#1c1c1c] hover:bg-white/10 border border-white/10 text-white/70 hover:text-white text-[11px] px-3 py-1.5 rounded-full transition-colors cursor-pointer">[ In Bangalore ]</button>
                        <button wire:click.prevent="loadMorePrompt('Start a fresh search')" class="bg-[#1c1c1c] hover:bg-white/10 border border-white/10 text-white/70 hover:text-white text-[11px] px-3 py-1.5 rounded-full transition-colors cursor-pointer">[ Restart Search ]</button>
                    </div>
                    @endif

                    <form wire:submit.prevent="submit" class="relative flex items-center group">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="query"
                            class="w-full bg-[#1c1c1c] border border-white/10 rounded-full pl-6 pr-14 py-4 text-white text-sm md:text-base outline-none focus:border-champagne-500/50 transition-all shadow-inner placeholder-white/30"
                            placeholder="Refine your search..."
                            autocomplete="off"
                        >
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white text-black flex items-center justify-center hover:bg-champagne-400 transition-colors shadow-lg">
                            @if(!$loadingAi)
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </span>
                            @else
                            <span>
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </span>
                            @endif
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @endif

    @if(!$isOpen && count($messages) > 0)
    <!-- Floating Action Button to reopen chat after first use -->
    <button wire:click="$set('isOpen', true)"
            class="absolute -bottom-20 right-4 md:-right-20 md:bottom-auto md:top-[15px] z-[40] w-14 h-14 rounded-full bg-linear-to-tr from-champagne-600 to-amber-200 flex items-center justify-center text-black shadow-[0_5px_20px_rgba(200,169,126,0.4)] hover:scale-105 hover:shadow-[0_5px_25px_rgba(200,169,126,0.6)] transition-all duration-300 group overflow-hidden">

        <!-- Ripple effect on hover -->
        <span class="absolute inset-0 rounded-full bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>

        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:rotate-12 transition-transform duration-300">
            <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
        </svg>

        <!-- Notification Dot -->
        <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-[#76b900] border-2 border-[#111111] rounded-full animate-pulse"></span>
    </button>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('commit', ({ component, succeed }) => {
                succeed(() => {
                    setTimeout(() => {
                        const chat = document.getElementById('chat-container');
                        if(chat) {
                            chat.scrollTo({
                                top: chat.scrollHeight,
                                behavior: 'smooth'
                            });
                        }
                    }, 50);
                });
            });
        });
    </script>
</div>
