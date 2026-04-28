# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.8] — 2026-04-28

### Added
- **Detailed API Debugging** — Improved SEO analysis to display exact error messages from Gemini API when connections fail.

---

## [1.0.7] — 2026-04-28

### Fixed
- **AI Response Parsing** — Fixed "AI Error" by stripping Markdown code blocks from Gemini's JSON response.
- **AJAX Stability** — Improved AJAX workflow to update SEO fields in real-time without page reloads.
- **Performance** — Optimized API requests by trimming post content sent to Gemini (4000 char limit).
- **Security** — Updated to a fresh Gemini API Key for improved reliability.

---

## [1.0.6] — 2026-04-28

### Added
- **AI-Powered SEO System** — Integrated Google Gemini 1.5 Flash to automatically optimize SEO titles, descriptions, and keywords.
- **Premium SEO Analysis** — Implemented a comprehensive content analysis engine checking keyword density, links, and structure.
- **Advanced ACF SEO Fields** — Added dedicated fields for Focus Keyphrase, Related Keyphrases, and Social Media overrides.
- **Auto-Optimizer** — One-click optimization button that fills all SEO metadata using AI.
- **Block-Aware SEO** — Added recommendations for blocks like FAQ when content length warrants it.

### Fixed
- **Localhost Compatibility** — Disabled SSL verification for Gemini API calls in local development environments.

---

## [1.0.5] — 2026-04-27

### Added
- **Breadcrumbs** — Integrated Yoast SEO breadcrumbs across all templates (single posts, pages, archives, search results)
- **Design Tokens** — Updated typography styles for headings (strong/bold support) and link hover effects

---

## [1.0.4] — 2026-04-27

### Fixed
- **Fonts** — Fixed an issue where custom fonts were not being loaded by correctly importing `fonts.css` in Tailwind
- **Linting** — Replaced `date()` with `gmdate()` in footer to comply with WordPress DateTime standards

### Changed
- **Design Updates** — Various UI/UX improvements to single post and page templates
  - Increased content width and font sizes for better readability
  - Added underline effect to links within post content
  - Adjusted social link icons and spacing
  - Updated page template to support TOC and similar layout to posts

---

## [1.0.3] — 2026-04-27

### Changed
- **Transliteration Improvements** — Enhanced slug conversion for existing posts
  - Added support for transliterating slugs during post updates via `wp_insert_post_data`
  - Ensures that existing Cyrillic slugs can be easily converted to Latin by simply re-saving/updating the post

---

## [1.0.2] — 2026-04-27

### Added
- **Post Transliteration** — Automatic Cyrillic to Latin slug conversion
  - Implemented custom transliteration logic for Mongolian Cyrillic
  - Automatically converts long/encoded Cyrillic slugs into clean Latin URLs upon post save/update

---

## [1.0.1] — 2026-04-27

### Added
- **ACF Safety & Requirements** — Prevented site crashes when ACF is missing
  - Added `function_exists('get_field')` checks across all theme files
  - Implemented a friendly custom error page (matching 404 design) when ACF PRO is inactive
  - Added administrative notices for required plugin activation

### Changed
- **Modified Date Logic** — Refined the display of updated dates on posts
  - Updated dates now only show if they are at least 7 days newer than the published date
  - Prevents "Modified" date from appearing for minor immediate edits
- **Featured Image Logic** — Simplified single post header display
  - Removed dependency on custom ACF `featured_image_type` field
  - Now uses WordPress default Featured Image logic for better compatibility with existing posts

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
- Version: 1.0.8
- Refactor code structure for improved readability and maintainability
