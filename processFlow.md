Deckify Export / Generation Progress Screens
============================================

Create a set of **full-screen dark progress states** for Deckify that appear while a presentation is being generated or exported.

The style should match the rest of the product:

-   black / near-black background
-   soft rounded card container
-   green accent color
-   minimal premium UI
-   centered content
-   smooth progress feedback
-   futuristic SaaS feel

These screens are meant to reassure the user that the AI is working and to make the waiting experience feel polished.

* * * * *

Overall Layout
==============

Each screen should show a **single centered status card** on a dark background.

Card style
----------

-   tall rounded rectangle
-   dark charcoal/black fill
-   very subtle border
-   soft shadow or slight glow
-   centered horizontally and vertically
-   lots of breathing room inside

Content alignment
-----------------

-   all elements center aligned
-   icon at top
-   main heading
-   supporting subtext
-   progress indicators or CTA
-   optional footer note

The entire design should feel calm, premium, and focused.

* * * * *

Screen 1: Multi-step generation state
=====================================

This is the detailed processing screen shown while the presentation is actively being built.

Top icon area
-------------

-   circular dark badge or disc
-   inside it, a bright green **D** logo
-   the circle should have a soft green glow or faint green background tint

Main heading
------------

Text like:\
**Designing your slides...**

Large, bold, white, centered.

Supporting text
---------------

Smaller muted text below the heading, such as:\
**Structuring "Forex Liquidity Cycle"**

This line explains what content is being processed.

Step list
---------

Below the supporting text, show a vertical progress checklist with 3 steps.

Example steps:

-   Analyzing raw input
-   Generating slide narrative
-   Applying premium layout

### Step behavior

Each step has a small dot on the left and a vertical connector line.

Use 3 states:

-   **Completed / active completed:** green dot
-   **Current active:** green dot + brighter text
-   **Upcoming:** gray dot + muted text

In the screenshot:

-   "Analyzing raw input" looks completed
-   "Generating slide narrative" looks active/highlighted
-   "Applying premium layout" looks pending

Progress bar
------------

At the bottom of the card, show a horizontal progress bar.

### Style

-   dark track
-   green fill
-   rounded ends
-   medium thickness
-   not too thin

Footer text
-----------

Small muted footer note like:\
**POWERED BY GROQ AI**

This should be uppercase, centered, subtle, and secondary.

* * * * *

Screen 2: Simple narrative structuring state
============================================

This is a lighter progress screen used for a single focused process.

Top icon
--------

-   circular dark badge
-   green Deckify "D" logo inside
-   soft green background glow

Main heading
------------

**Structuring narrative...**

Large, white, centered.

Supporting text
---------------

Muted line below:\
**Applying "Problem-Solution" framework**

This explains the specific AI action happening.

Progress bar
------------

One centered horizontal progress bar below the text.

### Style

-   dark track
-   green progress fill
-   rounded ends
-   about half-filled in the example

This version is simpler than the multi-step screen and works well for shorter focused AI operations.

* * * * *

Screen 3: Completed / success state
===================================

This appears when export or generation has completed successfully.

Top icon
--------

-   circular dark badge
-   green checkmark or success mark inside
-   subtle outline around the circle
-   should feel more celebratory than the progress state, but still minimal

Main heading
------------

**Presentation Ready ✨**

Large, bold, white, centered.

Supporting text
---------------

A muted line below, such as:\
**8 premium slides generated in 3.2s**

This gives a quick success summary.

Primary CTA button
------------------

Large bright green button:\
**Open Workspace ↗**

### Button style

-   full width or nearly full width inside the card
-   bold dark text
-   pill or rounded rectangle shape
-   strong visual emphasis
-   hover glow optional

Secondary helper text
---------------------

Below the button, show muted small text like:\
**or copy link to share**

This can later become an interactive secondary action.

* * * * *

Recommended export/generation flow
==================================

Your developer can structure the flow like this:

State 1: Processing started
---------------------------

Show a focused status screen like:

-   "Structuring narrative..."
-   progress bar only

State 2: Multi-step generation
------------------------------

Show detailed AI workflow:

-   analyzing
-   generating
-   applying layout

State 3: Success
----------------

Show:

-   ready state
-   slide count
-   time generated
-   open workspace CTA

* * * * *

Visual styling rules
====================

Background
----------

-   full-screen black background
-   no clutter
-   very subtle radial green glow if needed

Card
----

-   dark panel with large radius
-   subtle border: low opacity gray/white
-   premium spacing
-   centered layout

Text
----

-   heading: white, bold
-   supporting text: muted gray
-   status text: white/gray depending on state

Accent green
------------

Use a bright mint/green similar to:

-   `#20F59A`
-   `#2AF598`
-   `#63F5A6`

Icon treatment
--------------

-   icon circles should feel soft and elevated
-   green accents should be glowy, not neon harsh

* * * * *

UX meaning
==========

These screens should communicate:

-   the AI is actively working
-   the process has multiple smart stages
-   the experience is premium and intentional
-   the user should feel confident waiting
-   once complete, the next action is obvious