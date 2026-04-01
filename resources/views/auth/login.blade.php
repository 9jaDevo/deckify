<x-guest-layout>
    <section class="min-h-screen grid lg:grid-cols-2">
        <div class="relative hidden lg:flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 via-emerald-400/10 to-black"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_40%_35%,rgba(52,211,153,0.28),transparent_55%)]"></div>
            <div class="relative z-10 px-12">
                <p class="text-[86px] leading-[0.88] text-white/90" style="font-family: 'Caveat', cursive;">
                    We'll make<br>it here.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-16 bg-black">
            <div class="w-full max-w-md">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-3xl font-bold text-white mb-9 tracking-tight">
                    <span class="text-emerald-400">◢</span><span>Deckify</span>
                </a>

                <x-auth-session-status class="mb-4 text-sm text-emerald-300" :status="session('status')" />

                <a href="#" class="mb-6 inline-flex w-full items-center justify-center gap-3 rounded-2xl border border-white/35 bg-transparent py-3 text-sm font-semibold text-white hover:border-emerald-300 transition">
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-white text-black font-bold">G</span>
                    Sign in with Google
                </a>

                <div class="mb-7 flex items-center gap-3 text-xs uppercase tracking-[0.22em] text-white/55">
                    <span class="h-px flex-1 bg-white/20"></span>
                    <span>or sign in with Email</span>
                    <span class="h-px flex-1 bg-white/20"></span>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your username/email" class="w-full rounded-2xl border border-emerald-100/15 bg-emerald-100/14 px-5 py-3 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" class="w-full rounded-2xl border border-emerald-100/15 bg-emerald-100/14 px-5 py-3 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div class="flex items-center justify-between pt-1 text-sm">
                        <label for="remember_me" class="inline-flex items-center gap-2 text-white/80">
                            <input id="remember_me" type="checkbox" class="rounded border-white/30 bg-transparent text-emerald-400 focus:ring-emerald-400" name="remember">
                            <span>Remember</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-emerald-300 hover:text-emerald-200" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="mt-2 w-full rounded-2xl bg-emerald-300 py-3 text-base font-extrabold tracking-wide text-black transition hover:bg-emerald-200">
                        LOGIN
                    </button>
                </form>

                <p class="mt-7 text-center text-sm text-white/60">
                    Not registered yet?
                    <a href="{{ route('register') }}" class="font-semibold text-emerald-300 hover:text-emerald-200">Create an account</a>
                </p>
            </div>
        </div>
    </section>
</x-guest-layout>
