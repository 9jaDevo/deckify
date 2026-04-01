@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>All Slides — {{ config('app.name', 'Deckify') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased bg-[#0a0a0a] text-white overflow-hidden h-screen" style="background:#0a0a0a; color:#f5f5f5;">

<div class="flex h-screen bg-[#0a0a0a]" style="background:#0a0a0a;" x-data="{ showForm: {{ $errors->any() || old('source_text') ? 'true' : 'false' }} }">

    {{-- ── Left Sidebar ──────────────────────────────────────── --}}
    <aside class="w-[220px] shrink-0 flex flex-col bg-[#111111] border-r border-white/[0.07]">

        {{-- Logo --}}
        <div class="px-5 py-[18px] border-b border-white/[0.07]">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-2 h-2 rounded-full bg-[#00e97c] shadow-[0_0_8px_#00e97c80]"></div>
                <span class="text-sm font-semibold text-white tracking-tight">Deckify</span>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto">
            <div class="space-y-0.5">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg bg-white/[0.07] text-white text-sm font-medium">
                    <svg class="w-4 h-4 text-[#00e97c] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/>
                    </svg>
                    <span>All Slides</span>
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-[#00e97c]"></div>
                </a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-500 text-sm hover:bg-white/[0.04] hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path d="M12 7v5l3 3" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Recent</span>
                </a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-500 text-sm hover:bg-white/[0.04] hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Starred</span>
                </a>
            </div>

            {{-- Collections --}}
            <div class="mt-6">
                <p class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-widest text-gray-600">Collections</p>
                <div class="space-y-0.5">
                    <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-500 text-sm hover:bg-white/[0.04] hover:text-gray-200 transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>My Pitch</span>
                    </a>
                    <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-500 text-sm hover:bg-white/[0.04] hover:text-gray-200 transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Lecture Notes</span>
                    </a>
                    <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[#00e97c] text-sm hover:bg-white/[0.04] transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>New Collection</span>
                    </a>
                </div>
            </div>
        </nav>

        {{-- User footer --}}
        <div class="px-4 py-4 border-t border-white/[0.07]">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-7 h-7 rounded-full bg-[#1e1e1e] border border-white/10 flex items-center justify-center shrink-0">
                        <span class="text-xs text-gray-300 font-medium">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-600 uppercase tracking-wide">{{ $planName }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Log out"
                            class="text-gray-600 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── Main Content ───────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col overflow-hidden bg-[#0b0b0b]" style="background:#0b0b0b;">

        {{-- Flash messages --}}
        @if (session('status') || $errors->has('plan_limit'))
            <div class="px-8 pt-4 shrink-0">
                @if (session('status'))
                    @php $statusType = session('status_type', 'success'); @endphp
                    <div class="mb-2 rounded-lg px-4 py-2.5 text-sm border
                        {{ $statusType === 'error' ? 'bg-red-950/40 text-red-300 border-red-800/30' : 'bg-emerald-950/40 text-emerald-300 border-emerald-800/30' }}">
                        {{ session('status') }}
                    </div>
                @endif
                @error('plan_limit')
                    <div class="mb-2 rounded-lg px-4 py-2.5 text-sm bg-red-950/40 text-red-300 border border-red-800/30">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        {{-- Page header --}}
        <div class="px-8 pt-8 pb-5 shrink-0">
            <h1 class="text-2xl font-semibold text-white">All Slides</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your captured highlights and generated slide decks.</p>
        </div>

        {{-- Utility row --}}
        <div class="px-8 flex items-center gap-3 shrink-0">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke-width="2"/>
                    <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <input type="text" placeholder="Search decks…"
                       class="w-56 pl-9 pr-4 py-2 bg-[#1a1a1a] border border-white/[0.07] rounded-lg text-sm text-gray-300
                              placeholder-gray-600 focus:outline-none focus:border-[#00e97c]/40 focus:ring-0 transition-colors" />
            </div>
            <div class="ml-auto flex items-center gap-3">
                <span class="text-xs text-gray-600 hidden sm:block">
                    <span class="{{ $isLimitReached ? 'text-red-400' : 'text-[#00e97c]' }} font-semibold">{{ $usageCount }}</span>/{{ $usageLimit }} this month
                </span>
                <button @click="showForm = !showForm"
                        class="flex items-center gap-1.5 bg-[#00e97c] hover:bg-[#00d070] text-[#0a0a0a] font-semibold text-sm px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    New Presentation
                </button>
            </div>
        </div>

        {{-- New Presentation drawer --}}
        <div x-show="showForm" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="px-8 mt-4 shrink-0">
            <div class="bg-[#151515] border border-white/[0.07] rounded-xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-white">New Presentation</h3>
                    <div class="text-xs text-gray-600">
                        @if ($isLimitReached)
                            <span class="text-red-400 font-medium">Monthly limit reached on {{ strtoupper($planName) }} plan</span>
                        @else
                            {{ $remainingCount }} generation{{ $remainingCount !== 1 ? 's' : '' }} remaining
                        @endif
                    </div>
                </div>
                <form method="POST" action="{{ route('generations.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="lg:col-span-2">
                            <label for="source_text" class="block text-xs font-medium text-gray-500 mb-1.5">Paste Content</label>
                            <textarea id="source_text" name="source_text" rows="4"
                                      placeholder="Paste your content here…"
                                      class="w-full bg-[#1e1e1e] border border-white/[0.07] rounded-lg px-3 py-2.5 text-sm text-gray-200
                                             placeholder-gray-600 focus:outline-none focus:border-[#00e97c]/40 focus:ring-0 resize-none transition-colors">{{ old('source_text') }}</textarea>
                            <p class="mt-1 text-[10px] text-gray-600">Up to 50,000 characters</p>
                            @error('source_text') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="source_file" class="block text-xs font-medium text-gray-500 mb-1.5">Upload DOCX</label>
                            <div class="bg-[#1e1e1e] border border-white/[0.07] rounded-lg px-3 py-2.5 h-[calc(100%-1.625rem-0.375rem)]">
                                <input id="source_file" type="file" name="source_file" accept=".doc,.docx"
                                       class="text-xs text-gray-400 w-full
                                              file:mr-3 file:py-1 file:px-2.5 file:rounded file:border-0
                                              file:text-xs file:bg-[#2a2a2a] file:text-gray-300
                                              hover:file:bg-[#333]" />
                            </div>
                            <p class="mt-1 text-[10px] text-gray-600">DOC or DOCX, max 10 MB</p>
                            @error('source_file') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex flex-col gap-3">
                            <div>
                                <label for="provider" class="block text-xs font-medium text-gray-500 mb-1.5">AI Provider</label>
                                <select id="provider" name="provider"
                                        class="w-full bg-[#1e1e1e] border border-white/[0.07] rounded-lg px-3 py-2.5 text-sm text-gray-200
                                               focus:outline-none focus:border-[#00e97c]/40 focus:ring-0 transition-colors">
                                    <option value="" disabled @selected(old('provider') === null)>Select…</option>
                                    <option value="openai" @selected(old('provider') === 'openai')>OpenAI</option>
                                    <option value="grok" @selected(old('provider') === 'grok')>Grok</option>
                                </select>
                                @error('provider') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" @disabled($isLimitReached)
                                    class="mt-auto w-full bg-[#00e97c] hover:bg-[#00d070] disabled:opacity-40 disabled:cursor-not-allowed
                                           text-[#0a0a0a] font-semibold text-sm py-2.5 rounded-lg transition-colors">
                                Generate Slides
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Cards grid --}}
        <div class="flex-1 overflow-y-auto px-8 py-5">
            @if ($generations->isEmpty())
                <div class="flex flex-col items-center justify-center h-64 text-center">
                    <div class="w-12 h-12 rounded-xl bg-[#1a1a1a] border border-white/[0.07] flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-400">No presentations yet</p>
                    <p class="text-xs text-gray-600 mt-1">Click "New Presentation" to generate your first deck.</p>
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($generations as $generation)
                        @php
                            $slideCount = isset($generation->output_payload['slides'])
                                ? count($generation->output_payload['slides']) : 0;
                            $badge = match($generation->status) {
                                'completed'  => ['label' => 'Ready',      'cls' => 'bg-[#00e97c]/10 text-[#00e97c] border-[#00e97c]/20'],
                                'processing' => ['label' => 'Generating', 'cls' => 'bg-blue-500/10 text-blue-400 border-blue-500/20'],
                                'failed'     => ['label' => 'Failed',     'cls' => 'bg-red-500/10 text-red-400 border-red-500/20'],
                                default      => ['label' => 'Drafting',   'cls' => 'bg-white/5 text-gray-500 border-white/10'],
                            };
                        @endphp
                        <div class="group bg-[#151515] border border-white/[0.07] rounded-xl overflow-hidden
                                    hover:border-white/[0.14] hover:shadow-[0_4px_32px_rgba(0,0,0,0.5)] transition-all duration-200
                                    cursor-pointer"
                             onclick="window.location='{{ route('generations.show', $generation) }}'">

                            {{-- Thumbnail --}}
                            <div class="h-36 bg-[#1c1c1c] border-b border-white/[0.06] relative overflow-hidden">
                                @if ($generation->status === 'completed' && $slideCount > 0)
                                    <div class="absolute inset-4 bg-[#222] rounded-lg border border-white/[0.06] p-3 flex flex-col gap-2">
                                        <div class="h-1.5 w-14 bg-[#00e97c]/40 rounded-full"></div>
                                        <div class="h-2.5 w-4/5 bg-white/[0.14] rounded-full"></div>
                                        <div class="h-1.5 w-1/2 bg-white/[0.07] rounded-full"></div>
                                        <div class="flex-1"></div>
                                        <div class="flex gap-2">
                                            <div class="flex-1 h-9 rounded-md bg-white/[0.05] border border-white/[0.06]"></div>
                                            <div class="flex-1 h-9 rounded-md bg-white/[0.05] border border-white/[0.06]"></div>
                                        </div>
                                    </div>
                                @elseif ($generation->status === 'processing')
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-5 h-5 border-2 border-[#00e97c]/30 border-t-[#00e97c] rounded-full animate-spin"></div>
                                            <span class="text-[10px] text-gray-600">Generating…</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Card body --}}
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-white group-hover:text-[#00e97c] transition-colors line-clamp-1">
                                    {{ $generation->title }}
                                </h3>
                                <p class="mt-1 text-xs text-gray-600">
                                    @if ($slideCount > 0) {{ $slideCount }} Slide{{ $slideCount !== 1 ? 's' : '' }} • @endif
                                    Edited {{ $generation->updated_at->diffForHumans() }}
                                </p>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md border text-[10px] font-medium {{ $badge['cls'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                    <div class="flex items-center gap-3 text-xs" onclick="event.stopPropagation()">
                                        <a href="{{ route('generations.show', $generation) }}"
                                           class="text-gray-600 hover:text-white transition-colors">Open</a>
                                        @if ($generation->status === 'completed')
                                            <a href="{{ route('generations.export', $generation) }}"
                                               class="text-gray-600 hover:text-white transition-colors">Export</a>
                                        @endif
                                    </div>
                                </div>
                                @if ($generation->status === 'failed' && filled($generation->failed_reason))
                                    <p class="mt-2 text-[10px] text-red-400 line-clamp-2">{{ $generation->failed_reason }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($generations->hasPages())
                    <div class="mt-6">{{ $generations->links() }}</div>
                @endif
            @endif
        </div>
    </div>

</div>
</body>
</html>
