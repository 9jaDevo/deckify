@php
    use Illuminate\Support\Facades\Auth;
    $displayPlan = match (strtolower((string) ($planName ?? 'free'))) {
        'pro' => 'Pro Plan',
        'team' => 'Team Plan',
        default => 'Free Plan',
    };
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>All Slides — {{ config('app.name', 'Deckify') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased h-screen overflow-hidden" style="background:#0a0a0c;color:#f5f5f5;">

<div class="flex h-screen" style="background:#0a0a0c;" x-data="{ showForm: {{ $errors->any() || old('source_text') ? 'true' : 'false' }} }">

    {{-- ═══ LEFT SIDEBAR ═══════════════════════════════════════ --}}
    <aside class="w-[250px] shrink-0 flex flex-col border-r border-white/[0.07]" style="background:#0e0e12;">

        {{-- Logo --}}
        <div class="px-7 pt-8 pb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2.5">
                <span class="text-[#00e97c] text-3xl font-bold leading-none">D</span>
                <span class="text-2xl font-semibold text-white tracking-tight leading-none">Deckify</span>
            </a>
        </div>

        {{-- Navigation --}}
        <div class="px-5 flex-1 overflow-y-auto">
            <p class="px-3 mb-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500">Workspace</p>

            <nav class="space-y-1">
                {{-- Collections — active --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[15px] text-white font-medium" style="background:rgba(255,255,255,0.07);">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Collections</span>
                </a>

                {{-- Templates --}}
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[15px] text-gray-400 hover:bg-white/[0.04] hover:text-gray-200 transition-colors">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/>
                    </svg>
                    <span>Templates</span>
                </a>

                {{-- Trash --}}
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[15px] text-gray-400 hover:bg-white/[0.04] hover:text-gray-200 transition-colors">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Trash</span>
                </a>
            </nav>
        </div>

        {{-- User profile --}}
        <div class="px-5 pb-7 pt-4">
            <div class="border-t border-white/[0.07] pt-5">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-9 h-9 rounded-full border border-[#00e97c]/30 flex items-center justify-center shrink-0" style="background:#111318;">
                        <span class="text-sm font-semibold text-[#00e97c]">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[15px] font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[13px] text-gray-500 truncate">{{ $displayPlan }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Log out" class="text-gray-600 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    {{-- ═══ MAIN CONTENT ═══════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col overflow-hidden" style="background:#08090c;">

        {{-- Flash messages --}}
        @if (session('status') || $errors->has('plan_limit'))
            <div class="px-10 pt-6 shrink-0">
                @if (session('status'))
                    @php $statusType = session('status_type', 'success'); @endphp
                    <div class="mb-2 rounded-xl px-4 py-3 text-sm border {{ $statusType === 'error' ? 'bg-red-950/40 text-red-300 border-red-800/30' : 'bg-emerald-950/40 text-emerald-300 border-emerald-800/30' }}">
                        {{ session('status') }}
                    </div>
                @endif
                @error('plan_limit')
                    <div class="mb-2 rounded-xl px-4 py-3 text-sm bg-red-950/40 text-red-300 border border-red-800/30">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        {{-- Page header --}}
        <div class="px-10 pt-10 pb-2 shrink-0">
            <h1 class="text-[42px] font-bold text-white tracking-tight leading-tight">All Slides</h1>
            <p class="mt-1.5 text-[17px] text-gray-400">Manage your captured highlights and generated slide decks.</p>
        </div>

        {{-- Search + CTA row --}}
        <div class="px-10 pt-6 pb-2 flex items-center gap-4 shrink-0">
            <div class="relative w-full max-w-md">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke-width="2"/>
                    <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <input type="text" placeholder="Search decks..."
                       class="w-full rounded-xl border border-white/[0.08] py-3 pl-12 pr-4 text-[15px] text-gray-200 placeholder-gray-500 focus:border-[#00e97c]/40 focus:outline-none focus:ring-0 transition-colors" style="background:#14151a;" />
            </div>
            <div class="ml-auto flex items-center gap-4">
                <span class="hidden lg:block text-sm text-gray-500">
                    <span class="{{ $isLimitReached ? 'text-red-400' : 'text-[#00e97c]' }} font-semibold">{{ $usageCount }}</span>/{{ $usageLimit }} this month
                </span>
                <button @click="showForm = !showForm"
                        class="rounded-xl bg-[#00f586] hover:bg-[#00e97c] text-[#060608] font-semibold text-[15px] px-6 py-3 transition-colors whitespace-nowrap">
                    + New Presentation
                </button>
            </div>
        </div>

        {{-- New presentation drawer --}}
        <div x-show="showForm" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="px-10 mt-4 shrink-0">
            <div class="border border-white/[0.08] rounded-2xl p-5" style="background:#121317;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-white">New Presentation</h3>
                    <div class="text-sm text-gray-500">
                        @if ($isLimitReached)
                            <span class="text-red-400 font-medium">Monthly limit reached on {{ strtoupper($planName) }} plan</span>
                        @else
                            {{ $remainingCount }} generation{{ $remainingCount !== 1 ? 's' : '' }} remaining
                        @endif
                    </div>
                </div>
                <form method="POST" action="{{ route('generations.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="xl:col-span-2">
                            <label for="source_text" class="block text-xs font-medium text-gray-500 mb-1.5">Paste Content</label>
                            <textarea id="source_text" name="source_text" rows="4" placeholder="Paste your content here…"
                                      class="w-full rounded-xl border border-white/[0.08] px-3 py-2.5 text-sm text-gray-200 placeholder-gray-500 focus:border-[#00e97c]/40 focus:outline-none focus:ring-0 resize-none transition-colors" style="background:#1a1b22;">{{ old('source_text') }}</textarea>
                            <p class="mt-1 text-[11px] text-gray-600">Up to 50,000 characters</p>
                            @error('source_text') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="source_file" class="block text-xs font-medium text-gray-500 mb-1.5">Upload DOCX</label>
                            <div class="rounded-xl border border-white/[0.08] px-3 py-2.5 h-[calc(100%-1.625rem-0.375rem)]" style="background:#1a1b22;">
                                <input id="source_file" type="file" name="source_file" accept=".doc,.docx"
                                       class="text-xs text-gray-400 w-full file:mr-3 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:bg-[#2a2c35] file:text-gray-300 hover:file:bg-[#333]" />
                            </div>
                            <p class="mt-1 text-[11px] text-gray-600">DOC or DOCX, max 10 MB</p>
                            @error('source_file') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex flex-col gap-3">
                            <div>
                                <label for="provider" class="block text-xs font-medium text-gray-500 mb-1.5">AI Provider</label>
                                <select id="provider" name="provider"
                                        class="w-full rounded-xl border border-white/[0.08] px-3 py-2.5 text-sm text-gray-200 focus:border-[#00e97c]/40 focus:outline-none focus:ring-0 transition-colors" style="background:#1a1b22;">
                                    <option value="" disabled @selected(old('provider') === null)>Select…</option>
                                    <option value="openai" @selected(old('provider') === 'openai')>OpenAI</option>
                                    <option value="grok" @selected(old('provider') === 'grok')>Grok</option>
                                </select>
                                @error('provider') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" @disabled($isLimitReached)
                                    class="mt-auto w-full rounded-xl bg-[#00f586] hover:bg-[#00e97c] disabled:opacity-40 disabled:cursor-not-allowed text-[#060608] font-semibold text-sm py-2.5 transition-colors">
                                Generate Slides
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Cards grid --}}
        <div class="flex-1 overflow-y-auto px-10 py-6">
            @if ($generations->isEmpty())
                <div class="flex flex-col items-center justify-center h-64 text-center">
                    <div class="w-14 h-14 rounded-2xl border border-white/[0.08] flex items-center justify-center mb-5" style="background:#14151a;">
                        <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-lg font-medium text-gray-300">No presentations yet</p>
                    <p class="mt-1 text-sm text-gray-500">Click "+ New Presentation" to generate your first deck.</p>
                </div>
            @else
                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($generations as $generation)
                        @php
                            $slideCount = isset($generation->output_payload['slides']) ? count($generation->output_payload['slides']) : 0;
                            $isReady = $generation->status === 'completed';
                            $badge = match($generation->status) {
                                'completed'  => ['label' => 'Ready ✨',   'cls' => 'bg-[#00e97c]/15 text-[#00f586] border-[#00f586]/25'],
                                'processing' => ['label' => 'Drafting…',  'cls' => 'bg-white/[0.04] text-gray-400 border-white/[0.1]'],
                                'failed'     => ['label' => 'Failed',     'cls' => 'bg-red-500/10 text-red-400 border-red-500/20'],
                                default      => ['label' => 'Drafting…',  'cls' => 'bg-white/[0.04] text-gray-400 border-white/[0.1]'],
                            };
                            $metricLabel = $slideCount > 0 ? ($slideCount . ' Slide' . ($slideCount !== 1 ? 's' : '')) : '0 Slides';
                        @endphp
                        <div class="group rounded-2xl border border-white/[0.07] overflow-hidden cursor-pointer transition-all duration-200 hover:border-white/[0.15] hover:-translate-y-0.5 hover:shadow-[0_12px_40px_rgba(0,0,0,0.5)]"
                             style="background:#151619;"
                             onclick="window.location='{{ route('generations.show', $generation) }}'">

                            {{-- Thumbnail preview --}}
                            <div class="h-40 border-b border-white/[0.06] relative overflow-hidden p-4" style="background:#111318;">
                                @if ($isReady && $slideCount > 0)
                                    <div class="absolute inset-4 rounded-xl border border-white/[0.06] p-3.5 flex flex-col gap-2" style="background:#1a1d24;">
                                        <div class="h-1.5 w-14 rounded-full bg-gray-500/50"></div>
                                        <div class="h-3 w-4/5 rounded bg-white/70"></div>
                                        <div class="h-1.5 w-2/3 rounded-full bg-gray-600/40"></div>
                                        <div class="h-1.5 w-4/5 rounded-full bg-gray-700/40"></div>
                                    </div>
                                @elseif ($generation->status === 'processing')
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-5 h-5 border-2 border-[#00e97c]/30 border-t-[#00e97c] rounded-full animate-spin"></div>
                                            <span class="text-[11px] text-gray-500">Generating…</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Card body --}}
                            <div class="p-5">
                                <h3 class="text-[17px] font-semibold text-white leading-snug group-hover:text-[#00e97c] transition-colors line-clamp-2">
                                    {{ $generation->title }}
                                </h3>
                                <p class="mt-1.5 text-[13px] text-gray-500">
                                    {{ $metricLabel }} • Edited {{ $generation->updated_at->diffForHumans() }}
                                </p>
                                <div class="mt-3.5 flex items-center justify-between">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 border text-[11px] font-semibold {{ $badge['cls'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                    <div class="flex items-center gap-3 text-[13px]" onclick="event.stopPropagation()">
                                        <a href="{{ route('generations.show', $generation) }}" class="text-gray-500 hover:text-white transition-colors">Open</a>
                                        @if ($isReady)
                                            <a href="{{ route('generations.export', $generation) }}" class="text-gray-500 hover:text-white transition-colors">Export</a>
                                        @endif
                                    </div>
                                </div>
                                @if ($generation->status === 'failed' && filled($generation->failed_reason))
                                    <p class="mt-2 text-xs text-red-400 line-clamp-2">{{ $generation->failed_reason }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($generations->hasPages())
                    <div class="mt-8">{{ $generations->links() }}</div>
                @endif
            @endif
        </div>
    </div>

</div>
</body>
</html>
