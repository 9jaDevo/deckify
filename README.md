# Deckify

Deckify is a Laravel application that helps users convert text content into presentation-ready output using AI providers (OpenAI or Grok), then export results as PDF.

This repository is currently focused on an MVP for a competition.

## MVP Scope

1. User authentication (register, login, profile)
2. Landing page with subscription plans
3. Content input
	- Paste text
	- Upload Word document (DOCX)
4. AI generation pipeline
	- Provider selection: OpenAI or Grok
	- Prompt and response normalization
5. Download output as PDF
6. Generation history for logged-in users

## Subscription Model

Deckify has 3 subscription levels on the landing page:

1. Free
	- Basic generation limits
	- Standard processing queue
2. Pro (Paid)
	- Higher generation limits
	- Faster processing
	- Priority support
3. Team (Paid)
	- Highest generation limits
	- Team-focused usage
	- Premium support

## Tech Stack

1. Backend: Laravel 13
2. Database: MySQL
3. Auth scaffold: Laravel Breeze (Blade)
4. Frontend assets: Vite

## Local Setup

1. Install dependencies

```bash
composer install
npm install
```

2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

3. Ensure MySQL database exists (default name: deckify)

4. Run migrations

```bash
php artisan migrate
```

5. Build assets and start server

```bash
npm run build
php artisan serve
```

## Project Notes

Planning and implementation notes are available in:

1. docs/instructions/mvp-competition-plan.md
2. docs/skills/README.md

## Next Build Targets

1. Landing page UI and pricing cards for Free, Pro, and Team plans
2. Usage limits and feature gating by subscription level
3. Word ingestion and AI generation flow
4. PDF export endpoint and generation history pages
