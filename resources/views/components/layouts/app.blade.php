@props(['title' => 'Wedplanify | Luxe Wedding Marketplace', 'transparentNav' => false])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body x-data class="bg-stone-50 text-stone-800 transition-colors duration-300 min-h-screen font-sans selection:bg-champagne-200 selection:text-stone-900 flex flex-col">
    <x-layouts.navbar :transparent="$transparentNav" />

    <main class="grow {{ $transparentNav ? '' : 'pt-24 pb-16' }} flex flex-col">
        {{ $slot }}
    </main>

    <x-layouts.footer />

    <!-- Alpine Store for Saved Listings -->
    <script>
        document.addEventListener('alpine:init', () => {
            let initialItems = [];
            try {
                initialItems = JSON.parse(localStorage.getItem('savedListings')) || [];
                if (!Array.isArray(initialItems)) initialItems = [];
            } catch (e) {
                initialItems = [];
            }

            Alpine.store('savedListings', {
                items: initialItems,
                toggle(item) {
                    const index = this.items.findIndex(i => String(i.id) === String(item.id) && i.type === item.type);
                    if (index > -1) {
                        this.items.splice(index, 1);
                    } else {
                        this.items.push(item);
                    }
                    localStorage.setItem('savedListings', JSON.stringify(this.items));
                },
                has(id, type) {
                    return this.items.some(i => String(i.id) === String(id) && i.type === type);
                }
            });
        });
    </script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
