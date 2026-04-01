# Deckify Phase Development and Checklist

This is the execution checklist page for the MVP.

## Phase 0: Scope Lock and Execution Rules

- [x] Freeze in-scope MVP features.
- [x] Freeze deferred post-MVP features.
- [x] Align docs (`README`, MVP plan, skills) with same boundary.
- [x] Define phase completion gate process.

## Phase 1: Foundation and Auth Baseline

- [x] Users table includes `plan` default `free`.
- [x] Auth flow works: register, login, logout, profile.
- [x] Protected dashboard route is enforced.
- [x] Seed users available for testing.

## Phase 2: Public Landing Page and Pricing Tiers

- [ ] Hero section implemented.
- [ ] How-it-works section implemented.
- [ ] Features section implemented.
- [ ] Testimonials section implemented.
- [ ] Pricing section with Free, Pro, Team implemented.
- [ ] Final CTA and footer implemented.
- [ ] Mobile responsive behavior verified.

## Phase 3: New Presentation Intake and Dashboard History

- [x] New presentation form accepts pasted text.
- [x] New presentation form accepts DOCX upload.
- [x] Provider selector supports OpenAI and Grok.
- [x] Generation metadata is stored.
- [x] Dashboard lists user generation history.

## Phase 4: AI Provider Orchestration (OpenAI First, then Grok)

- [x] AI provider interface created.
- [x] OpenAI provider implementation connected.
- [x] Grok provider implementation connected.
- [x] Generation output normalized into internal schema.
- [x] API error handling and user feedback added.

## Phase 5: Workspace MVP-lite Editing Flow

- [ ] Generation detail/workspace page exists.
- [ ] Slide list panel is shown.
- [ ] Current slide editable area is shown.
- [ ] Prompt bar updates the active slide.
- [ ] Speaker notes can be edited and saved.
- [ ] Back-to-dashboard flow works.

## Phase 6: PDF Export

- [ ] Export endpoint implemented.
- [ ] Export button available in workspace.
- [ ] PDF contains generated content and notes.
- [ ] Exported filename is readable and consistent.

## Phase 7: Subscription Limit Enforcement

- [ ] Free plan limit enforced.
- [ ] Pro plan higher limit enforced.
- [ ] Team plan highest limit enforced.
- [ ] Usage indicator appears on dashboard.
- [ ] Over-limit message is clear and actionable.

## Phase 8: Stabilization and End-to-End Signoff

- [ ] Loading, success, and error states polished.
- [ ] End-to-end flow passes (landing -> auth -> create -> generate -> edit -> export).
- [ ] Responsive QA completed.
- [ ] Demo script prepared.
- [ ] Docs updated to final MVP state.
