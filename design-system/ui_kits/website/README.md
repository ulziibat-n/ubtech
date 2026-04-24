# Website UI Kit — ULZIIBAT.TECH

Recreation of the personal site theme (WordPress + Tailwind v4, per `ulziibat-n/ubtech-design-system`). Mongolian copy, rounded + ink-on-off-white aesthetic, lime accent.

## Components
- `Shared.jsx` — `LogoMono`, `Wordmark`, `ArrowRight`, `Header`, `Footer`, `Badge`, `ContactCTA`
- `Home.jsx` — hero + `PostCard` grid (1 featured + 5 standard)
- `Post.jsx` — single-post reading column with author strip and related
- `About.jsx` — bio, services grid, dark contact CTA

## Interactions
- Nav clicks swap page (`home` / `blog` / `work` / `about`)
- Clicking a post card opens `Post` with `← Буцах` to return
- Current page persisted in `localStorage` under `ubtech-route`

## Notes
Post imagery is a solid-color band with the monogram — real site uses WordPress featured images. Copy is placeholder Mongolian in brand voice (short, direct, ink-dot period).
