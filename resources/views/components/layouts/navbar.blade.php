@props(['transparent' => false])

<nav x-data="{ scrolled: false, isOpen: false, isHome: {{ $transparent ? 'true' : 'false' }} }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{
         'bg-transparent border-transparent py-6': isHome && !scrolled,
         'bg-white/90 backdrop-blur-xl shadow-sm border-stone-200/50 py-4': !(isHome && !scrolled)
     }"
     class="fixed w-full z-50 transition-all duration-500 border-b">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <a href="/"
           :class="{'text-white': isHome && !scrolled, 'text-stone-900': !(isHome && !scrolled)}"
           class="font-display text-2xl tracking-widest font-bold transition-colors">
            NUPTIAL<span :class="{'text-champagne-300': isHome && !scrolled, 'text-champagne-500': !(isHome && !scrolled)}">.</span>
        </a>

        <div class="hidden md:flex items-center space-x-8">
            <a href="/explore"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-champagne-600': !(isHome && !scrolled)}"
               class="text-sm font-medium tracking-wide transition-colors">Explore</a>

            <a href="/stories"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-champagne-600': !(isHome && !scrolled)}"
               class="text-sm font-medium tracking-wide transition-colors">Stories</a>

            <a href="/saved"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-champagne-600': !(isHome && !scrolled)}"
               class="text-sm font-medium tracking-wide transition-colors">Saved</a>
        </div>

        <div class="flex items-center space-x-4">
            @auth
            <a href="/dashboard"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-champagne-600': !(isHome && !scrolled)}"
               class="hidden md:flex items-center text-sm font-medium tracking-wide transition-colors">
                Dashboard
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    :class="{'bg-white/10 text-white hover:bg-white/20': isHome && !scrolled, 'bg-stone-900 text-white hover:bg-stone-800': !(isHome && !scrolled)}"
                    class="hidden md:flex items-center px-5 py-2.5 rounded-full text-xs font-bold tracking-widest uppercase transition-all duration-300 backdrop-blur-md">
                    Logout
                </button>
            </form>
            @else
            <a href="/login"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-champagne-600': !(isHome && !scrolled)}"
               class="hidden md:flex items-center text-sm font-medium tracking-wide transition-colors">
                Log In
            </a>
            <a href="/register"
                :class="{'bg-white/10 text-white hover:bg-white/20 border border-white/20': isHome && !scrolled, 'bg-stone-900 text-white hover:bg-stone-800': !(isHome && !scrolled)}"
                class="hidden md:flex items-center px-5 py-2.5 rounded-full text-xs font-bold tracking-widest uppercase transition-all duration-300 backdrop-blur-md">
                Sign Up
            </a>
            @endauth
            <button @click="isOpen = !isOpen"
                    :class="{'text-white': isHome && !scrolled, 'text-stone-900': !(isHome && !scrolled)}"
                    class="md:hidden p-2">
                <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                <svg x-cloak x-show="isOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-cloak x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-[-10px]"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-[-10px]"
         class="md:hidden fixed inset-0 top-[70px] bg-white  z-40 overflow-hidden h-screen">
        <div class="px-6 py-8 flex flex-col space-y-6">
            <a href="/explore" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Explore</a>
            <a href="/saved" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Saved Listings</a>
            <a href="/stories" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Stories</a>
            <hr class="border-stone-200 " />
            @auth
                <a href="/dashboard" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-3xl font-serif text-stone-900  text-left">Logout</button>
                </form>
            @else
                <a href="/login" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Login</a>
                <a href="/register" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Create Account</a>
            @endauth
        </div>
    </div>
</nav>
