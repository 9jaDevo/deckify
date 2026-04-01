# Deckify MVP Competition Plan

## Objective
Build a Laravel MVP where users land on a marketing page with pricing plans, can upload a Word document or paste text, generate presentation content through AI (OpenAI or Grok), download as PDF, and view history after login.

## Core Features (MVP)
1. Landing page:
   - Product value proposition
   - Pricing section with 3 subscription levels
2. Subscription levels:
   - Free
   - Pro (Paid)
   - Team (Paid)
3. Authentication (register, login, profile)
4. Input methods:
   - DOCX upload
   - Text paste
5. AI generation:
   - Provider selector (`openai` or `grok`)
   - Prompt + response normalization
6. Output:
   - Presentation preview
   - PDF download
7. User history:
   - Save every generation result
   - List and view previous results

## Subscription Rules (MVP)
1. Free:
   - Limited generations per month
   - Basic queue priority
2. Pro (Paid):
   - Higher generation allowance
   - Faster processing queue
3. Team (Paid):
   - Highest allowance
   - Team-focused capacity

Note: Exact numbers for limits should be defined in environment/config values for easy competition tuning.

## Build Order
1. Landing page and pricing sections
2. Auth and protected dashboard
3. Database schema for generation history and subscription fields
4. File/text ingestion pipeline
5. AI service abstraction with provider adapters
6. PDF export
7. Usage limits and plan-based access control
8. Polishing and validation

## Immediate Next Tasks
1. Build landing page sections (hero, features, pricing, CTA).
2. Add plan metadata to users table (default `free`).
3. Create `generation_histories` migration and model.
4. Add dashboard form for text/DOCX + provider selection.
5. Create `AiProviderInterface` and service classes.
6. Implement one provider first (OpenAI), then add Grok.
7. Add a first-pass PDF export endpoint.
8. Enforce generation limits by subscription level.

## Non-MVP (Later)
- PPTX export
- Collaborative editing
- Theme templates
- Analytics dashboard
