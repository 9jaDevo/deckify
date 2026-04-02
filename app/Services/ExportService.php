<?php

namespace App\Services;

use App\Models\Generation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ExportService
{
    public function exportGenerationPdf(Generation $generation): Response
    {
        $filename = $this->buildFilename($generation);
        $slides = $this->slides($generation);

        $pdf = Pdf::loadView('exports.generation-pdf', [
            'generation' => $generation,
            'slides' => $slides,
            'slideCount' => count($slides),
        ])
            ->setPaper('a4', 'landscape')
            ->setOption('defaultFont', 'Helvetica')
            ->setOption('isRemoteEnabled', false)
            ->setOption('isHtml5ParserEnabled', true);

        return $pdf->download($filename);
    }

    private function buildFilename(Generation $generation): string
    {
        $title = trim((string) $generation->title);
        $safeTitle = Str::slug($title !== '' ? $title : 'deckify-generation');

        return $safeTitle.'-'.$generation->id.'-'.now()->format('Ymd-His').'.pdf';
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function slides(Generation $generation): array
    {
        $payload = is_array($generation->output_payload) ? $generation->output_payload : [];
        $slides = $payload['slides'] ?? [];

        return is_array($slides) ? array_values(array_filter($slides, 'is_array')) : [];
    }
}
}
