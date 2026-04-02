<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Generating — {{ config('app.name', 'Deckify') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak]{display:none!important}
        body{background:#050506;color:#f5f5f5;font-family:'Figtree',sans-serif}

        .glow-circle{
            background:radial-gradient(circle,rgba(32,245,154,0.12) 0%,transparent 70%);
        }
        .progress-track{background:#1a1d22;border-radius:999px;overflow:hidden}
        .progress-fill{
            height:100%;border-radius:999px;
            background:linear-gradient(90deg,#20F59A,#2AF598);
            transition:width 0.8s cubic-bezier(0.4,0,0.2,1);
        }

        @keyframes pulse-glow{
            0%,100%{box-shadow:0 0 20px rgba(32,245,154,0.15),0 0 60px rgba(32,245,154,0.05)}
            50%{box-shadow:0 0 30px rgba(32,245,154,0.25),0 0 80px rgba(32,245,154,0.1)}
        }
        .icon-pulse{animation:pulse-glow 2.5s ease-in-out infinite}

        @keyframes fade-up{
            from{opacity:0;transform:translateY(12px)}
            to{opacity:1;transform:translateY(0)}
        }
        .animate-fade-up{animation:fade-up 0.5s ease-out forwards}

        .step-connector{width:2px;height:24px;margin-left:5px;background:#1a1d22;position:relative;overflow:hidden}
        .step-connector.active::after{
            content:'';position:absolute;inset:0;
            background:#20F59A;
            animation:fill-down 0.6s ease-out forwards;
        }
        @keyframes fill-down{
            from{transform:translateY(-100%)}
            to{transform:translateY(0)}
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

{{-- Subtle radial glow behind card --}}
<div class="fixed inset-0 pointer-events-none" style="background:radial-gradient(ellipse at center,rgba(32,245,154,0.03) 0%,transparent 60%)"></div>

<div class="relative w-full max-w-[420px]"
     x-data="progressScreen()"
     x-init="start()"
     x-cloak>

    {{-- ═══ PROCESSING STATE ═══ --}}
    <div x-show="screen === 'processing'" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="rounded-3xl border border-white/[0.06] px-10 py-12 text-center" style="background:#0d0e11;">

            {{-- D Logo with glow --}}
            <div class="flex justify-center mb-8">
                <div class="relative w-20 h-20 rounded-full flex items-center justify-center icon-pulse" style="background:#111418;">
                    <div class="absolute inset-0 rounded-full glow-circle"></div>
                    <span class="relative text-[#20F59A] text-4xl font-bold">D</span>
                </div>
            </div>

            {{-- Heading --}}
            <h1 class="text-[26px] font-bold text-white leading-tight mb-2">Designing your slides...</h1>
            <p class="text-[15px] text-gray-500 mb-10">Structuring "{{ \Illuminate\Support\Str::limit($generation->title, 40) }}"</p>

            {{-- Step checklist --}}
            <div class="text-left inline-block mx-auto">
                {{-- Step 1 --}}
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full shrink-0 transition-colors duration-500"
                         :class="step >= 1 ? 'bg-[#20F59A] shadow-[0_0_8px_rgba(32,245,154,0.4)]' : 'bg-[#2a2d33]'"></div>
                    <span class="text-[15px] transition-colors duration-500"
                          :class="step >= 1 ? 'text-white font-medium' : 'text-gray-600'">Analyzing raw input</span>
                </div>
                <div class="step-connector" :class="step >= 2 && 'active'"></div>

                {{-- Step 2 --}}
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full shrink-0 transition-colors duration-500"
                         :class="step >= 2 ? 'bg-[#20F59A] shadow-[0_0_8px_rgba(32,245,154,0.4)]' : 'bg-[#2a2d33]'"></div>
                    <span class="text-[15px] transition-colors duration-500"
                          :class="step >= 2 ? 'text-white font-semibold' : 'text-gray-600'">Generating slide narrative</span>
                </div>
                <div class="step-connector" :class="step >= 3 && 'active'"></div>

                {{-- Step 3 --}}
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full shrink-0 transition-colors duration-500"
                         :class="step >= 3 ? 'bg-[#20F59A] shadow-[0_0_8px_rgba(32,245,154,0.4)]' : 'bg-[#2a2d33]'"></div>
                    <span class="text-[15px] transition-colors duration-500"
                          :class="step >= 3 ? 'text-white font-medium' : 'text-gray-600'">Applying premium layout</span>
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="mt-10 progress-track h-[6px]">
                <div class="progress-fill" :style="'width:' + progressPercent + '%'"></div>
            </div>

            {{-- Footer --}}
            <p class="mt-8 text-[11px] font-semibold uppercase tracking-[0.16em] text-gray-600">
                Powered by {{ strtoupper($generation->provider) }} AI
            </p>
        </div>
    </div>

    {{-- ═══ SUCCESS STATE ═══ --}}
    <div x-show="screen === 'success'" x-cloak class="animate-fade-up">
        <div class="rounded-3xl border border-white/[0.06] px-10 py-12 text-center" style="background:#0d0e11;">

            {{-- Checkmark icon --}}
            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 rounded-full flex items-center justify-center" style="background:#111418;border:1.5px solid rgba(255,255,255,0.08);">
                    <svg class="w-10 h-10 text-[#20F59A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 12a8 8 0 01-8 8 8 8 0 01-8-8 8 8 0 018-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="3 3" opacity="0.4"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-[28px] font-bold text-white leading-tight mb-2">Presentation Ready ✨</h1>
            <p class="text-[15px] text-gray-500 mb-10" x-text="summaryText"></p>

            {{-- CTA --}}
            <a :href="workspaceUrl"
               class="block w-full rounded-2xl py-4 text-center text-[17px] font-bold text-[#060608] transition-all duration-200 hover:shadow-[0_0_30px_rgba(32,245,154,0.25)]"
               style="background:linear-gradient(135deg,#20F59A,#2AF598);">
                Open Workspace ↗
            </a>

            <p class="mt-5 text-[13px] text-gray-600">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-400 transition-colors">or back to dashboard</a>
            </p>
        </div>
    </div>

    {{-- ═══ ERROR STATE ═══ --}}
    <div x-show="screen === 'error'" x-cloak class="animate-fade-up">
        <div class="rounded-3xl border border-red-500/10 px-10 py-12 text-center" style="background:#0d0e11;">

            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 rounded-full flex items-center justify-center" style="background:#111418;border:1.5px solid rgba(239,68,68,0.15);">
                    <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 9v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-[26px] font-bold text-white leading-tight mb-2">Generation Failed</h1>
            <p class="text-[15px] text-red-400/80 mb-10" x-text="errorMessage"></p>

            <a href="{{ route('dashboard') }}"
               class="block w-full rounded-2xl py-4 text-center text-[17px] font-bold text-white border border-white/[0.1] transition-colors hover:bg-white/[0.04]"
               style="background:#15161a;">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

<script>
function progressScreen() {
    const generationId = @json($generation->id);
    const initialStatus = @json($generation->status);
    const initialSlideCount = @json($slideCount);
    const initialFailedReason = @json($generation->failed_reason);
    const statusUrl = @json(route('generations.status', $generation));
    const workspaceBaseUrl = @json(route('generations.show', $generation));

    return {
        screen: 'processing',
        step: 0,
        progressPercent: 0,
        summaryText: '',
        errorMessage: '',
        workspaceUrl: workspaceBaseUrl,
        startTime: Date.now(),
        pollTimer: null,

        start() {
            // If already completed/failed (sync queue), animate through steps then show result
            if (initialStatus === 'completed') {
                this.animateSteps(() => this.showSuccess(initialSlideCount));
            } else if (initialStatus === 'failed') {
                this.step = 1;
                this.progressPercent = 15;
                setTimeout(() => this.showError(initialFailedReason || 'Generation failed unexpectedly.'), 800);
            } else {
                // Still processing (async queue) — animate steps and poll
                this.animateSteps(() => {
                    // If still not complete after animation, hold at step 3 and keep polling
                });
                this.startPolling();
            }
        },

        animateSteps(onComplete) {
            // Step 1
            setTimeout(() => {
                this.step = 1;
                this.progressPercent = 20;
            }, 400);

            // Step 2
            setTimeout(() => {
                this.step = 2;
                this.progressPercent = 55;
            }, 1200);

            // Step 3
            setTimeout(() => {
                this.step = 3;
                this.progressPercent = 85;
            }, 2000);

            // Complete
            setTimeout(() => {
                this.progressPercent = 100;
                if (onComplete) onComplete();
            }, 2600);
        },

        startPolling() {
            this.pollTimer = setInterval(async () => {
                try {
                    const res = await fetch(statusUrl, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!res.ok) return;
                    const data = await res.json();

                    if (data.status === 'completed') {
                        clearInterval(this.pollTimer);
                        this.step = 3;
                        this.progressPercent = 100;
                        setTimeout(() => this.showSuccess(data.slide_count), 600);
                    } else if (data.status === 'failed') {
                        clearInterval(this.pollTimer);
                        this.showError(data.failed_reason || 'Generation failed unexpectedly.');
                    }
                } catch (e) { /* retry silently */ }
            }, 2000);
        },

        showSuccess(slideCount) {
            const elapsed = ((Date.now() - this.startTime) / 1000).toFixed(1);
            const count = slideCount || 0;
            this.summaryText = count + ' premium slide' + (count !== 1 ? 's' : '') + ' generated in ' + elapsed + 's';
            this.screen = 'success';
        },

        showError(message) {
            this.errorMessage = message;
            this.screen = 'error';
        }
    };
}
</script>

</body>
</html>
