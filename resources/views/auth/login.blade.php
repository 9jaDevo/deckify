<x-guest-layout>
    <x-auth-shell
        :action="route('login')"
        submit-label="LOGIN"
        helper-text="Not registered yet?"
        helper-link-text="Create an account"
        helper-link-route="register"
        divider-text="or sign in with Email"
        left-message="We'll make<br>it here.">

        <x-auth-session-status class="mb-2 text-sm text-emerald-300" :status="session('status')" />

        <div>
            <label for="email" class="sr-only">Email</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-white/55">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75h3a2.25 2.25 0 0 1 2.25 2.25v6a2.25 2.25 0 0 1-2.25 2.25h-13.5A2.25 2.25 0 0 1 3 15V9a2.25 2.25 0 0 1 2.25-2.25h3" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25 12 12l4.5-3.75" />
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your username/email" class="w-full rounded-full border border-white/15 bg-emerald-100/10 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-300" />
        </div>

        <div>
            <label for="password" class="sr-only">Password</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-white/55">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.5 4.5 0 1 0-9 0V10.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 10.5h13.5A2.25 2.25 0 0 1 21 12.75v6A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75v-6A2.25 2.25 0 0 1 5.25 10.5Z" />
                    </svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" class="w-full rounded-full border border-white/15 bg-emerald-100/10 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-300" />
        </div>

        <div class="flex items-center justify-between pt-1 text-sm">
            <label for="remember_me" class="inline-flex items-center gap-2 text-white/80">
                <input id="remember_me" type="checkbox" class="rounded border-white/30 bg-transparent text-emerald-400 focus:ring-emerald-400" name="remember">
                <span>Remember</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-emerald-300 transition hover:text-emerald-200" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>
    </x-auth-shell>
</x-guest-layout>
