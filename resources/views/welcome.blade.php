<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deckify - Transform raw intelligence into impact</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-bg-base text-text-primary font-sans antialiased selection:bg-primary selection:text-bg-base overflow-x-hidden">
    <!-- Navbar -->
    <nav x-data="{ scrolled: false }" 
         @scroll.window.throttle.16ms="scrolled = (window.pageYOffset > 20)"
         :class="scrolled ? 'bg-black/40 backdrop-blur-2xl border-white/5' : 'bg-transparent border-transparent'"
         class="fixed top-0 left-0 w-full z-50 border-b transition-all duration-500">
        <div class="max-w-[85rem] mx-auto px-6 py-4 flex items-center justify-between relative">
            <!-- Logo -->
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="w-10 h-10 rounded-xl bg-bg-base/50 flex items-center justify-center border border-white/5 group-hover:border-primary/50 transition-all">
                    <x-logo class="w-6 h-6 text-white" />
                </div>
                <span class="text-lg font-bold tracking-tight text-white/90">Deckify</span>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-10 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                @foreach(['About' => '#about', 'Features' => '#features', 'Pricing' => '#pricing'] as $label => $link)
                    <a href="{{ $link }}" class="text-[11px] font-bold uppercase tracking-[0.2em] text-text-muted hover:text-primary transition-all duration-300">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Action Button -->
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full border border-white/10 text-xs font-bold uppercase tracking-widest hover:bg-white/5 transition-all">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full border border-white/10 text-xs font-bold uppercase tracking-widest hover:bg-white/5 transition-all group">
                        <span class="group-hover:text-primary transition-colors">New Presentation</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-[90vh] overflow-hidden" style="background-color: #050E09;"
        x-data
        x-init="if (window.initPlasma) window.initPlasma($el, { color: '#9CA3AF', speed: 0.4, opacity: 0.35 })">
        
        <!-- Content (above WebGL canvas) -->
        <div class="relative z-20 pointer-events-none flex flex-col items-center justify-center min-h-[90vh] pt-32 px-6">
            <div class="max-w-5xl w-full text-center">
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-white/10 bg-white/[0.03] backdrop-blur-md mb-8 pointer-events-auto">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-text-muted">#1 AI Presentation Workflow</span>
                </div>
                <h1 class="text-6xl md:text-[5.5rem] font-serif text-white leading-[1.05] mb-12 tracking-tighter">
                    Transform raw <span class="italic text-primary" x-data="{
                        words: ['intelligence', 'docs', 'PDFs', 'MD files', 'Word docs', 'data'],
                        currentWordIndex: 0,
                        text: '',
                        isDeleting: false,
                        init() { this.type(); },
                        type() {
                            const currentWord = this.words[this.currentWordIndex];
                            this.text = this.isDeleting 
                                ? currentWord.substring(0, this.text.length - 1) 
                                : currentWord.substring(0, this.text.length + 1);
                            
                            let typeSpeed = this.isDeleting ? 40 : 100;
                            
                            if (!this.isDeleting && this.text === currentWord) {
                                typeSpeed = 2000;
                                this.isDeleting = true;
                            } else if (this.isDeleting && this.text === '') {
                                this.isDeleting = false;
                                this.currentWordIndex = (this.currentWordIndex + 1) % this.words.length;
                                typeSpeed = 400;
                            }
                            
                            setTimeout(() => this.type(), typeSpeed);
                        }
                    }"><span x-text="text"></span><span class="animate-pulse font-light not-italic ml-1 opacity-70">|</span></span><br>into 
                    <span class="relative inline-block">
                        impact
                        <svg class="absolute -bottom-2 md:-bottom-3 left-0 w-full h-[18px] md:h-[22px] text-primary pointer-events-none" viewBox="0 0 100 20" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 15C25.5 8 75.5 4 97.5 13" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </h1>
                
                <!-- Generation Input Card (Liquid Glass) -->
                <div class="max-w-3xl mx-auto rounded-[2.5rem] p-1 bg-gradient-to-b from-white/10 to-white/0 border border-white/10 shadow-[0_32px_120px_rgba(0,0,0,0.6)] group relative pointer-events-auto">
                    <div class="absolute inset-0 bg-primary/5 rounded-[2.5rem] opacity-0 group-focus-within:opacity-100 transition-opacity pointer-events-none"></div>
                    
                    <div class="bg-black/40 backdrop-blur-[40px] rounded-[2.4rem] p-6">
                        <textarea 
                            placeholder="Type your content here..." 
                            class="w-full h-32 bg-transparent text-text-primary border-none focus:ring-0 placeholder:text-text-muted/50 resize-none text-xl p-4 scrollbar-custom"
                        ></textarea>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between p-2 gap-2 sm:gap-0 bg-white/[0.03] backdrop-blur-md rounded-[1.5rem] sm:rounded-full border border-white/5 mt-4">
                            <button class="flex items-center justify-center sm:justify-start gap-3 text-sm font-medium text-text-muted hover:text-white transition-all sm:pl-6 py-3 sm:py-0 group/btn shrink-0 w-full sm:w-auto">
                                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center border border-white/10 group-hover/btn:bg-white/10 transition-all shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <span class="whitespace-nowrap">Upload Documents</span>
                            </button>
                            
                            <button class="w-full sm:w-auto px-8 py-3.5 bg-primary text-bg-base font-bold rounded-xl sm:rounded-[1.25rem] hover:scale-[1.02] active:scale-[0.98] transition-all btn-primary-glow flex items-center justify-center shrink-0">
                                <span class="whitespace-nowrap">New Presentation</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Gradient Mask for Smooth Transition -->
        <div class="absolute bottom-0 left-0 w-full h-48 bg-linear-to-t from-bg-base to-transparent z-10 pointer-events-none"></div>
    </section>

    <!-- How It Works Section -->
    <section id="about" class="py-32 px-6 max-w-6xl mx-auto text-center">
        <h2 class="text-5xl font-serif mb-4">Turn Ideas Into Presentations</h2>
        <p class="text-text-muted text-lg mb-16">Upload your documents or paste your raw notes, and let our intelligent engine generate structured layouts instantly.</p>
        
        <div class="relative max-w-5xl mx-auto aspect-video rounded-[3rem] bg-bg-surface border border-border-muted overflow-hidden group cursor-pointer shadow-2xl">
            <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/20 transition-all duration-500">
                <div class="w-24 h-24 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center group-hover:scale-110 transition-transform shadow-[0_0_50px_rgba(255,255,255,0.1)]">
                    <svg class="w-10 h-10 text-white fill-current translate-x-1" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </div>
            </div>
            <!-- Dynamic Background Element -->
            <div class="absolute -bottom-1/2 -right-1/4 w-full h-full bg-primary/10 blur-[120px] pointer-events-none group-hover:bg-primary/20 transition-all duration-700"></div>
        </div>
    </section>

    <!-- Our Features Section -->
    <section id="features" class="py-32 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-20">
            <h2 class="text-5xl font-serif mb-4">Core Pipeline</h2>
            <p class="text-text-muted text-lg">Built for the competition MVP. Designed for speed.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 relative z-10 w-full mb-10">
            
            <!-- Box 1: Team Workflow (Top Left, ~5 cols) -->
            <div class="md:col-span-5 rounded-[2rem] bg-[#101010] border border-white/5 overflow-hidden flex flex-col justify-end p-10 min-h-[400px] relative group hover:border-white/10 transition-colors">
                <!-- Visual Top -->
                <div class="absolute inset-0 flex items-start justify-center pt-24 pointer-events-none">
                    <div class="relative group-hover:-translate-y-2 transition-transform duration-500">
                        <button class="px-7 py-3 rounded-2xl bg-primary text-bg-base font-bold shadow-[0_0_30px_rgba(0,255,148,0.3)] text-sm whitespace-nowrap group-hover:shadow-[0_0_40px_rgba(0,255,148,0.5)] transition-all">
                            Generate Presentation
                        </button>
                        <!-- Mock Cursor -->
                        <div class="absolute -bottom-6 -right-6 w-12 h-12 flex items-center justify-center translate-x-2 translate-y-2 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-700 ease-out">
                            <svg class="w-6 h-6 text-white drop-shadow-lg absolute top-0 left-0 z-20" fill="currentColor" viewBox="0 0 24 24"><path d="M4 3l4 18 3-7 5 6 3-2-5-6 7-3z"/></svg>
                            <div class="absolute top-4 left-4 w-7 h-7 rounded-full bg-bg-surface border-2 border-white/20 z-10 overflow-hidden shadow-lg"><img src="https://i.pravatar.cc/150?img=33" alt="User" class="w-full h-full object-cover"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Content Bottom -->
                <div class="relative z-10 mt-auto pt-48">
                    <h3 class="text-2xl font-medium text-white mb-3">Instant Generation</h3>
                    <p class="text-text-muted text-[15px] leading-relaxed max-w-[90%]">Paste your text directly or drop in a DOCX file. Deckify normalizes the input automatically.</p>
                </div>
            </div>

            <!-- Box 2: Intelligent Engine (Top Right, ~7 cols) -->
            <div class="md:col-span-7 rounded-[2rem] bg-[#101010] border border-white/5 overflow-hidden flex flex-col p-10 min-h-[400px] relative group hover:border-white/10 transition-colors">
                <!-- Content Top Left -->
                <div class="relative z-30 max-w-[60%] bg-[#101010]/80 p-2 -m-2 rounded-xl backdrop-blur-sm sm:bg-transparent sm:backdrop-blur-none sm:p-0 sm:m-0">
                    <h3 class="text-2xl font-medium text-white mb-3">Intelligent Engine</h3>
                    <p class="text-text-muted text-[15px] leading-relaxed text-shadow-sm">Our advanced algorithms understand context and automatically transform unstructured text into visually captivating, professional slides.</p>
                </div>
                
                <!-- Visual Right Side -->
                <div class="absolute inset-0 pointer-events-none overflow-hidden z-10">
                    <div class="absolute top-[20%] -right-[15%] lg:-right-[5%] w-[500px] h-[500px] bg-primary rounded-full flex items-center justify-center opacity-[0.85] group-hover:scale-105 transition-transform duration-700 ease-out origin-center">
                        <!-- Abstract Logo Structure -->
                        <svg class="w-64 h-64 text-bg-base rotate-12 drop-shadow-2xl translate-x-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                        
                        <!-- Floating Orbits -->
                        <div class="absolute inset-0 w-[120%] h-[120%] -left-[10%] -top-[10%] rounded-full border border-bg-base/20 border-dashed animate-[spin_40s_linear_infinite]"></div>
                        
                        <!-- Mini Badges -->
                        <div class="absolute top-[30%] left-[15%] w-10 h-10 bg-bg-base rounded-full shadow-2xl border border-white/10 flex items-center justify-center p-2.5">
                            <svg class="w-full h-full text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <div class="absolute bottom-[25%] left-[20%] w-10 h-10 bg-bg-base rounded-full shadow-2xl border border-white/10 flex items-center justify-center p-2.5">
                            <svg class="w-full h-full text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 3: All-In-One Search (Bottom Left, ~6 cols) -->
            <div class="md:col-span-6 rounded-[2rem] bg-[#101010] border border-white/5 overflow-hidden flex flex-col justify-end p-10 min-h-[380px] relative group hover:border-white/10 transition-colors">
                <!-- Visual Top -->
                <div class="absolute top-20 left-1/2 -translate-x-1/2 w-4/5 pointer-events-none group-hover:-translate-y-2 transition-transform duration-500">
                    <div class="flex items-center justify-between bg-[#1A1A1A] border border-white/5 rounded-2xl p-4 shadow-2xl ring-1 ring-white/5">
                        <span class="text-text-muted text-sm px-2 font-medium">Generate deck context...</span>
                        <div class="flex items-center gap-1.5 opacity-60">
                            <kbd class="px-2 py-1 rounded bg-[#2A2A2A] border border-black text-[11px] text-white font-sans font-bold shadow-inner">Win</kbd>
                            <kbd class="px-2 py-1 rounded bg-[#2A2A2A] border border-black text-[11px] text-white font-sans font-bold shadow-inner">K</kbd>
                        </div>
                    </div>
                    <!-- Slight background glow -->
                    <div class="absolute inset-0 -z-10 bg-primary/5 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                </div>

                <!-- Content Bottom -->
                <div class="relative z-10 mt-auto pt-32">
                    <h3 class="text-2xl font-medium text-white mb-3">Library Dashboard</h3>
                    <p class="text-text-muted text-[15px] leading-relaxed max-w-[90%]">Access your authenticated history dashboard to view past generations and dive into details.</p>
                </div>
            </div>

            <!-- Box 4: App Integrations (Bottom Right, ~6 cols) -->
            <div class="md:col-span-6 rounded-[2rem] bg-[#101010] border border-white/5 overflow-hidden flex flex-col justify-end p-10 min-h-[380px] relative group hover:border-white/10 transition-colors">
                <!-- Visual Top -->
                <div class="absolute top-16 left-1/2 -translate-x-1/2 w-4/5 flex flex-wrap justify-center items-center gap-6 pointer-events-none group-hover:scale-105 transition-transform duration-500">
                    <!-- Icon layout roughly matching the image -->
                    <div class="flex w-full justify-center gap-6 mb-2">
                        <div class="w-14 h-14 rounded-full bg-[#1A1A1A] border border-white/5 flex items-center justify-center shadow-2xl relative translate-y-3">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.166 6.839 9.489.5.09.682-.217.682-.482 0-.237-.008-.866-.013-1.699-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.03-2.682-.103-.253-.447-1.27.098-2.646 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.376.202 2.394.1 2.646.64.699 1.026 1.591 1.026 2.682 0 3.841-2.337 4.687-4.565 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.577.688.48C19.138 20.161 22 16.416 22 12c0-5.523-4.477-10-10-10z"/></svg>
                        </div>
                        <div class="w-16 h-16 rounded-full bg-[#1A1A1A] border border-white/5 flex items-center justify-center shadow-2xl relative translate-y-1">
                            <span class="text-3xl">📘</span>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-[#1A1A1A] border border-white/5 flex items-center justify-center shadow-2xl relative translate-y-4">
                            <span class="text-2xl">📦</span>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-[#1A1A1A] border border-white/5 flex items-center justify-center shadow-2xl relative">
                            <span class="text-2xl">📊</span>
                        </div>
                    </div>
                    <div class="flex w-full justify-center gap-6">
                         <div class="w-14 h-14 rounded-full bg-[#1A1A1A] border border-white/5 flex items-center justify-center shadow-2xl relative -translate-y-2 translate-x-4">
                            <span class="text-2xl">📁</span>
                        </div>
                        <div class="w-16 h-16 rounded-full bg-[#1A1A1A] border border-white/5 flex items-center justify-center shadow-2xl relative z-10">
                            <svg class="w-8 h-8 text-black bg-white rounded flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm4 4v8l8-8v8l-8-8z"/></svg>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-[#1A1A1A] border border-white/5 flex items-center justify-center shadow-2xl relative -translate-x-4 -translate-y-2">
                             <span class="text-2xl">🎨</span>
                        </div>
                    </div>
                </div>

                <!-- Content Bottom -->
                <div class="relative z-10 mt-auto pt-32">
                    <h3 class="text-2xl font-medium text-white mb-3">Universal PDF Export</h3>
                    <p class="text-text-muted text-[15px] leading-relaxed max-w-[90%]">Download your final results instantly as a high-quality PDF, fully prepared for any high-stakes presentation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof Section -->
    <section id="testimonials" class="py-32 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-20">
            <h2 class="text-5xl font-serif mb-4">Trusted by Professionals</h2>
            <p class="text-text-muted text-lg">See how Deckify transforms workflows across industries.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['name' => 'Sara Chen', 'role' => 'Principal Lead'],
                ['name' => 'Michael Robbins', 'role' => 'Project Director'],
                ['name' => 'Sofia Thompson', 'role' => 'VP of Design']
            ] as $user)
                <div class="p-10 rounded-[2.5rem] bg-bg-surface border border-border-muted flex flex-col gap-6 hover:shadow-2xl transition-all duration-500">
                    <div class="flex gap-1 text-primary">
                        @for($i=0; $i<5; $i++)
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-text-secondary text-lg leading-relaxed font-serif italic">"Deckify has completely transformed our workflow. It makes my everyday project tasks easy and effortless."</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="w-14 h-14 rounded-full bg-bg-base border border-white/10 overflow-hidden ring-4 ring-white/5">
                             <img src="https://i.pravatar.cc/150?u={{ $user['name'] }}" alt="{{ $user['name'] }}" class="w-full h-full object-cover grayscale brightness-110">
                        </div>
                        <div>
                            <p class="font-bold text-white text-lg">{{ $user['name'] }}</p>
                            <p class="text-sm text-text-muted uppercase tracking-widest">{{ $user['role'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Transparent Pricing Section -->
    <section id="pricing" class="py-32 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-20">
            <h2 class="text-5xl font-serif mb-4 text-glow">MVP Pricing Plans</h2>
            <p class="text-text-muted text-lg">Gated limits based on simple subscription tiers.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
            <!-- Free / Starter -->
            <div class="p-12 rounded-[3rem] bg-bg-surface border border-border-muted flex flex-col hover:border-white/20 transition-all duration-500">
                <p class="text-text-muted font-bold tracking-widest uppercase text-xs mb-4">Free</p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-5xl font-serif text-white">$0</span>
                </div>
                <p class="text-text-secondary text-sm mb-10 leading-relaxed">Try out the core pipeline and see how AI can transform your notes.</p>
                
                <ul class="space-y-5 mb-12 flex-grow">
                    @foreach(['Lowest generation quota', 'Basic text input', 'Standard latency', 'Community support'] as $feature)
                        <li class="flex items-center gap-4 text-text-secondary">
                            <div class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center">
                                <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm">{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>

                <button class="w-full py-5 bg-primary/10 text-primary font-bold rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all">Get Started</button>
            </div>

            <!-- Pro -->
            <div class="p-12 rounded-[3rem] bg-bg-surface border-2 border-primary relative shadow-[0_0_50px_rgba(0,255,148,0.1)] flex flex-col lg:scale-105 z-10 overflow-hidden group">
                <div class="absolute top-0 right-0 py-2 px-6 bg-primary text-bg-base text-xs font-bold rounded-bl-2xl uppercase tracking-widest">Most Popular</div>
                
                <p class="text-primary font-bold tracking-widest uppercase text-xs mb-4">Pro</p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-5xl font-serif text-white">$29</span>
                    <span class="text-text-muted text-sm">/mo</span>
                </div>
                <p class="text-text-secondary text-sm mb-10 leading-relaxed">Higher quotas and access to both OpenAI and Grok models for fast-scaling professionals.</p>
                
                <ul class="space-y-5 mb-12 flex-grow">
                    @foreach(['Higher generation quota', 'DOCX Uploads integrated', 'Priority generation speed', 'Export as PDF', 'History Dashboard'] as $feature)
                        <li class="flex items-center gap-4 text-text-secondary">
                            <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center">
                                <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm font-medium text-white">{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>

                <button class="w-full py-5 bg-white text-bg-base font-bold rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all shadow-2xl">Upgrade to Pro</button>
            </div>

            <!-- Team -->
            <div class="p-12 rounded-[3rem] bg-bg-surface border border-border-muted flex flex-col hover:border-white/20 transition-all duration-500">
                <p class="text-text-muted font-bold tracking-widest uppercase text-xs mb-4">Team</p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-5xl font-serif text-white">$99</span>
                    <span class="text-text-muted text-sm">/mo</span>
                </div>
                <p class="text-text-secondary text-sm mb-10 leading-relaxed">Highest generation limits for collaborative environments making many decks.</p>
                
                <ul class="space-y-5 mb-12 flex-grow">
                    @foreach(['Highest generation quota', 'All Pro features', '24/7 dedicated support', 'Early access to editors (Soon)'] as $feature)
                        <li class="flex items-center gap-4 text-text-secondary">
                            <div class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center">
                                <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm">{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>

                <button class="w-full py-5 bg-primary text-bg-base font-bold rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all btn-primary-glow">Get Started</button>
            </div>
        </div>
        
        <div class="text-center mt-16 flex flex-col md:flex-row items-center justify-center gap-4 text-sm text-text-muted">
            <a href="#" class="text-primary hover:underline underline-offset-4 decoration-primary/30">Free trial available</a>
            <span class="hidden md:block w-1.5 h-1.5 bg-border-muted rounded-full"></span>
            <span>No credit card required</span>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-32 px-6">
        <div class="max-w-6xl mx-auto rounded-[4rem] bg-gradient-to-br from-bg-surface to-bg-base border border-border-muted overflow-hidden relative p-12 md:p-24 text-center">
            <!-- Heroic Background Glow -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,rgba(0,255,148,0.15),transparent_70%)]"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <h2 class="text-4xl md:text-6xl font-serif text-white mb-8 tracking-tight">Ready to Solve Your Presentation<br>Challenges?</h2>
                <p class="text-text-muted text-lg mb-12 max-w-2xl mx-auto">Don't let raw information slow you down. Book your free consultation today and see what Deckify can do for you.</p>
                
                <button class="px-12 py-5 bg-primary text-bg-base font-bold rounded-[1.25rem] hover:scale-105 active:scale-95 transition-all shadow-[0_0_40px_rgba(0,255,148,0.4)] mb-12 flex items-center gap-3">
                    Book Free Consultation
                </button>

                <div class="flex flex-wrap justify-center gap-10 text-sm font-medium text-text-muted uppercase tracking-[0.2em]">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        (555) 123-4567
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        hello@deckify
                    </div>
                    <div class="flex items-center gap-3">
                         <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                         Abuja, Nigeria
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black pt-32 pb-16 px-6 border-t border-white/5">
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-5 gap-16 mb-32">
            <div class="col-span-2">
                <div class="flex items-center gap-3 mb-8">
                    <x-logo class="w-10 h-10 text-white" />
                    <span class="text-2xl font-bold tracking-tight text-white">Deckify</span>
                </div>
                <p class="text-text-muted text-lg max-w-sm leading-relaxed mb-8">
                    The world's most advanced AI presentation platform. High-stakes meetings, automated.
                </p>
                <div class="flex gap-5">
                    @foreach(['twitter', 'linkedin', 'instagram', 'facebook'] as $social)
                        <a href="#" class="w-12 h-12 rounded-2xl bg-bg-surface border border-white/5 flex items-center justify-center text-text-muted hover:text-primary hover:border-primary/50 transition-all">
                            <span class="sr-only">{{ $social }}</span>
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.1s.493-1.1 1.1-1.1 1.1.496 1.1 1.1-.493 1.1-1.1 1.1zm8 6.891h-2v-3.868c0-1.214-1.184-1.084-1.787-1.084s-1.213.149-1.213 1.084v3.868h-2v-6h2v.917c.511-.612 1.348-.917 2.298-.917 2.457 0 2.702 1.932 2.702 4.192v1.891z"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Platform</h4>
                <ul class="space-y-4 text-text-muted">
                    <li><a href="#" class="hover:text-primary transition-colors">Generations</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Templates</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Integrations</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Pricing</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Company</h4>
                <ul class="space-y-4 text-text-muted">
                    <li><a href="#" class="hover:text-primary transition-colors">About</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Careers</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Privacy</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Terms</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Contact</h4>
                <ul class="space-y-4 text-text-muted">
                    <li><a href="#" class="hover:text-primary transition-colors">Support</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Sales</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Press</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Status</a></li>
                </ul>
            </div>
        </div>

        <div class="max-w-6xl mx-auto pt-16 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-10">
            <p class="text-text-muted text-sm">
                © 2026 Deckify. All rights reserved. Built for the competition MVP.
            </p>
            <div class="flex items-center gap-10">
                <a href="#" class="text-sm text-text-muted hover:text-white transition-colors">Cookie Policy</a>
                <a href="#" class="px-6 py-3 bg-primary/10 text-primary text-sm font-bold rounded-xl border border-primary/20 hover:bg-primary hover:text-bg-base transition-all">
                    New Presentation
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
