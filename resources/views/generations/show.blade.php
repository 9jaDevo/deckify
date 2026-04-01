<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $generation->title }}
            </h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                @php
                    $statusType = session('status_type', 'success');
                    $statusClasses = $statusType === 'error'
                        ? 'bg-red-100 text-red-800'
                        : 'bg-green-100 text-green-800';
                @endphp
                <div class="rounded-lg p-4 {{ $statusClasses }}">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex items-center gap-3 text-sm text-gray-600">
                <span class="uppercase tracking-wide">{{ $generation->status }}</span>
                <span>&middot;</span>
                <span>Provider: {{ strtoupper($generation->provider) }}</span>
                <span>&middot;</span>
                <span>{{ count($slides) }} slides</span>
                @if ($generation->status === 'completed' && count($slides) > 0)
                    <span>&middot;</span>
                    <a href="{{ route('generations.export', $generation) }}" class="font-medium text-indigo-700 hover:text-indigo-800">Export PDF</a>
                @endif
            </div>

            <div class="grid gap-6 lg:grid-cols-4">
                <aside class="lg:col-span-1 bg-white rounded-lg border border-gray-200 p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Slides</h3>

                    @if (count($slides) === 0)
                        <p class="text-sm text-gray-600">Slides are not ready yet. Check back once generation is completed.</p>
                    @else
                        <div class="space-y-2">
                            @foreach ($slides as $index => $slide)
                                <a href="{{ route('generations.show', ['generation' => $generation, 'slide' => $index]) }}"
                                   class="block rounded-md border px-3 py-2 text-sm {{ $slideIndex === $index ? 'border-indigo-500 bg-indigo-50 text-indigo-800' : 'border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                                    <p class="font-medium">Slide {{ $index + 1 }}</p>
                                    <p class="text-xs mt-1 line-clamp-2">{{ $slide['title'] ?? 'Untitled Slide' }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </aside>

                <section class="lg:col-span-3 space-y-6">
                    @if (! $activeSlide)
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <p class="text-gray-700">No editable slide is available yet.</p>
                        </div>
                    @else
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Active Slide</h3>

                            <form method="POST" action="{{ route('generations.slide.update', $generation) }}" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="slide_index" value="{{ $slideIndex }}">

                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Slide Title</label>
                                    <input id="title" name="title" type="text" value="{{ old('title', $activeSlide['title'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700">Slide Content</label>
                                    <textarea id="content" name="content" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('content', $activeSlide['content'] ?? '') }}</textarea>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="speaker_notes" class="block text-sm font-medium text-gray-700">Speaker Notes (This Slide)</label>
                                    <textarea id="speaker_notes" name="speaker_notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('speaker_notes', $activeSlide['speaker_notes'] ?? '') }}</textarea>
                                    @error('speaker_notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                                    Save Slide Changes
                                </button>
                            </form>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Refine With AI</h3>
                            <form method="POST" action="{{ route('generations.slide.refine', $generation) }}" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="slide_index" value="{{ $slideIndex }}">

                                <div>
                                    <label for="prompt" class="block text-sm font-medium text-gray-700">Prompt</label>
                                    <textarea id="prompt" name="prompt" rows="3" placeholder="Make this slide more concise and outcome-oriented." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('prompt') }}</textarea>
                                    @error('prompt')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                                    Apply Prompt To Active Slide
                                </button>
                            </form>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
