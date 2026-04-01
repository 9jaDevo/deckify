<?php

namespace App\Services;

use App\Models\Generation;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ExportService
{
    public function exportGenerationPdf(Generation $generation): Response
    {
        $filename = $this->buildFilename($generation);

        $content = view('exports.generation-pdf', [
            'generation' => $generation,
            'slides' => $this->slides($generation),
        ])->render();

        $pdfBytes = $this->renderSimplePdf($content);

        return response($pdfBytes, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
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

    private function renderSimplePdf(string $htmlContent): string
    {
        $text = trim(strip_tags($htmlContent));
        $text = preg_replace('/\s+/', ' ', $text) ?? '';

        $maxLength = 1800;
        $text = mb_substr($text, 0, $maxLength);

        $chunks = str_split($text !== '' ? $text : 'Deckify export', 90);
        $lines = [];

        foreach ($chunks as $chunk) {
            $lines[] = '('.$this->escapePdfText($chunk).') Tj';
        }

        $textCommands = implode("\n", array_map(
            static fn (string $line, int $i): string => '1 0 0 1 50 '.(780 - ($i * 14)).' Tm '.$line,
            $lines,
            array_keys($lines)
        ));

        $stream = "BT\n/F1 12 Tf\n{$textCommands}\nET";

        $objects = [
            '1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj',
            '2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj',
            '3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj',
            '4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj',
            '5 0 obj << /Length '.strlen($stream).' >> stream'."\n".$stream."\n".'endstream endobj',
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object."\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= 'xref'."\n";
        $pdf .= '0 '.(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= str_pad((string) $offsets[$i], 10, '0', STR_PAD_LEFT)." 00000 n \n";
        }

        $pdf .= 'trailer << /Size '.(count($objects) + 1).' /Root 1 0 R >>' ."\n";
        $pdf .= 'startxref' ."\n".$xrefOffset."\n";
        $pdf .= "%%EOF";

        return $pdf;
    }

    private function escapePdfText(string $text): string
    {
        return str_replace(
            ['\\', '(', ')'],
            ['\\\\', '\\(', '\\)'],
            $text,
        );
    }
}
