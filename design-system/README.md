# ULZIIBAT.TECH Design System

A unified design language for **ULZIIBAT.TECH & AI** — the personal brand, WordPress site, and tooling of Ulziibat N. The system bridges the interactive web experience and the social-media visual identity. The style is engaging, vibrant, user-centric — **rounded corners, warm-leaning neutrals offset by a signature lime-green accent, and dynamic, single-column editorial layouts**. It is designed to feel approachable and energetic while staying instantly recognizable.

The **logotype** is the anchor: a stacked circular "U" glyph (black-and-lime) paired with the `ULZIIBAT.TECH` wordmark, where `.TECH` always renders in brand-lime — even inside body copy.

---

## Source references

| Source | What it contains |
|---|---|
| `ulziibat-n/ubtech` (GitHub, branch `master`) | The `ulziibat-tech` WordPress theme (Tailwind v4 + custom token CSS). The token system, `color-mapping.md`, typography rules, and every real component come from here. |
| Figma — `Брэндинг.fig` (page `/Logo`) | The logo lockups (Color=Black, Dark, Light, White, Pure White), wordmark SVG, and brand-lime samples. |
| `uploads/*.ttf` | **TT Hoves** type family (20 weights incl. italics and Hairline). Brand typeface. |
| `uploads/Color=*.svg` | The 5 monogram logo color variants, copied into `assets/`. |

> The Figma file is a pseudocode export — exact colors / layouts are trustworthy, rendered SVGs are the source of truth for marks.

---

## Index

```
README.md                  ← you are here
SKILL.md                   ← Agent Skill entry point (cross-compatible with Claude Code)
colors_and_type.css        ← all color tokens (light + dark) and type scale
fonts/                     ← TT Hoves TTFs + @font-face rules
assets/                    ← logos (5 variants) and wordmark
preview/                   ← small HTML cards, one per token/component, for the Design System tab
ui_kits/
  website/                 ← WordPress front-end recreation (homepage, post, 404)
slides/                    ← (not present — no deck template was provided)
```

Start at `colors_and_type.css`. Every card in `preview/` is a live example of one token or component.

---

## CONTENT FUNDAMENTALS — Voice, tone, copy

**Primary language: Mongolian (Cyrillic).** English appears for product/tech nouns (`ULZIIBAT.TECH`, `Figma`, `Tailwind`, `WordPress`) and developer-aimed surfaces. Never translate product names.

- **Address form:** direct and warm. The only CTA in the live header is `Надтай холбогдох` ("Contact me") — first-person, personal, not corporate "Contact us".
- **Tone:** engineer-casual. Precise about tools and versions ("Custom WordPress Theme", "Tailwind v4"), relaxed about everything else. Comments in the codebase are conversational and bilingual — e.g. `Өнгө нэмэх/өөрчлөх бол → tokens.css файлд ... засна`.
- **Casing:**
  - `ULZIIBAT.TECH` — wordmark in **all-caps** always, with `.TECH` in brand-lime.
  - `ulziibat.tech` — lowercase only inside URLs/handles.
  - Mongolian headings use sentence case, never all-caps.
  - Eyebrows/labels/footer legal use `ALL CAPS` with letter-spacing. (e.g. `ULZIIBAT.TECH © 2025`, `АГУУЛГА`)
- **Weight is the voice.** Brand voice is shouted through **TT Hoves Black (900)**. Headings and eyebrows are almost always Black or ExtraBold; body is Regular; meta is DemiBold/Bold at small sizes.
- **Emoji:** not used in UI. The only "emoji" slot in the product is the logotype itself.
- **Numbers & units:** use ASCII digits; stick to ISO-style dates (`2026-03-13`).

**Specific examples from the repo:**

> `Надтай холбогдох →` (header CTA, right-aligned)
> `ULZIIBAT.TECH © 2025` (footer eyebrow, `.TECH` in lime)
> `Агуулга` (table of contents heading for posts)
> `Брэнд өнгө нэмэх/өөрчлөх бол tokens.css файлд засна` (dev-doc voice)

---

## VISUAL FOUNDATIONS

### Colors
- **Brand lime** `#82BD39` (`oklch(76.8% 0.233 130.85)`) — logo green, links, brand buttons, focus rings, selection. Always accent, never body.
- **Brand lime dark** `oklch(64.8% 0.200 131.68)` — hover state.
- **Brand tint** `#E3F2CE` — used as a large, calm background for flat logo lockups.
- **Ink** `#0C0D0B` — logo black; maps to `fg-default` in light mode.
- **Cool slate** neutrals, 50 → 900, define every surface/text/stroke token. Whites are *not* pure white — base is `slate-50`.
- **Status**: success `oklch(60% .17 145)`, error `oklch(58% .22 29)`, warning `oklch(72% .17 75)`, info `oklch(62% .17 230)`. Used sparingly.
- Full token mapping and dark-mode pairs in `colors_and_type.css`.

### Typography
- **One family: TT Hoves.** Mono variant used for code only. Hairline is a separate family for special display.
- Heavy preference for **900 (Black)** in headings and eyebrows — it's the brand's voice.
- Body is **400 Regular**, 16px / 1.55 line-height. Captions/metadata step to 12–14px in **700–900** with tracking + uppercase.
- Display uses generous negative tracking (`-0.015em` → `-0.02em`); small caps / eyebrows go positive (`+0.08em` → `+0.12em`).

### Spacing & grid
- **8-pt grid.** Container uses `px-8 mx-auto` with `max-w-7xl` content columns.
- Vertical rhythm on pages is generous: hero stacks use `pt-64 pb-32` (Tailwind spacing = 256px/128px) for single posts; body sections use `py-24` (96px).
- Gutters between header items: `gap-12` (48px). Nav items `gap-1`. Author box padding `p-6 md:p-8`.

### Backgrounds & imagery
- Content areas are flat **`surface-base` (slate-50)** with occasional **`surface-card` (white)** panels. No gradients in UI chrome.
- **Single gradient pattern in active use:** a protection gradient `from-transparent to-black/50` over hero imagery to keep white titles legible. That's it.
- **Imagery:** full-bleed, horizon-filling photography for post heroes, slightly warm, realistic (no illustrations, no grain, no stylization). Logos live on solid tint backgrounds.
- **No repeating patterns, no noise textures** anywhere in the live system.

### Corners & cards
- Cards use `rounded-2xl` (32px) for author boxes, `rounded-radius-md` (8px) for compact UI, `rounded-full` for pills and CTAs.
- Logo lockups themselves round at `12px` inside the Figma source.
- Card surface is **`surface-card` + `border border-stroke-default` + `shadow-sm`**. Shadows are low-intensity and cool (no colored drop shadows).

### Borders & shadows
- Divider style: a single 1px `border-t border-stroke-default` (see footer). Dividers do a lot of the work; cards are rarely heavy.
- Shadow system is 3-step: `--shadow-sm`, `--shadow-md`, `--shadow-lg`. All use pure black alpha (never color-tinted).
- No inner shadows, no glass/blur in active UI surfaces.

### Motion & states
- Single easing: `--ease-primary: cubic-bezier(0.075, 0.82, 0.165, 1)` ("quint out") at `duration-300`. Everything transitions with this.
- **Hover:** swap to a darker / inverse variant (`bg-surface-inverse → bg-surface-inverse-hover`), or `text-fg-link → text-brand-hover`. No scale, no shadow pop.
- **Press:** relies on the default browser active state; the hover-dark ramp continues to deepen.
- **Focus:** `focus:outline-0` paired with `focus:bg-surface-inverse-hover` or `focus:outline-stroke-strong focus:outline-offset-2`. Lime focus ring is reserved for inputs.
- **Fades/bounces:** none. No decorative animation in the live site.

### Transparency & blur
- Transparency is used only for the hero protection gradient and `surface-overlay` (modal scrim @ 85%). No backdrop-blur in the production theme.

### Layout conventions
- Fixed elements: header is **not sticky** in the template; the post TOC (`data-post-toc`) is `sticky top-24` in its sidebar.
- Pages are single-column with a wide max-width (`max-w-7xl` / `max-w-wide`). Post bodies drop to `max-w-3xl` + a 1/3 right TOC rail.
- Footer is a thin line — border-top + small eyebrow + social icons.

### Iconography (see ICONOGRAPHY section)
- Inline monochrome SVGs, Google Material Symbols style ("Rounded" variant). Size `w-6 h-6`, `fill-current`. Social logos are plain brand SVGs.

---

## ICONOGRAPHY

**Primary icon system: inline SVG, `currentColor`, no icon font.** Three families show up in the live site:

1. **Google Material Symbols (Rounded / Filled)** — `w-8 h-auto fill-fg-inverse`, 24px grid (e.g. the small logo mark in the header, the arrow in `Надтай холбогдох →`). Not loaded as a font; individual SVG paths are pasted directly into PHP.
2. **Simple-Icons-style brand marks** — used for social (Facebook, Instagram, Threads, X/Twitter, LinkedIn). Monochrome, filled, 24px viewBox. See the `$social_links` array in `content-single.php`.
3. **The ULZIIBAT.TECH logomark itself** — a circular black disc with a zig-zag lime motif. Ships in 5 color variants (see `assets/logo-color-*.svg`).

**Rules:**
- Always monochrome. Color through `fill-current` / `text-fg-*` so icons inherit the correct token.
- Size: `w-4/5/6/8` (16/20/24/32 px). Stroke/fill icons only — never mix.
- **Emoji: not used.** Unicode chars (`→`, `©`) are used sparingly and only in text.
- Placeholders live in `assets/`. For CDN fallback the closest match to the existing Material-Rounded style is **Google's Material Symbols (Rounded, filled)** via `https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded`. Do not substitute Lucide/Heroicons — the visual weight is wrong.

---

## Known gaps / flags to the user

- **No `TT Hoves Pro Mono` file was uploaded** — the codebase references it for code blocks. We fall back to system mono. Drop the `.ttf` into `fonts/` and the `colors_and_type.css` mono stack picks it up automatically.
- The Figma file only contains the `/Logo` page (no full marketing / product screens). The website UI kit is reconstructed from the real WordPress templates, which is the higher-fidelity source anyway.
- No slide deck templates were provided — `slides/` is intentionally absent.
