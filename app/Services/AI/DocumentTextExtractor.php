<?php

namespace App\Services\AI;

use App\Services\AI\Exceptions\AiProviderException;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DocumentTextExtractor
{
    public function extract(?string $sourceFilePath): string
    {
        if ($sourceFilePath === null || $sourceFilePath === '') {
            throw new AiProviderException('The uploaded document was not found.', 'source_missing');
        }

        if (! Storage::disk('local')->exists($sourceFilePath)) {
            throw new AiProviderException('The uploaded document was not found.', 'source_missing');
        }

        $extension = strtolower(pathinfo($sourceFilePath, PATHINFO_EXTENSION));

        if ($extension !== 'docx') {
            throw new AiProviderException('Only DOCX parsing is currently supported.', 'unsupported_source_type');
        }

        if (! class_exists(ZipArchive::class)) {
            throw new AiProviderException('DOCX parsing is unavailable on this server.', 'docx_parser_unavailable');
        }

        $absolutePath = Storage::disk('local')->path($sourceFilePath);

        $zip = new ZipArchive;

        if ($zip->open($absolutePath) !== true) {
            throw new AiProviderException('Could not read the uploaded DOCX file.', 'source_read_error');
        }

        $documentXml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (! is_string($documentXml) || $documentXml === '') {
            throw new AiProviderException('The uploaded DOCX has no readable content.', 'source_empty');
        }

        $text = strip_tags(str_replace(['</w:p>', '</w:tr>', '</w:br>'], ' ', $documentXml));
        $text = preg_replace('/\s+/', ' ', html_entity_decode($text, ENT_QUOTES | ENT_XML1)) ?? '';
        $text = trim($text);

        if ($text === '') {
            throw new AiProviderException('The uploaded DOCX has no readable text.', 'source_empty');
        }

        return $text;
    }
}
