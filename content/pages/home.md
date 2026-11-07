---
title: Clonio CLI
excerpt: Clone production-like database data into dev, test, staging, and CI environments with anonymization, key remapping, and signed audit logs.
layout: landing
allow_html: true
seo.title: "Clonio CLI - GDPR-aware database cloning for developers"
seo.description: "MIT-licensed CLI for safe, anonymized database cloning inside your own infrastructure."
---

<main class="clonio-home">
  <section class="clonio-hero" aria-labelledby="clonio-hero-title">
    <div class="clonio-hero-copy">
      <a class="clonio-brand" href="/" aria-label="Clonio home">
        <svg class="clonio-brand-mark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 144 144" aria-hidden="true">
          <defs>
            <linearGradient id="clonio-logo-hero" x1="0" x2="1" y1="0" y2="1">
              <stop offset="0" stop-color="#6EE7B7" />
              <stop offset="1" stop-color="#3B82F6" />
            </linearGradient>
          </defs>
          <g transform="matrix(.43 0 0 .43 -38.1 -60.17)">
            <path fill="url(#clonio-logo-hero)" d="M160 250a96 96 0 1 1 192 0v170q0 70-96 20t-96-140Z" />
            <ellipse cx="215" cy="260" fill="#1e3a8a" rx="18" ry="28" />
            <ellipse cx="297" cy="260" fill="#1e3a8a" rx="18" ry="28" />
          </g>
        </svg>
        <span class="clonio-brand-name">Clonio</span>
      </a>
      <p class="clonio-eyebrow">Open-source CLI for anonymized database clones</p>
      <h1 id="clonio-hero-title">Test with production-like data, not personal data.</h1>
      <p class="clonio-lede">Clonio CLI copies production data into development, test, staging, and CI. On the way it anonymizes columns, syncs the schema, remaps keys, and writes a signed audit log.</p>
      <p class="clonio-lede clonio-lede-small">Run it from your terminal, Docker, Composer, or CI pipeline. Clonio connects directly from your machine or CI runner to your databases, with no Clonio cloud service in between.</p>
      <div class="clonio-actions" aria-label="Primary actions">
        <a class="clonio-button clonio-button-primary" href="/docs/getting-started/introduction">Read the docs</a>
        <a class="clonio-button clonio-button-secondary" href="/docs/getting-started/installation">Install the CLI</a>
      </div>
    </div>
    <div class="clonio-hero-visual" aria-label="Clonio command line workflow visualization">
      <div class="clonio-terminal" aria-label="Terminal session">
        <div class="clonio-window-bar">
          <span class="clonio-dots" aria-hidden="true"><span></span><span></span><span></span></span>
          <span class="clonio-window-title">~/app</span>
        </div>
        <pre><span class="clonio-prompt">$</span> clonio init
<span class="clonio-prompt">$</span> clonio connection:add production --production
<span class="clonio-prompt">$</span> clonio connection:add ci
<span class="clonio-prompt">$</span> clonio cloning:dump --connection production
<span class="clonio-prompt">$</span> clonio cloning:run production.cloning.yaml --target ci
<span class="clonio-ok">✓ anonymization rules applied</span>
<span class="clonio-ok">✓ foreign keys remapped</span>
<span class="clonio-ok">✓ audit artefact signed</span></pre>
      </div>
      <div class="clonio-pipeline" aria-hidden="true">
        <svg viewBox="0 0 520 220" role="img">
          <defs>
            <linearGradient id="clonio-flow-gradient" x1="0" x2="1" y1="0" y2="0">
              <stop offset="0" stop-color="#22d3ee" />
              <stop offset="0.55" stop-color="#3b82f6" />
              <stop offset="1" stop-color="#34d399" />
            </linearGradient>
            <filter id="clonio-glow" x="-30%" y="-30%" width="160%" height="160%">
              <feGaussianBlur stdDeviation="4" result="blur" />
              <feMerge><feMergeNode in="blur" /><feMergeNode in="SourceGraphic" /></feMerge>
            </filter>
          </defs>
          <path class="clonio-flow" filter="url(#clonio-glow)" d="M74 112 C146 34, 214 34, 270 112 S394 188, 452 90" />
          <g>
            <rect class="clonio-node" x="18" y="78" width="96" height="72" rx="18" />
            <text class="clonio-node-label" x="45" y="105">source</text>
            <text class="clonio-node-label" x="38" y="126">database</text>
          </g>
          <g>
            <rect class="clonio-node" x="220" y="76" width="104" height="76" rx="18" />
            <text class="clonio-node-label" x="238" y="105">anonymize</text>
            <text class="clonio-node-label" x="252" y="126">remap</text>
          </g>
          <g>
            <rect class="clonio-node" x="404" y="54" width="96" height="72" rx="18" />
            <text class="clonio-node-label" x="434" y="84">CI</text>
            <text class="clonio-node-label" x="422" y="105">target</text>
          </g>
        </svg>
      </div>
      <div class="clonio-audit-card" aria-label="Signed audit artefact visual">
        <p class="clonio-audit-title">audit artefact <span class="clonio-signature">signed</span></p>
        <div class="clonio-audit-lines" aria-hidden="true"><span></span><span></span><span></span></div>
      </div>
    </div>
  </section>

  <div class="clonio-signal-strip" aria-label="Clonio signals">
    <span>MIT licensed</span>
    <span>Runs in your infrastructure</span>
    <span>Signed audit logs</span>
    <span>Docker/Composer/CI ready</span>
  </div>

  <section class="clonio-section" aria-labelledby="clonio-problems-title">
    <p class="clonio-section-kicker">Problem solved</p>
    <h2 id="clonio-problems-title">Production-like data without production risk.</h2>
    <p class="clonio-section-intro">Developers and QA get usable database states without seeing personal data or production IDs, and every run writes an audit log, even a failed one.</p>
    <div class="clonio-card-grid">
      <article class="clonio-card" data-index="01">
        <h3>Realistic data without exposing people</h3>
        <p>Apply explicit transformations to names, emails, addresses, tokens, identifiers, and payment-related fields before records reach the target environment.</p>
      </article>
      <article class="clonio-card" data-index="02">
        <h3>Repeatable .cloning.yaml runs</h3>
        <p>Generate a cloning file, review it once, commit it, and rerun the same clone whenever a team needs fresh production-like data.</p>
      </article>
      <article class="clonio-card" data-index="03">
        <h3>Audit evidence teams can keep</h3>
        <p>Produce signed audit artefacts and structured process logs for local storage, S3-compatible storage, email, Slack, Microsoft Teams, or ntfy.</p>
      </article>
    </div>
  </section>

  <section class="clonio-section" aria-labelledby="clonio-workflow-title">
    <p class="clonio-section-kicker">CLI workflow</p>
    <h2 id="clonio-workflow-title">Initialize, inspect, clone.</h2>
    <div class="clonio-workflow">
      <div class="clonio-workflow-note">
        <strong>Connection names stay separate from secrets.</strong>
        <p>The generated YAML controls row selection, schema synchronization, anonymization strategies, and key remapping. It is safe to commit because it references connection names, not credentials.</p>
      </div>
      <div class="clonio-command-panel" aria-label="First run command workflow">
        <div class="clonio-window-bar">
          <span class="clonio-dots" aria-hidden="true"><span></span><span></span><span></span></span>
          <span class="clonio-window-title">first run</span>
        </div>
        <pre><span class="clonio-prompt">$</span> clonio init
<span class="clonio-prompt">$</span> clonio connection:add production --production
<span class="clonio-prompt">$</span> clonio connection:add local-dev
<span class="clonio-prompt">$</span> clonio cloning:dump --connection production
<span class="clonio-prompt">$</span> clonio cloning:run production.cloning.yaml --target local-dev</pre>
      </div>
    </div>
  </section>

  <section class="clonio-section" aria-labelledby="clonio-capabilities-title">
    <p class="clonio-section-kicker">Core capabilities</p>
    <h2 id="clonio-capabilities-title">What a cloning run does to your data.</h2>
    <div class="clonio-card-grid clonio-capability-grid">
      <article class="clonio-card" data-index="A">
        <h3>Per-column anonymization</h3>
        <p>Use fake, hash, mask, null, static, exclude, or keep per column, with PII matchers to help draft a configuration you can review.</p>
      </article>
      <article class="clonio-card" data-index="B">
        <h3>Schema-aware transfers</h3>
        <p>Create missing tables automatically. Optionally add missing columns or drop extra ones to keep targets aligned when the production schema moves faster.</p>
      </article>
      <article class="clonio-card" data-index="C">
        <h3>Key remapping</h3>
        <p>Replace primary keys with new random values and rewrite declared foreign keys consistently across cloned records.</p>
      </article>
      <article class="clonio-card" data-index="D">
        <h3>Install it your way</h3>
        <p>Install a standalone binary, PHAR, Composer dev dependency, or Docker image, then run it from local scripts, cron, or CI jobs.</p>
      </article>
    </div>
  </section>

  <section class="clonio-cta" aria-labelledby="clonio-oss-title">
    <div>
      <p class="clonio-section-kicker">Open source</p>
      <h2 id="clonio-oss-title">MIT licensed, free for commercial use.</h2>
      <p>Use Clonio CLI inside your own infrastructure, including commercial projects. Sponsorships fund maintenance, new database drivers, better anonymization strategies, and documentation.</p>
    </div>
    <div class="clonio-cta-card">
      <p>Read the source before you adopt it, or open a feature request through the GitHub issue template.</p>
      <div class="clonio-cta-links" aria-label="Open source links">
        <a class="clonio-button clonio-button-primary" href="https://github.com/sponsors/clonio-dev">Sponsor Clonio</a>
        <a class="clonio-button clonio-button-secondary" href="https://github.com/clonio-dev/clonio-cli/issues/new?template=feature_request.md">Request a feature</a>
        <a class="clonio-button clonio-button-secondary" href="https://github.com/clonio-dev/clonio-cli">View source</a>
      </div>
    </div>
  </section>
</main>
