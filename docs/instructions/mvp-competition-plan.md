# Deckify MVP Competition Plan

## Objective
Ship an achievable competition MVP that proves Deckify's core value: users can start from text or DOCX, generate with AI, manage results in a dashboard, and export to PDF.

## Core Features (MVP)
1. Landing page:
   - Product value proposition
   - Hero with quick start (paste text / upload DOCX)
   - How it works, features, testimonials, pricing, final CTA
2. Subscription levels:
   - Free
   - Pro (Paid)
   - Team (Paid)
3. Authentication (register, login, profile)
4. New presentation flow:
   - DOCX upload
   - Text paste
   - Provider selector (`openai` or `grok`)
5. Generation storage:
   - Save every generation result
   - Track source type, provider, user, status
6. Dashboard/library:
   - List and view previous results
   - Start new generation
7. Workspace (MVP-lite):
   - Show generated content in editable sections
   - Simple prompt-based refinement input
   - Speaker notes text area
8. Output:
   - PDF download

## Subscription Rules (MVP)
1. Free:
   - Limited generations per month
2. Pro (Paid):
   - Higher generation allowance
3. Team (Paid):
   - Highest allowance

Note: Exact numbers for limits should be defined in environment/config values for easy competition tuning.

## Scope Guardrails (Important)
1. Build a functional workspace, not a complex design suite.
2. Keep editor interactions form-driven in MVP (no heavy drag-drop engine).
3. Keep plan management simple (store plan + enforce limits).
4. If payments are needed later, integrate billing after MVP demo readiness.
5. Browser extension capture and advanced collections are deferred.

## Build Order
1. Landing page and pricing sections
2. Auth and protected routes
3. Database schema for users plan + generation history
4. File/text ingestion pipeline
5. AI service abstraction with provider adapters
6. Dashboard/history pages
7. Workspace MVP-lite (prompt + speaker notes + save)
8. PDF export
9. Usage limits and plan-based access control
10. Polishing and validation

## Immediate Next Tasks
1. Build landing page sections (hero, features, pricing, CTA).
2. Add `plan` metadata to users table (default `free`).
3. Create `generation_histories` migration and model.
4. Add dashboard form for text/DOCX + provider selection.
5. Create `AiProviderInterface` and provider service classes.
6. Implement OpenAI first, then Grok.
7. Create workspace MVP-lite page for refinement + speaker notes.
8. Add PDF export endpoint.
9. Enforce generation limits by subscription level.

## Non-MVP (Later)
- Browser extension capture flow
- Rich drag-drop slide editor with advanced layout tooling
- Full collections taxonomy, starring, and complex filters
- PPTX export
- Collaborative editing
- Theme templates
- Analytics dashboard

## Checklist Reference
- Main phase checklist document: docs/instructions/phase-checklists.md
- In-app checklist page: /planning/phases-checklist
