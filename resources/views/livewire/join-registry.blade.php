<div>
    <div class="min-h-screen bg-stone-50 py-24 px-6 md:px-12 flex flex-col items-center justify-center pt-32">
        <div class="max-w-4xl w-full mx-auto bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">

            <!-- Interactive Value Prop / Branding Sidebar -->
            <div class="md:w-5/12 bg-black text-white p-12 relative overflow-hidden flex flex-col justify-between">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1511285560982-1351cdeb9821?auto=format&fit=crop&q=80" alt="Professional Setup" class="w-full h-full object-cover opacity-30 mix-blend-overlay">
                    <div class="absolute inset-0 bg-linear-to-b from-black/20 via-black/60 to-black"></div>
                </div>

                <div class="relative z-10">
                    <span class="inline-flex items-center gap-2 py-1.5 px-3 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-champagne-400 text-xs tracking-widest uppercase mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-champagne-400 animate-pulse"></span> App-Only Network
                    </span>
                    <h2 class="font-display text-4xl font-medium mb-4 leading-tight">Elevate Your <br/> <span class="italic text-champagne-400">Business</span></h2>
                    <p class="text-white/60 font-light leading-relaxed">Join the curated registry for premier wedding agencies and elite creatives. Gain access to premium clientele globally.</p>
                </div>

                <div class="relative z-10 mt-12">
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-white/80 font-light text-sm">
                            <svg class="w-5 h-5 text-champagne-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> Expand your audience footprint
                        </li>
                        <li class="flex items-center gap-3 text-white/80 font-light text-sm">
                            <svg class="w-5 h-5 text-champagne-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> Verified luxury leads
                        </li>
                        <li class="flex items-center gap-3 text-white/80 font-light text-sm">
                            <svg class="w-5 h-5 text-champagne-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> Direct portfolio integrations
                        </li>
                    </ul>
                </div>
            </div>

            <!-- The Application Form -->
            <div class="md:w-7/12 p-8 md:p-12">
                @if($submitted)
                    <div class="h-full flex flex-col items-center justify-center text-center animate-[fade-in-up_0.5s_ease-out]">
                        <div class="w-20 h-20 rounded-full bg-green-50 flex items-center justify-center text-green-500 mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="font-display text-3xl text-stone-900 mb-3 font-medium">Application Received</h3>
                        <p class="text-stone-500 font-light text-lg">Thank you for requesting to join our network. Our team will review your portfolio and reach out to you directly.</p>
                        <a href="/" class="mt-8 text-champagne-600 font-medium hover:text-champagne-700 tracking-wide uppercase text-sm border-b border-champagne-600 pb-1">Return to Homepage</a>
                    </div>
                @else
                    <div>
                        <h3 class="font-display text-2xl text-stone-900 mb-1">Partner Application</h3>
                        <p class="text-stone-500 text-sm mb-8 font-light">Tell us a bit about your business and operations.</p>

                        <form wire:submit.prevent="submit" class="space-y-5">
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">First Name *</label>
                                    <input type="text" wire:model="first_name" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800" required>
                                    @error('first_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Last Name *</label>
                                    <input type="text" wire:model="last_name" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800" required>
                                    @error('last_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Email Address *</label>
                                    <input type="email" wire:model="email" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800" required>
                                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Phone Number *</label>
                                    <input type="tel" wire:model="phone" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800" required>
                                    @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="border-t border-stone-100 my-6"></div>

                            <div>
                                <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Business Name *</label>
                                <input type="text" wire:model="business_name" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800" required>
                                @error('business_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Business Type *</label>
                                    <select wire:model="business_type" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800 bg-white">
                                        <option value="vendor">Creative / Vendor</option>
                                        <option value="agency">Planning Agency</option>
                                    </select>
                                    @error('business_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Primary Location *</label>
                                    <input type="text" wire:model="location" placeholder="e.g. New York, NY" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800" required>
                                    @error('location') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Portfolio / Website URL</label>
                                    <input type="url" wire:model="website_url" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800">
                                    @error('website_url') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Instagram Handle</label>
                                    <input type="text" wire:model="instagram_handle" placeholder="@" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800">
                                    @error('instagram_handle') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-stone-700 uppercase tracking-widest mb-1.5">Additional Notes</label>
                                <textarea wire:model="additional_notes" rows="3" class="w-full border-stone-200 rounded-lg px-4 py-3 focus:border-champagne-500 focus:ring focus:ring-champagne-200 transition-all font-light text-stone-800 resize-none"></textarea>
                                @error('additional_notes') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="w-full bg-black text-white hover:bg-champagne-600 rounded-xl px-4 py-4 font-medium tracking-wide transition-colors duration-300 shadow-xl shadow-black/5">
                                    Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- UI Enhancements for Benefits Section -->
    <section id="benefits" class="relative bg-black py-32 px-6 overflow-hidden">
        <!-- Ambient splodges -->
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-champagne-900/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-stone-800/50 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="text-center mb-20 animate-[fade-in-up_0.8s_ease-out]">
                <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full border border-champagne-500/30 text-champagne-400 text-[10px] tracking-[0.25em] uppercase mb-6 bg-white/5 backdrop-blur-md shadow-[0_0_20px_rgba(200,169,126,0.15)]">
                    <span class="w-1.5 h-1.5 rounded-full bg-champagne-400 animate-pulse"></span> Network Perks
                </span>
                <h2 class="font-display text-4xl md:text-5xl lg:text-6xl text-white font-medium mb-6">Exclusive Partner Benefits</h2>
                <p class="text-white/50 text-lg font-light max-w-2xl mx-auto leading-relaxed">Join an elite cohort of professionals. We provide the tools, the trust, and the audience so you can focus entirely on your craft.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Benefit 1 -->
                <div class="group relative bg-[#111] p-10 rounded-3xl border border-white/10 hover:border-champagne-500/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(200,169,126,0.1)]">
                    <div class="absolute inset-0 bg-linear-to-b from-champagne-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-champagne-400 mb-8 group-hover:scale-110 transition-transform duration-500 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
                        </div>
                        <h3 class="text-2xl font-serif text-white mb-4">Verified Trust</h3>
                        <p class="text-white/50 font-light leading-relaxed">Our curated approach means you are positioned alongside the industry's finest. Build immediate trust with luxury clientele.</p>
                    </div>
                </div>

                <!-- Benefit 2 -->
                <div class="group relative bg-[#111] p-10 rounded-3xl border border-white/10 hover:border-champagne-500/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(200,169,126,0.1)]">
                    <div class="absolute inset-0 bg-linear-to-b from-champagne-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-champagne-400 mb-8 group-hover:scale-110 transition-transform duration-500 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <h3 class="text-2xl font-serif text-white mb-4">Premium Leads</h3>
                        <p class="text-white/50 font-light leading-relaxed">Connect directly with engaged couples who value high-end services and have the budget to match your expertise.</p>
                    </div>
                </div>

                <!-- Benefit 3 -->
                <div class="group relative bg-[#111] p-10 rounded-3xl border border-white/10 hover:border-champagne-500/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(200,169,126,0.1)]">
                    <div class="absolute inset-0 bg-linear-to-b from-champagne-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-champagne-400 mb-8 group-hover:scale-110 transition-transform duration-500 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><line x1="3" x2="21" y1="9" y2="9"></line><line x1="9" x2="9" y1="21" y2="9"></line></svg>
                        </div>
                        <h3 class="text-2xl font-serif text-white mb-4">Seamless Tools</h3>
                        <p class="text-white/50 font-light leading-relaxed">Manage your storefront, track inquiries, and handle reviews seamlessly through our intuitive professional dashboard.</p>
                    </div>
                </div>
            </div>

            <div class="mt-20 flex justify-center">
                 <a href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" class="inline-flex items-center gap-2 text-white/40 hover:text-champagne-400 transition-colors duration-300 font-sans tracking-widest uppercase text-[11px] font-bold">
                     <span>Return to Form</span>
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="animate-bounce"><path d="m18 15-6-6-6 6"/></svg>
                 </a>
            </div>
        </div>
    </section>
</div>
