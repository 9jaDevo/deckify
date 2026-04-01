# Deckify MVP Demo Script

## Goal
Show the complete core MVP flow in under 5 minutes.

## Pre-demo Setup
1. Start app: `php artisan serve`
2. Start queue worker: `php artisan queue:work`
3. Ensure `.env` has provider keys for OpenAI and/or Grok.
4. Ensure at least one completed generation exists, or generate one during demo.

## Demo Flow
1. Open landing page (`/`) and explain value proposition.
2. Register a new account and land on dashboard.
3. Show subscription usage indicator and explain monthly quota.
4. Create a new generation from pasted text and choose provider.
5. Show status transition in recent generations (draft/processing/completed).
6. Open workspace from dashboard.
7. Edit active slide title/content and save.
8. Use AI prompt bar to refine active slide.
9. Add or edit per-slide speaker notes.
10. Export the completed deck as PDF from workspace.
11. Return to dashboard and show export action on completed row.

## Key Talking Points
1. Plan-aware generation limits are enforced (Free, Pro, Team).
2. All generations are tracked per user with provider metadata.
3. Workspace supports practical MVP editing without heavy design tooling.
4. Export provides portable output for immediate sharing.

## Fallback Plan
1. If provider API is unavailable, open an existing completed generation.
2. Demonstrate workspace editing and PDF export from existing data.
3. Show failed generation messaging and retry flow as resilience evidence.
