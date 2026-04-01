# Deckify Skills Folder

This folder defines implementation skills for the competition MVP.

## MVP Skill Modules

1. `landing-and-pricing.md`
	- Build public landing page sections and 3 plan cards.
2. `auth-and-plan-gating.md`
	- Add auth flows and user `plan` field with simple usage limits.
3. `content-ingestion.md`
	- Support text paste and DOCX upload as generation sources.
4. `ai-provider-routing.md`
	- Choose provider and execute normalized AI generation (OpenAI/Grok).
5. `generation-history.md`
	- Save and list user generations in dashboard.
6. `workspace-lite.md`
	- Provide editable generated output view with prompt input and speaker notes.
7. `pdf-export.md`
	- Export generated output to PDF.

## Deferred Skills (Post-MVP)

1. `browser-extension-capture.md`
2. `advanced-slide-designer.md`
3. `realtime-collaboration.md`
4. `pptx-export.md`

Each skill document should include:
- Goal
- Inputs
- Outputs
- Validation rules
- Failure handling
- Test checklist

## Definition of Done (MVP)

1. New user can land on homepage, see pricing tiers, and start generation.
2. Logged-in user can create from text or DOCX and choose provider.
3. Generation result is saved and visible in dashboard/history.
4. User can open result in workspace-lite and refine with prompt input.
5. User can add/edit speaker notes.
6. User can export result as PDF.
7. Plan limits are enforced for Free, Pro, Team.
