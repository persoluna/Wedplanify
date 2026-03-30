<?php
$file = 'resources/views/livewire/ai-search-modal.blade.php';
$content = file_get_contents($file);

$needle = <<<'NEEDLE'
                                    @foreach($msg['items'] as $vendor)
                                        <a href="/listing/vendor/{{ $vendor->slug }}"
 class="group block bg-black rounded-2xl overflow-hidden border border-white/10 hover:border-champagne-400 transition-all duration-500 hover:shadow-[0_10px_30px_rgba(200,169,126,0.15)] hover:-translate-y-1">
                                            <div class="h-32 w-full overflow-hidden r
elative">
                                                @php
                                                    $thumb = "https://images.unsplash
.com/photo-1519225421980-715cb0215aed?q=80&w=800&auto=format&fit=crop";
                                                    if (!empty($vendor->banner)) $thu
mb = asset('storage/' . $vendor->banner);
                                                    elseif ($vendor->hasMedia('galler
y')) $thumb = $vendor->getFirstMediaUrl('gallery');
                                                @endphp
                                                <img src="{{ $thumb }}" class="w-full
 h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                                <div class="absolute inset-0 bg-linea
r-to-t from-black/90 via-black/20 to-transparent"></div>
                                                
                                                <div class="absolute bottom-3 left-4 
right-4">
                                                    <span class="text-[9px] text-cham
pagne-400 font-medium uppercase tracking-widest mb-1 block">{{ $vendor->category->name ?? 'Service' }}</span>
                                                    <h4 class="text-white font-serif 
text-base leading-tight truncate">{{ $vendor->business_name }}</h4>
                                                </div>
                                            </div>
                                            <div class="p-3 bg-[#111111] flex items-c
enter justify-between text-xs font-light text-white/60">
                                                <span class="flex items-center gap-1"
><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>{{ $vendor->city }}</span>
                                                <span class="text-white/90 font-mediu
m">${{ number_format($vendor->min_price, 0) }}</span>
                                            </div>
                                        </a>
                                    @endforeach
NEEDLE;

$needle = str_replace("\n", "", $needle);
$needle = str_replace("\r", "", $needle);
// just manual replace
$content = preg_replace('/@foreach\(\$msg\[\'items\'\] as \$vendor\).*?@endforeach/s', <<<'REPLACE'
@foreach($msg['items'] as $vendor)
                                        <a href="/listing/vendor/{{ is_array($vendor) ? $vendor['slug'] : $vendor->slug }}" class="group block bg-black rounded-2xl overflow-hidden border border-white/10 hover:border-champagne-400 transition-all duration-500 hover:shadow-[0_10px_30px_rgba(200,169,126,0.15)] hover:-translate-y-1">
                                            <div class="h-32 w-full overflow-hidden relative">
                                                @php
                                                    $thumb = "https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=800&auto=format&fit=crop"\;
                                                    if (is_array($vendor)) {
                                                        if (!empty($vendor['banner'])) $thumb = asset('storage/' . $vendor['banner']);
                                                    } else {
                                                        if (!empty($vendor->banner)) $thumb = asset('storage/' . $vendor->banner);
                                                        elseif ($vendor->hasMedia('gallery')) $thumb = $vendor->getFirstMediaUrl('gallery');
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
                                                <span class="text-white/90 font-medium">${{ number_format(is_array($vendor) ? $vendor['min_price'] : $vendor->min_price, 0) }}</span>
                                            </div>
                                        </a>
                                    @endforeach
REPLACE
, $content);

file_put_contents($file, $content);
