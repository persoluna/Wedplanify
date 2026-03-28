<x-layouts.app>
    <div class="grow flex items-center justify-center p-6 mt-10">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden p-8 border border-stone-100">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-display font-bold text-stone-900">Welcome Back</h2>
                <p class="text-stone-500 mt-2">Sign in to your account</p>
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

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full rounded-xl border border-stone-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-champagne-500 focus:border-transparent transition-all">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-navy-600 focus:ring-navy-500 border-stone-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-stone-600">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-navy-900 text-white font-bold py-3 px-4 rounded-xl hover:bg-navy-800 transition-colors shadow-lg shadow-navy-900/20">
                    Sign In
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-stone-500">
                <p>Don't have an account? <a href="{{ route('register') }}" class="text-champagne-600 font-bold hover:text-champagne-700 transition-colors">Register here</a></p>
            </div>
        </div>
    </div>
</x-layouts.app>
