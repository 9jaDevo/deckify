<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Presentation;
use App\Services\AIService;
class PresentationController extends Controller
{
    public function create()
{
    return view('presentations.create');
}
public function index()
{
    $presentations = Presentation::latest()->where('user_id', auth()->id())->get();

    return view('dashboard', compact('presentations'));
}
public function store(Request $request, AIService $aiService)
{
    $request->validate([
        'content' => 'nullable|string',
        'document' => 'nullable|file|mimes:docx',
        'provider' => 'required|string'
    ]);

    $text = $request->input('content');

    if ($request->hasFile('document')) {
        $request->file('document')->store('docs');
        $text = "Extracted text from DOCX";
    }

    // 🤖 REAL AI CALL (via service)
    $result = $aiService->generate($request->provider, $text);

    // ⏱ metadata
    $metadata = [
        'provider' => $request->provider,
        'input_length' => strlen($text),
        'output_length' => strlen($result),
    ];

    // 💾 save
    Presentation::create([
        'user_id' => auth()->id(),
        'input_text' => $text,
        'provider' => $request->provider,
        'output' => $result,
        'metadata' => $metadata,
    ]);

    return redirect()->route('dashboard');
    return redirect()->route('dashboard');
}
}
