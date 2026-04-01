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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-base text-text-primary font-sans antialiased selection:bg-primary selection:text-bg-base overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 flex justify-center pt-6 px-6">
        <div class="max-w-7xl w-full glass-dark rounded-full px-6 py-3 flex items-center justify-between border border-white/5 shadow-2xl">
            <!-- Logo -->
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="w-10 h-10 rounded-xl bg-bg-base/50 flex items-center justify-center border border-white/5 group-hover:border-primary/50 transition-all">
                    <x-logo class="w-6 h-6 text-white" />
                </div>
                <span class="text-lg font-bold tracking-tight text-white/90">Deckify</span>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-10">
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
    <section class="relative min-h-[90vh] flex flex-col items-center justify-center pt-32 px-6">
        <!-- Background Blurs -->
        <div class="absolute top-[10%] left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-primary/20 rounded-full blur-[120px] pointer-events-none opacity-50"></div>
        
        <div class="max-w-5xl w-full text-center relative z-10">
            <h1 class="text-6xl md:text-[5.5rem] font-serif text-white leading-[1.05] mb-12 tracking-tighter">
                Transform raw <span class="italic text-primary">intelligence</span><br>into impact
            </h1>
            
            <!-- Generation Input Card -->
            <div class="max-w-4xl mx-auto p-3 rounded-[2.5rem] bg-bg-surface border border-border-muted shadow-[0_24px_80px_rgba(0,0,0,0.4)] relative group">
                <div class="absolute inset-0 bg-primary/5 opacity-0 group-focus-within:opacity-100 transition-opacity rounded-[2.5rem] pointer-events-none"></div>
                
                <textarea 
                    placeholder="Type your content here..." 
                    class="w-full h-44 bg-transparent text-text-primary border-none focus:ring-0 placeholder:text-text-muted resize-none text-xl p-8 pb-4"
                ></textarea>

                <div class="flex items-center justify-between p-4 bg-bg-base/30 backdrop-blur-sm rounded-[1.75rem] border border-border-muted/50">
                    <button class="flex items-center gap-3 text-sm font-medium text-text-muted hover:text-white transition-colors pl-6">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload Documents
                    </button>
                    
                    <button class="px-12 py-4 bg-primary text-bg-base font-bold rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all btn-primary-glow">
                        New Presentation
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="about" class="py-32 px-6 max-w-6xl mx-auto text-center">
        <h2 class="text-5xl font-serif mb-4">How it works!</h2>
        <p class="text-text-muted text-lg mb-16">Getting started is easy and takes less than 30 seconds.</p>
        
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
            <h2 class="text-5xl font-serif mb-4">Our Features</h2>
            <p class="text-text-muted text-lg">Getting started is easy and takes less than 30 seconds.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                <div class="h-80 rounded-[2.5rem] bg-bg-surface border border-border-muted p-12 relative overflow-hidden group hover:border-primary/30 transition-colors">
                    <div class="max-w-md relative z-10">
                        <h3 class="text-2xl font-serif mb-4">AI-Driven Storytelling</h3>
                        <p class="text-text-muted">Our advanced algorithms analyze your data to extract the most compelling narratives automatically.</p>
                    </div>
                    <div class="absolute top-0 right-0 p-12 text-primary/20 group-hover:text-primary transition-colors">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="h-80 rounded-[2.5rem] bg-bg-surface border border-border-muted p-12 relative overflow-hidden group hover:border-primary/30 transition-colors">
                     <div class="max-w-md relative z-10">
                        <h3 class="text-2xl font-serif mb-4">Seamless Collaboration</h3>
                        <p class="text-text-muted">Invite your team to review, edit, and perfect your decks in real-time with granular permissions.</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side (Tall Card) -->
            <div class="lg:col-span-4 rounded-[2.5rem] bg-bg-surface border border-border-muted p-12 relative overflow-hidden group hover:border-primary/30 transition-colors">
                <h3 class="text-2xl font-serif mb-4">Custom Branding</h3>
                <p class="text-text-muted mb-8">Maintain consistency with your brand's unique assets and guidelines.</p>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-all duration-500"></div>
            </div>
        </div>
    </section>

    <!-- Social Proof Section -->
    <section id="testimonials" class="py-32 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-20">
            <h2 class="text-5xl font-serif mb-4">Social Proof</h2>
            <p class="text-text-muted text-lg">Getting started is easy and takes less than 30 seconds.</p>
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
            <h2 class="text-5xl font-serif mb-4 text-glow">Transparent Pricing</h2>
            <p class="text-text-muted text-lg">Getting started is easy and takes less than 30 seconds.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
            <!-- Starter -->
            <div class="p-12 rounded-[3rem] bg-bg-surface border border-border-muted flex flex-col hover:border-white/20 transition-all duration-500">
                <p class="text-text-muted font-bold tracking-widest uppercase text-xs mb-4">Starter</p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-5xl font-serif text-white">$499</span>
                </div>
                <p class="text-text-secondary text-sm mb-10 leading-relaxed">Perfect for individuals and solopreneurs looking to level up their presentations.</p>
                
                <ul class="space-y-5 mb-12 flex-grow">
                    @foreach(['Up to 1000 AI generations', 'Standard workflows', 'Basic support', 'Email resources'] as $feature)
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

            <!-- Professional -->
            <div class="p-12 rounded-[3rem] bg-bg-surface border-2 border-primary relative shadow-[0_0_50px_rgba(0,255,148,0.1)] flex flex-col lg:scale-105 z-10 overflow-hidden group">
                <div class="absolute top-0 right-0 py-2 px-6 bg-primary text-bg-base text-xs font-bold rounded-bl-2xl uppercase tracking-widest">Most Popular</div>
                
                <p class="text-primary font-bold tracking-widest uppercase text-xs mb-4">Professional</p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-5xl font-serif text-white">$999</span>
                </div>
                <p class="text-text-secondary text-sm mb-10 leading-relaxed">For serious professionals and fast-scaling teams that need maximum throughput.</p>
                
                <ul class="space-y-5 mb-12 flex-grow">
                    @foreach(['Up to 2500 AI generations', 'Unlimited workflows', 'Priority support', 'Commerce integrations', 'Remove branding'] as $feature)
                        <li class="flex items-center gap-4 text-text-secondary">
                            <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center">
                                <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm font-medium text-white">{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>

                <button class="w-full py-5 bg-white text-bg-base font-bold rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all shadow-2xl">Get Started</button>
            </div>

            <!-- Custom -->
            <div class="p-12 rounded-[3rem] bg-bg-surface border border-border-muted flex flex-col hover:border-white/20 transition-all duration-500">
                <p class="text-text-muted font-bold tracking-widest uppercase text-xs mb-4">Starter</p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-5xl font-serif text-white">Custom</span>
                </div>
                <p class="text-text-secondary text-sm mb-10 leading-relaxed">Family solutions for enterprises needing specialized workflows.</p>
                
                <ul class="space-y-5 mb-12 flex-grow">
                    @foreach(['Daily 1000 AI generations', 'Custom workflows', '24/7 dedicated support', 'Full white-labeling'] as $feature)
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
                         New York, USA
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
