# Deckify

Deckify is a Laravel app that turns user content into presentation-ready output with AI.

This repo is scoped for a competition MVP: ship a polished core flow quickly, then expand.

## Product Direction

Deckify has three core product surfaces:

1. Public landing page (marketing + conversion)
2. Authenticated dashboard/library (saved decks and history)
3. Presentation workspace/editor (editing generated content)

## Competition MVP (In Scope)

1. Landing page with:
	- Hero, how-it-works, features, testimonials, pricing, final CTA, footer
	- Input options in hero: paste text or upload DOCX
	- Three plan cards: Free, Pro, Team
2. Authentication:
	- Register, login, logout, profile
3. New presentation creation:
	- Text input and DOCX upload
	- Choose AI provider (OpenAI or Grok)
4. Generation pipeline:
	- Normalize input and call selected AI provider
	- Save generated result to database
5. Dashboard/history:
	- List user generations
	- Open a generation detail page
6. Export:
	- Download generated result as PDF
7. Basic plan gating:
	- Store user plan (`free`, `pro`, `team`)
	- Enforce simple generation limits per plan

## Post-MVP (Out of Scope for Competition)

1. Browser extension capture flow
2. Full Figma-level slide editor with complex drag-drop design tools
3. Real-time collaboration and comments
4. Billing automation and payment gateway integration
5. PPTX export and advanced template marketplace

## Subscription Model (MVP)

1. Free
	- Lowest generation quota
2. Pro (Paid)
	- Higher generation quota
3. Team (Paid)
	- Highest generation quota

For MVP, pricing display is required on landing page. Payment collection can be mocked or deferred.

## Plan Limits and Usage

Deckify enforces monthly generation limits by plan:

1. Free: `DECKIFY_LIMIT_FREE`
2. Pro: `DECKIFY_LIMIT_PRO`
3. Team: `DECKIFY_LIMIT_TEAM`

Configure these values in `.env` (defaults are set in `.env.example`).

The dashboard shows plan name, monthly usage, remaining allowance, and a clear over-limit message when quota is exhausted.

## Workspace and Export

1. Open any generation from dashboard with **Open Workspace**.
2. Edit active slide content and per-slide speaker notes.
3. Use prompt refinement for active slide updates.
4. Export completed generations as PDF from workspace or dashboard.

Demo script: `docs/instructions/demo-script.md`
Responsive QA checklist: `docs/instructions/responsive-qa-checklist.md`

## Tech Stack

1. Laravel 13
2. MySQL
3. Laravel Breeze (Blade)
4. Vite

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

Ensure a MySQL database named `deckify` exists (or update `.env` values).

## Implementation Notes

1. MVP plan: docs/instructions/mvp-competition-plan.md
2. Phase checklist: docs/instructions/phase-checklists.md
3. Checklist page route: /planning/phases-checklist
4. Skills and done criteria: docs/skills/README.md
