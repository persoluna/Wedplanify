<x-layouts.app>
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grow w-full mt-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Sidebar -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
                    <div class="text-center mb-6">
                        <div class="h-24 w-24 rounded-full bg-champagne-100 text-champagne-800 flex items-center justify-center text-3xl font-display font-bold mx-auto mb-4 border-2 border-champagne-200">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-semibold text-stone-900">{{ $user->name }}</h2>
                        <p class="text-stone-500 text-sm">{{ $user->email }}</p>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="block w-full text-left px-4 py-2 rounded-xl bg-champagne-50 text-champagne-800 font-medium">Dashboard</a>
                        <!-- Future: Profile Settings link -->
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="md:col-span-3 space-y-6">

                <!-- Welcome Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6 border-l-4 border-l-navy-800">
                    <h3 class="text-2xl font-display font-medium text-stone-900 mb-2">Welcome to your Planner!</h3>
                    <p class="text-stone-600">Here you can keep track of all the vendors and agencies you've contacted.</p>
                </div>

                <!-- Recent Inquiries -->
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-stone-100 flex justify-between items-center bg-stone-50">
                        <h3 class="text-lg font-semibold text-stone-900">Your Inquiries</h3>
                        <span class="bg-navy-100 text-navy-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $client->inquiries->count() }} Total</span>
                    </div>

                    @if($client->inquiries->count() > 0)
                        <div class="divide-y divide-stone-100">
                            @foreach($client->inquiries as $inquiry)
                            @php
                                $target = $inquiry->vendor ?? $inquiry->agency;
                                $targetType = $inquiry->vendor_id ? 'vendor' : 'agency';
                            @endphp
                            <div class="p-6 hover:bg-stone-50 transition-colors">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                                    <div>
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="px-2 py-1 bg-stone-200 text-stone-700 text-xs rounded-md uppercase font-semibold tracking-wider">
                                                {{ $targetType }}
                                            </span>
                                            <span class="text-sm text-stone-400">{{ \Carbon\Carbon::parse($inquiry->created_at)->format('M d, Y') }}</span>
                                        </div>
                                        <h4 class="text-lg font-medium text-stone-900 mb-1">
                                            @if($target)
                                                <a href="{{ route('listing.show', ['type' => $targetType, 'slug' => $target->slug]) }}" class="hover:text-champagne-600 transition-colors">
                                                    {{ $target->business_name }}
                                                </a>
                                            @else
                                                <span class="text-red-500">Deleted Vendor/Agency</span>
                                            @endif
                                        </h4>
                                        <p class="text-stone-600 text-sm mt-2 line-clamp-2"><span class="font-medium text-stone-700">Message:</span> "{{ $inquiry->message }}"</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <!-- Assuming status is enum: new, responded, booked, etc. -->
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                            {{ $inquiry->status === 'new' ? 'bg-amber-100 text-amber-800' :
                                               ($inquiry->status === 'responded' ? 'bg-sky-100 text-sky-800' :
                                               ($inquiry->status === 'booked' ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-800')) }}">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center text-stone-500 bg-white">
                            <svg class="w-12 h-12 text-stone-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <p>You haven't sent any inquiries yet.</p>
                            <a href="{{ route('explore') }}" class="text-champagne-600 hover:text-champagne-700 font-medium mt-2 inline-block">Explore Vendors</a>
                        </div>
                    @endif
                </div>

                <!-- Your Bookings (Placeholder for future) -->
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-stone-100 flex justify-between items-center bg-stone-50">
                        <h3 class="text-lg font-semibold text-stone-900">Your Bookings</h3>
                        <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $client->bookings->count() }} Total</span>
                    </div>

                    @if($client->bookings->count() > 0)
                        <div class="divide-y divide-stone-100">
                            <!-- Loop through bookings when implemented -->
                        </div>
                    @else
                        <div class="p-8 text-center text-stone-500 bg-white">
                            <p>You don't have any confirmed bookings.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>
