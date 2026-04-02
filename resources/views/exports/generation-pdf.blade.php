<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $generation->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #1a1a2e;
            font-size: 13px;
            line-height: 1.6;
        }

        /* ── Cover Page ─────────────────────────── */
        .cover {
            page-break-after: always;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 60px 80px;
            background: linear-gradient(135deg, #0a0a0f 0%, #111827 100%);
            color: #fff;
        }
        .cover-logo {
            font-size: 48px;
            font-weight: bold;
            color: #20F59A;
            margin-bottom: 12px;
        }
        .cover-brand {
            font-size: 16px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 60px;
        }
        .cover-title {
            font-size: 36px;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 16px;
            max-width: 600px;
        }
        .cover-meta {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 8px;
        }
        .cover-badge {
            display: inline-block;
            padding: 6px 18px;
            border-radius: 20px;
            background: rgba(32, 245, 154, 0.12);
            color: #20F59A;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 24px;
        }

        /* ── Slide Pages ────────────────────────── */
        .slide-page {
            page-break-after: always;
            padding: 40px 50px 60px;
            position: relative;
            min-height: 100%;
        }
        .slide-page:last-child {
            page-break-after: auto;
        }

        .slide-header {
            display: flex;
            align-items: center;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e5e7eb;
        }
        .slide-number {
            display: inline-block;
            width: 36px;
            height: 36px;
            line-height: 36px;
            text-align: center;
            border-radius: 10px;
            background: #111827;
            color: #20F59A;
            font-size: 14px;
            font-weight: 700;
            margin-right: 16px;
            flex-shrink: 0;
        }
        .slide-title {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            line-height: 1.3;
        }

        .slide-content {
            font-size: 14px;
            line-height: 1.8;
            color: #374151;
            white-space: pre-wrap;
            margin-bottom: 28px;
        }

        .speaker-notes {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px 20px;
            margin-top: auto;
        }
        .speaker-notes-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9ca3af;
            margin-bottom: 8px;
        }
        .speaker-notes-text {
            font-size: 12px;
            line-height: 1.6;
            color: #6b7280;
            white-space: pre-wrap;
        }

        /* ── Footer ─────────────────────────────── */
        .page-footer {
            position: fixed;
            bottom: 20px;
            left: 50px;
            right: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #d1d5db;
        }
        .page-footer-brand {
            color: #9ca3af;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    {{-- Fixed footer on all pages --}}
    <div class="page-footer">
        <span class="page-footer-brand">DECKIFY</span>
        <span>{{ now()->format('M d, Y') }}</span>
    </div>

    {{-- ═══ COVER PAGE ═══ --}}
    <div class="cover">
        <div class="cover-logo">D</div>
        <div class="cover-brand">Deckify</div>
        <div class="cover-title">{{ $generation->title }}</div>
        <div class="cover-meta">{{ $slideCount }} slide{{ $slideCount !== 1 ? 's' : '' }} &bull; Generated via {{ strtoupper($generation->provider) }}</div>
        <div class="cover-meta">{{ now()->format('F d, Y') }}</div>
        <div class="cover-badge">AI-Generated Presentation</div>
    </div>

    {{-- ═══ SLIDE PAGES ═══ --}}
    @foreach ($slides as $index => $slide)
        <div class="slide-page">
            <div class="slide-header">
                <div class="slide-number">{{ $index + 1 }}</div>
                <div class="slide-title">{{ $slide['title'] ?? 'Untitled Slide' }}</div>
            </div>

            @if (! empty($slide['content']))
                <div class="slide-content">{{ $slide['content'] }}</div>
            @endif

            @if (! empty($slide['speaker_notes']))
                <div class="speaker-notes">
                    <div class="speaker-notes-label">Speaker Notes</div>
                    <div class="speaker-notes-text">{{ $slide['speaker_notes'] }}</div>
                </div>
            @endif
        </div>
    @endforeach

</body>
</html>
    @endforeach
</body>
</html>
