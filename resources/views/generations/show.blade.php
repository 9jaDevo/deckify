@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $generation->title }} — {{ config('app.name', 'Deckify') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased bg-[#0d0d0d] text-white h-screen overflow-hidden">

<div class="flex flex-col h-screen" x-data="{ editMode: false }">

    {{-- ── Top Action Bar ─────────────────────────────────────── --}}
    <header class="h-14 shrink-0 flex items-center justify-between px-6 bg-[#111111] border-b border-white/[0.07]">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 12H5m7-7-7 7 7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back to All Decks
        </a>

        <div class="flex items-center gap-2">
            <h1 class="text-sm font-medium text-white">{{ $generation->title }}</h1>
            @if (session('status') && session('status_type', 'success') === 'success')
                <span class="px-2 py-0.5 rounded-md text-[10px] bg-[#00e97c]/10 text-[#00e97c] border border-[#00e97c]/20">Saved</span>
            @else
                <span class="px-2 py-0.5 rounded-md text-[10px] bg-[#1a1a1a] text-gray-500 border border-white/[0.07]">{{ ucfirst($generation->status) }}</span>
            @endif
        </div>

        <div class="flex items-center gap-2">
            @if ($generation->status === 'completed' && count($slides) > 0)
                <a href="{{ route('generations.export', $generation) }}"
                   class="flex items-center gap-1.5 px-3 py-1.5 bg-[#1a1a1a] border border-white/10 rounded-lg text-sm text-gray-300
                          hover:bg-[#222] hover:border-white/[0.18] transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4-4 4m0 0-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Export
                </a>
            @endif
            <button class="flex items-center gap-1.5 px-4 py-1.5 bg-[#00e97c] hover:bg-[#00d070] text-[#0a0a0a] font-semibold text-sm rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
                Present
            </button>
        </div>
    </header>

    {{-- ── Workspace Body ──────────────────────────────────────── --}}
    <div class="flex-1 flex overflow-hidden">

        {{-- ── Left Thumbnail Rail ──────────────────────────────── --}}
        <aside class="w-[168px] shrink-0 bg-[#111111] border-r border-white/[0.07] overflow-y-auto p-3 flex flex-col gap-2">
            @if (count($slides) === 0)
                <p class="text-[11px] text-gray-600 text-center pt-4">No slides yet</p>
            @else
                @foreach ($slides as $index => $slide)
                    <a href="{{ route('generations.show', ['generation' => $generation, 'slide' => $index]) }}"
                       class="block rounded-lg border transition-colors
                              {{ $slideIndex === $index
                                  ? 'border-[#00e97c] bg-[#00e97c]/[0.04]'
                                  : 'border-white/[0.07] hover:border-white/[0.15]' }}">
                        {{-- Mini slide preview --}}
                        <div class="aspect-video bg-[#1a1a1a] rounded-t-lg overflow-hidden relative p-2.5">
                            <div class="h-0.5 w-8 bg-[#00e97c]/50 rounded-full mb-1.5"></div>
                            <div class="h-1.5 w-full bg-white/[0.14] rounded-full mb-1"></div>
                            <div class="h-1 w-2/3 bg-white/[0.07] rounded-full mb-1.5"></div>
                            <div class="flex gap-1 mt-auto">
                                <div class="flex-1 h-5 rounded bg-white/[0.05]"></div>
                                <div class="flex-1 h-5 rounded bg-white/[0.05]"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5">
                            <p class="text-[10px] font-medium truncate {{ $slideIndex === $index ? 'text-[#00e97c]' : 'text-gray-500' }}">
                                {{ $index + 1 }}. {{ Str::limit($slide['title'] ?? 'Slide '.($index + 1), 18) }}
                            </p>
                        </div>
                    </a>
                @endforeach

                <button class="mt-1 w-full py-2 rounded-lg border border-dashed border-white/[0.09] text-gray-600 text-[11px]
                               hover:border-white/[0.18] hover:text-gray-400 transition-colors">
                    + Add Slide
                </button>
            @endif
        </aside>

        {{-- ── Main Content Area ───────────────────────────────── --}}
        <div class="flex-1 flex flex-col overflow-y-auto p-6 gap-4">

            {{-- Status flash (non-blocking inline) --}}
            @if (session('status') && session('status_type', 'success') !== 'success')
                @php $statusType = session('status_type', 'success'); @endphp
                <div class="rounded-lg px-4 py-2.5 text-sm border shrink-0
                    {{ $statusType === 'error' ? 'bg-red-950/40 text-red-300 border-red-800/30' : 'bg-emerald-950/40 text-emerald-300 border-emerald-800/30' }}">
                    {{ session('status') }}
                </div>
            @endif

            @if ($activeSlide)

                {{-- ── Slide Canvas + Right Tool Rail ─────────── --}}
                <div class="relative shrink-0">

                    {{-- Slide Canvas --}}
                    <div class="bg-[#161616] border border-white/[0.07] rounded-2xl p-8 pr-14 min-h-[260px]">

                        {{-- Section label --}}
                        <p class="text-[11px] font-semibold text-[#00e97c] uppercase tracking-[0.15em] mb-4">
                            {{ str_pad($slideIndex + 1, 2, '0', STR_PAD_LEFT) }} / {{ Str::upper(Str::limit($activeSlide['title'] ?? 'SLIDE', 28, '')) }}
                        </p>

                        {{-- Headline --}}
                        <h2 class="text-2xl lg:text-[1.75rem] font-bold text-white leading-tight mb-6">
                            {{ $activeSlide['title'] ?? 'Untitled Slide' }}
                        </h2>

                        {{-- Content --}}
                        @php $content = $activeSlide['content'] ?? ''; @endphp
                        @if ($content)
                            @php
                                // Try to detect JSON-encoded blocks, otherwise treat as plain text
                                $blocks = null;
                                if (str_starts_with(trim($content), '[') || str_starts_with(trim($content), '{')) {
                                    try { $blocks = json_decode($content, true, 5); } catch (\Throwable) {}
                                }
                            @endphp
                            @if (is_array($blocks))
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @foreach (array_slice($blocks, 0, 4) as $block)
                                        <div class="bg-[#1e1e1e] border border-white/[0.06] rounded-xl p-4">
                                            @if (!empty($block['title'] ?? $block['heading'] ?? null))
                                                <div class="flex items-start gap-2 mb-1.5">
                                                    <svg class="w-4 h-4 text-[#00e97c] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M5 13l4 4L19 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    <p class="text-sm font-semibold text-white">{{ $block['title'] ?? $block['heading'] ?? '' }}</p>
                                                </div>
                                            @endif
                                            @if (!empty($block['body'] ?? $block['text'] ?? $block['description'] ?? null))
                                                <p class="text-xs text-gray-400 leading-relaxed">{{ $block['body'] ?? $block['text'] ?? $block['description'] ?? '' }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @foreach (array_filter(array_slice(preg_split('/\n{2,}/', trim($content)), 0, 4)) as $para)
                                        <div class="bg-[#1e1e1e] border border-white/[0.06] rounded-xl p-4">
                                            <p class="text-sm text-gray-300 leading-relaxed">{{ $para }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                @if (substr_count(trim($content), "\n\n") === 0 && !empty(trim($content)))
                                    {{-- Single block fallback --}}
                                    <p class="text-sm text-gray-300 leading-relaxed -mt-3">{{ $content }}</p>
                                @endif
                            @endif
                        @endif
                    </div>

                    {{-- Right Floating Tool Rail --}}
                    <div class="absolute right-2 top-3 flex flex-col gap-1 bg-[#1a1a1a] border border-white/[0.07] rounded-xl p-1.5">
                        <button @click="editMode = !editMode" title="Edit slide"
                                class="w-7 h-7 flex items-center justify-center rounded-lg transition-colors text-gray-500 hover:text-white"
                                :class="editMode ? 'bg-white/[0.08] text-white' : 'hover:bg-white/[0.06]'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button title="Improve with AI"
                                class="w-7 h-7 flex items-center justify-center rounded-lg text-[#00e97c] hover:bg-[#00e97c]/[0.08] transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button title="Duplicate"
                                class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-600 hover:text-white hover:bg-white/[0.06] transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="h-px bg-white/[0.07] mx-1 my-0.5"></div>
                        <button title="Delete"
                                class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-700 hover:text-red-400 hover:bg-red-500/[0.08] transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- ── AI Prompt Bar ────────────────────────────── --}}
                <div class="shrink-0 bg-[#151515] border @error('prompt') border-red-500/40 @else border-[#00e97c]/20 @enderror rounded-xl
                            focus-within:border-[#00e97c]/50 transition-colors overflow-hidden">
                    <form method="POST" action="{{ route('generations.slide.refine', $generation) }}"
                          class="flex items-center gap-3 px-4 py-3">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="slide_index" value="{{ $slideIndex }}">
                        <div class="w-5 h-5 rounded-full bg-[#00e97c]/10 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-[#00e97c]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input name="prompt" type="text"
                               placeholder="Make this slide more visual and add a comparison table…"
                               value="{{ old('prompt') }}"
                               class="flex-1 bg-transparent text-sm text-gray-300 placeholder-gray-600
                                      focus:outline-none focus:ring-0 border-0 p-0" />
                        <button type="submit"
                                class="shrink-0 px-3 py-1 bg-[#1e1e1e] border border-white/[0.09] rounded-lg text-xs
                                       text-gray-500 hover:text-white hover:border-white/[0.18] font-medium transition-colors">
                            ENTER
                        </button>
                    </form>
                    @error('prompt')
                        <p class="px-4 pb-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Edit Panel (toggled by rail icon) ──────────── --}}
                <div x-show="editMode" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="shrink-0 bg-[#151515] border border-white/[0.07] rounded-xl p-5">
                    <h3 class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-4">Edit Slide</h3>
                    <form method="POST" action="{{ route('generations.slide.update', $generation) }}"
                          class="grid gap-4 sm:grid-cols-2">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="slide_index" value="{{ $slideIndex }}">

                        <div>
                            <label for="title" class="block text-xs font-medium text-gray-500 mb-1.5">Title</label>
                            <input id="title" name="title" type="text" value="{{ old('title', $activeSlide['title'] ?? '') }}"
                                   class="w-full bg-[#1e1e1e] border border-white/[0.07] rounded-lg px-3 py-2 text-sm text-gray-200
                                          focus:outline-none focus:border-[#00e97c]/40 focus:ring-0 transition-colors">
                            @error('title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:row-span-2">
                            <label for="content" class="block text-xs font-medium text-gray-500 mb-1.5">Content</label>
                            <textarea id="content" name="content" rows="7"
                                      class="w-full bg-[#1e1e1e] border border-white/[0.07] rounded-lg px-3 py-2 text-sm text-gray-200
                                             focus:outline-none focus:border-[#00e97c]/40 focus:ring-0 resize-none transition-colors">{{ old('content', $activeSlide['content'] ?? '') }}</textarea>
                            @error('content') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="speaker_notes" class="block text-xs font-medium text-gray-500 mb-1.5">Speaker Notes</label>
                            <textarea id="speaker_notes" name="speaker_notes" rows="4"
                                      class="w-full bg-[#1e1e1e] border border-white/[0.07] rounded-lg px-3 py-2 text-sm text-gray-200
                                             focus:outline-none focus:border-[#00e97c]/40 focus:ring-0 resize-none transition-colors">{{ old('speaker_notes', $activeSlide['speaker_notes'] ?? '') }}</textarea>
                        </div>

                        <div class="sm:col-span-2 flex justify-end">
                            <button type="submit"
                                    class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-sm text-white transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ── AI Speaker Notes ─────────────────────────── --}}
                @if (!empty($activeSlide['speaker_notes']))
                    <div class="shrink-0 bg-[#151515] border border-white/[0.07] rounded-xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-[#00e97c]"></div>
                                <h3 class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">AI Speaker Notes</h3>
                            </div>
                            <button class="text-xs text-gray-600 hover:text-gray-400 transition-colors">Settings ⚙</button>
                        </div>
                        <p class="text-sm text-gray-400 leading-relaxed">{{ $activeSlide['speaker_notes'] }}</p>
                    </div>
                @endif

            @else
                {{-- No active slide --}}
                <div class="flex-1 flex flex-col items-center justify-center text-center py-16">
                    @if ($generation->status === 'processing')
                        <div class="w-10 h-10 border-2 border-[#00e97c]/30 border-t-[#00e97c] rounded-full animate-spin mb-4"></div>
                        <p class="text-sm text-gray-500">AI is generating slides for this deck…</p>
                        <p class="text-xs text-gray-600 mt-1">Refresh in a moment to see the latest state.</p>
                    @else
                        <p class="text-sm text-gray-500">No slide content available yet.</p>
                    @endif
                </div>
            @endif

        </div>
    </div>

    {{-- ── Status footer bar ───────────────────────────────────── --}}
    <div class="shrink-0 h-8 px-6 flex items-center border-t border-white/[0.06] bg-[#0f0f0f]">
        @if ($generation->status === 'processing')
            <span class="text-[11px] text-blue-400">⟳ AI is standing by to edit slide {{ $slideIndex + 1 }}…</span>
        @elseif (session('status'))
            @php $st = session('status_type', 'success'); @endphp
            <span class="text-[11px] {{ $st === 'error' ? 'text-red-400' : 'text-[#00e97c]' }}">{{ session('status') }}</span>
        @else
            <span class="text-[11px] text-gray-700">{{ count($slides) }} slide{{ count($slides) !== 1 ? 's' : '' }} · {{ strtoupper($generation->provider) }}</span>
        @endif
    </div>

</div>
</body>
</html>
