<footer class="relative bg-stone-900 text-white py-12 border-t border-stone-800 overflow-hidden">
    <!-- Particle Background -->
    <div x-data="partyBg" class="absolute inset-0 pointer-events-none opacity-60 z-0">
        <canvas x-ref="canvas" class="w-full h-full"></canvas>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="col-span-1 md:col-span-2">
            <h2 class="font-display text-2xl mb-4">WEDPLANIFY<span class="text-champagne-500">.</span></h2>
            <p class="text-stone-400 max-w-sm font-light leading-relaxed text-sm">
                The curated marketplace for modern weddings. Connecting couples with the world's finest agencies and creatives.
            </p>
        </div>
        <div>
            <h4 class="font-bold uppercase tracking-widest text-xs mb-4 text-stone-500">Platform</h4>
            <ul class="space-y-3 text-stone-300 text-sm font-light">
                <li><a href="/explore" class="hover:text-champagne-400 transition-colors">Explore Agencies</a></li>
                <li><a href="/explore" class="hover:text-champagne-400 transition-colors">Find Vendors</a></li>
                <li><a href="/" class="hover:text-champagne-400 transition-colors">Real Weddings</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold uppercase tracking-widest text-xs mb-4 text-stone-500">Company</h4>
            <ul class="space-y-3 text-stone-300 text-sm font-light">
                <li><a href="/" class="hover:text-champagne-400 transition-colors">About Us</a></li>
                <li><a href="/" class="hover:text-champagne-400 transition-colors">For Professionals</a></li>
                <li><a href="/" class="hover:text-champagne-400 transition-colors">Contact</a></li>
            </ul>
        </div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 mt-10 pt-6 border-t border-stone-800 flex flex-col md:flex-row justify-between text-xs text-stone-500">
        <p>&copy; {{ date('Y') }} Wedplanify Inc. All rights reserved.</p>
        <div class="flex gap-6 mt-4 md:mt-0">
            <span class="hover:text-white cursor-pointer">Privacy Policy</span>
            <span class="hover:text-white cursor-pointer">Terms of Service</span>
        </div>
    </div>
</footer>
