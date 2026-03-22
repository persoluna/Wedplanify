<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WedPlanify — Indian Wedding Marketplace Platform</title>
    <meta name="description" content="A full-stack wedding marketplace platform built with Laravel 12, Filament 4, and PostgreSQL. Live demo with real data.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --gold: #c9a96e;
            --gold-light: #e8d5b0;
            --gold-dim: #7a6040;
            --bg: #080706;
            --bg2: #0f0d0b;
            --bg3: #151210;
            --surface: #1a1714;
            --border: rgba(201,169,110,0.15);
            --text: #f0ebe3;
            --text-muted: #8a7d6b;
            --text-dim: #4a4038;
            --red: #c94f4f;
            --teal: #4f9c8c;
            --blue: #4f7ec9;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-weight: 300;
            line-height: 1.7;
            overflow-x: hidden;
        }

        /* ── NOISE TEXTURE OVERLAY ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1000;
            opacity: 0.4;
        }

        /* ── NAV ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 1.5rem 3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid transparent;
            transition: all 0.4s ease;
        }
        nav.scrolled {
            background: rgba(8,7,6,0.92);
            border-bottom-color: var(--border);
            backdrop-filter: blur(12px);
            padding: 1rem 3rem;
        }
        .nav-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--gold);
            letter-spacing: 0.05em;
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            gap: 2.5rem;
            list-style: none;
        }
        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.8rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--gold); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 8rem 2rem 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% 0%, rgba(201,169,110,0.06) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 20% 80%, rgba(201,169,110,0.03) 0%, transparent 50%),
                radial-gradient(ellipse 40% 40% at 80% 80%, rgba(79,124,201,0.03) 0%, transparent 50%);
        }

        .hero-ornament {
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.75rem;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--gold-dim);
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeUp 0.8s ease 0.2s forwards;
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(4rem, 10vw, 9rem);
            font-weight: 300;
            line-height: 0.95;
            letter-spacing: -0.02em;
            color: var(--text);
            opacity: 0;
            animation: fadeUp 0.8s ease 0.4s forwards;
        }
        .hero-title em {
            font-style: italic;
            color: var(--gold);
        }

        .hero-sub {
            margin-top: 2.5rem;
            font-size: 1rem;
            color: var(--text-muted);
            max-width: 520px;
            font-weight: 300;
            line-height: 1.8;
            opacity: 0;
            animation: fadeUp 0.8s ease 0.6s forwards;
        }

        .hero-badges {
            margin-top: 2.5rem;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: center;
            opacity: 0;
            animation: fadeUp 0.8s ease 0.8s forwards;
        }
        .badge {
            font-family: 'DM Mono', monospace;
            font-size: 0.7rem;
            padding: 0.35rem 0.85rem;
            border: 1px solid var(--border);
            border-radius: 2px;
            color: var(--gold-dim);
            letter-spacing: 0.08em;
            background: rgba(201,169,110,0.04);
        }

        .hero-cta {
            margin-top: 3.5rem;
            display: flex;
            gap: 1rem;
            opacity: 0;
            animation: fadeUp 0.8s ease 1s forwards;
        }
        .btn-primary {
            padding: 0.9rem 2.2rem;
            background: var(--gold);
            color: var(--bg);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background: var(--gold-light);
            transform: translateY(-1px);
        }
        .btn-secondary {
            padding: 0.9rem 2.2rem;
            border: 1px solid var(--border);
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            border-color: var(--gold-dim);
            color: var(--gold);
        }

        .hero-scroll {
            position: absolute;
            bottom: 2.5rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            opacity: 0;
            animation: fadeIn 1s ease 1.5s forwards;
        }
        .hero-scroll span {
            font-size: 0.65rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--text-dim);
        }
        .scroll-line {
            width: 1px;
            height: 40px;
            background: linear-gradient(to bottom, var(--gold-dim), transparent);
            animation: scrollLine 2s ease-in-out infinite;
        }

        /* ── SECTIONS ── */
        section {
            padding: 7rem 2rem;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
        }
        .section-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--gold-dim);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
            max-width: 60px;
        }
        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        .section-title em {
            font-style: italic;
            color: var(--gold);
        }
        .section-body {
            color: var(--text-muted);
            font-size: 1rem;
            max-width: 640px;
            line-height: 1.9;
        }

        /* ── DIVIDER ── */
        .divider {
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--border), transparent);
        }

        /* ── ABOUT ── */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
            margin-top: 4rem;
        }
        .about-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px;
        }
        .stat-card {
            background: var(--surface);
            padding: 2rem;
            border: 1px solid var(--border);
        }
        .stat-card:first-child { border-top-left-radius: 2px; }
        .stat-number {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.5rem;
            font-weight: 300;
            color: var(--gold);
            line-height: 1;
        }
        .stat-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            letter-spacing: 0.05em;
        }

        /* ── PANELS ── */
        .panels-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 4rem;
        }
        .panel-card {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }
        .panel-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(to right, var(--gold-dim), var(--gold), var(--gold-dim));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .panel-card:hover { border-color: var(--gold-dim); transform: translateY(-3px); }
        .panel-card:hover::before { transform: scaleX(1); }
        .panel-role {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--gold-dim);
            margin-bottom: 1rem;
        }
        .panel-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 300;
            color: var(--text);
            margin-bottom: 1rem;
        }
        .panel-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }
        .panel-creds {
            border-top: 1px solid var(--border);
            padding-top: 1.2rem;
        }
        .cred-row {
            display: flex;
            justify-content: space-between;
            font-family: 'DM Mono', monospace;
            font-size: 0.68rem;
            color: var(--text-muted);
            margin-bottom: 0.4rem;
        }
        .cred-val { color: var(--gold-dim); }
        .panel-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.2rem;
            font-size: 0.75rem;
            color: var(--gold);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .panel-link::after { content: '→'; transition: transform 0.2s; }
        .panel-card:hover .panel-link::after { transform: translateX(4px); }

        /* ── TECH STACK ── */
        .tech-section { background: var(--bg2); }
        .tech-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            margin-top: 4rem;
            background: var(--border);
            border: 1px solid var(--border);
        }
        .tech-item {
            background: var(--bg2);
            padding: 2.5rem 2rem;
            position: relative;
        }
        .tech-icon {
            font-family: 'DM Mono', monospace;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--gold);
        }
        .tech-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 0.4rem;
        }
        .tech-version {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            color: var(--gold-dim);
            margin-bottom: 0.8rem;
        }
        .tech-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ── INFRASTRUCTURE ── */
        .infra-timeline {
            margin-top: 4rem;
            position: relative;
        }
        .infra-timeline::before {
            content: '';
            position: absolute;
            left: 1.5rem;
            top: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, var(--gold), var(--border), transparent);
        }
        .infra-item {
            display: flex;
            gap: 3rem;
            margin-bottom: 3.5rem;
            padding-left: 5rem;
            position: relative;
        }
        .infra-dot {
            position: absolute;
            left: 1rem;
            top: 0.35rem;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 12px rgba(201,169,110,0.4);
        }
        .infra-phase {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--gold-dim);
            white-space: nowrap;
            padding-top: 0.4rem;
            min-width: 80px;
        }
        .infra-content { flex: 1; }
        .infra-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 0.5rem;
        }
        .infra-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.8;
        }
        .infra-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.8rem;
        }
        .infra-tag {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            padding: 0.25rem 0.6rem;
            background: rgba(201,169,110,0.06);
            border: 1px solid var(--border);
            color: var(--gold-dim);
            letter-spacing: 0.05em;
        }

        /* ── API ── */
        .api-section { background: var(--bg2); }
        .api-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 4rem;
        }
        .api-card {
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 2px;
            overflow: hidden;
        }
        .api-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .api-method {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            padding: 0.2rem 0.5rem;
            background: rgba(79,156,140,0.15);
            color: var(--teal);
            letter-spacing: 0.05em;
        }
        .api-endpoint {
            font-family: 'DM Mono', monospace;
            font-size: 0.78rem;
            color: var(--text);
        }
        .api-body {
            padding: 1.2rem 1.5rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.7;
        }
        .api-params {
            margin-top: 0.8rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }
        .api-param {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            padding: 0.2rem 0.5rem;
            background: rgba(201,169,110,0.05);
            border: 1px solid var(--border);
            color: var(--gold-dim);
        }

        /* ── FOOTER ── */
        footer {
            padding: 4rem 2rem;
            border-top: 1px solid var(--border);
            text-align: center;
        }
        .footer-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 300;
            color: var(--gold);
            margin-bottom: 1rem;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 1.5rem 0;
            list-style: none;
        }
        .footer-links a {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-decoration: none;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--gold); }
        .footer-note {
            font-size: 0.78rem;
            color: var(--text-dim);
            line-height: 1.8;
        }
        .footer-note a { color: var(--gold-dim); text-decoration: none; }
        .footer-note a:hover { color: var(--gold); }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scrollLine {
            0%, 100% { opacity: 0.3; transform: scaleY(1); }
            50% { opacity: 1; transform: scaleY(1.2); }
        }

        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            nav { padding: 1.2rem 1.5rem; }
            nav.scrolled { padding: 0.8rem 1.5rem; }
            .nav-links { display: none; }
            .about-grid { grid-template-columns: 1fr; gap: 3rem; }
            .panels-grid { grid-template-columns: 1fr; }
            .tech-grid { grid-template-columns: 1fr 1fr; }
            .api-grid { grid-template-columns: 1fr; }
            .infra-item { padding-left: 3.5rem; gap: 1.5rem; flex-direction: column; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav id="nav">
    <a href="#" class="nav-logo">WedPlanify</a>
    <ul class="nav-links">
        <li><a href="#about">About</a></li>
        <li><a href="#demo">Live Demo</a></li>
        <li><a href="#stack">Stack</a></li>
        <li><a href="#infra">Infrastructure</a></li>
        <li><a href="#api">API</a></li>
    </ul>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-bg"></div>
    <p class="hero-ornament">✦ Full-Stack Demo Project ✦</p>
    <h1 class="hero-title">Wed<em>Planify</em></h1>
    <p class="hero-sub">
        A curated Indian wedding marketplace — connecting couples with agencies and vendors across the country. Built to production standards and deployed on a hardened cloud server.
    </p>
    <div class="hero-badges">
        <span class="badge">Laravel 12</span>
        <span class="badge">PHP 8.4</span>
        <span class="badge">Filament 4</span>
        <span class="badge">PostgreSQL 17</span>
        <span class="badge">Redis</span>
        <span class="badge">Docker</span>
        <span class="badge">Cloudflare</span>
    </div>
    <div class="hero-cta">
        <a href="#demo" class="btn-primary">Explore Live Demo</a>
        <a href="https://github.com/persoluna/wedding-platform-backend" target="_blank" class="btn-secondary">View Source</a>
    </div>
    <div class="hero-scroll">
        <div class="scroll-line"></div>
        <span>Scroll</span>
    </div>
</section>

<div class="divider"></div>

<!-- ABOUT -->
<section id="about">
    <div class="container">
        <div class="reveal">
            <p class="section-label">01 — About</p>
            <h2 class="section-title">A marketplace built for<br><em>Indian weddings</em></h2>
            <p class="section-body">
                WedPlanify is a full-featured wedding marketplace backend with three role-specific admin panels, a versioned public API, and a complete booking system. It centralises agencies, vendors, clients, and inquiries in one authoritative platform — built with domain-driven architecture and Filament's multi-panel system.
            </p>
        </div>
        <div class="about-grid reveal">
            <div>
                <p class="section-body" style="margin-bottom: 1.5rem;">
                    The system allows administrators to manage the entire marketplace, agencies to handle their vendors and respond to client inquiries, and vendors to maintain profiles, services, and availability calendars.
                </p>
                <p class="section-body">
                    A read-only public API exposes agencies and vendors with rich filtering, sorting, pagination, and media URLs — ready to power a frontend marketing site without any additional backend work.
                </p>
            </div>
            <div class="about-stats">
                <div class="stat-card">
                    <div class="stat-number">56</div>
                    <div class="stat-label">Demo users seeded</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Wedding agencies</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">20</div>
                    <div class="stat-label">Vendors & services</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">157</div>
                    <div class="stat-label">Inquiry messages</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">62</div>
                    <div class="stat-label">Bookings created</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">117</div>
                    <div class="stat-label">Test assertions</div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- LIVE DEMO PANELS -->
<section id="demo">
    <div class="container">
        <div class="reveal">
            <p class="section-label">02 — Live Demo</p>
            <h2 class="section-title">Three panels,<br><em>one platform</em></h2>
            <p class="section-body">
                Each panel is scoped to a specific role with tailored navigation, resources, and permissions. All demo credentials below are live and working.
            </p>
        </div>
        <div class="panels-grid">
            <a href="/admin" class="panel-card reveal">
                <p class="panel-role">Super Administrator</p>
                <h3 class="panel-name">Admin Panel</h3>
                <p class="panel-desc">Full CRUD across all entities — users, agencies, vendors, clients, inquiries, bookings, and reviews. Includes Filament Shield permissions and dependency-aware soft deletes.</p>
                <div class="panel-creds">
                    <div class="cred-row">
                        <span>Email</span>
                        <span class="cred-val">admin@shaadimandap.com</span>
                    </div>
                    <div class="cred-row">
                        <span>Password</span>
                        <span class="cred-val">password</span>
                    </div>
                </div>
                <span class="panel-link">Open Panel</span>
            </a>
            <a href="/agency" class="panel-card reveal">
                <p class="panel-role">Agency Owner</p>
                <h3 class="panel-name">Agency Panel</h3>
                <p class="panel-desc">Agency staff manage their vendor network, respond to client inquiries, maintain portfolios and packages, and track KPIs on a custom dashboard.</p>
                <div class="panel-creds">
                    <div class="cred-row">
                        <span>Email</span>
                        <span class="cred-val">vikram@dreamshaadi.in</span>
                    </div>
                    <div class="cred-row">
                        <span>Password</span>
                        <span class="cred-val">password</span>
                    </div>
                </div>
                <span class="panel-link">Open Panel</span>
            </a>
            <a href="/vendor" class="panel-card reveal">
                <p class="panel-role">Vendor</p>
                <h3 class="panel-name">Vendor Panel</h3>
                <p class="panel-desc">Vendors manage their profiles, services, pricing, availability calendar, and respond to leads — all from a scoped panel tailored to their workflow.</p>
                <div class="panel-creds">
                    <div class="cred-row">
                        <span>Email</span>
                        <span class="cred-val">arjun@pixelperfect.in</span>
                    </div>
                    <div class="cred-row">
                        <span>Password</span>
                        <span class="cred-val">password</span>
                    </div>
                </div>
                <span class="panel-link">Open Panel</span>
            </a>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- TECH STACK -->
<section id="stack" class="tech-section">
    <div class="container">
        <div class="reveal">
            <p class="section-label">03 — Tech Stack</p>
            <h2 class="section-title">Built on a<br><em>modern foundation</em></h2>
            <p class="section-body">
                Every technology was chosen deliberately — for performance, developer experience, and long-term maintainability.
            </p>
        </div>
        <div class="tech-grid reveal">
            <div class="tech-item">
                <div class="tech-icon">⚡</div>
                <div class="tech-name">Laravel 12</div>
                <div class="tech-version">PHP 8.4 · OPcache JIT</div>
                <p class="tech-desc">Modern routing, Eloquent ORM, queues, and first-class Sail support. Domain-driven architecture with <code>app/Domain/*</code> namespaces.</p>
            </div>
            <div class="tech-item">
                <div class="tech-icon">🎛</div>
                <div class="tech-name">Filament 4</div>
                <div class="tech-version">Multi-panel · Shield RBAC</div>
                <p class="tech-desc">Three role-scoped panels (/admin, /agency, /vendor) with Filament Shield permissions, custom widgets, and dashboard KPIs.</p>
            </div>
            <div class="tech-item">
                <div class="tech-icon">🐘</div>
                <div class="tech-name">PostgreSQL 17</div>
                <div class="tech-version">Docker · Alpine</div>
                <p class="tech-desc">Reliable relational storage with JSON support for flexible vendor attributes. 24 migrations, soft deletes, and full referential integrity.</p>
            </div>
            <div class="tech-item">
                <div class="tech-icon">⚙️</div>
                <div class="tech-name">Redis</div>
                <div class="tech-version">Cache · Sessions</div>
                <p class="tech-desc">High-speed in-memory cache for sessions, query results, and queue processing. Runs as a health-checked Docker service.</p>
            </div>
            <div class="tech-item">
                <div class="tech-icon">🐳</div>
                <div class="tech-name">Docker</div>
                <div class="tech-version">Compose · Production</div>
                <p class="tech-desc">Fully containerised production stack. Custom PHP 8.4 image from Ubuntu 24.04 with Supervisor managing the app process.</p>
            </div>
            <div class="tech-item">
                <div class="tech-icon">🔷</div>
                <div class="tech-name">Nginx 1.28</div>
                <div class="tech-version">HTTP/3 · QUIC</div>
                <p class="tech-desc">Official Nginx repo (not Ubuntu's outdated 1.24). HTTP/3 enabled with QUIC. Reverse proxy to Docker container on port 8080.</p>
            </div>
            <div class="tech-item">
                <div class="tech-icon">☁️</div>
                <div class="tech-name">Cloudflare</div>
                <div class="tech-version">CDN · DDoS · DNS</div>
                <p class="tech-desc">All traffic proxied through Cloudflare's Mumbai edge. Real server IP hidden. Brotli compression and DDoS mitigation included free.</p>
            </div>
            <div class="tech-item">
                <div class="tech-icon">🎨</div>
                <div class="tech-name">Vite 7</div>
                <div class="tech-version">ESM · Production build</div>
                <p class="tech-desc">Modern frontend bundler with hot module replacement for development. Production builds are minified and fingerprinted for cache busting.</p>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- INFRASTRUCTURE -->
<section id="infra">
    <div class="container">
        <div class="reveal">
            <p class="section-label">04 — Infrastructure</p>
            <h2 class="section-title">How the server<br><em>was built</em></h2>
            <p class="section-body">
                This isn't just deployed — it's hardened. Every layer of the server stack was configured deliberately, from kernel parameters to HTTP/3. Here's what was done and why.
            </p>
        </div>
        <div class="infra-timeline">
            <div class="infra-item reveal">
                <div class="infra-dot"></div>
                <div class="infra-phase">Phase 1</div>
                <div class="infra-content">
                    <h3 class="infra-title">Server hardening</h3>
                    <p class="infra-desc">
                        Started with a fresh Ubuntu 24.04 LTS droplet on DigitalOcean (2GB RAM / 1 vCPU / 70GB SSD, Bangalore region). Upgraded 151 packages including a full kernel upgrade (6.8.0-71 → 6.8.0-106). Created a non-root sudo user, disabled root SSH login entirely, and forced SSH key-only authentication — no passwords accepted. UFW firewall locked to ports 22, 80, and 443 only. Timezone set to IST, hostname to raza-server.
                    </p>
                    <div class="infra-tags">
                        <span class="infra-tag">Ubuntu 24.04</span>
                        <span class="infra-tag">UFW firewall</span>
                        <span class="infra-tag">SSH key-only</span>
                        <span class="infra-tag">No root login</span>
                        <span class="infra-tag">IST timezone</span>
                    </div>
                </div>
            </div>
            <div class="infra-item reveal">
                <div class="infra-dot"></div>
                <div class="infra-phase">Phase 2</div>
                <div class="infra-content">
                    <h3 class="infra-title">Audit & activity tracking</h3>
                    <p class="infra-desc">
                        Installed auditd with custom rules to log every command executed, every change to /etc/passwd, /etc/sudoers, sshd_config, and cron. Configured bash history with dd/mm/yyyy timestamps on every command. Installed fail2ban — any IP failing SSH 3 times within 10 minutes gets banned for 1 hour. Enabled unattended-upgrades for automatic security patches so we're not manually tracking CVEs.
                    </p>
                    <div class="infra-tags">
                        <span class="infra-tag">auditd</span>
                        <span class="infra-tag">fail2ban</span>
                        <span class="infra-tag">Timestamped history</span>
                        <span class="infra-tag">Auto security patches</span>
                    </div>
                </div>
            </div>
            <div class="infra-item reveal">
                <div class="infra-dot"></div>
                <div class="infra-phase">Phase 3</div>
                <div class="infra-content">
                    <h3 class="infra-title">Memory optimisation — zram + swap</h3>
                    <p class="infra-desc">
                        A 2GB droplet needs smart memory management. Created a 2GB disk swapfile as a last-resort safety net (priority 10). Installed zram-tools to create 984MB of compressed RAM swap (priority 100) — zram uses the lz4 algorithm to compress data in RAM itself, effectively giving ~3GB of usable memory without touching disk. vm.swappiness set to 10 so the kernel strongly prefers RAM and only falls back to swap under pressure. zram module added to /etc/modules-load.d/ for persistence across reboots.
                    </p>
                    <div class="infra-tags">
                        <span class="infra-tag">zram 984MB (priority 100)</span>
                        <span class="infra-tag">Swap 2GB (priority 10)</span>
                        <span class="infra-tag">lz4 compression</span>
                        <span class="infra-tag">swappiness=10</span>
                    </div>
                </div>
            </div>
            <div class="infra-item reveal">
                <div class="infra-dot"></div>
                <div class="infra-phase">Phase 4</div>
                <div class="infra-content">
                    <h3 class="infra-title">Docker deployment</h3>
                    <p class="infra-desc">
                        Installed Docker 29.3.0 from the official repo. Built a custom production compose file (compose.prod.yaml) with three services: PHP 8.4 app, PostgreSQL 17, and Redis — no Mailpit in production. A dedicated queue worker service runs php artisan queue:work as a separate container sharing the same image. All containers use restart: unless-stopped — verified to survive a full server reboot. Permissions were tricky: the Sail user (uid 1337) inside the container needed to own storage/ and bootstrap/cache/ on the host.
                    </p>
                    <div class="infra-tags">
                        <span class="infra-tag">Docker 29.3.0</span>
                        <span class="infra-tag">PHP 8.4 container</span>
                        <span class="infra-tag">Queue worker</span>
                        <span class="infra-tag">Auto-restart</span>
                        <span class="infra-tag">Health checks</span>
                    </div>
                </div>
            </div>
            <div class="infra-item reveal">
                <div class="infra-dot"></div>
                <div class="infra-phase">Phase 5</div>
                <div class="infra-content">
                    <h3 class="infra-title">Nginx 1.28 + HTTP/3 + SSL</h3>
                    <p class="infra-desc">
                        Ubuntu's package manager ships Nginx 1.24 — we added the official Nginx repo and upgraded to 1.28.2. This unlocked HTTP/3 via QUIC (listen 443 quic reuseport). Let's Encrypt SSL cert issued via Certbot with auto-renewal via a systemd timer that runs twice daily. Security headers added: HSTS, X-Frame-Options, X-Content-Type-Options, Referrer-Policy. Canonical URL is https://www.wedplanify.dev — all other forms (http, non-www) redirect with 301.
                    </p>
                    <div class="infra-tags">
                        <span class="infra-tag">Nginx 1.28.2</span>
                        <span class="infra-tag">HTTP/3 QUIC</span>
                        <span class="infra-tag">Let's Encrypt</span>
                        <span class="infra-tag">HSTS</span>
                        <span class="infra-tag">Security headers</span>
                    </div>
                </div>
            </div>
            <div class="infra-item reveal">
                <div class="infra-dot"></div>
                <div class="infra-phase">Phase 6</div>
                <div class="infra-content">
                    <h3 class="infra-title">Cloudflare CDN + kernel hardening</h3>
                    <p class="infra-desc">
                        Domain transferred to Cloudflare nameservers. SSL mode set to Full (strict) — end-to-end encryption between visitor, Cloudflare edge, and origin server. UFW firewall updated to only accept port 80/443 traffic from Cloudflare's published IP ranges — the real server IP 142.93.211.229 is now completely hidden from the internet. Traffic routes through Cloudflare's Mumbai (BOM) edge node — the closest to our Gujarat-based deployment. Kernel hardened with sysctl: SYN flood protection, IP spoofing prevention, ICMP redirect blocking, and TCP connection limits raised to 65535. PHP 8.4 OPcache tuned with JIT tracing mode and 128MB memory for maximum runtime performance.
                    </p>
                    <div class="infra-tags">
                        <span class="infra-tag">Cloudflare (Mumbai edge)</span>
                        <span class="infra-tag">IP hidden</span>
                        <span class="infra-tag">Kernel hardening</span>
                        <span class="infra-tag">OPcache JIT</span>
                        <span class="infra-tag">Brotli compression</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- API -->
<section id="api" class="api-section">
    <div class="container">
        <div class="reveal">
            <p class="section-label">05 — Public API</p>
            <h2 class="section-title">A versioned<br><em>read-only API</em></h2>
            <p class="section-body">
                Clean JSON endpoints expose agencies and vendors with rich filtering, sorting, pagination, and media URLs. Rate limited to 120 requests/minute per IP. All responses follow Laravel's pagination shape.
            </p>
        </div>
        <div class="api-grid reveal">
            <div class="api-card">
                <div class="api-header">
                    <span class="api-method">GET</span>
                    <span class="api-endpoint">/api/v1/agencies</span>
                </div>
                <div class="api-body">
                    Paginated list of wedding agencies with filtering and sorting.
                    <div class="api-params">
                        <span class="api-param">search</span>
                        <span class="api-param">city</span>
                        <span class="api-param">state</span>
                        <span class="api-param">verified</span>
                        <span class="api-param">featured</span>
                        <span class="api-param">sort=-avg_rating</span>
                        <span class="api-param">per_page</span>
                    </div>
                </div>
            </div>
            <div class="api-card">
                <div class="api-header">
                    <span class="api-method">GET</span>
                    <span class="api-endpoint">/api/v1/agencies/{slug}</span>
                </div>
                <div class="api-body">
                    Single agency by slug. Returns nested location, stats, media (logo, banner, gallery), and increments view count unless track_views=false.
                    <div class="api-params">
                        <span class="api-param">track_views</span>
                    </div>
                </div>
            </div>
            <div class="api-card">
                <div class="api-header">
                    <span class="api-method">GET</span>
                    <span class="api-endpoint">/api/v1/vendors</span>
                </div>
                <div class="api-body">
                    Paginated vendor list with category, price range, and availability filtering.
                    <div class="api-params">
                        <span class="api-param">category_id</span>
                        <span class="api-param">min_price</span>
                        <span class="api-param">max_price</span>
                        <span class="api-param">available_on</span>
                        <span class="api-param">sort=-min_price</span>
                    </div>
                </div>
            </div>
            <div class="api-card">
                <div class="api-header">
                    <span class="api-method">GET</span>
                    <span class="api-endpoint">/api/v1/vendors/{slug}</span>
                </div>
                <div class="api-body">
                    Single vendor with full profile — category, services, tags, pricing, media, and stats. Availability helper included for calendar views.
                    <div class="api-params">
                        <span class="api-param">track_views</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="footer-logo">WedPlanify</div>
        <ul class="footer-links">
            <li><a href="/admin">Admin Panel</a></li>
            <li><a href="/agency">Agency Panel</a></li>
            <li><a href="/vendor">Vendor Panel</a></li>
            <li><a href="/api/v1/agencies">API</a></li>
            <li><a href="https://github.com/persoluna/wedding-platform-backend" target="_blank">GitHub</a></li>
        </ul>
        <p class="footer-note">
            A demo project by <a href="https://github.com/persoluna" target="_blank">Persoluna</a> ·
            Built with Laravel 12, Filament 4 &amp; PostgreSQL 17 ·
            Deployed on DigitalOcean via Docker ·
            Served through Cloudflare from Mumbai ·
            <a href="https://github.com/persoluna/wedding-platform-backend" target="_blank">View source on GitHub →</a>
        </p>
    </div>
</footer>

<script>
    // Nav scroll effect
    const nav = document.getElementById('nav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 60);
    });

    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(el => observer.observe(el));
</script>

</body>
</html>