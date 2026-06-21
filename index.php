<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TaskMaster - Manage your tasks with ease</title>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Tailwind Config -->
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                            "inverse-on-surface": "#eff1f3",
                            "inverse-primary": "#c3c0ff",
                            "primary-fixed-dim": "#c3c0ff",
                            "surface-bright": "#f7f9fb",
                            "surface-container-lowest": "#ffffff",
                            "outline-variant": "#c7c4d8",
                            "surface-tint": "#4d44e3",
                            "priority-high": "#EF4444",
                            "secondary-fixed": "#d3e4fe",
                            "secondary-fixed-dim": "#b7c8e1",
                            "on-error": "#ffffff",
                            "status-todo": "#94A3B8",
                            "border": "#E2E8F0",
                            "on-tertiary-fixed": "#001a42",
                            "tertiary-fixed-dim": "#adc6ff",
                            "error": "#ba1a1a",
                            "surface": "#f7f9fb",
                            "on-secondary-fixed": "#0b1c30",
                            "on-surface-variant": "#464555",
                            "card-bg": "#FFFFFF",
                            "primary-fixed": "#e2dfff",
                            "tertiary": "#004598",
                            "on-secondary-container": "#54647a",
                            "on-tertiary-container": "#cedbff",
                            "secondary-container": "#d0e1fb",
                            "on-tertiary-fixed-variant": "#004395",
                            "priority-low": "#22C55E",
                            "surface-container-low": "#f2f4f6",
                            "on-secondary-fixed-variant": "#38485d",
                            "status-done": "#16A34A",
                            "on-primary-container": "#ffffff", /* Adjusted to ensure text is white on primary CTA */
                            "tertiary-container": "#005cc6",
                            "outline": "#777587",
                            "error-container": "#ffdad6",
                            "surface-container-high": "#e6e8ea",
                            "primary": "#3525cd",
                            "surface-dim": "#d8dadc",
                            "inverse-surface": "#2d3133",
                            "tertiary-fixed": "#d8e2ff",
                            "priority-medium": "#F59E0B",
                            "on-primary-fixed-variant": "#3323cc",
                            "on-background": "#191c1e",
                            "on-secondary": "#ffffff",
                            "surface-container-highest": "#e0e3e5",
                            "on-error-container": "#93000a",
                            "primary-container": "#4f46e5", /* Slate Blue */
                            "on-tertiary": "#ffffff",
                            "deadline-warning": "#FB923C",
                            "secondary": "#505f76",
                            "background": "#f7f9fb",
                            "on-primary-fixed": "#0f0069",
                            "on-surface": "#191c1e",
                            "on-primary": "#ffffff",
                            "surface-container": "#eceef0",
                            "surface-variant": "#e0e3e5",
                            "text-main": "#1E293B"
                    },
                    "borderRadius": {
                            "DEFAULT": "0.25rem",
                            "lg": "0.5rem",
                            "xl": "0.75rem",
                            "full": "9999px"
                    },
                    "spacing": {
                            "unit": "4px",
                            "gutter": "16px",
                            "margin-mobile": "16px",
                            "container-max-width": "1440px",
                            "margin-desktop": "32px"
                    },
                    "fontFamily": {
                            "body-md": [
                                    "Inter"
                            ],
                            "headline-lg": [
                                    "Hanken Grotesk"
                            ],
                            "body-sm": [
                                    "Inter"
                            ],
                            "label-sm": [
                                    "Inter"
                            ],
                            "headline-lg-mobile": [
                                    "Hanken Grotesk"
                            ],
                            "label-md": [
                                    "Inter"
                            ],
                            "headline-md": [
                                    "Hanken Grotesk"
                            ]
                    },
                    "fontSize": {
                            "body-md": [
                                    "16px",
                                    {
                                            "lineHeight": "24px",
                                            "fontWeight": "400"
                                    }
                            ],
                            "headline-lg": [
                                    "48px", /* Increased slightly for hero presence */
                                    {
                                            "lineHeight": "56px",
                                            "letterSpacing": "-0.02em",
                                            "fontWeight": "700"
                                    }
                            ],
                            "body-sm": [
                                    "14px",
                                    {
                                            "lineHeight": "20px",
                                            "fontWeight": "400"
                                    }
                            ],
                            "label-sm": [
                                    "11px",
                                    {
                                            "lineHeight": "14px",
                                            "fontWeight": "500"
                                    }
                            ],
                            "headline-lg-mobile": [
                                    "36px",
                                    {
                                            "lineHeight": "44px",
                                            "letterSpacing": "-0.01em",
                                            "fontWeight": "700"
                                    }
                            ],
                            "label-md": [
                                    "14px", /* Adjusted slightly for legibility on nav */
                                    {
                                            "lineHeight": "20px",
                                            "letterSpacing": "0.02em",
                                            "fontWeight": "600"
                                    }
                            ],
                            "headline-md": [
                                    "24px",
                                    {
                                            "lineHeight": "32px",
                                            "fontWeight": "600"
                                    }
                            ]
                    }
                }
            }
        }
    </script>
<style>
        html { scroll-behavior: smooth; }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md antialiased selection:bg-primary-fixed selection:text-on-primary-fixed">
<!-- TopNavBar -->
<nav class="bg-surface sticky top-0 z-50 border-b border-outline-variant">
<div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 max-w-container-max-width mx-auto">
<!-- Brand -->
<a href="index.php" class="font-headline-md text-headline-md font-bold text-primary hover:opacity-80 transition-opacity block">
                TaskMaster
            </a>
<!-- Navigation Links -->
<div class="hidden md:flex gap-8 items-center">
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all duration-300" href="#features">Features</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all duration-300" href="#how-it-works">How it Works</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all duration-300" href="#faq">FAQ</a>
</div>
<!-- Actions -->
<div class="flex gap-4 items-center">
<a class="hidden md:block font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="auth/login.php">Login</a>
<a class="bg-primary-container text-on-primary-container font-label-md text-label-md px-5 py-2.5 rounded-lg hover:bg-surface-tint hover:scale-105 hover:shadow-md transition-all duration-300" href="auth/register.php">
                    Get Started
                </a>
</div>
</div>
</nav>
<main>
<!-- Hero Section -->
<section class="relative w-full overflow-hidden">
<!-- Subtle background blob -->
<div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] bg-primary-fixed-dim rounded-full mix-blend-multiply filter blur-[100px] opacity-30 z-0"></div>
<div class="px-margin-mobile md:px-margin-desktop py-24 md:py-32 max-w-container-max-width mx-auto flex flex-col md:flex-row items-center gap-16 relative z-10">
<!-- Hero Content -->
<div class="flex-1 space-y-8 text-center md:text-left">
<h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-text-main text-balance">
                        Manage your tasks with ease
                    </h1>
<p class="font-body-md text-body-md text-on-surface-variant max-w-xl mx-auto md:mx-0">
                        A blank canvas for your thoughts. Organize, prioritize, and collaborate in a distraction-free environment built on the principles of functional minimalism.
                    </p>
<div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-4">
<a class="bg-primary-container text-on-primary-container font-label-md text-label-md px-8 py-3.5 rounded-lg hover:bg-surface-tint hover:scale-105 hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 group" href="auth/register.php">
                            Start for Free
                            <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform duration-300" style="font-variation-settings: 'FILL' 0;">arrow_forward</span>
</a>
<a class="bg-transparent border border-border text-text-main font-label-md text-label-md px-8 py-3.5 rounded-lg hover:bg-surface-container-low hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex items-center justify-center" href="#features">
                            View Demo
                        </a>
</div>
</div>
<!-- Hero Graphic (Trello-inspired Cards) -->
<div class="flex-1 w-full relative h-[400px] hidden md:block perspective-1000">
<!-- Base Grid Pattern Background -->
<div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNFMkU4RjAiLz48L3N2Zz4=')] opacity-50 mask-image-radial"></div>
<!-- Card 1 (Back) -->
<div class="absolute top-12 left-1/4 w-72 bg-surface-container-lowest rounded-xl shadow-md border border-border p-5 transform -rotate-6 scale-95 opacity-80 blur-[1px]">
<div class="flex justify-between items-center mb-3">
<span class="font-label-sm text-label-sm text-status-todo">Q3 Launch</span>
<span class="bg-priority-high/10 text-priority-high font-label-sm text-label-sm px-2 py-0.5 rounded">High</span>
</div>
<div class="h-4 bg-surface-container rounded w-3/4 mb-2"></div>
<div class="h-4 bg-surface-container rounded w-1/2"></div>
</div>
<!-- Card 2 (Front/Focus) -->
<div class="absolute top-24 left-10 w-[340px] bg-card-bg rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-border p-6 transform rotate-2 hover:rotate-0 hover:-translate-y-2 transition-all duration-300 z-10 cursor-default">
<div class="flex justify-between items-center mb-4">
<span class="font-label-sm text-label-sm text-secondary uppercase tracking-wider">Design System</span>
<span class="bg-priority-medium/10 text-priority-medium font-label-sm text-label-sm px-2.5 py-1 rounded">In Progress</span>
</div>
<h3 class="font-headline-md text-[20px] text-text-main mb-3">Refine Component Tokens</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-6 line-clamp-2">Ensure all semantic color tokens are properly mapped to the new bento grid layout and verify contrast ratios.</p>
<div class="flex justify-between items-center border-t border-border pt-4">
<div class="flex -space-x-2">
<div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center border-2 border-card-bg text-on-primary-fixed font-label-sm">JS</div>
<div class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center border-2 border-card-bg text-on-secondary-fixed font-label-sm">MK</div>
</div>
<div class="flex gap-3 text-on-surface-variant">
<div class="flex items-center gap-1 font-body-sm text-body-sm">
<span class="material-symbols-outlined text-[18px]">checklist</span> 3/4
                                </div>
<div class="flex items-center gap-1 font-body-sm text-body-sm">
<span class="material-symbols-outlined text-[18px]">chat_bubble</span> 2
                                </div>
</div>
</div>
</div>
<!-- Card 3 (Side) -->
<div class="absolute top-36 right-4 w-64 bg-surface-container-lowest rounded-xl shadow-sm border border-border p-5 transform rotate-6 scale-90 opacity-90">
<div class="flex justify-between items-center mb-3">
<span class="font-label-sm text-label-sm text-status-todo">Marketing</span>
<span class="bg-priority-low/10 text-priority-low font-label-sm text-label-sm px-2 py-0.5 rounded">Low</span>
</div>
<h3 class="font-body-md text-body-md text-text-main font-semibold mb-2">Draft Release Notes</h3>
<div class="h-2 bg-surface-container rounded w-full mt-4">
<div class="h-full bg-status-done rounded w-1/3"></div>
</div>
</div>
</div>
</div>
</section>
<!-- Stats Section -->
<section class="w-full bg-surface py-12 border-b border-outline-variant">
<div class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop">
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-outline-variant">
<div class="py-4 md:py-0">
<div class="font-headline-lg text-[40px] text-primary mb-2">10k+</div>
<div class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Active Users</div>
</div>
<div class="py-4 md:py-0">
<div class="font-headline-lg text-[40px] text-primary mb-2">500k+</div>
<div class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Tasks Completed</div>
</div>
<div class="py-4 md:py-0">
<div class="font-headline-lg text-[40px] text-primary mb-2">4.9/5</div>
<div class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">User Rating</div>
</div>
</div>
</div>
</section>
<!-- Features Bento Grid -->
<section id="features" class="w-full bg-surface-container-low py-24 border-b border-outline-variant">
<div class="px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto">
<div class="text-center max-w-2xl mx-auto mb-16">
<h2 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-text-main mb-4">
                        Everything you need.<br/>Nothing you don't.
                    </h2>
<p class="font-body-md text-body-md text-on-surface-variant">
                        Our functional minimalist approach strips away the clutter, leaving you with powerful tools that get out of your way.
                    </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Feature 1: Large Visual -->
<div class="md:col-span-2 bg-card-bg rounded-2xl p-8 border border-border shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
<div class="relative z-10 md:w-3/5">
<div class="w-12 h-12 bg-primary-fixed text-on-primary-fixed rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined">dashboard</span>
</div>
<h3 class="font-headline-md text-headline-md text-text-main mb-3">Fluid Organization</h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-6">Trello-inspired boards give you a comprehensive view of your workflow. Drag, drop, and prioritize with zero friction.</p>
</div>
<!-- Abstract UI representation -->
<div class="absolute right-[-10%] top-[20%] w-1/2 h-full opacity-30 group-hover:opacity-100 transition-opacity duration-500 hidden md:block">
<div class="flex gap-4 transform rotate-12">
<div class="w-32 h-48 bg-surface-container rounded-lg border border-border"></div>
<div class="w-32 h-64 bg-surface-container rounded-lg border border-border -mt-8"></div>
<div class="w-32 h-40 bg-surface-container rounded-lg border border-border"></div>
</div>
</div>
</div>
<!-- Feature 2: Small -->
<div class="bg-card-bg rounded-2xl p-8 border border-border shadow-sm hover:shadow-md transition-shadow">
<div class="w-12 h-12 bg-secondary-fixed text-on-secondary-fixed rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined">group</span>
</div>
<h3 class="font-headline-md text-[20px] text-text-main mb-3">Team Collaboration</h3>
<p class="font-body-md text-body-md text-on-surface-variant">Assign tasks, leave contextual comments, and maintain momentum without leaving the board.</p>
</div>
<!-- Feature 3: Small -->
<div class="bg-card-bg rounded-2xl p-8 border border-border shadow-sm hover:shadow-md transition-shadow">
<div class="w-12 h-12 bg-tertiary-fixed text-on-tertiary-fixed rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined">bolt</span>
</div>
<h3 class="font-headline-md text-[20px] text-text-main mb-3">Lightning Fast</h3>
<p class="font-body-md text-body-md text-on-surface-variant">Built for speed. Keyboard-first navigation and optimistic UI updates keep you in the flow state.</p>
</div>
<!-- Feature 4: Large Image Based -->
<div class="md:col-span-2 bg-card-bg rounded-2xl p-8 border border-border shadow-sm hover:shadow-md transition-shadow relative overflow-hidden flex flex-col justify-between min-h-[300px]">
<div class="relative z-10 md:w-1/2 bg-card-bg/80 backdrop-blur-sm p-4 rounded-xl inline-block mt-auto md:mt-0">
<div class="w-10 h-10 bg-surface-variant text-on-surface-variant rounded-lg flex items-center justify-center mb-4">
<span class="material-symbols-outlined">analytics</span>
</div>
<h3 class="font-headline-md text-[20px] text-text-main mb-2">Actionable Insights</h3>
<p class="font-body-md text-body-md text-on-surface-variant">Track throughput and identify bottlenecks with clean, minimal charting tools.</p>
</div>
<div class="absolute inset-0 w-full h-full md:left-1/3 md:w-2/3 bg-cover bg-center opacity-40 md:opacity-100 mix-blend-multiply md:mix-blend-normal" data-alt="A modern, minimalist data visualization interface displayed on a clean white background. The UI features subtle slate blue line charts and soft grey bar graphs. The aesthetic is corporate, structured, and highly professional, focusing on clear productivity metrics without clutter. The lighting is bright and even, reinforcing a light-mode software environment." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA8IoKmpWZRGVyuSkXpoVjweE3UtuNSIYcZ3dIzvOcFGQD5XY00u4V-EBBZY2tDSXgE88s29N2t61GJbSIYclnXKumgUW98e3oxdg_G35O_9Fjld3ZCApF6PGAvoavB1vAoWMpLZOXeoHzt6NMqJha1V65UVUv1wD1SyC0Sa-VdZR9MehlZ9Hy19LlyUJQI_2SEoA5opMsDDT97ya-rU2kmjvRQZpxFjQ89NJuVMBidnAxft7GarzYfNPnjvnnBe0KaAmcf9H2Nn-Y')"></div>
</div>
</div>
</div>
</section>
<!-- How it Works Section -->
<section id="how-it-works" class="w-full bg-surface py-24 border-b border-outline-variant">
<div class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop">
<div class="text-center max-w-2xl mx-auto mb-16">
<h2 class="font-headline-lg-mobile md:font-headline-lg text-text-main mb-4">How it Works</h2>
<p class="font-body-md text-on-surface-variant">Three simple steps to regain control of your workflow.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
<!-- Connecting line for desktop -->
<div class="hidden md:block absolute top-8 left-[16.666%] right-[16.666%] h-0.5 bg-surface-variant z-0"></div>
<!-- Step 1 -->
<div class="relative z-10 flex flex-col items-center text-center">
<div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center font-headline-md mb-6 shadow-md border-4 border-surface">1</div>
<h3 class="font-headline-md text-[20px] text-text-main mb-3">Create Account</h3>
<p class="font-body-md text-on-surface-variant">Sign up in seconds and access your clean, distraction-free workspace immediately.</p>
</div>
<!-- Step 2 -->
<div class="relative z-10 flex flex-col items-center text-center">
<div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center font-headline-md mb-6 shadow-md border-4 border-surface">2</div>
<h3 class="font-headline-md text-[20px] text-text-main mb-3">Add Your Tasks</h3>
<p class="font-body-md text-on-surface-variant">Dump your thoughts, organize them into boards, and set priorities with ease.</p>
</div>
<!-- Step 3 -->
<div class="relative z-10 flex flex-col items-center text-center">
<div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center font-headline-md mb-6 shadow-md border-4 border-surface">3</div>
<h3 class="font-headline-md text-[20px] text-text-main mb-3">Boost Productivity</h3>
<p class="font-body-md text-on-surface-variant">Experience the flow state as you check off tasks in our lightning-fast interface.</p>
</div>
</div>
</div>
</section>
<!-- Testimonials Section -->
<section class="w-full bg-surface-container-low py-24 border-b border-outline-variant">
<div class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop">
<div class="text-center max-w-2xl mx-auto mb-16">
<h2 class="font-headline-lg-mobile md:font-headline-lg text-text-main mb-4">What Our Users Say</h2>
<p class="font-body-md text-on-surface-variant">Don't just take our word for it.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Testimonial 1 -->
<div class="bg-card-bg p-8 rounded-2xl border border-border shadow-sm">
<div class="flex gap-1 text-priority-medium mb-6">
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
<p class="font-body-md text-text-main mb-6 italic">"TaskMaster has completely transformed how our team manages projects. The minimal interface keeps us focused on the actual work."</p>
<div class="flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface font-label-md">SJ</div>
<div>
<div class="font-label-md text-text-main">Sarah Jenkins</div>
<div class="font-label-sm text-on-surface-variant">Product Manager</div>
</div>
</div>
</div>
<!-- Testimonial 2 -->
<div class="bg-card-bg p-8 rounded-2xl border border-border shadow-sm">
<div class="flex gap-1 text-priority-medium mb-6">
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
<p class="font-body-md text-text-main mb-6 italic">"Finally, a task manager that doesn't feel like a chore to use. The speed is incredible and the hotkeys save me hours each week."</p>
<div class="flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface font-label-md">MC</div>
<div>
<div class="font-label-md text-text-main">Michael Chen</div>
<div class="font-label-sm text-on-surface-variant">Software Engineer</div>
</div>
</div>
</div>
<!-- Testimonial 3 -->
<div class="bg-card-bg p-8 rounded-2xl border border-border shadow-sm">
<div class="flex gap-1 text-priority-medium mb-6">
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
<p class="font-body-md text-text-main mb-6 italic">"The actionable insights actually make sense. I can see exactly where my bottlenecks are without needing a data science degree."</p>
<div class="flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface font-label-md">ED</div>
<div>
<div class="font-label-md text-text-main">Elena Davis</div>
<div class="font-label-sm text-on-surface-variant">Marketing Director</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- FAQ Section -->
<section id="faq" class="w-full bg-surface py-24">
<div class="max-w-[800px] mx-auto px-margin-mobile md:px-margin-desktop">
<div class="text-center mb-16">
<h2 class="font-headline-lg-mobile md:font-headline-lg text-text-main mb-4">Frequently Asked Questions</h2>
<p class="font-body-md text-on-surface-variant">Everything you need to know about TaskMaster.</p>
</div>
<div class="space-y-4">
<!-- FAQ 1 -->
<details class="group border border-outline-variant rounded-xl p-6 bg-card-bg cursor-pointer hover:shadow-md transition-all duration-300">
<summary class="font-headline-md text-[18px] text-text-main font-semibold flex justify-between items-center list-none">
    Is there a free trial available?
    <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180">expand_more</span>
</summary>
<p class="font-body-md text-on-surface-variant mt-4 pt-4 border-t border-border opacity-0 group-open:opacity-100 transition-opacity duration-500">Yes! You can use our fully-featured Pro tier free for 14 days. After that, you can choose to upgrade or continue with our basic free plan.</p>
</details>
<!-- FAQ 2 -->
<details class="group border border-outline-variant rounded-xl p-6 bg-card-bg cursor-pointer hover:shadow-md transition-all duration-300">
<summary class="font-headline-md text-[18px] text-text-main font-semibold flex justify-between items-center list-none">
    Can I collaborate with my team?
    <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180">expand_more</span>
</summary>
<p class="font-body-md text-on-surface-variant mt-4 pt-4 border-t border-border opacity-0 group-open:opacity-100 transition-opacity duration-500">Absolutely. TaskMaster is built for teams. You can invite unlimited members, assign tasks, and communicate in real-time within task comments.</p>
</details>
<!-- FAQ 3 -->
<details class="group border border-outline-variant rounded-xl p-6 bg-card-bg cursor-pointer hover:shadow-md transition-all duration-300">
<summary class="font-headline-md text-[18px] text-text-main font-semibold flex justify-between items-center list-none">
    Does TaskMaster integrate with other tools?
    <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180">expand_more</span>
</summary>
<p class="font-body-md text-on-surface-variant mt-4 pt-4 border-t border-border opacity-0 group-open:opacity-100 transition-opacity duration-500">We currently support integrations with Slack, GitHub, Google Drive, and Notion. We're constantly adding more integrations based on user feedback.</p>
</details>
<!-- FAQ 4 -->
<details class="group border border-outline-variant rounded-xl p-6 bg-card-bg cursor-pointer hover:shadow-md transition-all duration-300">
<summary class="font-headline-md text-[18px] text-text-main font-semibold flex justify-between items-center list-none">
    How secure is my data?
    <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180">expand_more</span>
</summary>
<p class="font-body-md text-on-surface-variant mt-4 pt-4 border-t border-border opacity-0 group-open:opacity-100 transition-opacity duration-500">We take security seriously. All data is encrypted at rest and in transit using enterprise-grade standards. We undergo regular security audits to ensure your information stays safe.</p>
</details>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="bg-surface-container-lowest border-t border-outline-variant w-full">
<div class="py-12 px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-2 items-center gap-8 max-w-container-max-width mx-auto">
<div>
<div class="font-headline-md text-headline-md font-bold text-on-surface mb-2">
                    TaskMaster
                </div>
<p class="font-body-sm text-body-sm text-on-surface-variant">
                    © 2024 TaskMaster Functional Minimalism. All rights reserved.
                </p>
</div>
<div class="flex flex-wrap gap-x-8 gap-y-4 md:justify-end">
<a class="font-label-md text-label-md text-on-secondary-container hover:text-primary transition-colors" href="#">Privacy Policy</a>
<a class="font-label-md text-label-md text-on-secondary-container hover:text-primary transition-colors" href="#">Terms of Service</a>
<a class="font-label-md text-label-md text-on-secondary-container hover:text-primary transition-colors" href="#">Contact Support</a>
<a class="font-label-md text-label-md text-on-secondary-container hover:text-primary transition-colors" href="#">API Documentation</a>
</div>
</div>
</footer>
</body></html>