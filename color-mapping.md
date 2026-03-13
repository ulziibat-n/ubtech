# Өнгөний Token Систем — Гарын авлага

## Яагаад token систем ашигладаг вэ?

Хуучин аргаар `text-zinc-800`, `bg-slate-100` гэх мэт **raw** өнгийг шууд HTML-д бичдэг байсан. Энэ аргын асуудал:

- Dark mode нэмэхэд **бүх файлыг** нэг нэгээр хайж өөрчлөх шаардлагатай
- Ижил өнгийг ямар зорилгоор ашиглаж байгааг нэрнээс нь мэдэхгүй
- Брэнд өнгийг өөрчлөхөд олон газар засварлах хэрэгтэй

Token систем ашиглахад `tokens.css` **нэг файлд утгыг өөрчлөхөд** сайт даяар өнгө автоматаар шинэчлэгдэнэ.

---

## Нэршлийн категори

| Угтвар | Утга | Tailwind utility | Жишээ |
|---|---|---|---|
| **`fg-*`** | Текст, icon (foreground) | `text-fg-*`, `fill-fg-*` | `text-fg-default` |
| **`surface-*`** | Арын фон (background) | `bg-surface-*` | `bg-surface-base` |
| **`stroke-*`** | Хүрээ, хуваагч (border) | `border-stroke-*`, `outline-stroke-*` | `border-stroke-default` |
| **`brand-*`** | Брэнд өнгө (accent) | `bg-brand-*`, `text-brand-*` | `bg-brand-primary` |
| **`status-*`** | Мэдэгдлийн өнгө (feedback) | `text-status-*`, `bg-status-*` | `text-status-error` |

---

## Давхаргын бүтэц

```
Primitive tokens  →  Semantic tokens    →  Tailwind utility classes
(raw утгууд)         (утга + зорилго)      (HTML-д ашиглах)

--primitive-lime-500  →  --color-brand-primary  →  bg-brand-primary
                                                    text-brand-primary
                                                    fill-brand-primary
```

---

## Primitive tokens — Raw утгууд

> **Дүрэм:** Эдгээрийг HTML дотор шууд **ашиглахгүй**. Зөвхөн semantic token-уудын утга болгон ашиглана.

Файл: `tailwind/custom/tokens.css` → `:root` блок

| Token нэр | Утга | Тайлбар |
|---|---|---|
| `--primitive-lime-500` | `oklch(76.8% 0.233 130.85)` | Брэнд өнгө (тод) |
| `--primitive-lime-600` | `oklch(64.8% 0.200 131.68)` | Брэнд өнгө (харанхуй) |
| `--primitive-lime-900` | `oklch(35.0% 0.120 130.00)` | Брэнд өнгө (маш харанхуй) |
| `--primitive-slate-50` | `oklch(98.4% 0.003 247.86)` | Бараг цагаан |
| `--primitive-slate-100` | `oklch(96.8% 0.007 247.90)` | Цайвар саарал |
| `--primitive-slate-200` | `oklch(93.0% 0.013 255.51)` | Хүрээний өнгө |
| `--primitive-slate-400` | `oklch(70.4% 0.028 261.33)` | Бүдэгхэн текст |
| `--primitive-slate-600` | `oklch(44.6% 0.030 256.80)` | Дэд текст |
| `--primitive-slate-800` | `oklch(27.9% 0.029 256.85)` | Харанхуй hover |
| `--primitive-slate-900` | `oklch(20.8% 0.042 265.76)` | Маш харанхуй |

---

## Semantic tokens — Light / Dark утгууд

Файл: `tailwind/custom/tokens.css` → `[data-theme="light"]` / `[data-theme="dark"]` блокууд

### `surface-*` — Арын фон

| Token | Tailwind класс | Light | Dark | Ашиглах газар |
|---|---|---|---|---|
| `--color-surface-base` | `bg-surface-base` | slate-50 | `oklch(15%)` | `<body>`, хуудасны үндсэн фон |
| `--color-surface-card` | `bg-surface-card` | цагаан | `oklch(20%)` | Card, modal гадаргуу |
| `--color-surface-raised` | `bg-surface-raised` | slate-100 | `oklch(24%)` | Hover, dropdown |
| `--color-surface-overlay` | `bg-surface-overlay` | slate-50/85% | `oklch(15%/88%)` | Modal арын бүрхэвч |
| `--color-surface-inverse` | `bg-surface-inverse` | slate-900 | slate-50 | Харанхуй товч дэвсгэр |
| `--color-surface-inverse-hover` | `bg-surface-inverse-hover` | slate-800 | `oklch(93%)` | Харанхуй товчны hover |

### `fg-*` — Текст, icon

| Token | Tailwind класс | Light | Dark | Ашиглах газар |
|---|---|---|---|---|
| `--color-fg-default` | `text-fg-default` | slate-900 | `oklch(95%)` | Үндсэн текст, гарчиг |
| `--color-fg-subtle` | `text-fg-subtle` | slate-600 | `oklch(70%)` | Дэд текст, тайлбар |
| `--color-fg-muted` | `text-fg-muted` | slate-400 | `oklch(50%)` | Metadata, timestamp |
| `--color-fg-disabled` | `text-fg-disabled` | `oklch(75%)` | `oklch(38%)` | Идэвхгүй элемент |
| `--color-fg-inverse` | `text-fg-inverse` | slate-50 | slate-900 | Харанхуй фон дээрх текст |
| `--color-fg-link` | `text-fg-link` | lime-600 | lime-500 | Холбоос, идэвхтэй nav |

### `stroke-*` — Хүрээ, хуваагч

| Token | Tailwind класс | Light | Dark | Ашиглах газар |
|---|---|---|---|---|
| `--color-stroke-default` | `border-stroke-default` | slate-200 | `oklch(28%)` | Card хүрээ, divider |
| `--color-stroke-strong` | `border-stroke-strong` | `oklch(80%)` | `oklch(38%)` | Тод хүрээ, table |
| `--color-stroke-focus` | `border-stroke-focus` | lime-500 | lime-500 | Focus ring, input |

### `brand-*` — Брэнд

| Token | Tailwind класс | Ашиглах газар |
|---|---|---|
| `--color-brand-primary` | `bg-brand-primary`, `text-brand-primary` | Товч, link, accent |
| `--color-brand-hover` | `bg-brand-hover` | Брэнд товчны hover |
| `--color-brand-subtle` | `bg-brand-subtle` | Брэнд өнгийн цайвар дэвсгэр |
| `--color-brand-fg` | `text-brand-fg` | Брэнд фон дээрх текст |

### `status-*` — Мэдэгдэл

| Token | Tailwind класс | Ашиглах газар |
|---|---|---|
| `--color-status-success` | `text-status-success` | Амжилт, баталгаа |
| `--color-status-error` | `text-status-error` | Алдаа |
| `--color-status-warning` | `text-status-warning` | Анхааруулга |
| `--color-status-info` | `text-status-info` | Мэдээлэл |

---

## HTML-д хэрэглэх жишээ

```html
<!-- Хуудасны үндсэн бүтэц -->
<body class="bg-surface-base text-fg-default font-sans">

  <!-- Card -->
  <div class="bg-surface-card border border-stroke-default rounded-radius-md shadow-shadow-md">

    <!-- Гарчиг -->
    <h2 class="text-fg-default">Гарчиг</h2>

    <!-- Дэд текст -->
    <p class="text-fg-subtle">Тайлбар текст</p>

    <!-- Metadata -->
    <span class="text-fg-muted">2026-03-13</span>

    <!-- Холбоос -->
    <a class="text-fg-link hover:text-brand-hover">Холбоос</a>

    <!-- Хүрээлсэн хуваагч -->
    <hr class="border-stroke-default">

    <!-- Брэнд товч -->
    <button class="bg-brand-primary hover:bg-brand-hover text-fg-inverse rounded-radius-md px-4 py-2">
      Товч
    </button>

    <!-- Харанхуй (inverse) товч -->
    <a class="bg-surface-inverse hover:bg-surface-inverse-hover text-fg-inverse rounded-full px-4 py-2">
      Харанхуй товч
    </a>

  </div>

</body>
```

---

## Dark mode

```html
<html data-theme="light">  <!-- Light mode -->
<html data-theme="dark">   <!-- Dark mode -->
```

```js
// Toggle хийх
function toggleTheme() {
  const html = document.documentElement;
  const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('theme', next);
}

// Хуудас ачааллахад localStorage-аас унших
(function () {
  const saved = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-theme', saved);
})();
```

Тодорхой элементийг dark mode-д өөр харуулах:

```html
<div class="bg-surface-card dark:bg-surface-raised">
<svg class="fill-fg-default dark:fill-fg-inverse">
```

---

## Хуучин → Шинэ шилжилтийн хүснэгт

| Хуучин Tailwind класс | Шинэ token класс |
|---|---|
| `text-zinc-800`, `text-zinc-900`, `text-slate-900` | `text-fg-default` |
| `text-zinc-600`, `text-slate-600` | `text-fg-subtle` |
| `text-zinc-400`, `text-gray-400`, `text-slate-400` | `text-fg-muted` |
| `text-white`, `text-zinc-100`, `text-zinc-200` | `text-fg-inverse` |
| `text-lime-500`, `text-lime-600` | `text-fg-link` / `text-brand-primary` |
| `bg-slate-50`, `bg-zinc-50` | `bg-surface-base` |
| `bg-white` | `bg-surface-card` |
| `bg-slate-100`, `bg-gray-100` | `bg-surface-raised` |
| `bg-zinc-900`, `bg-slate-900` | `bg-surface-inverse` |
| `bg-zinc-800` | `bg-surface-inverse-hover` |
| `border-zinc-900`, `border-zinc-800` | `border-stroke-default` |
| `border-zinc-700`, `border-zinc-600` | `border-stroke-strong` |
| `fill-white` | `fill-fg-inverse` |
| `fill-lime-500` | `fill-brand-primary` |
| `outline-zinc-700` | `outline-stroke-strong` |
| `selection:bg-lime-600` | `selection:bg-brand-hover` |
| `selection:text-white` | `selection:text-fg-inverse` |

---

## Файлуудын бүтэц

```
tailwind/
├── custom/
│   ├── tokens.css        ← Primitive + Semantic CSS variables  ← ЭНИЙГ ЗАСНА
│   ├── utilities.css     ← Prose болон custom utility classes
│   ├── base.css          ← body болон global base styles
│   └── fonts.css         ← @font-face тодорхойлолт
└── tailwind-theme.css    ← @custom-variant dark + @theme inline mappings
```

**Өнгө нэмэх/өөрчлөх бол** → `tokens.css` файлд primitive эсвэл semantic token засна.
