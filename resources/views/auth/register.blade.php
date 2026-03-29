<x-layouts.app>
    <div class="grow flex items-center justify-center p-6 mt-10">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden p-8 border border-stone-100">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-display font-bold text-stone-900">Create an Account</h2>
                <p class="text-stone-500 mt-2">Sign up to start planning your perfect day with Wedplanify</p>
            </div>

            @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
                <ul class="list-disc list-inside px-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Your Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="partner_name" class="block text-sm font-medium text-stone-700 mb-1">Partner's Name</label>
                        <input type="text" name="partner_name" id="partner_name" value="{{ old('partner_name') }}"
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email address *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-stone-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="wedding_date" class="block text-sm font-medium text-stone-700 mb-1">Wedding Date</label>
                        <input type="date" name="wedding_date" id="wedding_date" value="{{ old('wedding_date') }}"
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="wedding_city" class="block text-sm font-medium text-stone-700 mb-1">Wedding City</label>
                        <input type="text" name="wedding_city" id="wedding_city" value="{{ old('wedding_city') }}" placeholder="e.g. New York, NY"
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Password *</label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-1">Confirm Password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-navy-900 text-white font-bold py-3 px-4 rounded-xl hover:bg-navy-800 transition-colors shadow-lg shadow-navy-900/20">
                    Register
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-stone-500">
                <p>Already have an account? <a href="{{ route('login') }}" class="text-champagne-600 font-bold hover:text-champagne-700 transition-colors">Log in</a></p>
            </div>
        </div>
    </div>
</x-layouts.app>
