Full user flow in simple language
=================================

A. Landing page flow
--------------------

The landing page is the public homepage.

### What it contains

-   top navigation
-   hero section with strong headline
-   document/text input area
-   upload document button
-   CTA button like **New Presentation**
-   "How it works" section
-   features section
-   social proof/testimonials
-   pricing section
-   final CTA section
-   footer

### What the user does here

1.  User lands on homepage
2.  Reads value proposition
3.  Either types/pastes document text or uploads a document
4.  Clicks **New Presentation**
5.  System takes them into the app generation flow or dashboard

### Developer note

The homepage is mainly for:

-   acquisition
-   trust building
-   conversion
-   starting a new presentation quickly

* * * * *

B. Quick creation / extension flow
----------------------------------

This is the fast-entry system.

Users can create slides in different ways:

-   type an idea
-   paste long text
-   upload PDF / DOC / markdown
-   capture selected text from a website
-   save snippets into collections

### Main logic

1.  User provides source content
2.  User chooses where to save it, if needed
3.  User clicks generate
4.  AI processes the content
5.  User is redirected to the workspace

This flow should feel very fast and lightweight.

* * * * *

C. Collections / library flow
-----------------------------

There is a dashboard/library screen called something like **All Slides**.

### What it shows

-   left sidebar navigation
-   list of collections or presentation categories
-   recent items
-   starred items
-   specific collections like:
    -   My Pitch
    -   Lecture Notes
-   search bar
-   presentation cards
-   CTA for **New Presentation**

### What the user does

1.  User opens dashboard
2.  Sees all saved presentations
3.  Searches, filters, or selects one
4.  Opens an existing deck or creates a new one

### Developer note

This is the user's main organization area for all saved decks and captured content.

* * * * *

Workspace / editor flow
=======================

This is the most important part of the product.

The workspace is where the user edits generated slides.

Main layout of workspace
------------------------

From the screenshots, the editor has these parts:

### 1\. Left slide panel

-   list of slide thumbnails
-   active slide highlighted
-   button to add a new slide

### 2\. Main canvas / slide preview

-   large editable slide area
-   shows the current slide design
-   updates when user selects another slide

### 3\. Bottom prompt bar

-   AI instruction input
-   user can type commands like:
    -   make this slide more visual
    -   add a comparison table
    -   explain FOMO execution
-   enter/send action to apply AI changes

### 4\. Speaker notes section

-   shown below the slide
-   contains notes for presentation delivery
-   likely editable
-   one of your handwritten notes specifically points out that the workspace should include:
    -   **layout**
    -   **speaker notes**
    -   **sidebar**
    -   **bottom input/prompt area**

### 5\. Top bar

-   back to dashboard / back to all decks
-   presentation title
-   saved state
-   export button
-   present button

### 6\. Right floating toolbar

Looks like quick slide tools such as:

-   layout/view toggle
-   AI actions
-   delete or remove
-   maybe regenerate or settings

* * * * *

Simple editor flow for developer
================================

1.  User opens a presentation from dashboard
2.  First slide appears in main canvas
3.  User clicks another slide thumbnail on the left to switch slides
4.  User edits or improves current slide using AI prompt bar at the bottom
5.  System updates the slide content/design
6.  User can read or edit speaker notes below
7.  User can add more slides
8.  User can export or present when ready

* * * * *

AI editing flow inside the workspace
====================================

The screenshots show that AI is deeply integrated into the editor.

### Example usage

User writes in the bottom input:

-   "Make this slide more visual"
-   "Add a comparison table"
-   "Add a third card explaining FOMO execution"

### Expected system behavior

-   AI reads the current slide
-   applies the requested change
-   updates the slide live
-   may also adjust the speaker notes if needed

### Developer meaning

The workspace should support **slide-specific prompting**, not just full-deck generation.

* * * * *

Main product structure your developer should build
==================================================

1\. Marketing site
------------------

Purpose:

-   explain the product
-   convert visitors
-   allow quick presentation start

### Key sections

-   Header / Nav
-   Hero with headline and input/upload
-   How it works
-   Features
-   Testimonials / Social proof
-   Pricing
-   Final CTA
-   Footer

* * * * *

2\. Authenticated dashboard
---------------------------

Purpose:

-   show all user decks
-   organize saved work
-   allow search and filtering

### Key elements

-   sidebar navigation
-   search
-   deck cards
-   collection list
-   new presentation button

* * * * *

3\. Presentation editor
-----------------------

Purpose:

-   edit slides in detail
-   use AI to refine slides
-   manage notes
-   present/export

### Key elements

-   left slide thumbnails
-   main slide canvas
-   top action bar
-   right quick tools
-   bottom AI prompt bar
-   speaker notes section

* * * * *

Suggested end-to-end product flow
=================================

Here is the full flow in very simple language:

Flow 1: New visitor
-------------------

1.  User lands on homepage
2.  Reads value proposition
3.  Uploads document or pastes content
4.  Clicks **New Presentation**
5.  AI generates first version of deck
6.  User enters workspace to edit

Flow 2: Existing user
---------------------

1.  User logs in
2.  Lands on dashboard/library
3.  Sees existing decks
4.  Opens one deck
5.  Edits slides in workspace
6.  Presents or exports

Flow 3: Capture from extension
------------------------------

1.  User highlights text on a webpage
2.  Sends it to the app/collection
3.  Generates deck from captured text
4.  Opens workspace for editing

* * * * *

Important UX behavior to preserve
=================================

Your developer should not miss these:

1\. Dark premium visual style
-----------------------------

-   black / deep charcoal background
-   soft glowing green CTA buttons
-   clean modern layout
-   minimal but premium

2\. Fast creation from anywhere
-------------------------------

The product should support:

-   typing
-   pasting
-   file upload
-   web capture

3\. Dashboard + workspace separation
------------------------------------

The dashboard is for browsing decks.\
The workspace is for editing a single deck.

4\. AI prompt bar inside editor
-------------------------------

This is a core feature, not optional.

5\. Speaker notes inside editor
-------------------------------

The handwritten note makes this important.\
It should sit below the slide or in a dedicated panel.

6\. Easy presentation actions
-----------------------------

Users should be able to:

-   save
-   export
-   present
-   go back to all decks

* * * * *

Very short version for your developer
=====================================

You can send this exact version:

> Build this as a 3-part AI presentation platform:
>
> **1\. Landing page:**\
> A public homepage with hero section, document/text input, upload button, features, testimonials, pricing, CTA, and footer.
>
> **2\. Dashboard / library:**\
> Logged-in area where users see all presentations, collections, recent items, search, and a "New Presentation" button.
>
> **3\. Workspace / editor:**\
> A full slide editor with left slide thumbnails, main slide canvas, top actions (save/export/present), speaker notes below, and an AI prompt bar at the bottom for editing the current slide with natural language.
>
> Users should be able to start from typed text, pasted text, uploaded files, or captured web text. After generation, they should land in the workspace to refine slides and present/export them.

* * * * *

Feature list in plain language
==============================

Core features
-------------

-   Create presentation from text
-   Create presentation from uploaded file
-   Capture text from web
-   Save content into collections
-   Dashboard for managing decks
-   Open and edit presentations
-   Slide-by-slide AI editing
-   Speaker notes support
-   Export presentation
-   Presentation mode

* * * * *

Suggested page list for the web app
===================================

For implementation, your developer can think of these pages/screens:

-   Landing Page
-   Login / Signup
-   Dashboard / All Slides
-   New Presentation Flow
-   Collections View
-   Presentation Workspace / Editor
-   Pricing Page
-   Export / Present modal or actions

* * * * *

Suggested developer modules
===========================

Frontend modules
----------------

-   Landing page UI
-   Dashboard UI
-   Workspace UI
-   Upload component
-   AI prompt component
-   Slide thumbnail panel
-   Speaker notes panel
-   Collections manager

Backend / logic modules
-----------------------

-   Authentication
-   File upload handling
-   Presentation generation
-   Deck storage
-   Collections storage
-   Slide editing actions
-   Export logic
-   Presentation rendering/state save