@props([
    'action',
    'submitLabel',
    'helperText',
    'helperLinkText',
    'helperLinkRoute',
    'leftMessage' => "We'll make<br>it here.",
    'heading' => null,
    'dividerText' => 'or sign in with Email',
])

<section class="min-h-screen grid lg:grid-cols-[58%_42%]">
    <div class="relative hidden lg:flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 via-emerald-400/8 to-black"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_38%_48%,rgba(90,255,180,0.25),transparent_55%)]"></div>
        <div class="relative z-10 px-14">
            <p class="text-[84px] leading-[0.88] text-white/90" style="font-family: 'Caveat', cursive;">
                {!! $leftMessage !!}
            </p>
        </div>
    </div>

    <div class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-16 bg-black">
        <div class="w-full max-w-[400px]">
            <a href="{{ url('/') }}" class="mb-10 flex flex-col items-center gap-2 text-center text-white">
                <img src="{{ asset('deckify_logo.png') }}" alt="Deckify" class="h-10 w-auto" />
            </a>

            @if ($heading)
                <h1 class="mb-6 text-center text-2xl font-semibold text-white">{{ $heading }}</h1>
            @endif

            <button type="button" data-coming-soon="google-auth" class="mb-6 inline-flex w-full items-center justify-center gap-3 rounded-full border border-white/20 bg-[#111111] py-3 text-sm font-semibold text-white transition duration-300 hover:border-emerald-300/80 hover:shadow-[0_0_24px_rgba(124,255,178,0.16)]">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-white text-[11px] font-extrabold text-black">G</span>
                <span>Sign in with Google</span>
            </button>

            <div class="mb-7 flex items-center gap-3 text-xs uppercase tracking-[0.2em] text-white/45">
                <span class="h-px flex-1 bg-white/15"></span>
                <span>{{ $dividerText }}</span>
                <span class="h-px flex-1 bg-white/15"></span>
            </div>

            <form method="POST" action="{{ $action }}" class="space-y-4">
                @csrf
                {{ $slot }}

                <button type="submit" class="mt-2 w-full rounded-full bg-gradient-to-r from-[#7CFFB2] to-[#63F5A6] py-3 text-base font-extrabold tracking-wide text-black transition duration-300 hover:shadow-[0_0_30px_rgba(124,255,178,0.45)]">
                    {{ $submitLabel }}
                </button>
            </form>

            <p class="mt-7 text-center text-sm text-white/55">
                {{ $helperText }}
                <a href="{{ route($helperLinkRoute) }}" class="font-semibold text-emerald-300 transition hover:text-emerald-200">{{ $helperLinkText }}</a>
            </p>

            <div id="coming-soon-toast" class="pointer-events-none fixed bottom-5 left-1/2 z-50 hidden -translate-x-1/2 rounded-full border border-emerald-300/35 bg-[#111111] px-5 py-2 text-sm text-emerald-200 shadow-[0_0_24px_rgba(124,255,178,0.2)]">
                Google sign-in is coming soon.
            </div>
        </div>
    </div>
</section>

@once
<script>
document.addEventListener('DOMContentLoaded', function () {
    const triggers = document.querySelectorAll('[data-coming-soon="google-auth"]');
    const toast = document.getElementById('coming-soon-toast');

    if (!triggers.length || !toast) {
        return;
    }

    let timer;
    triggers.forEach((button) => {
        button.addEventListener('click', function () {
            toast.classList.remove('hidden');
            clearTimeout(timer);
            timer = setTimeout(() => {
                toast.classList.add('hidden');
            }, 1800);
        });
    });
});
</script>
@endonce
