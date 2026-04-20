# ubtech Theme — Project Brain

## Identity
- Theme: `ulziibat.tech` | Slug: `ubtech` | Text domain: `ub` | Prefix: `ub_`
- Version: 0.2.0 | Requires WP 6.8+ | PHP 7.4+
- Root: `/wp-content/themes/ubtech/`
- Theme files live in `theme/` subdirectory

## Stack
- **Tailwind CSS v4** via PostCSS — source: `tailwind.css` → compiled to `theme/style.css`
- **ACF Pro** — field groups sync via `theme/json/` (acf-json)
- **TutorLMS Pro** — overrides in `theme/tutor/` (copy-only, never edit plugin)
- **PHPCS** — WordPress-Extra + WordPress-Docs + PHPCompatibilityWP (PHP 7.4+, WP 6.2+)
- **Prettier** — `@wordpress/prettier-config` + `prettier-plugin-tailwindcss`
- **esbuild** — JS bundled from `javascript/` → `theme/js/*.min.js`

## Directory Map
```
ubtech/
├── theme/                  # All PHP/CSS/JS theme files
│   ├── inc/                # PHP helpers (template-functions, template-tags, disable-comments)
│   ├── template-parts/     # Partials (content/, layout/)
│   ├── json/               # ACF field group JSON (acf-json sync)
│   ├── js/                 # Compiled JS (do not edit directly)
│   ├── fonts/              # Local fonts (TT Hoves, TT Hoves Pro Mono)
│   ├── functions.php       # Theme setup
│   ├── style.css           # Compiled Tailwind output (do not edit directly)
│   └── theme.json          # Block editor theme config
├── tailwind.css            # Tailwind source (edit this)
├── tailwind/               # Tailwind partials
├── javascript/             # JS source files
├── phpcs.xml.dist          # PHPCS config
├── prettier.config.js      # Prettier config
└── .claude/                # AI workspace
```

## Tailwind v4 Conventions
- Use `@theme` block in `tailwind.css` for design tokens (not `tailwind.config.js`)
- CSS variables: `--color-*`, `--font-*`, `--spacing-*`
- Custom fonts: TT Hoves (sans), TT Hoves Pro Mono (mono)
- Run `npm run dev` to watch/compile

## ACF Conventions
- All field groups sync to `theme/json/` (acf-json)
- Blocks: `block.json` → `render.php` pattern
- Register blocks via `acf_register_block_type()` in `functions.php`

## TutorLMS Conventions
- Override templates: copy from plugin to `theme/tutor/` preserving path
- Never modify plugin files directly
- Style with Tailwind utility classes in override files

## PHPCS Rules
- Tabs for indentation (WordPress standard)
- All globals prefixed `ub_`
- Text domain: `ub`
- Escape all output: `esc_html()`, `esc_attr()`, `esc_url()`
- Nonces on all forms/AJAX
- `$wpdb->prepare()` for all queries
- `ABSPATH` check at top of every PHP file

## Verify Loop (mandatory for every feature)
PLAN → RESEARCH → WRITE → FORMAT (PHPCS+Prettier+Headwind) → REVIEW → FIX → QA → SHIP

## Build Commands
```bash
npm run dev          # Watch all (Tailwind + esbuild)
npm run prod         # Production build
npm run lint         # ESLint + Prettier check
npm run lint-fix     # Auto-fix lint issues
vendor/bin/phpcs     # PHP code standards check
vendor/bin/phpcbf    # PHP auto-fix
```

## Key Constants
- `UB_VERSION` — theme version (cache busting)
- `UB_TYPOGRAPHY_CLASSES` — Tailwind typography classes string
