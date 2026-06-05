<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Content Path
    |--------------------------------------------------------------------------
    |
    | The base directory where all Pergament content files (docs, blog, pages) live.
    |
    */

    'content_path' => base_path('content'),

    /*
    |--------------------------------------------------------------------------
    | URL Prefix
    |--------------------------------------------------------------------------
    |
    | The base URL path where Pergament listens. All Pergament routes will be nested
    | under this prefix. Use "/" to take over the root, "docs" for /docs/*,
    | or any path like "landing-page/hello-world".
    |
    */

    'prefix' => '/',

    /*
    |--------------------------------------------------------------------------
    | Site Configuration
    |--------------------------------------------------------------------------
    |
    | Global site settings used across all pages. These can be overridden
    | in individual page/post front matter using dot notation.
    | e.g. "seo.title" in front matter overrides site.seo.title
    |
    */

    'site' => [
        'name' => 'Clonio',
        'url' => env('APP_URL', 'http://localhost'),
        'locale' => 'en',
        'seo' => [
            'title' => 'Clonio',
            'description' => 'Clone your production database to test environments with automatic anonymization, schema versioning, and full audit trails. GDPR-compliant by design.',
            'keywords' => 'database cloning, GDPR compliance, test data, database anonymization, schema versioning',
            'og_image' => '',
            'twitter_card' => 'summary_large_image',
            'robots' => 'index, follow',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Homepage
    |--------------------------------------------------------------------------
    |
    | Configure what content is displayed at the base URL.
    | Types: "page", "blog-index", "doc-page", "redirect"
    | For "page": source is the page slug (e.g. "home")
    | For "doc-page": source is "chapter/page" (e.g. "getting-started/introduction")
    | For "redirect": source is the target URL path
    |
    */

    'homepage' => [
        'type' => 'page',
        'source' => 'home',
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation
    |--------------------------------------------------------------------------
    */

    'docs' => [
        'enabled' => true,
        'path' => 'docs',
        'url_prefix' => 'docs',
        'title' => 'Documentation',
        'tts' => true,
        'statistics' => [
            'reading_time' => true,
            'word_count' => false,
            'character_count' => false,
            'paragraph_count' => false,
            'last_modified' => false,
            'content_age' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Blog
    |--------------------------------------------------------------------------
    */

    'blog' => [
        'enabled' => false,
        'path' => 'blog',
        'url_prefix' => 'blog',
        'title' => 'Blog',
        'per_page' => 12,
        'tts' => false,
        'default_authors' => [],
        'feed' => [
            'enabled' => true,
            'type' => 'atom',
            'title' => null,
            'description' => '',
            'limit' => 20,
        ],
        'statistics' => [
            'reading_time' => false,
            'word_count' => false,
            'character_count' => false,
            'paragraph_count' => false,
            'last_modified' => false,
            'content_age' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    'pages' => [
        'enabled' => true,
        'path' => 'pages',
        'tts' => false,
        'statistics' => [
            'reading_time' => false,
            'word_count' => false,
            'character_count' => false,
            'paragraph_count' => false,
            'last_modified' => false,
            'content_age' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap
    |--------------------------------------------------------------------------
    */

    'sitemap' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Robots.txt
    |--------------------------------------------------------------------------
    */

    'robots' => [
        'enabled' => true,
        'content' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | LLMs.txt
    |--------------------------------------------------------------------------
    */

    'llms' => [
        'enabled' => true,
        'content' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | PWA / Service Worker
    |--------------------------------------------------------------------------
    */

    'pwa' => [
        'enabled' => false,
        'name' => env('APP_NAME', 'Pergament'),
        'short_name' => env('APP_NAME', 'Pergament'),
        'description' => '',
        'theme_color' => '#ffffff',
        'background_color' => '#ffffff',
        'display' => 'standalone',
        'icons' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Path relative to the content directory, or an absolute URL.
    |
    */

    'favicon' => 'data:image/x-icon;base64,AAABAAEAICAAAAEAIACoEAAAFgAAACgAAAAgAAAAQAAAAAEAIAAAAAAAABAAAMMOAADDDgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADqlkYA93g2AOqVRQ_skkM97pBCde-NQJnxij-Z84g-XPSGPQvzhj0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADkn0gA1L1NAOacSBromUdq6ZZFweuTRPLtkUL_7o5B__CLQP_yiT7584c9eft6NgDzhj0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADipE0A4qJLAOGjTBPjoEpr5Z5J0OebSPzomEb_6pVF_-ySQ__tkEL_741A__GKP__yiD7V84Y9GfOHPQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA3qpPAN2tUAPfqE5C4KVNveKiS_vkn0r_5ZxJ_-eaR__pl0b_6pRE_-yRQ__uj0H_8IxA__GJP-7yiD4y8og-AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAANqvUQDar1EL3KxQdd2pT-rfpk3_4aRM_-OhS__knkn_5ptI_-iZR__qlkX_65NE_-2QQv_vjkH_8Is_8vGKPzrxij8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADYs1QA2LNUENmwUpPbrlH53KtQ_96oTv_gpk3_4aNM_-OgSv_lnUn_55tH_-iYRv_qlUX_7JJD_-6QQv_vjUHy8ItAOvCLQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA1rdVANW4VgzWtVWW2LJT_dqvUv_brVH_3apP_9-nTv_hpEz_4qJL_-SfSv_mnEj_6JlH_-mXRf_rlET_7ZFD_-6PQfLvjUE6741BAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAANO7WADPwFoC1LlXeNW3VvrXtFT_2LFT_9qvUv_crFD_3qlP_9-mTf_hpEz_46FK_-WeSf_mm0j_6JlG_-qWRf_rk0T_7ZBC8u6PQjruj0IAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADMvl0A0r1YANG9WT_Su1jp1LhW_9a2Vf_Xs1T_2bBS_9utUf_dq1D_36hO_-ClTf_io0v_46BK_-WdSP_nmkf_6ZhG_-qURP_skkPy7ZFCOu2RQgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAM7BWwDOwlsK0L9ardG9Wf_Tulf_1bdW_9a1Vf_YslP_2q9S_9ysUf_dqk__36dO_-GkTP_ioUv_5J9J_-acSP_nmUf_6ZZF_-uURPLskkQ67JJEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAzsNcAM3DXEDPwVvw0L9a_9K8WP_UuVf_1bZV_9ezVP_ZsVP_265R_9yrUP_eqU__4KZN_-GjTP_joEr_5Z5J_-ebR__omEb_6pVF8uuURDrrlEQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMzGXwDOv1gAzMZdis3DXP_PwFv_0b5Z_9O7WP_UuFb_1rVV_9izVP_ZsFL_261R_92qT__eqE7_4KVN_-KiS__kn0r_5Z1I_-eaR__pl0by6pZFOuqWRQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAyslfAMrKXwzLx17CzMVd_87CW__Qv1r_0r1Z_9O6V__Vt1b_17RU_9iyU__ar1L_3KxQ_92pT__fp03_4aRM_-OhS__lnkn_5pxI_-iZRvLpl0Y66ZdGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADIymAAyMtgIcrJX-DLx17_zcRc_8_BW__Qvlr_0rxY_9S5V__VtlX_17NU_9mwUv_brlH_3KtQ_96oTv_gpU3_4qNM_-OgSv_lnUn_55tH8uiZRzromUcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjMYQDIzGEyyctg7srIXv_Mxl3_zsNc_8_AWv_RvVn_07tY_9S4Vv_WtVX_2LJT_9qwUv_brVD_3apP_9-nTv_gpUz_4qJL_-SfSv_mnEjy55tIOuebSAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAxs5hAMbOYTrHzWHyycpf_8vHXv_NxV3_z8Nc_9HAWv_SvFn_07lX_9W3Vv_XtFT_2LFT_9quUf_drVH_3qpP_9-mTf_ho0z_46FL_-SeSfLlnUg65Z1IAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADF0GIAxdBiPMbOYvPIzGD_yslf_8zHXv_GtVX_xq9S_9C-Wf_Su1j_1LhX_9a2Vf_Ys1T_2bBS_9CeSv_Unkr_36hO_-ClTf_iokv_46BK8uSeSTrknkkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMTSYwDE0mM8xdBj88fNYf_JzGD_wLFU_5hXK_-UTif_vp5L_9K-Wf_Tulf_1bdW_9e2Vf_ElEb_lUsl_5xSKf_QmEf_4KhO_-GkTP_ioUvy46BKOuOgSgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAw9NkAMPTZDzE0mPzxs9i_8jOYf-qhED_iTgd_4k3Hf-kbTX_0L5Z_9K8WP_UuVf_1bVV_6doMv-INx3_iTgd_7V1OP_fqk__4KZN_-GjTPLioks64qJLAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADC1WUAwtVlPMPUZPPF0WP_xs5i_6J0OP-JNx3_iTgd_5xeLv_NvVn_0b5Z_9O7WP_StFX_nVos_4k4Hf-JOB3_q2gy_92rUP_fqE7_4KVN8-GkTDvhpEwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMHXZgDB12Y6wtVl8sTTZP_G0WP_qIRA_4k4Hf-JNx3_om01_87BW__QwFr_0r1Z_9O5V_-lZzL_iTcd_4k4Hf-zdTj_3a5R_96pT__fp07y4KVNOeClTQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwNhnAMDYZzDB12btw9Vl_8XTZP-7tVb_lVQq_5FLJv-6oUz_zsVd_8_BW__Qvln_071Z_7-WR_-TSCT_mFAo_8ucSv_br1L_3KtQ_96oTuzfp00u36dNAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC_2WcAv9lnGcDYZ9bC1mX_w9Nk_8XRY_--ulj_vrRV_8rHXv_Mxl3_zsNc_8_AWv_RvVn_0rpX_8ikTf_MpU7_2LNU_9qvUv_brVH_3apP1N6oThjeqU8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAL_baAC-3WkDv9pooMDYZv_C1WX_xNJk_8bRY__IzmH_ycpf_8vHXv_NxV3_zsJb_9C_Wv_SvFj_1LtY_9a4Vv_XtFT_2LFT_9qvUv_crFCe3qZNA9yqTwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAvt1nAL_aaAC_22hLwNln88HXZv_D1GT_xdFj_8bOYv_IzGD_yslf_8zGXf_Nw1z_z8Fb_9G-Wf_Su1j_1LhW_9a2Vf_Ys1T_2bBS8tquUUjar1IA3a5RAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAvttoAL3baAm_22ifwNln_8LWZf_D02T_xdBi_8fOYf_Jy2D_yshe_8zFXf_Ow1z_0MBa_9G9Wf_Tulf_1bhW_9a1Vf_YslOe2q5SCNmwUgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAv9toAL_baCK_2mfDwdhm_8PVZf_E0mP_xs9i_8jMYP_Jyl__y8de_83EXP_OwVv_0L9a_9K8WP_UuVf_1bZWwta0VCHWtFQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC922sAwNlnAL_aaCnA2We3wdZm_cPUZP_F0WP_x85h_8jLYP_KyV__y8Zd_83DXP_PwFv_0b5Z_NO7WLbUuFYp07lXANS6VwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC92mkAwNhmAMDZZxXB12Z2wtVl1cTTZPrF0GL_x81h_8nKX__LyF7_zMVd-s7CW9XQwFp40r1ZFdG-WgDVu1cAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwNdmAL_ZZwHC1mUbw9RkU8XRY4PGzmKbyMxgm8rJX4PLxl1TzcRcHNDAWgHOwlsAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA________wH___wB___wAP__wAD__4AA__8AAP_-AAD__AAA__wAAP_4AAD_-AAA__gAAP_wAAD_8AAA__AAAP_wAAD_8AAA__AAAP_wAAD_8AAA__AAAP_wAAD_8AAA__AAAP_4AAH_-AAB__wAA__-AAf__wAP__-AH______8',

    /*
    |--------------------------------------------------------------------------
    | Colors
    |--------------------------------------------------------------------------
    |
    | Primary color drives all interactive UI elements: active states, focus
    | rings, badges, links, and highlights. Background sets the page surface
    | in light mode; dark mode always uses a near-black surface.
    | Both values accept any valid CSS color (hex, rgb, oklch, …).
    |
    */

    'colors' => [
        'primary' => 'hsl(221 83% 53%)',
        'background' => 'hsl(210 40% 98%)',
    ],

    /*
    |--------------------------------------------------------------------------
    | Text-to-Speech
    |--------------------------------------------------------------------------
    |
    | Global voice and rate settings for the browser's Speech Synthesis API.
    | To enable TTS per content type, set "tts" within the docs, blog, or
    | pages section above.
    |
    | voice: preferred voice name (browser-dependent). Set to null to use the
    |        browser default. Common voices across platforms:
    |
    |        macOS / iOS:
    |          "Samantha", "Alex", "Daniel", "Karen", "Moira",
    |          "Tessa", "Thomas", "Anna" (de), "Amelie" (fr)
    |
    |        Chrome (online):
    |          "Google UK English Female", "Google UK English Male",
    |          "Google US English", "Google Deutsch", "Google français"
    |
    |        Windows:
    |          "Microsoft David", "Microsoft Zira", "Microsoft Mark",
    |          "Microsoft Hedda" (de), "Microsoft Hortense" (fr)
    |
    |        Android:
    |          varies by device — typically uses the system TTS engine
    |
    | rate:  speech rate between 0.5 and 2.0 (1.0 = normal speed).
    |
    */

    'tts' => [
        'voice' => 'Google US English',
        'rate' => 1.0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Page Actions
    |--------------------------------------------------------------------------
    |
    | Optional toolbar for content pages. When enabled, visitors can copy the
    | raw markdown source, open the .md version, or start a chat with a
    | configured AI agent using the current page URL.
    |
    */

    'page_actions' => [
        'enabled' => true,
        'copy_markdown' => true,
        'open_markdown' => true,
        'ai_agents' => [
            'claude' => [
                'enabled' => true,
                'label' => 'Claude',
                'url' => 'https://claude.ai/new?q=I%E2%80%99d+like+to+discuss+the+content+from+{url}',
            ],
            'chatgpt' => [
                'enabled' => true,
                'label' => 'ChatGPT',
                'url' => 'https://chatgpt.com/?q=I%27d+like+to+discuss+the+content+from+{url}',
            ],
            'perplexity' => [
                'enabled' => true,
                'label' => 'Perplexity',
                'url' => 'https://www.perplexity.ai/?q=I%27d+like+to+discuss+the+content+from+{url}',
            ],
            'gemini' => [
                'enabled' => true,
                'label' => 'Gemini',
                'url' => 'https://gemini.google.com/app?q=I%27d+like+to+discuss+the+content+from+{url}',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    'search' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown
    |--------------------------------------------------------------------------
    |
    | Configure Markdown rendering extensions and behavior.
    |
    */

    'markdown' => [

        /*
        |--------------------------------------------------------------------------
        | Alerts
        |--------------------------------------------------------------------------
        |
        | GitHub-style alert components (NOTE, TIP, IMPORTANT, WARNING, CAUTION).
        | When enabled, blockquotes like "> [!NOTE]" are rendered as styled alerts.
        |
        */
        'alerts' => true,

        /*
        |----------------------------------------------------------------------
        | Footnotes
        |----------------------------------------------------------------------
        |
        | Enable footnote support using the [^1] syntax. When enabled, footnote
        | references like [^1] in the text link to definitions at the bottom
        | of the document, similar to GitHub Flavored Markdown footnotes.
        |
        */

        'footnotes' => false,

    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    |
    | Privacy-first, server-side page view tracking. Records the URL path,
    | a timestamp, and whether the request came from a bot — no IP addresses,
    | no user agents, no cookies, and no personal data of any kind.
    | No cookie banner required.
    |
    | Data is written as newline-delimited JSON (NDJSON) to one file per day:
    |   storage/pergament/analytics/YYYY-MM-DD.ndjson
    |
    | storage_path: override the directory where analytics files are stored.
    |               Defaults to storage_path('pergament/analytics').
    |
    | download.enabled: expose a URL to download the raw NDJSON log file.
    |                   Disabled by default — enable explicitly for production
    |                   access without shell.
    |
    | download.token:   secret token required to access the download URL.
    |                   Must be set by the developer before enabling the route.
    |                   Example: php artisan tinker --execute="echo bin2hex(random_bytes(32));"
    |                   Can be set with the PERGAMENT_ANALYTICS_TOKEN environment variable.
    |
    */

    'analytics' => [
        'enabled' => false,
        'storage_path' => null,

        'download' => [
            'enabled' => false,
            'token' => env('PERGAMENT_ANALYTICS_TOKEN'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Exports
    |--------------------------------------------------------------------------
    */

    'exports' => [

        /*
        |--------------------------------------------------------------------------
        | Markdown exports are made especially for llms
        |--------------------------------------------------------------------------
        */

        'markdown' => [
            'detection' => [
                /*
                |--------------------------------------------------------------------------
                | Detect for given user agents
                |--------------------------------------------------------------------------
                |
                | Requests from user agents containing any of these strings
                | will automatically receive a markdown response. Matching
                | is case-insensitive.
                */
                'user_agents' => [
                    'GPTBot',
                    'ClaudeBot',
                    'Claude-Web',
                    'Anthropic',
                    'ChatGPT-User',
                    'PerplexityBot',
                    'Bytespider',
                    'Google-Extended',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Content Signals is for llms
            |--------------------------------------------------------------------------
            |
            | These signals are sent as a `Content-Signal` response header to
            | inform AI agents what they are allowed to do with your content.
            | Set to an empty array to disable the header entirely.
            |
            | See: https://contentstandards.org
            */
            'content_signals' => [
                'ai-train' => 'disallow',
                'ai-input' => 'allow',
                'search' => 'allow',
            ],
        ],
    ],
];
