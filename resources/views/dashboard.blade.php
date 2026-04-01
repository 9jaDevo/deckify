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
    <title>All Slides - {{ config('app.name', 'Deckify') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased bg-[#060607] text-white" style="background:#060607;color:#f5f5f5;">
<div class="h-screen flex bg-[#060607]" style="background:#060607;" x-data="{ showForm: {{ $errors->any() || old('source_text') ? 'true' : 'false' }} }">

    <aside class="w-[260px] shrink-0 bg-[#0d0d10] border-r border-white/[0.08] flex flex-col">
        <div class="px-8 pt-9 pb-7">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3">
                <span class="text-[#00e97c] text-[40px] font-bold leading-none">D</span>
                <span class="text-[36px] font-semibold tracking-tight leading-none">Deckify</span>
            </a>
        </div>

        <div class="px-8">
            <p class="text-[12px] uppercase tracking-[0.12em] text-gray-500 font-semibold">Workspace</p>
            <nav class="mt-4 space-y-1.5">
                <a href="#" class="flex items-center gap-3 rounded-xl bg-white/[0.08] px-4 py-3 text-sm text-white">
                    <svg class="w-4 h-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="font-medium">Collections</span>
                </a>
                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-400 hover:bg-white/[0.04] hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/>
                        <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/>
                    </svg>
                    <span>Templates</span>
                </a>
                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-400 hover:bg-white/[0.04] hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Trash</span>
                </a>
            </nav>
        </div>

        <div class="mt-auto px-8 pb-7 pt-8">
            <div class="border-t border-white/[0.08] pt-5">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-full border border-white/[0.18] bg-[#101217] flex items-center justify-center shrink-0">
                            <span class="text-sm font-semibold text-[#00e97c]">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-base font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $displayPlan }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Log out" class="text-gray-500 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 min-w-0 bg-[#07080b]" style="background:#07080b;">
        <div class="h-full overflow-y-auto px-12 py-10 lg:px-16 lg:py-12">
            @if (session('status') || $errors->has('plan_limit'))
                <div class="mb-6">
                    @if (session('status'))
                        @php $statusType = session('status_type', 'success'); @endphp
                        <div class="mb-2 rounded-xl px-4 py-3 text-sm border {{ $statusType === 'error' ? 'bg-red-950/50 text-red-300 border-red-800/30' : 'bg-emerald-950/40 text-emerald-300 border-emerald-800/30' }}">
                            {{ session('status') }}
                        </div>
                    @endif
                    @error('plan_limit')
                        <div class="rounded-xl px-4 py-3 text-sm bg-red-950/50 text-red-300 border border-red-800/30">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            <header class="mb-8">
                <h1 class="text-5xl font-semibold tracking-tight text-white">All Slides</h1>
                <p class="mt-2 text-2xl text-gray-400">Manage your captured highlights and generated slide decks.</p>
            </header>

            <div class="mb-8 flex items-center gap-4">
                <div class="relative w-full max-w-[420px]">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" stroke-width="2"/>
                        <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="text" placeholder="Search decks..." class="w-full rounded-xl border border-white/[0.09] bg-[#13141a] py-3.5 pl-12 pr-4 text-base text-gray-200 placeholder-gray-500 focus:border-[#00e97c]/55 focus:ring-0 focus:outline-none" />
                </div>
                <div class="ml-auto flex items-center gap-4">
                    <span class="hidden xl:block text-sm text-gray-500">
                        <span class="{{ $isLimitReached ? 'text-red-400' : 'text-[#00e97c]' }} font-semibold">{{ $usageCount }}</span>/{{ $usageLimit }} this month
                    </span>
                    <button @click="showForm = !showForm" class="rounded-xl bg-[#00f586] px-7 py-3.5 text-xl font-semibold text-[#06120b] hover:bg-[#00e97c] transition-colors">
                        + New Presentation
                    </button>
                </div>
            </div>

            <section x-show="showForm" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1" class="mb-7">
                <div class="rounded-2xl border border-white/[0.09] bg-[#121317] p-5">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-white">New Presentation</h2>
                        <p class="text-sm text-gray-500">
                            @if ($isLimitReached)
                                <span class="text-red-400">Monthly limit reached on {{ strtoupper($planName) }}</span>
                            @else
                                {{ $remainingCount }} generation{{ $remainingCount !== 1 ? 's' : '' }} remaining
                            @endif
                        </p>
                    </div>

                    <form method="POST" action="{{ route('generations.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                            <div class="xl:col-span-2">
                                <label for="source_text" class="mb-1.5 block text-xs font-medium text-gray-500">Paste Content</label>
                                <textarea id="source_text" name="source_text" rows="5" placeholder="Paste your content here..." class="w-full rounded-xl border border-white/[0.08] bg-[#1a1b22] px-3 py-2.5 text-sm text-gray-200 placeholder-gray-500 focus:border-[#00e97c]/55 focus:outline-none focus:ring-0 resize-none">{{ old('source_text') }}</textarea>
                                <p class="mt-1 text-[11px] text-gray-600">Up to 50,000 characters</p>
                                @error('source_text') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="source_file" class="mb-1.5 block text-xs font-medium text-gray-500">Upload DOCX</label>
                                <div class="h-[calc(100%-1.75rem)] rounded-xl border border-white/[0.08] bg-[#1a1b22] px-3 py-2.5">
                                    <input id="source_file" type="file" name="source_file" accept=".doc,.docx" class="w-full text-xs text-gray-400 file:mr-3 file:rounded file:border-0 file:bg-[#2a2c35] file:px-2.5 file:py-1 file:text-xs file:text-gray-300 hover:file:bg-[#333644]" />
                                </div>
                                <p class="mt-1 text-[11px] text-gray-600">DOC or DOCX, max 10MB</p>
                                @error('source_file') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex flex-col gap-3">
                                <div>
                                    <label for="provider" class="mb-1.5 block text-xs font-medium text-gray-500">AI Provider</label>
                                    <select id="provider" name="provider" class="w-full rounded-xl border border-white/[0.08] bg-[#1a1b22] px-3 py-2.5 text-sm text-gray-200 focus:border-[#00e97c]/55 focus:outline-none focus:ring-0">
                                        <option value="" disabled @selected(old('provider') === null)>Select...</option>
                                        <option value="openai" @selected(old('provider') === 'openai')>OpenAI</option>
                                        <option value="grok" @selected(old('provider') === 'grok')>Grok</option>
                                    </select>
                                    @error('provider') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <button type="submit" @disabled($isLimitReached) class="mt-auto rounded-xl bg-[#00f586] py-2.5 text-base font-semibold text-[#06120b] hover:bg-[#00e97c] disabled:cursor-not-allowed disabled:opacity-40 transition-colors">Generate Slides</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            @if ($generations->isEmpty())
                <section class="rounded-3xl border border-white/[0.08] bg-[#12141a] p-12 text-center">
                    <div class="mx-auto mb-5 w-14 h-14 rounded-2xl border border-white/[0.1] bg-[#1a1d25] flex items-center justify-center">
                        <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-semibold text-white">No presentations yet</h2>
                    <p class="mt-2 text-base text-gray-400">Create your first deck using the New Presentation button.</p>
                </section>
            @else
                <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($generations as $generation)
                        @php
                            $slideCount = isset($generation->output_payload['slides']) ? count($generation->output_payload['slides']) : 0;
                            $isReady = $generation->status === 'completed';
                            $statusLabel = $isReady ? 'Ready' : ($generation->status === 'processing' ? 'Drafting...' : ucfirst($generation->status));
                            $metricLabel = $slideCount > 0 ? 'Slides' : (($generation->source_type ?? 'text') === 'docx' ? 'Highlights' : 'Slides');
                            $metricValue = $slideCount > 0 ? $slideCount : 0;
                        @endphp

                        <article class="group cursor-pointer rounded-3xl border border-white/[0.08] bg-[#17181f] p-4 transition-all duration-200 hover:border-white/[0.16] hover:-translate-y-0.5 hover:shadow-[0_18px_40px_rgba(0,0,0,0.45)]" onclick="window.location='{{ route('generations.show', $generation) }}'">
                            <div class="h-40 rounded-2xl border border-white/[0.07] bg-[#101116] p-4">
                                @if ($loop->index % 3 === 0)
                                    <div class="h-2.5 w-1/2 rounded-full bg-gray-500/60"></div>
                                    <div class="mt-3 h-7 w-full rounded-md bg-white/80"></div>
                                    <div class="mt-4 h-2 w-2/3 rounded-full bg-gray-600/50"></div>
                                    <div class="mt-2 h-2 w-4/5 rounded-full bg-gray-700/50"></div>
                                @elseif ($loop->index % 3 === 1)
                                    <div class="space-y-3 pt-1">
                                        @for ($r = 0; $r < 4; $r++)
                                            <div class="h-2 rounded-full bg-gray-600/55"></div>
                                        @endfor
                                    </div>
                                @else
                                    <div class="h-full flex items-center justify-center rounded-xl bg-[#23242d] border border-white/[0.06]">
                                        <div class="w-16 h-12 rounded-md bg-gray-500/30"></div>
                                    </div>
                                @endif
                            </div>

                            <h3 class="mt-4 text-[38px] font-semibold leading-tight text-white line-clamp-2">{{ $generation->title }}</h3>
                            <p class="mt-1 text-lg text-gray-500">{{ $metricValue }} {{ $metricLabel }} - Edited {{ $generation->updated_at->diffForHumans() }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $isReady ? 'bg-[#00e97c]/15 text-[#00f586] border border-[#00f586]/25' : 'bg-white/[0.04] text-gray-400 border border-white/[0.1]' }}">
                                    {{ $statusLabel }}
                                </span>
                                <div class="flex items-center gap-3 text-sm" onclick="event.stopPropagation()">
                                    <a href="{{ route('generations.show', $generation) }}" class="text-gray-500 hover:text-white transition-colors">Open</a>
                                    @if ($isReady)
                                        <a href="{{ route('generations.export', $generation) }}" class="text-gray-500 hover:text-white transition-colors">Export</a>
                                    @endif
                                </div>
                            </div>

                            @if ($generation->status === 'failed' && filled($generation->failed_reason))
                                <p class="mt-2 text-xs text-red-400 line-clamp-2">{{ $generation->failed_reason }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>

                @if ($generations->hasPages())
                    <div class="mt-8">{{ $generations->links() }}</div>
                @endif
            @endif
        </div>
    </main>
</div>
</body>
</html>
