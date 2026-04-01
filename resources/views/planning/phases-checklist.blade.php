<x-guest-layout>
    <section class="min-h-screen bg-black px-6 py-10 text-white sm:px-10 lg:px-16">
        <div class="mx-auto w-full max-w-5xl">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold tracking-tight">Deckify MVP Phases and Checklist</h1>
                <p class="mt-2 text-sm text-white/65">This page is the implementation checklist for all phases from Phase 0 to Phase 8.</p>
            </div>

            <div class="space-y-6">
                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 0: Scope Lock and Execution Rules</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [x] Freeze MVP boundaries and deferred scope.</li>
                        <li>- [x] Align README, instruction, and skills docs.</li>
                        <li>- [x] Set phase-completion gate process.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 1: Foundation and Auth Baseline</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [x] Users include subscription plan default free.</li>
                        <li>- [x] Register, login, logout, and profile flow work.</li>
                        <li>- [x] Dashboard route protected by auth middleware.</li>
                        <li>- [x] Seed users available for demo testing.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 2: Public Landing Page and Pricing Tiers</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [ ] Hero, features, testimonials, pricing, CTA, footer done.</li>
                        <li>- [ ] Free, Pro, Team plan cards shown clearly.</li>
                        <li>- [ ] Responsive desktop and mobile behavior verified.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 3: New Presentation Intake and Dashboard History</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [ ] Pasted text intake works.</li>
                        <li>- [ ] DOCX upload intake works.</li>
                        <li>- [ ] Provider selection saved (OpenAI or Grok).</li>
                        <li>- [ ] Dashboard lists generation history by user.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 4: AI Provider Orchestration</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [ ] Provider abstraction implemented.</li>
                        <li>- [ ] OpenAI integration completed first.</li>
                        <li>- [ ] Grok integration follows same output schema.</li>
                        <li>- [ ] API errors handled with user feedback.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 5: Workspace MVP-lite Editing Flow</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [ ] Generation detail workspace page exists.</li>
                        <li>- [ ] Slide list and active content panel exist.</li>
                        <li>- [ ] Prompt-based refinement updates slide content.</li>
                        <li>- [ ] Speaker notes are editable and saved.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 6: PDF Export</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [ ] Export route implemented.</li>
                        <li>- [ ] Export action available in workspace.</li>
                        <li>- [ ] PDF output includes generated content and notes.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 7: Subscription Limit Enforcement</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [ ] Free, Pro, Team limits are enforced.</li>
                        <li>- [ ] Dashboard shows usage status.</li>
                        <li>- [ ] Over-limit generation is blocked with clear message.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-white/12 bg-[#111111] p-5">
                    <h2 class="text-lg font-semibold text-emerald-300">Phase 8: Stabilization and End-to-End Signoff</h2>
                    <ul class="mt-3 space-y-2 text-sm text-white/80">
                        <li>- [ ] Full flow passes: landing -> auth -> create -> generate -> edit -> export.</li>
                        <li>- [ ] Responsive and validation QA done.</li>
                        <li>- [ ] Demo runbook and final docs prepared.</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
</x-guest-layout>
