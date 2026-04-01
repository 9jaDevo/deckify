<x-guest-layout>
    <section class="min-h-screen grid lg:grid-cols-2">
        <div class="relative hidden lg:flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/20 via-emerald-500/10 to-black"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_45%_35%,rgba(74,222,128,0.25),transparent_55%)]"></div>
            <div class="relative z-10 px-12">
                <p class="text-[74px] leading-[0.9] text-white/90" style="font-family: 'Caveat', cursive;">
                    Start your<br>next deck.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-16 bg-black">
            <div class="w-full max-w-md">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-3xl font-bold text-white mb-9 tracking-tight">
                    <span class="text-emerald-400">◢</span><span>Deckify</span>
                </a>

                <h1 class="mb-6 text-2xl font-semibold text-white">Create your account</h1>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="sr-only">Full name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name" class="w-full rounded-2xl border border-emerald-100/15 bg-emerald-100/14 px-5 py-3 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email" class="w-full rounded-2xl border border-emerald-100/15 bg-emerald-100/14 px-5 py-3 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create password" class="w-full rounded-2xl border border-emerald-100/15 bg-emerald-100/14 px-5 py-3 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="sr-only">Confirm password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password" class="w-full rounded-2xl border border-emerald-100/15 bg-emerald-100/14 px-5 py-3 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <button type="submit" class="mt-2 w-full rounded-2xl bg-emerald-300 py-3 text-base font-extrabold tracking-wide text-black transition hover:bg-emerald-200">
                        CREATE ACCOUNT
                    </button>
                </form>

                <p class="mt-7 text-center text-sm text-white/60">
                    Already registered?
                    <a href="{{ route('login') }}" class="font-semibold text-emerald-300 hover:text-emerald-200">Log in</a>
                </p>
            </div>
        </div>
    </section>
</x-guest-layout>
