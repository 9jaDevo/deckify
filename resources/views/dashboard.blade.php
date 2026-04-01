<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Slides') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">New Presentation</h3>

                        <form method="POST" action="{{ route('generations.store') }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label for="source_text" class="block text-sm font-medium text-gray-700">Paste Text</label>
                                <textarea id="source_text" name="source_text" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Paste your content here...">{{ old('source_text') }}</textarea>
                                @error('source_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="source_file" class="block text-sm font-medium text-gray-700">Upload DOCX</label>
                                <input id="source_file" type="file" name="source_file" accept=".doc,.docx" class="mt-1 block w-full text-sm text-gray-700" />
                                @error('source_file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="provider" class="block text-sm font-medium text-gray-700">AI Provider</label>
                                <select id="provider" name="provider" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="openai" @selected(old('provider') === 'openai')>OpenAI</option>
                                    <option value="grok" @selected(old('provider') === 'grok')>Grok</option>
                                </select>
                                @error('provider')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-gray-900 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-800">
                                Save Generation Source
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Recent Generations</h3>

                        @if ($generations->isEmpty())
                            <p class="text-gray-600">No generations yet. Start with text or DOCX on the left.</p>
                        @else
                            <div class="space-y-3">
                                @foreach ($generations as $generation)
                                    <div class="rounded-lg border border-gray-200 p-4">
                                        <div class="flex items-center justify-between">
                                            <p class="font-medium text-gray-900">{{ $generation->title }}</p>
                                            <span class="text-xs uppercase tracking-wide text-gray-500">{{ $generation->status }}</span>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-600 space-x-2">
                                            <span>Source: {{ strtoupper($generation->source_type) }}</span>
                                            <span>•</span>
                                            <span>Provider: {{ strtoupper($generation->provider) }}</span>
                                            <span>•</span>
                                            <span>{{ $generation->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                {{ $generations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
