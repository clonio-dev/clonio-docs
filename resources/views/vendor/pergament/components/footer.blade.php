{{-- Footer (app override) --}}
@php($siteName = config('pergament.site.name', config('app.name', 'Clonio')))
<footer class="clonio-footer print:hidden" role="contentinfo">
    <div class="clonio-footer-inner">
        <div class="clonio-footer-top">
            <div class="clonio-footer-brand">
                <a href="/" class="clonio-footer-logo" aria-label="{{ $siteName }} home">
                    <svg width="26" height="26" viewBox="0 0 144 144" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <defs>
                            <linearGradient id="clonio-logo-footer" x1="0" x2="1" y1="0" y2="1">
                                <stop offset="0" stop-color="#6EE7B7" />
                                <stop offset="1" stop-color="#3B82F6" />
                            </linearGradient>
                        </defs>
                        <g transform="matrix(.43 0 0 .43 -38.1 -60.17)">
                            <path fill="url(#clonio-logo-footer)" d="M160 250a96 96 0 1 1 192 0v170q0 70-96 20t-96-140Z" />
                            <ellipse cx="215" cy="260" fill="#1e3a8a" rx="18" ry="28" />
                            <ellipse cx="297" cy="260" fill="#1e3a8a" rx="18" ry="28" />
                        </g>
                    </svg>
                    <span>clonio</span>
                </a>
                <p class="clonio-footer-tagline">Anonymized database clones, run inside your own infrastructure.</p>
            </div>

            <nav class="clonio-footer-nav" aria-label="Footer">
                <a href="/docs/getting-started/introduction">Docs</a>
                <a href="/docs/getting-started/installation">Install</a>
                <a href="https://github.com/clonio-dev/clonio-cli">GitHub</a>
                <a href="https://github.com/sponsors/clonio-dev">Sponsor</a>
            </nav>
        </div>

        <div class="clonio-footer-bottom">
            <span>MIT licensed open source</span>
            <span class="clonio-footer-love">
                Made with
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" aria-label="love" role="img">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                </svg>
                in Berlin
            </span>
        </div>
    </div>
</footer>

{{-- Self-contained footer styles. Kept inline (not @push('styles')) because the
     footer renders after the head's @stack('styles'), so a push would be lost.
     Colors follow the homepage tokens; dark mode uses Pergament's .dark class. --}}
<style>
    .clonio-footer {
        --cf-ink: #0e1a2b;
        --cf-muted: #4a5868;
        --cf-rule: #dce2e9;
        --cf-accent: #0f766e;
        --cf-mono: ui-monospace, "SF Mono", "Cascadia Code", "JetBrains Mono", Menlo, Consolas, monospace;
        margin-top: 2rem;
        border-top: 1px solid var(--cf-rule);
        background: transparent;
        color: var(--cf-muted);
        font-size: 0.875rem;
    }

    .dark .clonio-footer {
        --cf-ink: #e6edf5;
        --cf-muted: #9aa8b8;
        --cf-rule: rgba(148, 163, 184, 0.16);
        --cf-accent: #2dd4bf;
    }

    .clonio-footer-inner {
        max-width: 80rem;
        margin-inline: auto;
        padding: 3rem 2rem 2rem;
    }

    .clonio-footer-top {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 2rem;
    }

    .clonio-footer-logo {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        color: var(--cf-ink);
        font-family: var(--cf-mono);
        font-size: 1.05rem;
        font-weight: 600;
        letter-spacing: -0.02em;
        text-decoration: none;
    }

    .clonio-footer-logo svg {
        transition: transform 200ms ease;
    }

    .clonio-footer-logo:hover svg {
        transform: rotate(-6deg);
    }

    .clonio-footer-tagline {
        margin: 0.6rem 0 0;
        max-width: 32ch;
        line-height: 1.5;
    }

    .clonio-footer-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem 1.75rem;
        font-family: var(--cf-mono);
        font-size: 0.8rem;
    }

    .clonio-footer-nav a {
        color: var(--cf-muted);
        text-decoration: none;
        transition: color 150ms ease;
    }

    .clonio-footer-nav a:hover {
        color: var(--cf-accent);
    }

    .clonio-footer a:focus-visible {
        outline: 2px solid var(--cf-accent);
        outline-offset: 3px;
        border-radius: 2px;
    }

    .clonio-footer-bottom {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem 2rem;
        margin-top: 2.5rem;
        padding-top: 1.25rem;
        border-top: 1px dashed var(--cf-rule);
        font-family: var(--cf-mono);
        font-size: 0.75rem;
    }

    .clonio-footer-love {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        cursor: default;
    }

    .clonio-footer-love svg {
        width: 1.05rem;
        height: 1.05rem;
        stroke: currentColor;
        transition: fill 200ms ease, stroke 200ms ease, transform 200ms ease;
    }

    .clonio-footer-love:hover svg {
        fill: #ef4444;
        stroke: #dc2626;
        transform: scale(1.12);
    }

    @media (max-width: 640px) {
        .clonio-footer-inner {
            padding: 2.5rem 1rem 1.5rem;
        }

        .clonio-footer-top {
            flex-direction: column;
            gap: 1.5rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .clonio-footer *,
        .clonio-footer *::before {
            transition: none !important;
        }
    }

    @media print {
        .print\:hidden { display: none; }
    }
</style>
