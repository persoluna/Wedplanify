<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full mt-4" x-data>
        <div class="mb-8">
            <h1 class="text-4xl font-display font-bold text-stone-900">Saved Listings</h1>
            <p class="text-stone-600 mt-2">Your personal collection of favorite vendors and agencies.</p>
        </div>

        <!-- Render if Items Exist -->
        <template x-if="$store.savedListings && $store.savedListings.items.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <template x-for="item in $store.savedListings.items" :key="item.type + item.id">
                    <div class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-stone-100 flex flex-col h-full">
                        <div class="relative h-64 overflow-hidden">
                            <img :src="item.image" :alt="item.title" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

                            <button @click="$store.savedListings.toggle(item)"
                                    class="absolute top-4 right-4 p-3 rounded-full bg-white/90 backdrop-blur border border-white/20 shadow-sm transition-colors hover:bg-white text-rose-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                </svg>
                            </button>

                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold tracking-widest uppercase text-navy-900 shadow-sm border border-white/20" x-text="item.type">
                            </div>
                        </div>

                        <div class="p-6 flex flex-col grow">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-display text-xl font-bold text-stone-900 leading-tight group-hover:text-champagne-600 transition-colors" x-text="item.title"></h3>
                            </div>

                            <div class="flex items-center text-sm text-stone-500 mt-2">
                                <svg class="w-4 h-4 mr-1 text-champagne-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span x-text="item.location"></span>
                            </div>

                            <div class="flex items-center mt-4">
                                <div class="flex items-center text-amber-400">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    <span class="ml-1 font-bold text-stone-700" x-text="item.rating"></span>
                                </div>
                                <span class="mx-2 text-stone-300">•</span>
                                <span class="text-sm text-stone-500"><span x-text="item.reviews"></span> reviews</span>
                            </div>

                            <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between">
                                <a :href="'/listing/' + item.type + '/' + item.slug" class="text-sm font-bold text-navy-900 group-hover:text-navy-700 inline-flex items-center transition-colors">
                                    View Details
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <!-- Empty State -->
        <template x-if="!$store.savedListings || $store.savedListings.items.length === 0">
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-12 text-center mt-8">
                <svg class="w-16 h-16 text-champagne-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <h3 class="text-xl font-medium text-stone-900 mb-2">No saves yet</h3>
                <p class="text-stone-500 max-w-md mx-auto mb-6">You haven't saved any vendors or agencies to your wishlist. Explore our directory to find the perfect team for your special day.</p>
                <a href="/explore" class="inline-block bg-navy-900 hover:bg-navy-800 text-white font-medium px-6 py-3 rounded-full transition-colors">
                    Explore Vendors
                </a>
            </div>
        </template>
    </div>
</x-layouts.app>
