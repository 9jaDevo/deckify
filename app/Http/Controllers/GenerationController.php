<?php

namespace App\Http\Controllers;

use App\Models\Generation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GenerationController extends Controller
{
    public function index(Request $request): View
    {
        $generations = $request->user()
            ->generations()
            ->latest()
            ->paginate(10);

        return view('dashboard', [
            'generations' => $generations,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source_text' => ['nullable', 'string'],
            'source_file' => ['nullable', 'file', 'mimes:doc,docx', 'max:10240'],
            'provider' => ['required', 'in:openai,grok'],
        ]);

        if (empty($validated['source_text']) && ! $request->hasFile('source_file')) {
            return back()
                ->withErrors(['source_text' => 'Provide text or upload a DOCX file.'])
                ->withInput();
        }

        $sourceType = $request->hasFile('source_file') ? 'docx' : 'text';
        $sourceFilePath = $request->hasFile('source_file')
            ? $request->file('source_file')->store('generation-sources', 'local')
            : null;

        $title = $sourceType === 'docx'
            ? pathinfo($request->file('source_file')->getClientOriginalName(), PATHINFO_FILENAME)
            : str((string) $validated['source_text'])->limit(50)->toString();

        Generation::create([
            'user_id' => $request->user()->id,
            'title' => $title ?: 'Untitled generation',
            'source_type' => $sourceType,
            'source_file_path' => $sourceFilePath,
            'provider' => $validated['provider'],
            'status' => 'draft',
            'input_text' => $validated['source_text'] ?? null,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Generation source saved. AI processing will be connected in the next phase.');
    }
}
