<x-layouts.app title="{{ $listing->business_name }} - Wedplanify">
    <div class="bg-stone-50 min-h-screen pb-20">
        <!-- Hero Header with Banner Background -->
        <div class="relative h-[400px] bg-navy-900 overflow-hidden">
            @php
                $banner = null;
                if (!empty($listing->banner)) {
                    $banner = asset('storage/' . $listing->banner);
                } elseif ($listing->hasMedia('banner')) {
                    $banner = $listing->getFirstMediaUrl('banner');
                } elseif ($listing->hasMedia('gallery')) {
                    $banner = $listing->getFirstMediaUrl('gallery');
                }

                if (!$banner) {
                    $banner = "https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=2000";
                }
            @endphp
            <img src="{{ $banner }}" alt="Banner for {{ $listing->business_name }}" class="w-full h-full object-cover opacity-50" />
            <div class="absolute inset-0 bg-linear-to-t from-navy-900 via-navy-900/40 to-transparent"></div>

            <div class="absolute bottom-0 w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
                    <div class="flex flex-col md:flex-row gap-8 items-end">
                        <!-- Avatar -->
                        <div class="relative group">
                            @php
                                $avatar = null;
                                if (!empty($listing->logo)) {
                                    $avatar = asset('storage/' . $listing->logo);
                                } elseif ($listing->hasMedia('logo')) {
                                    $avatar = $listing->getFirstMediaUrl('logo');
                                } elseif ($listing->hasMedia('avatar')) {
                                    $avatar = $listing->getFirstMediaUrl('avatar');
                                }

                                if (!$avatar) {
                                    $avatar = "https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=300";
                                }
                            @endphp
                            <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden border-4 border-white shadow-xl bg-white relative z-10">
                                <img src="{{ $avatar }}" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 text-white">
                            <div class="flex items-center gap-3 mb-2">
                                @if($listing->featured || $listing->premium)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-champagne-500 text-white shadow-sm">
                                        Featured {{ ucfirst($listing->listing_type) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-black/40 backdrop-blur-md border border-white/20 text-white shadow-sm">
                                        {{ ucfirst($listing->listing_type) }}
                                    </span>
                                @endif

                                @if(isset($listing->category))
                                    <span class="text-champagne-200 text-sm font-medium">{{ $listing->category->name }}</span>
                                @endif
                            </div>

                            <h1 class="text-4xl md:text-5xl font-serif mb-2">{{ $listing->business_name }}</h1>

                            <div class="flex flex-wrap items-center gap-4 text-stone-200 text-sm">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-champagne-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $listing->city }}, {{ $listing->state ?? 'NY' }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-champagne-500 fill-champagne-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    <span class="font-bold text-white">{{ number_format($listing->avg_rating ?? 5.0, 1) }}</span>
                                    <span>({{ $listing->reviews->count() ?? 12 }} Reviews)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Call to actions -->
                        <div class="flex gap-3 mt-4 md:mt-0">
                            <!-- Alpine Save Button -->
                            <div role="button" @click.prevent="$store.savedListings.toggle({
                                      id: '{{ $listing->id }}',
                                      type: '{{ strtolower(class_basename($listing)) }}',
                                      title: @js($listing->business_name),
                                      image: @js($avatar),
                                      location: @js($listing->city . ', ' . ($listing->state ?? 'NY')),
                                      rating: @js(number_format($listing->avg_rating ?? 5.0, 1)),
                                      reviews: @js($listing->reviews->count() ?? 12),
                                      slug: @js($listing->slug)
                                })"
                                class="backdrop-blur-md px-5 py-3 rounded-xl font-medium transition-all flex items-center gap-2 border"
                                :class="$store.savedListings.has('{{ $listing->id }}', '{{ strtolower(class_basename($listing)) }}') ? 'bg-rose-500/90 border-rose-400 text-white hover:bg-rose-500' : 'bg-white/10 hover:bg-white/20 border-white/20 text-white'"
                            >
                                <svg class="w-5 h-5"
                                     :fill="$store.savedListings.has('{{ $listing->id }}', '{{ strtolower(class_basename($listing)) }}') ? 'currentColor' : 'none'"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span x-text="$store.savedListings.has('{{ $listing->id }}', '{{ strtolower(class_basename($listing)) }}') ? 'Saved' : 'Save'"></span>
                            </div>
                            <a href="#contact" class="bg-champagne-600 hover:bg-champagne-500 text-white shadow-lg shadow-champagne-500/30 px-6 py-3 rounded-xl font-medium transition-all flex items-center gap-2">
                                Request Quote
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <div class="flex flex-col lg:flex-row gap-12">

                <!-- Main Content Column -->
                <div class="w-full lg:w-2/3 space-y-12">

                    <!-- About Section -->
                    <section class="bg-white rounded-3xl p-8 border border-stone-200 shadow-sm">
                        <h2 class="text-2xl font-serif text-navy-900 mb-6 border-b border-stone-100 pb-4">About</h2>
                        <div class="prose prose-stone max-w-none text-stone-600 leading-relaxed">
                            {!! nl2br(e($listing->description ?? 'No description provided. Please contact the vendor directly for more specific information.')) !!}
                        </div>
                    </section>

                    <!-- Reviews Section -->
                    <section class="bg-white rounded-3xl p-8 border border-stone-200 shadow-sm">
                        <div class="flex justify-between items-center mb-6 border-b border-stone-100 pb-4">
                            <h2 class="text-2xl font-serif text-navy-900">Reviews</h2>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-navy-900">{{ number_format($listing->avg_rating ?? 5.0, 1) }} <span class="text-sm text-stone-500 font-normal">/ 5.0</span></div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            @forelse($listing->reviews as $review)
                                <div class="border-b border-stone-100 last:border-0 pb-6 last:pb-0">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-full bg-stone-200 overflow-hidden shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($review->client->user->name ?? 'Guest') }}&background=E5E1D8&color=1B2A4A" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start mb-1">
                                                <h4 class="font-bold text-navy-900">{{ $review->client->user->name ?? 'A client' }}</h4>
                                                <span class="text-xs text-stone-400">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="flex text-champagne-500 mb-3">
                                                @for($i=1; $i<=5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-stone-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                                @endfor
                                            </div>
                                            <p class="text-stone-600">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-stone-500">
                                    <p>No reviews yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- Availability Calendar Section -->
                    @if($listing->listing_type === 'vendor')
                    <section class="bg-white rounded-3xl p-8 border border-stone-200 shadow-sm" x-data="vendorCalendar()">
                        <div class="flex justify-between items-center mb-6 border-b border-stone-100 pb-4">
                            <h2 class="text-2xl font-serif text-navy-900">Availability</h2>
                            <div class="flex items-center gap-4 text-sm">
                                <div class="flex items-center gap-1"><div class="w-3 h-3 rounded-full bg-champagne-500"></div> Available</div>
                                <div class="flex items-center gap-1"><div class="w-3 h-3 rounded-full bg-rose-500"></div> Booked</div>
                            </div>
                        </div>

                        <div id="availability-calendar" class="fc-theme-standard"></div>
                    </section>

                    @push('styles')
                    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
                    <style>
                        .fc .fc-toolbar-title { font-family: ui-serif, Georgia, serif; font-size: 1.5rem; color: #1B2A4A; }
                        .fc .fc-button-primary { background-color: #1B2A4A; border-color: #1B2A4A; }
                        .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #E5E1D8; color: #1B2A4A; border-color: #E5E1D8; }
                        .fc .fc-daygrid-day.fc-day-today { background-color: #f8fafc; }
                    </style>
                    @endpush

                    @push('scripts')
                    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
                    <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('vendorCalendar', () => ({
                                init() {
                                    const rawAvailabilities = @js($listing->availabilities ?? []);
                                    const events = rawAvailabilities.map(a => {
                                        let color = '#C2B28F'; // champagne-500 default available
                                        let title = 'Available';

                                        if (a.status === 'fully_booked') {
                                            color = '#f43f5e'; // rose-500
                                            title = 'Booked';
                                        } else if(a.status === 'partially_booked') {
                                            color = '#f59e0b';
                                            title = 'Partial';
                                        } else if(a.status === 'unavailable') {
                                            color = '#9ca3af';
                                            title = 'Unavailable';
                                        }

                                        return {
                                            title: title,
                                            start: typeof a.date === 'string' ? a.date.substring(0, 10) : a.date,
                                            allDay: true,
                                            backgroundColor: color,
                                            borderColor: color,
                                            display: 'background'
                                        };
                                    });

                                    const calendarEl = document.getElementById('availability-calendar');
                                    const calendar = new FullCalendar.Calendar(calendarEl, {
                                        initialView: 'dayGridMonth',
                                        events: events,
                                        height: 500,
                                        headerToolbar: {
                                            left: 'prev',
                                            center: 'title',
                                            right: 'next'
                                        },
                                        validRange: {
                                            start: new Date().toISOString().split('T')[0] // Only show from today onwards
                                        },
                                        dateClick: function(info) {
                                            const dateInput = document.querySelector('input[name="event_date"]');
                                            if (dateInput) {
                                                dateInput.value = info.dateStr;
                                                dateInput.classList.add('ring-2', 'ring-champagne-500', 'animate-pulse');
                                                setTimeout(() => dateInput.classList.remove('animate-pulse', 'ring-2', 'ring-champagne-500'), 1500);
                                                // Removed annoying window.scrollTo behavior
                                            }
                                        }
                                    });
                                    calendar.render();
                                }
                            }));
                        });
                    </script>
                    @endpush
                    @endif
                </div>

                <!-- Sidebar Column -->
                <div class="w-full lg:w-1/3">
                    <div class="sticky top-24 space-y-6">

                        <!-- Pricing Widget -->
                        @if($listing->listing_type === 'vendor' && $listing->min_price)
                        <div class="bg-white rounded-3xl p-6 border border-stone-200 shadow-sm relative overflow-hidden group">
                            <div class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-champagne-400 to-champagne-600"></div>
                            <h3 class="text-lg font-semibold text-navy-900 mb-4">Pricing Estimation</h3>

                            <div class="mb-6">
                                <p class="text-sm text-stone-500 mb-1">Starting at</p>
                                <div class="text-3xl font-serif text-navy-900">
                                    ₹{{ number_format($listing->min_price) }}
                                    @if($listing->max_price)
                                        <span class="text-lg text-stone-400"> - ₹{{ number_format($listing->max_price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Contact Form Widget -->
                        <div id="contact" class="bg-white rounded-3xl p-6 border border-stone-200 shadow-sm">
                            <h3 class="text-lg font-semibold text-navy-900 mb-6">Contact {{ $listing->business_name }}</h3>

                            @if(session('success'))
                                <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @auth
                                @if(auth()->user()->isClient())
                                    <form action="{{ route('inquiry.store', ['type' => $listing->listing_type, 'id' => $listing->id]) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-stone-700 mb-1">Your Name *</label>
                                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-stone-700 mb-1">Email *</label>
                                                <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500" required>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-stone-700 mb-1">Phone Number</label>
                                                <input type="tel" name="phone" value="{{ auth()->user()->phone }}" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-stone-700 mb-1">Guest Count</label>
                                                <input type="number" name="guest_count" value="{{ auth()->user()->client?->guest_count }}" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-stone-700 mb-1">Event Date</label>
                                                <input type="date" name="event_date" value="{{ auth()->user()->client?->wedding_date?->format('Y-m-d') }}" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-stone-700 mb-1">Event City</label>
                                                <input type="text" name="event_location" value="{{ auth()->user()->client?->wedding_city }}" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-stone-700 mb-1">Message *</label>
                                            <textarea name="message" rows="4" class="w-full bg-stone-50 border-stone-200 rounded-xl focus:border-champagne-500 focus:ring-champagne-500" placeholder="Hi, I'm interested in your services for my wedding..." required></textarea>
                                        </div>
                                        <button type="submit" class="w-full bg-navy-900 hover:bg-navy-800 text-white py-3 rounded-xl font-medium transition-all shadow-sm">
                                            Send Message
                                        </button>
                                    </form>
                                @else
                                    <div class="text-center p-6 bg-stone-50 rounded-xl border border-stone-200">
                                        <h4 class="text-lg font-medium text-stone-900 mb-2">Vendors cannot send inquiries</h4>
                                        <p class="text-stone-600 mb-4">Please log in using a client account if you are planning a wedding.</p>
                                    </div>
                                @endif
                            @else
                                <div class="text-center p-6 bg-stone-50 rounded-xl border border-stone-200">
                                    <h4 class="text-lg font-medium text-stone-900 mb-2">Interested in booking?</h4>
                                    <p class="text-stone-600 mb-5">Please log in or create a free account to send direct inquiries and track all your communications in one place.</p>
                                    <div class="flex flex-col space-y-3">
                                        <a href="{{ route('login') }}" class="w-full bg-navy-900 hover:bg-navy-800 text-white py-3 rounded-xl font-medium text-center transition-all shadow-sm">Log In</a>
                                        <a href="{{ route('register') }}" class="w-full bg-white border border-stone-200 hover:border-stone-300 text-stone-700 py-3 rounded-xl font-medium text-center transition-all">Create Account</a>
                                    </div>
                                </div>
                            @endauth
                        </div>                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>
