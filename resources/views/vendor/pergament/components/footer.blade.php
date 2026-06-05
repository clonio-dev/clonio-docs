{{-- Footer (app override) --}}
@php($siteName = config('pergament.site.name', config('app.name', 'Clonio')))
<footer class="border-t border-gray-200 dark:border-gray-700 pergament-bg print:hidden" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col items-center gap-4 sm:flex-row sm:justify-between">
            <a href="/" class="flex items-center gap-2.5 group" aria-label="{{ $siteName }} home">
                <svg width="28" height="28" viewBox="0 0 144 144" fill="none" xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true" class="transition-transform duration-200 group-hover:-rotate-6">
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
                <span class="text-base font-bold tracking-tight text-gray-900 dark:text-white">{{ $siteName }}</span>
            </a>

            <nav class="flex items-center gap-5 text-sm" aria-label="Footer">
                <a href="/docs/getting-started/introduction"
                   class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Docs</a>
                <a href="https://github.com/clonio-dev/clonio-cli"
                   class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">GitHub</a>
                <a href="https://github.com/sponsors/clonio-dev"
                   class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Sponsor</a>
            </nav>
        </div>

        <div class="mt-8 border-t border-gray-700 pt-8 text-sm text-center">
            <a href="/" class="group inline-flex items-center hover:text-gray-700 focus:rounded-sm focus:outline-2 focus:outline-indigo-500 dark:hover:text-white">
                Made with
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="mx-1 -mt-px h-5 w-5 stroke-gray-400 group-hover:fill-red-500 group-hover:stroke-red-600 dark:stroke-gray-600 dark:group-hover:fill-red-700 dark:group-hover:stroke-red-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                </svg>
                in Berlin
            </a>
        </div>
    </div>
</footer>

{{-- Tailwind utilities used by this footer that are absent from Pergament's
     purged pergament.css. Hand-written so the footer renders regardless of the
     package's prebuilt stylesheet. Dark variants follow Pergament's .dark strategy.
     Kept inline (not @push('styles')) because the footer renders after the head's
     @stack('styles'), so a push from here would be discarded. --}}
<style>
    /* footer-marker */
    .gap-2\.5 { gap: 0.625rem; }
    .gap-5 { gap: 1.25rem; }
    .tracking-tight { letter-spacing: -0.025em; }
    .duration-200 { transition-duration: 200ms; }
    .border-gray-100 { border-color: #f3f4f6; }
    .text-red-500 { color: #ef4444; }
    .-mt-px { margin-top: -1px; }
    .h-5 { height: 1.25rem; }
    .stroke-gray-400 { stroke: #9ca3af; }

    .hover\:text-gray-700:hover { color: #374151; }
    .hover\:text-gray-900:hover { color: #111827; }

    .focus\:rounded-sm:focus { border-radius: 0.125rem; }
    .focus\:outline-2:focus { outline-width: 2px; outline-style: solid; }
    .focus\:outline-indigo-500:focus { outline-color: #6366f1; }

    .group:hover .group-hover\:-rotate-6 { transform: rotate(-6deg); }
    .group:hover .group-hover\:fill-red-500 { fill: #ef4444; }
    .group:hover .group-hover\:stroke-red-600 { stroke: #dc2626; }

    .dark .dark\:border-gray-700 { border-color: #374151; }
    .dark .dark\:text-white { color: #ffffff; }
    .dark .dark\:text-gray-400 { color: #9ca3af; }
    .dark .dark\:stroke-gray-600 { stroke: #4b5563; }
    .dark .dark\:hover\:text-white:hover { color: #ffffff; }
    .dark .group:hover .dark\:group-hover\:fill-red-700 { fill: #b91c1c; }
    .dark .group:hover .dark\:group-hover\:stroke-red-800 { stroke: #991b1b; }

    @media print {
        .print\:hidden { display: none; }
    }

    @media (min-width: 640px) {
        .sm\:flex-row { flex-direction: row; }
        .sm\:justify-between { justify-content: space-between; }
    }
</style>
