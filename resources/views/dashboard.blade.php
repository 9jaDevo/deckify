<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Slides') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                @php
                    $statusType = session('status_type', 'success');
                    $statusClasses = $statusType === 'error'
                        ? 'bg-red-100 text-red-800'
                        : 'bg-green-100 text-green-800';
                @endphp
                <div class="mb-4 p-4 rounded-lg {{ $statusClasses }}">
                    {{ session('status') }}
                </div>
            @endif

            @error('plan_limit')
                <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800">
                    {{ $message }}
                </div>
            @enderror

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">New Presentation</h3>

                        <div class="mb-4 rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm text-gray-700">
                            <p class="font-medium">Plan: {{ $planName }}</p>
                            <p>Usage this month: {{ $usageCount }} / {{ $usageLimit }}</p>
                            <p>Remaining: {{ $remainingCount }}</p>
                        </div>

                        @if ($isLimitReached)
                            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                                Monthly limit reached for your current plan. Upgrade your plan or wait for the next monthly cycle.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('generations.store') }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label for="source_text" class="block text-sm font-medium text-gray-700">Paste Text</label>
                                <textarea id="source_text" name="source_text" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Paste your content here...">{{ old('source_text') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Paste up to 50,000 characters, or upload a DOC/DOCX file below.</p>
                                @error('source_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="source_file" class="block text-sm font-medium text-gray-700">Upload DOCX</label>
                                <input id="source_file" type="file" name="source_file" accept=".doc,.docx" class="mt-1 block w-full text-sm text-gray-700" />
                                <p class="mt-1 text-xs text-gray-500">Accepted formats: DOC, DOCX. Maximum size: 10MB.</p>
                                @error('source_file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="provider" class="block text-sm font-medium text-gray-700">AI Provider</label>
                                <select id="provider" name="provider" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="" disabled @selected(old('provider') === null)>Select a provider</option>
                                    <option value="openai" @selected(old('provider') === 'openai')>OpenAI</option>
                                    <option value="grok" @selected(old('provider') === 'grok')>Grok</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Pick a provider before submitting your generation source.</p>
                                @error('provider')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" @disabled($isLimitReached) class="w-full inline-flex justify-center rounded-md border border-transparent bg-gray-900 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-60">
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
                                            @php
                                                $statusColors = [
                                                    'draft' => 'bg-gray-100 text-gray-700',
                                                    'processing' => 'bg-blue-100 text-blue-700',
                                                    'completed' => 'bg-green-100 text-green-700',
                                                    'failed' => 'bg-red-100 text-red-700',
                                                ];

                                                $statusColor = $statusColors[$generation->status] ?? $statusColors['draft'];
                                            @endphp
                                            <span class="text-xs uppercase tracking-wide px-2 py-1 rounded {{ $statusColor }}">{{ $generation->status }}</span>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-600 space-x-2">
                                            <span>Source: {{ strtoupper($generation->source_type) }}</span>
                                            <span>•</span>
                                            <span>Provider: {{ strtoupper($generation->provider) }}</span>
                                            <span>•</span>
                                            <span>{{ $generation->created_at->diffForHumans() }}</span>
                                        </div>

                                        @if ($generation->status === 'processing')
                                            <p class="mt-2 text-sm text-blue-700">AI is generating slides for this deck. Refresh shortly to see the latest state.</p>
                                        @endif

                                        <div class="mt-3 flex items-center gap-3 text-sm">
                                            <a href="{{ route('generations.show', $generation) }}" class="font-medium text-indigo-700 hover:text-indigo-800">Open Workspace</a>
                                            @if ($generation->status === 'completed')
                                                <a href="{{ route('generations.export', $generation) }}" class="font-medium text-gray-800 hover:text-gray-900">Export PDF</a>
                                            @endif
                                        </div>

                                        @if ($generation->status === 'failed' && filled($generation->failed_reason))
                                            <p class="mt-3 text-sm text-red-700">{{ $generation->failed_reason }}</p>
                                        @endif
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
