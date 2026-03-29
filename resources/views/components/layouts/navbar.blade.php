@props(['transparent' => false])

<nav x-data="{ scrolled: false, isOpen: false, isHome: {{ $transparent ? 'true' : 'false' }} }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{
         'bg-[rgba(0,0,0,0.4)] backdrop-blur-[12px] border-transparent': isHome && !scrolled,
         'bg-white/80 backdrop-blur-2xl shadow-sm border-white/20': !(isHome && !scrolled)
     }"
     class="fixed w-full z-50 transition-all duration-500 border-b h-[72px] flex items-center">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between w-full">
        <a href="/"
           :class="{'text-white': isHome && !scrolled, 'text-navy-900': !(isHome && !scrolled)}"
           class="font-display text-2xl tracking-widest font-bold transition-colors">
            WEDPLANIFY<span :class="{'text-champagne-300': isHome && !scrolled, 'text-champagne-500': !(isHome && !scrolled)}">.</span>
        </a>

        <div class="hidden md:flex items-center space-x-10">
            <a href="/explore"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-navy-900': !(isHome && !scrolled)}"
               class="relative text-sm font-medium tracking-wide transition-colors group py-2">
                Explore
                <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-champagne-400 group-hover:w-full group-hover:left-0 transition-all duration-300 ease-out"></span>
            </a>

            <a href="/saved"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-navy-900': !(isHome && !scrolled)}"
               class="relative text-sm font-medium tracking-wide transition-colors group py-2">
                Saved
                <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-champagne-400 group-hover:w-full group-hover:left-0 transition-all duration-300 ease-out"></span>
            </a>
        </div>

        <div class="flex items-center space-x-4">
            @auth
            <a href="/dashboard"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-navy-900': !(isHome && !scrolled)}"
               class="hidden md:flex items-center text-sm font-medium tracking-wide transition-colors group relative py-2 mr-2">
                Dashboard
                <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-champagne-400 group-hover:w-full group-hover:left-0 transition-all duration-300 ease-out"></span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    :class="{'bg-transparent text-white border border-[rgba(255,255,255,0.2)] hover:bg-white/10': isHome && !scrolled, 'bg-navy-900 border border-transparent text-white hover:bg-navy-800': !(isHome && !scrolled)}"
                    class="hidden md:flex items-center px-6 py-2 rounded-[20px] text-xs font-semibold tracking-widest uppercase transition-all duration-300 backdrop-blur-md shadow-sm hover:-translate-y-0.5">
                    Log out
                </button>
            </form>
            @else
            <a href="/login"
               class="hidden md:flex items-center text-sm font-medium tracking-wide transition-colors group relative py-2 mr-2"
               :class="{'text-white/90 hover:text-white': isHome && !scrolled, 'text-stone-700 hover:text-navy-900': !(isHome && !scrolled)}">
                Log in
                <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-champagne-400 group-hover:w-full group-hover:left-0 transition-all duration-300 ease-out"></span>
            </a>
            <a href="/register"
                :class="{'bg-transparent text-white border border-[rgba(255,255,255,0.2)] hover:bg-white/10': isHome && !scrolled, 'bg-navy-900 border border-transparent text-white hover:bg-navy-800': !(isHome && !scrolled)}"
                class="hidden md:flex items-center px-6 py-2 rounded-[20px] text-xs font-semibold tracking-widest uppercase transition-all duration-300 backdrop-blur-md shadow-sm hover:-translate-y-0.5">
                Join
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
            <a href="/saved" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Saved</a>
            <hr class="border-stone-200 " />
            @auth
                <a href="/dashboard" @click="isOpen = false" class="text-3xl font-serif text-stone-900 flex items-center gap-2">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-3xl font-serif text-stone-900  text-left">Log out</button>
                </form>
            @else
                <a href="/login" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Log in</a>
                <a href="/register" @click="isOpen = false" class="text-3xl font-serif text-stone-900 ">Create Account</a>
            @endauth
        </div>
    </div>
</nav>
