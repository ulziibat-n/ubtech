# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [0.1.0] — 2026-03-13

### Added
- **Design Token System** — 2-layer semantic token architecture (`tailwind/custom/tokens.css`)
  - Primitive tokens: raw color values referenced by semantic tokens
  - Semantic tokens: `surface-*`, `fg-*`, `stroke-*`, `brand-*`, `status-*` categories
  - Light and dark theme token sets via `[data-theme]` attribute
- **Dark mode support** — `@custom-variant dark` via `data-theme="dark"` on `<html>`
- **Tailwind `@theme inline`** mapping — all semantic tokens exposed as utility classes
  - `bg-surface-*`, `text-fg-*`, `border-stroke-*`, `text-brand-*`, `text-status-*`
- **`color-mapping.md`** — Mongolian-language reference documentation for the token system

### Changed
- Replace all hardcoded `zinc-*`, `slate-*`, `lime-*` color classes with semantic tokens across:
  - `theme/inc/template-functions.php` (navigation menu links)
  - `theme/template-parts/layout/header-content.php`
  - `theme/template-parts/layout/footer-content.php`
  - `theme/template-parts/content/content-page.php`
- Update `.prose` utility in `tailwind/custom/utilities.css` to use semantic tokens for all typography colors
- Update `body` base style in `tailwind/custom/base.css` to use `bg-surface-base text-fg-default`

---

## [0.0.144] — 2026-03-05

### Changed
- Update block editor script loading to defer and load in footer
- Enhance footer and header navigation menus with conditional checks
- Update footer and header links for social media and contact information

---

## [0.0.143] — earlier

### Changed
- Update theme version to 0.0.143
- Refactor code structure for improved readability and maintainability
