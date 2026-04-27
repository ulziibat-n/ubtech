# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0] — 2026-04-27

### Added
- **Search Experience** — Unified and enhanced search functionality
  - Added dedicated search result header with integrated search form
  - Restricted search results to blog posts only (excluding pages and other post types)
  - Implemented search results list view for better readability
- **Archive Improvements** — Refined archive empty states and headers
  - Redesigned `archive-none.php` to match 404 page aesthetics
  - Created dynamic search and fallback headers for generic archives
- **Theme Infrastructure** — Unified template logic and coding standards
  - Re-created `search.php` to delegate to `archive.php` for consistency (DRY)
  - Removed `declare(strict_types=1);` from all PHP files to match project preference
  - Updated Antigravity rules in `.agent/instructions.md` for better automation
- **Footer Updates** — Dynamic copyright year implementation

### Changed
- Refined archive header padding and z-index for better visibility
- Optimized `archive.php` logic to determine layout types dynamically

---

## [0.2.0] — 2026-03-15

### Added
- **Table of Contents (TOC)** — Automatically generated based on post headings (H2, H3)
  - Nested structure for H3 headings
  - ScrollSpy integration with dynamic active state highlighting
  - Sticky positioning for better readability on long articles
- **Code Block Enhancements** — Premium custom styling for WordPress code blocks
  - Clean white background in light mode and inverse surface in dark mode
  - Applied `--primitive-font-mono` for better code readability
  - Added custom selection color to match brand identity

### Changed
- Refined typography for single post content, adjusting font sizes and max-widths for optimal readability
- Optimized script loading strategy for Table of Contents and code blocks

### Removed
- PrismJS external library to maintain site speed and avoid TrustedHTML security conflicts

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
