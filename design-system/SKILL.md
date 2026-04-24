---
name: ulziibat-tech-design
description: Use this skill to generate well-branded interfaces and assets for ULZIIBAT.TECH & AI (Улзийбат — personal/studio brand, bilingual Mongolian + English, rounded + ink-on-off-white aesthetic with lime accent), either for production or throwaway prototypes/mocks/etc. Contains essential design guidelines, colors, type, fonts, assets, and UI kit components for prototyping.
user-invocable: true
---

Read the `README.md` file within this skill, and explore the other available files:

- `colors_and_type.css` — all design tokens (primitives + semantic, light + dark)
- `fonts/` — TT Hoves family (brand display + body) + license
- `assets/` — logo SVGs (5 color variants) + `monogram.svg`
- `ui_kits/website/` — React recreation of the personal site (Home, Post, About)
- `preview/` — individual token/component cards
- `brand_voice.md` — copy guidance for Mongolian + English

If creating visual artifacts (slides, mocks, throwaway prototypes, etc.), copy assets out and create static HTML files for the user to view. If working on production code, you can copy assets and read the rules here to become an expert in designing with this brand.

If the user invokes this skill without any other guidance, ask them what they want to build or design, ask some questions, and act as an expert designer who outputs HTML artifacts _or_ production code, depending on the need.

## Quick cheat sheet

- **Brand**: ULZIIBAT.TECH & AI — dot-period ink, green "TECH"
- **Font**: TT Hoves (Regular, DemiBold, ExtraBold, Black). Fallback: Manrope
- **Hero wordmark pattern**: heavy text, italic lowercase, ink dot at end, often with colored period: `дизайн, код, & хиймэл оюун<span class="brand">.</span>`
- **Palette**: lime `#82BD39`, lime tint `#E3F2CE`, ink `#0C0D0B`, off-white `#F7F7F2`
- **Voice**: direct, warm, lowercase, Mongolian-primary. No emoji. No exclamation marks except rare moments.
- **Radii**: 12–16px cards, 9999 pills, 8 inputs. Corners are always rounded.
- **Icons**: Material Symbols (Rounded) as inline SVG, fill-current, 20–24px.
- **Shadows**: used SPARINGLY — only on hover of interactive cards. Pages mostly flat with 1px strokes.
