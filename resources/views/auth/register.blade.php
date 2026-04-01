<x-guest-layout>
    <x-auth-shell
        :action="route('register')"
        submit-label="SIGN UP"
        heading="Create your account"
        helper-text="Already have an account?"
        helper-link-text="Login"
        helper-link-route="login"
        divider-text="or sign up with Email"
        left-message="Start your<br>next deck.">

        <div>
            <label for="name" class="sr-only">Full name</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-white/55">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.118a7.5 7.5 0 0 1 15 0A17.93 17.93 0 0 1 12 21.75a17.93 17.93 0 0 1-7.5-1.632Z" />
                    </svg>
                </span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name" class="w-full rounded-full border border-white/15 bg-emerald-100/10 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-300" />
        </div>

        <div>
            <label for="email" class="sr-only">Email</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-white/55">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75h3a2.25 2.25 0 0 1 2.25 2.25v6a2.25 2.25 0 0 1-2.25 2.25h-13.5A2.25 2.25 0 0 1 3 15V9a2.25 2.25 0 0 1 2.25-2.25h3" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25 12 12l4.5-3.75" />
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email" class="w-full rounded-full border border-white/15 bg-emerald-100/10 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
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
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create password" class="w-full rounded-full border border-white/15 bg-emerald-100/10 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-300" />
        </div>

        <div>
            <label for="password_confirmation" class="sr-only">Confirm password</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-white/55">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9Z" />
                    </svg>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password" class="w-full rounded-full border border-white/15 bg-emerald-100/10 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/45 focus:border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-300/35" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-300" />
        </div>
    </x-auth-shell>
</x-guest-layout>
