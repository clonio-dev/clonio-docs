---
title: Clonio CLI
excerpt: Clone production-like database data into dev, test, staging, and CI environments with anonymization, key remapping, and signed audit logs.
layout: landing
allow_html: true
seo.title: "Clonio CLI - GDPR-aware database cloning for developers"
seo.description: "MIT-licensed CLI for safe, anonymized database cloning inside your own infrastructure."
---

<div class="clonio-home">
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
        <span class="clonio-brand-name">clonio</span>
      </a>
      <p class="clonio-eyebrow">Open-source CLI for anonymized database clones</p>
      <h1 id="clonio-hero-title">Test with <span class="clonio-nowrap">production-like</span> data, not personal data.</h1>
      <p class="clonio-lede">Clonio CLI copies production data into development, test, staging, and CI. On the way it anonymizes columns, syncs the schema, remaps keys, and writes a signed audit log.</p>
      <p class="clonio-lede clonio-lede-small">Run it from your terminal, Docker, Composer, or CI pipeline. Clonio connects directly from your machine or CI runner to your databases, with no Clonio cloud service in between.</p>
      <div class="clonio-actions">
        <a class="clonio-button clonio-button-primary" href="/docs/getting-started/introduction">Read the docs</a>
        <a class="clonio-button clonio-button-secondary" href="/docs/getting-started/installation">Install the CLI</a>
      </div>
    </div>
    <figure class="clonio-row" aria-labelledby="clonio-row-caption">
      <figcaption id="clonio-row-caption" class="clonio-row-head">
        <span class="clonio-row-table">customers</span>
        <span class="clonio-row-legend"><span class="clonio-tag-src">production</span><span aria-hidden="true">→</span><span class="clonio-tag-dst">target</span></span>
      </figcaption>
      <table>
        <thead>
          <tr><th scope="col">column</th><th scope="col">production</th><th scope="col">target</th><th scope="col">strategy</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">id</th><td class="clonio-src">4812</td><td class="clonio-dst">731905</td><td class="clonio-strategy">remap</td></tr>
          <tr><th scope="row">first_name</th><td class="clonio-src">Jana</td><td class="clonio-dst">Lukas</td><td class="clonio-strategy">fake</td></tr>
          <tr><th scope="row">email</th><td class="clonio-src">jana.weber@gmx.de</td><td class="clonio-dst">marie42@example.org</td><td class="clonio-strategy">fake</td></tr>
          <tr><th scope="row">phone</th><td class="clonio-src">+49 151 2345 6789</td><td class="clonio-dst">+49 *** **** ****</td><td class="clonio-strategy">mask</td></tr>
          <tr><th scope="row">notes</th><td class="clonio-src">Prefers calls before noon</td><td class="clonio-dst clonio-null">NULL</td><td class="clonio-strategy">"null"</td></tr>
          <tr class="clonio-row-keep"><th scope="row">created_at</th><td class="clonio-src">2023-04-11</td><td class="clonio-dst">2023-04-11</td><td class="clonio-strategy">keep</td></tr>
        </tbody>
      </table>
      <p class="clonio-row-foot"><code>$ clonio cloning:run production.cloning.yaml --target ci</code><span class="clonio-row-signed">audit log signed</span></p>
    </figure>
  </section>

  <ul class="clonio-signals" aria-label="At a glance">
    <li>MIT licensed</li>
    <li>Runs in your infrastructure</li>
    <li>Signed audit logs</li>
    <li>Docker, Composer, CI</li>
  </ul>

  <section class="clonio-section" aria-labelledby="clonio-problems-title">
    <p class="clonio-kicker">Problem solved</p>
    <h2 id="clonio-problems-title"><span class="clonio-nowrap">Production-like</span> data without production risk.</h2>
    <p class="clonio-intro">Developers and QA get usable database states without seeing personal data or production IDs, and every run writes an audit log, even a failed one.</p>
    <div class="clonio-columns">
      <article>
        <h3>Realistic data without exposing people</h3>
        <p>Apply explicit transformations to names, emails, addresses, tokens, identifiers, and payment-related fields before records reach the target environment.</p>
      </article>
      <article>
        <h3>Repeatable .cloning.yaml runs</h3>
        <p>Generate a cloning file, review it once, commit it, and rerun the same clone whenever a team needs fresh production-like data.</p>
      </article>
      <article>
        <h3>Audit evidence teams can keep</h3>
        <p>Produce signed audit artefacts and structured process logs for local storage, S3-compatible storage, email, Slack, Microsoft Teams, or ntfy.</p>
      </article>
    </div>
  </section>

  <section class="clonio-section clonio-workflow" aria-labelledby="clonio-workflow-title">
    <div class="clonio-workflow-copy">
      <p class="clonio-kicker">CLI workflow</p>
      <h2 id="clonio-workflow-title">Initialize, inspect, clone.</h2>
      <p class="clonio-intro"><strong>Connection names stay separate from secrets.</strong> The generated YAML controls row selection, schema synchronization, anonymization strategies, and key remapping. It is safe to commit because it references connection names, not credentials.</p>
    </div>
    <div class="clonio-terminal" aria-label="First run command workflow">
      <div class="clonio-terminal-bar"><span class="clonio-dots" aria-hidden="true"><span></span><span></span><span></span></span><span>first run</span></div>
<pre><span class="clonio-prompt">$</span> clonio init
<span class="clonio-prompt">$</span> clonio connection:add production --production
<span class="clonio-prompt">$</span> clonio connection:add local-dev
<span class="clonio-prompt">$</span> clonio cloning:dump --connection production
<span class="clonio-prompt">$</span> clonio cloning:run production.cloning.yaml --target local-dev</pre>
    </div>
  </section>

  <section class="clonio-section" aria-labelledby="clonio-capabilities-title">
    <p class="clonio-kicker">Core capabilities</p>
    <h2 id="clonio-capabilities-title">What a cloning run does to your data.</h2>
    <div class="clonio-grid">
      <article>
        <h3>Per-column anonymization</h3>
        <p>Use fake, hash, mask, null, static, exclude, or keep per column, with PII matchers to help draft a configuration you can review.</p>
      </article>
      <article>
        <h3>Schema-aware transfers</h3>
        <p>Create missing tables automatically. Optionally add missing columns or drop extra ones to keep targets aligned when the production schema moves faster.</p>
      </article>
      <article>
        <h3>Key remapping</h3>
        <p>Replace primary keys with new random values and rewrite declared foreign keys consistently across cloned records.</p>
      </article>
      <article>
        <h3>Install it your way</h3>
        <p>Install a standalone binary, PHAR, Composer dev dependency, or Docker image, then run it from local scripts, cron, or CI jobs.</p>
      </article>
    </div>
  </section>

  <section class="clonio-cta" aria-labelledby="clonio-oss-title">
    <div>
      <p class="clonio-kicker">Open source</p>
      <h2 id="clonio-oss-title">MIT licensed, free for commercial use.</h2>
      <p>Use Clonio CLI inside your own infrastructure, including commercial projects. Sponsorships fund maintenance, new database drivers, better anonymization strategies, and documentation.</p>
    </div>
    <div class="clonio-cta-side">
      <p>Read the source before you adopt it, or open a feature request through the GitHub issue template.</p>
      <div class="clonio-actions">
        <a class="clonio-button clonio-button-primary" href="https://github.com/sponsors/clonio-dev">Sponsor Clonio</a>
        <a class="clonio-button clonio-button-secondary" href="https://github.com/clonio-dev/clonio-cli/issues/new?template=feature_request.md">Request a feature</a>
        <a class="clonio-button clonio-button-secondary" href="https://github.com/clonio-dev/clonio-cli">View source</a>
      </div>
    </div>
  </section>
</div>
