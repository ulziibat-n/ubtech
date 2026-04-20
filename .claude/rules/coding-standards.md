# Coding Standards

## Tailwind CSS v4
- Use `@theme` block for design tokens (not `tailwind.config.js`):
  ```css
  @theme {
    --color-brand: oklch(60% 0.2 250);
    --font-sans: "TT Hoves", ui-sans-serif;
  }
  ```
- Reference tokens as CSS variables: `var(--color-brand)` in custom CSS
- Use utility classes in PHP/HTML templates directly
- No `theme()` function (v3 only) — use `var(--*)` instead
- Headwind class ordering enforced by Prettier plugin
- Source: `tailwind.css` → compiled to `theme/style.css` (never edit compiled output)

## PHPCS / WordPress PHP Standards
- **Indentation**: tabs (not spaces)
- **Braces**: Allman style for classes/functions, same-line for control structures
- **Prefix**: all functions, classes, hooks, globals with `ub_`
- **Naming**: `snake_case` for functions/variables, `PascalCase` for classes
- **Docblocks**: required on all functions and classes
- **Text domain**: always `'ub'` for i18n functions
- Run: `vendor/bin/phpcs` to check, `vendor/bin/phpcbf` to auto-fix

## Prettier Config
- Based on `@wordpress/prettier-config`
- Plugin: `prettier-plugin-tailwindcss` (auto-sorts Tailwind classes)
- Run: `npm run lint-fix` to auto-format JS/CSS/JSON files

## PHP File Header
Every PHP file must begin with:
```php
<?php
/**
 * Description of this file.
 *
 * @package ulziibat-tech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
```

## JavaScript
- ESNext syntax, bundled via esbuild
- Source in `javascript/`, output to `theme/js/*.min.js`
- No jQuery unless absolutely required by WP dependency
- ESLint enforced via `eslint.config.js`

## File Naming
- PHP templates: `kebab-case.php`
- PHP classes: `class-name.php` (WP convention)
- JS: `kebab-case.js`
- CSS partials: `_partial-name.css`
