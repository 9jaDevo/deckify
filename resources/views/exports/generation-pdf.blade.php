<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $generation->title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            margin: 24px;
            font-size: 12px;
            line-height: 1.5;
        }

        h1 {
            font-size: 22px;
            margin: 0 0 12px;
        }

        .meta {
            color: #4b5563;
            margin-bottom: 20px;
            font-size: 11px;
        }

        .slide {
            page-break-inside: avoid;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 14px;
        }

        .slide-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .slide-content {
            white-space: pre-wrap;
            margin-bottom: 10px;
        }

        .notes {
            border-top: 1px dashed #d1d5db;
            padding-top: 8px;
            color: #374151;
            white-space: pre-wrap;
        }

        .notes-label {
            font-weight: bold;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <h1>{{ $generation->title }}</h1>
    <div class="meta">
        Provider: {{ strtoupper($generation->provider) }} | Exported: {{ now()->format('Y-m-d H:i') }}
    </div>

    @foreach ($slides as $index => $slide)
        <section class="slide">
            <div class="slide-title">Slide {{ $index + 1 }}: {{ $slide['title'] ?? 'Untitled Slide' }}</div>
            <div class="slide-content">{{ $slide['content'] ?? '' }}</div>

            @if (! empty($slide['speaker_notes']))
                <div class="notes">
                    <div class="notes-label">Speaker Notes</div>
                    <div>{{ $slide['speaker_notes'] }}</div>
                </div>
            @endif
        </section>
    @endforeach
</body>
</html>
