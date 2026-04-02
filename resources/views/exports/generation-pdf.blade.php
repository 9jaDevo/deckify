<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $generation->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @page {
            margin: 14mm;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.55;
            background: #f3f4f6;
        }

        .page {
            page-break-after: always;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            background: #ffffff;
        }
        .page.last {
            page-break-after: auto;
        }

        .page-inner {
            padding: 26px 30px;
        }

        .top-chrome {
            font-size: 9px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 30px;
            background: #f8fafc;
        }

        .cover {
            page-break-after: always;
            border-radius: 14px;
            overflow: hidden;
            background: linear-gradient(140deg, #0f172a 0%, #111827 46%, #042f2e 100%);
            color: #f9fafb;
            border: 1px solid #0b1220;
        }
        .cover-logo {
            display: inline-block;
            font-size: 42px;
            font-weight: bold;
            color: #20F59A;
            margin-bottom: 10px;
            width: 68px;
            height: 68px;
            line-height: 68px;
            border-radius: 16px;
            background: rgba(32, 245, 154, 0.1);
            border: 1px solid rgba(32, 245, 154, 0.28);
        }
        .cover-brand {
            font-size: 14px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #a7f3d0;
            margin-bottom: 46px;
        }
        .cover-title {
            font-size: 34px;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 14px;
            max-width: 680px;
        }
        .cover-meta {
            font-size: 13px;
            color: #d1d5db;
            margin-bottom: 8px;
        }
        .cover-badge {
            display: inline-block;
            padding: 7px 18px;
            border-radius: 20px;
            background: rgba(32, 245, 154, 0.16);
            color: #20F59A;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 24px;
        }
        .cover-content {
            text-align: center;
            padding: 92px 70px 84px;
        }
        .cover-footer {
            font-size: 10px;
            color: #93c5fd;
            border-top: 1px solid rgba(148, 163, 184, 0.28);
            padding: 10px 24px;
        }

        .slide-page {
            background: #ffffff;
        }

        .slide-header {
            border-bottom: 2px solid #eef2f7;
            margin-bottom: 20px;
            padding-bottom: 16px;
        }
        .slide-number {
            display: inline-block;
            width: 34px;
            height: 34px;
            line-height: 34px;
            text-align: center;
            border-radius: 9px;
            background: #0f172a;
            color: #20F59A;
            font-size: 13px;
            font-weight: 700;
            margin-right: 12px;
            vertical-align: middle;
        }
        .slide-title {
            display: inline-block;
            width: 88%;
            vertical-align: middle;
            font-size: 25px;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }

        .slide-content {
            font-size: 13px;
            line-height: 1.75;
            color: #374151;
            white-space: pre-wrap;
            margin-bottom: 22px;
            padding: 16px 18px;
            border: 1px solid #edf2f7;
            border-radius: 10px;
            background: #ffffff;
        }

        .speaker-notes {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px 16px;
        }
        .speaker-notes-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748b;
            margin-bottom: 6px;
        }
        .speaker-notes-text {
            font-size: 12px;
            line-height: 1.6;
            color: #6b7280;
            white-space: pre-wrap;
        }

        .page-footer {
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e5e7eb;
            margin-top: 18px;
            padding-top: 10px;
        }
        .page-footer-brand {
            font-weight: 700;
            color: #334155;
            letter-spacing: 0.9px;
        }

        .meta-chip {
            display: inline-block;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #065f46;
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            border-radius: 999px;
            padding: 4px 8px;
            margin-bottom: 10px;
        }

        .footer-left {
            float: left;
            width: 70%;
        }

        .footer-right {
            float: right;
            width: 30%;
            text-align: right;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="cover">
        <div class="cover-content">
            <div class="cover-logo">D</div>
            <div class="cover-brand">Deckify</div>
            <div class="cover-title">{{ $generation->title }}</div>
            <div class="cover-meta">{{ $slideCount }} slide{{ $slideCount !== 1 ? 's' : '' }} · Generated via {{ strtoupper($generation->provider) }}</div>
            <div class="cover-meta">{{ now()->format('F d, Y') }}</div>
            <div class="cover-badge">AI-Generated Presentation</div>
        </div>
        <div class="cover-footer">Prepared by Deckify AI</div>
    </div>

    @foreach ($slides as $index => $slide)
        <div class="page slide-page {{ $loop->last ? 'last' : '' }}">
            <div class="top-chrome">Deckify Presentation Workspace</div>
            <div class="page-inner">
                <div class="meta-chip">Slide {{ $index + 1 }} of {{ $slideCount }}</div>
                <div class="slide-header">
                    <span class="slide-number">{{ $index + 1 }}</span>
                    <span class="slide-title">{{ $slide['title'] ?? 'Untitled Slide' }}</span>
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

                <div class="page-footer">
                    <div class="footer-left"><span class="page-footer-brand">DECKIFY</span> · Premium Deck Export</div>
                    <div class="footer-right">{{ now()->format('M d, Y') }}</div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @endforeach

</body>
</html>
