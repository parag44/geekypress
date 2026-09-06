# GeekyPress - Agent Guidelines & Skills

This repository is a developer-focused WordPress theme. It includes the official **[WordPress Agent Skills](https://github.com/WordPress/agent-skills)** under `.agents/skills/` to guide code analysis, theme development, block features, performance profiling, and standards verification.

## Available WordPress Skills (.agents/skills/)

- `wordpress-router`: Fast routing and classification for WordPress repositories.
- `wp-project-triage`: Deterministic inspection of theme/plugin structure, tooling, and version hints.
- `wp-block-themes`: Block themes, `theme.json`, block templates, and Site Editor guidance.
- `wp-patterns`: Filesystem and core block patterns registration.
- `wp-performance`: Performance inspection, database optimization, and Core Web Vitals.
- `wp-phpstan`: PHPStan static analysis configuration and WordPress stubs.
- `wp-rest-api`: Custom endpoints, schemas, authentication, and permission callbacks.
- `wp-interactivity-api`: Client-side reactive interactivity with WordPress 6.5+ Interactivity API.
- `wp-plugin-development`: Plugin lifecycle, activation, and data management best practices.
- `wp-plugin-directory-guidelines`: Security, escaping, sanitization, and compliance rules.
- `wp-wpcli-and-ops`: WP-CLI diagnostics, profile, and administrative automation.
- `wp-playground` & `blueprint`: Testing within in-browser WordPress environments.
- `wp-abilities-api`, `wp-abilities-audit`, `wp-abilities-verify`: WordPress Abilities API tool adoption.
- `wpds`: WordPress Design System component guidance.

## Key Project Scripts

- Run project triage:
  ```bash
  node .agents/skills/wp-project-triage/scripts/detect_wp_project.mjs
  ```
- Detect block theme roots:
  ```bash
  node .agents/skills/wp-block-themes/scripts/detect_block_themes.mjs
  ```
