// Social poster — layout templates
// ====================================
// Each template is a React component that takes width/height + content props
// and renders a complete poster. Templates use `cqw` (container-query width)
// units so they scale 1:1 across 1080², 1080×1350, 1600×900 etc.
//
// Naming convention: <Purpose><Direction>  e.g. BlogPromoEditorial, QuoteBold,
// TipItemDark, StatDark, AnnounceLime …
//
// All are exported to window for use from the main file.

// Aspect-aware title sizer — landscape frames need smaller cqw because
// there's less vertical room. Returns an fs multiplier.
//   portrait (h > w):    1.0  (use full size)
//   square:               0.95
//   landscape (<16:9):    0.75
//   wide landscape:       0.62
function titleFs(width, height, baseCqw) {
  const ratio = width / height;
  if (ratio <= 1)     return baseCqw;               // portrait / square
  if (ratio <= 1.25)  return baseCqw * 0.95;        // nearly square
  if (ratio <= 1.6)   return baseCqw * 0.75;        // landscape (LI 1.91, FB cover 1.91, YT 1.78)
  return baseCqw * 0.62;                             // very wide (X, FB cover, LI)
}

// ── BLOG PROMO ────────────────────────────────────────────
// Purpose: drive to a new blog post. Shows: eyebrow, title, CTA + handle.

function BlogPromoEditorial({ width, height, eyebrow, title, cta, readTime }) {
  return (
    <PosterFrame width={width} height={height} variant="cream" id="blog-editorial">
      <div style={{
        position: 'absolute', inset: '6% 6% 14% 6%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline' }}>
          <p className="poster-eyebrow" style={{ fontSize: '2.2cqw' }}>{eyebrow}</p>
          <p className="poster-meta" style={{ fontSize: '2.2cqw' }}>{readTime}</p>
        </div>
        <div>
          <hr className="poster-rule" style={{ margin: '0 0 5% 0' }} />
          <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 9.6)}cqw` }}>
            {title}
          </h1>
          <div style={{
            marginTop: '6%',
            display: 'flex', alignItems: 'center', gap: '1.5%',
            fontFamily: 'var(--primitive-font-mono)', fontSize: '2.4cqw',
            letterSpacing: '0.1em', textTransform: 'uppercase',
            color: 'var(--color-brand-primary, #82BD39)',
          }}>
            <span style={{ color: '#0C0D0B' }}>{cta}</span>
            <span style={{ color: '#0C0D0B', opacity: 0.4 }}>·→</span>
          </div>
        </div>
      </div>
      <BrandBand />
    </PosterFrame>
  );
}

function BlogPromoLime({ width, height, eyebrow, title, cta, readTime }) {
  return (
    <PosterFrame width={width} height={height} variant="lime" id="blog-lime">
      <div style={{
        position: 'absolute', inset: '6% 6% 14% 6%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <p className="poster-eyebrow" style={{ fontSize: '2.2cqw' }}>{eyebrow}</p>
          <p className="poster-meta" style={{ fontSize: '2.2cqw', opacity: 1 }}>{readTime}</p>
        </div>
        <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 11)}cqw`, color: '#0C0D0B' }}>
          {title}
        </h1>
        <div style={{
          display: 'inline-flex', alignItems: 'center', gap: '1.5%',
          alignSelf: 'flex-start',
          background: '#0C0D0B', color: '#82BD39',
          padding: '1.4% 2.4%', borderRadius: 999,
          fontFamily: 'var(--primitive-font-mono)', fontSize: '2.2cqw',
          letterSpacing: '0.1em', textTransform: 'uppercase',
        }}>
          <span>{cta}</span><span>·→</span>
        </div>
      </div>
      <BrandBand tone="dark" />
    </PosterFrame>
  );
}

function BlogPromoDark({ width, height, eyebrow, title, cta, readTime }) {
  return (
    <PosterFrame width={width} height={height} variant="ink" id="blog-dark">
      <div style={{
        position: 'absolute', inset: '6% 6% 14% 6%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <p className="poster-eyebrow" style={{ fontSize: '2.2cqw', color: '#82BD39' }}>{eyebrow}</p>
          <p className="poster-meta" style={{ fontSize: '2.2cqw' }}>{readTime}</p>
        </div>
        <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 10)}cqw` }}>
          {title.split(' ').map((w, i, arr) => (
            <span key={i}>
              {i === arr.length - 1 ? <em style={{ color: '#82BD39', fontStyle: 'normal' }}>{w}</em> : w}
              {i < arr.length - 1 ? ' ' : ''}
            </span>
          ))}
        </h1>
        <div style={{
          fontFamily: 'var(--primitive-font-mono)', fontSize: '2.2cqw',
          letterSpacing: '0.1em', textTransform: 'uppercase', color: '#82BD39',
        }}>
          <span>{cta}  ·→</span>
        </div>
      </div>
      <BrandBand tone="light" />
    </PosterFrame>
  );
}

function BlogPromoPhoto({ width, height, eyebrow, title, cta, readTime }) {
  return (
    <PosterFrame width={width} height={height} variant="photo" id="blog-photo">
      <Photo overlay />
      <div style={{
        position: 'absolute', inset: '6% 6% 14% 6%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
        color: '#FAFAF8',
      }}>
        <div style={{ display: 'flex', gap: '3%' }}>
          <span style={{
            background: '#82BD39', color: '#0C0D0B',
            padding: '0.8% 2%', borderRadius: 4,
            fontFamily: 'var(--primitive-font-mono)', fontSize: '2cqw',
            letterSpacing: '0.1em', textTransform: 'uppercase', fontWeight: 700,
          }}>{eyebrow}</span>
          <span className="poster-meta" style={{ fontSize: '2cqw' }}>{readTime}</span>
        </div>
        <div>
          <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 10)}cqw` }}>{title}</h1>
          <div style={{
            marginTop: '4%',
            fontFamily: 'var(--primitive-font-mono)', fontSize: '2.2cqw',
            letterSpacing: '0.1em', textTransform: 'uppercase',
          }}>{cta}  ·→</div>
        </div>
      </div>
      <BrandBand tone="light" />
    </PosterFrame>
  );
}

// ── QUOTE ─────────────────────────────────────────────────
function QuoteEditorial({ width, height, quote, attribution }) {
  return (
    <PosterFrame width={width} height={height} variant="cream" id="quote-editorial">
      <span className="poster-quotemark" style={{
        fontSize: '40cqw', top: '-6%', left: '2%',
      }}>"</span>
      <div style={{
        position: 'absolute', inset: '12% 8% 14% 8%',
        display: 'flex', flexDirection: 'column', justifyContent: 'center',
      }}>
        <blockquote className="poster-title" style={{
          fontSize: `${titleFs(width, height, 7.2)}cqw`, fontWeight: 700, letterSpacing: '-0.02em',
          lineHeight: 1.08, margin: 0,
        }}>
          {quote}
        </blockquote>
        <hr className="poster-rule" style={{ margin: '6% 0 3% 0', width: '14%', borderTopWidth: 2, opacity: 1, color: '#82BD39' }} />
        <p className="poster-meta" style={{ fontSize: '2.2cqw', opacity: 1 }}>— {attribution}</p>
      </div>
      <BrandBand />
    </PosterFrame>
  );
}

function QuoteLime({ width, height, quote, attribution }) {
  return (
    <PosterFrame width={width} height={height} variant="lime" id="quote-lime">
      <div style={{
        position: 'absolute', inset: '12% 8% 14% 8%',
        display: 'flex', flexDirection: 'column', justifyContent: 'center',
      }}>
        <blockquote className="poster-title" style={{
          fontSize: `${titleFs(width, height, 8)}cqw`, fontWeight: 900, color: '#0C0D0B',
          lineHeight: 1.02,
        }}>
          "{quote}"
        </blockquote>
        <p className="poster-meta" style={{
          fontSize: '2.2cqw', opacity: 1, marginTop: '5%', color: '#0C0D0B',
        }}>— {attribution}</p>
      </div>
      <BrandBand tone="dark" />
    </PosterFrame>
  );
}

function QuoteDark({ width, height, quote, attribution }) {
  return (
    <PosterFrame width={width} height={height} variant="ink" id="quote-dark">
      <span className="poster-quotemark" style={{
        fontSize: '48cqw', top: '-10%', right: '-4%', color: '#82BD39', opacity: 0.16,
      }}>"</span>
      <div style={{
        position: 'absolute', inset: '12% 8% 14% 8%',
        display: 'flex', flexDirection: 'column', justifyContent: 'center',
      }}>
        <blockquote className="poster-title" style={{
          fontSize: `${titleFs(width, height, 7.4)}cqw`, fontWeight: 700, lineHeight: 1.1,
        }}>
          {quote}
        </blockquote>
        <p style={{
          fontFamily: 'var(--primitive-font-mono)', fontSize: '2.2cqw',
          letterSpacing: '0.1em', textTransform: 'uppercase', marginTop: '6%',
          color: '#82BD39',
        }}>— {attribution}</p>
      </div>
      <BrandBand tone="light" />
    </PosterFrame>
  );
}

// ── HOT TAKE / STATEMENT ──────────────────────────────────
function HotTakeBold({ width, height, label, statement }) {
  return (
    <PosterFrame width={width} height={height} variant="cream" id="hottake-bold">
      <div style={{
        position: 'absolute', inset: '8% 8% 14% 8%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <div style={{ display: 'inline-flex', alignSelf: 'flex-start',
          background: '#82BD39', color: '#0C0D0B',
          padding: '1% 2%', borderRadius: 4,
          fontFamily: 'var(--primitive-font-mono)', fontSize: '2.4cqw',
          letterSpacing: '0.14em', textTransform: 'uppercase', fontWeight: 700,
        }}>
          {label}
        </div>
        <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 11)}cqw` }}>
          {statement}
        </h1>
        <div />
      </div>
      <BrandBand />
    </PosterFrame>
  );
}

function HotTakeDark({ width, height, label, statement }) {
  return (
    <PosterFrame width={width} height={height} variant="ink" id="hottake-dark">
      <div style={{
        position: 'absolute', inset: '8% 8% 14% 8%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <div style={{ display: 'inline-flex', alignSelf: 'flex-start',
          background: 'transparent', color: '#82BD39',
          border: '1px solid #82BD39',
          padding: '1% 2%', borderRadius: 4,
          fontFamily: 'var(--primitive-font-mono)', fontSize: '2.4cqw',
          letterSpacing: '0.14em', textTransform: 'uppercase', fontWeight: 700,
        }}>
          {label}
        </div>
        <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 11)}cqw` }}>
          {statement.split(/(\*[^*]+\*)/).filter(Boolean).map((chunk, i) =>
            chunk.startsWith('*')
              ? <em key={i} style={{ color: '#82BD39', fontStyle: 'normal' }}>{chunk.slice(1, -1)}</em>
              : <span key={i}>{chunk}</span>
          )}
        </h1>
        <div />
      </div>
      <BrandBand tone="light" />
    </PosterFrame>
  );
}

// ── STAT / NUMBER ─────────────────────────────────────────
function StatEditorial({ width, height, number, unit, label, caption }) {
  return (
    <PosterFrame width={width} height={height} variant="cream" id="stat-editorial">
      <div style={{
        position: 'absolute', inset: '8% 8% 14% 8%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <p className="poster-eyebrow" style={{ fontSize: '2.2cqw' }}>{label}</p>
        <div style={{ display: 'flex', alignItems: 'baseline', gap: '2%' }}>
          <span className="poster-numbadge" style={{ fontSize: '34cqw', letterSpacing: '-0.04em' }}>
            {number}
          </span>
          {unit && <span className="poster-numbadge" style={{ fontSize: '7cqw', color: '#82BD39' }}>{unit}</span>}
        </div>
        <p style={{ fontSize: '3.6cqw', lineHeight: 1.2, fontWeight: 500, margin: 0, maxWidth: '80%' }}>
          {caption}
        </p>
      </div>
      <BrandBand />
    </PosterFrame>
  );
}

function StatLime({ width, height, number, unit, label, caption }) {
  return (
    <PosterFrame width={width} height={height} variant="lime" id="stat-lime">
      <div style={{
        position: 'absolute', inset: '8% 8% 14% 8%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
        color: '#0C0D0B',
      }}>
        <p className="poster-eyebrow" style={{ fontSize: '2.2cqw' }}>{label}</p>
        <div style={{ display: 'flex', alignItems: 'baseline', gap: '2%' }}>
          <span className="poster-numbadge" style={{ fontSize: '36cqw', letterSpacing: '-0.04em' }}>
            {number}
          </span>
          {unit && <span className="poster-numbadge" style={{ fontSize: '7cqw' }}>{unit}</span>}
        </div>
        <p style={{ fontSize: '3.4cqw', lineHeight: 1.2, fontWeight: 500, margin: 0, maxWidth: '80%' }}>
          {caption}
        </p>
      </div>
      <BrandBand tone="dark" />
    </PosterFrame>
  );
}

// ── ANNOUNCEMENT ──────────────────────────────────────────
function AnnounceEditorial({ width, height, kicker, headline, date, place, cta }) {
  return (
    <PosterFrame width={width} height={height} variant="cream" id="announce-editorial">
      <div style={{
        position: 'absolute', inset: '7% 7% 14% 7%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <div>
          <p className="poster-eyebrow" style={{ fontSize: '2.2cqw', color: '#82BD39' }}>● {kicker}</p>
          <hr className="poster-rule" style={{ marginTop: '3%' }} />
        </div>
        <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 10)}cqw` }}>
          {headline}
        </h1>
        <div>
          <hr className="poster-rule" />
          <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: '3%', flexWrap: 'wrap', gap: '2%' }}>
            <p className="poster-meta" style={{ fontSize: '2.2cqw', opacity: 1 }}>{date}</p>
            <p className="poster-meta" style={{ fontSize: '2.2cqw', opacity: 1 }}>{place}</p>
            <p className="poster-meta" style={{ fontSize: '2.2cqw', color: '#82BD39', opacity: 1 }}>{cta} ·→</p>
          </div>
        </div>
      </div>
      <BrandBand />
    </PosterFrame>
  );
}

function AnnounceDark({ width, height, kicker, headline, date, place, cta }) {
  return (
    <PosterFrame width={width} height={height} variant="ink" id="announce-dark">
      <div style={{
        position: 'absolute', inset: '7% 7% 14% 7%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <div>
          <p className="poster-eyebrow" style={{ fontSize: '2.2cqw', color: '#82BD39' }}>● {kicker}</p>
        </div>
        <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 10)}cqw` }}>
          {headline}
        </h1>
        <div style={{ display: 'flex', justifyContent: 'space-between', flexWrap: 'wrap', gap: '2%' }}>
          <p className="poster-meta" style={{ fontSize: '2.2cqw' }}>{date}</p>
          <p className="poster-meta" style={{ fontSize: '2.2cqw' }}>{place}</p>
          <p className="poster-meta" style={{ fontSize: '2.2cqw', color: '#82BD39' }}>{cta} ·→</p>
        </div>
      </div>
      <BrandBand tone="light" />
    </PosterFrame>
  );
}

// ── BEFORE / AFTER ────────────────────────────────────────
function BeforeAfter({ width, height, beforeLabel, afterLabel, beforeText, afterText }) {
  return (
    <PosterFrame width={width} height={height} variant="cream" id="beforeafter">
      <div style={{ position: 'absolute', inset: 0, display: 'flex' }}>
        <div style={{
          flex: 1, padding: '8% 6%', borderRight: '1px solid rgba(12,13,11,0.2)',
          display: 'flex', flexDirection: 'column', justifyContent: 'center', gap: '4%',
        }}>
          <p className="poster-eyebrow" style={{ fontSize: '2.2cqw', opacity: 0.5 }}>○ {beforeLabel}</p>
          <p className="poster-title" style={{ fontSize: '6.4cqw', opacity: 0.65, fontWeight: 700, textDecoration: 'line-through', textDecorationThickness: '2px' }}>
            {beforeText}
          </p>
        </div>
        <div style={{
          flex: 1, padding: '8% 6%', background: '#82BD39',
          display: 'flex', flexDirection: 'column', justifyContent: 'center', gap: '4%',
        }}>
          <p className="poster-eyebrow" style={{ fontSize: '2.2cqw' }}>● {afterLabel}</p>
          <p className="poster-title" style={{ fontSize: '7cqw', fontWeight: 900 }}>
            {afterText}
          </p>
        </div>
      </div>
      <BrandBand />
    </PosterFrame>
  );
}

// ── CAROUSEL SLIDES — TIP LIST ────────────────────────────
function TipCoverEditorial({ width, height, count, title, kicker }) {
  return (
    <PosterFrame width={width} height={height} variant="cream" id="tipcover-editorial">
      <div style={{
        position: 'absolute', inset: '7% 7% 14% 7%',
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
      }}>
        <p className="poster-eyebrow" style={{ fontSize: '2.2cqw', color: '#82BD39' }}>{kicker}</p>
        <div>
          <span className="poster-numbadge" style={{ fontSize: '28cqw', display: 'block', lineHeight: 0.85 }}>
            {count}
          </span>
          <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 9)}cqw`, marginTop: '2%' }}>
            {title}
          </h1>
        </div>
        <p className="poster-meta" style={{ fontSize: '2.2cqw', color: '#82BD39' }}>
          SWIPE ·→
        </p>
      </div>
      <BrandBand />
    </PosterFrame>
  );
}

function TipItemEditorial({ width, height, num, total, head, body }) {
  return (
    <PosterFrame width={width} height={height} variant="cream" id="tipitem-editorial">
      <div style={{
        position: 'absolute', inset: '7% 7% 14% 7%',
        display: 'flex', flexDirection: 'column', gap: '6%',
      }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline' }}>
          <span className="poster-numbadge" style={{ fontSize: '14cqw', color: '#82BD39' }}>{num}</span>
          <span className="poster-meta" style={{ fontSize: '2cqw' }}>{num} / {total}</span>
        </div>
        <hr className="poster-rule" />
        <h2 className="poster-title" style={{ fontSize: '6.6cqw', fontWeight: 700 }}>
          {head}
        </h2>
        <p style={{
          fontSize: '3.2cqw', lineHeight: 1.35, fontWeight: 400, margin: 0, maxWidth: '92%',
          color: '#0C0D0B', opacity: 0.78,
        }}>
          {body}
        </p>
      </div>
      <BrandBand />
    </PosterFrame>
  );
}

function TipItemDark({ width, height, num, total, head, body }) {
  return (
    <PosterFrame width={width} height={height} variant="ink" id="tipitem-dark">
      <div style={{
        position: 'absolute', inset: '7% 7% 14% 7%',
        display: 'flex', flexDirection: 'column', gap: '6%',
      }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline' }}>
          <span className="poster-numbadge" style={{ fontSize: '14cqw', color: '#82BD39' }}>{num}</span>
          <span className="poster-meta" style={{ fontSize: '2cqw' }}>{num} / {total}</span>
        </div>
        <hr className="poster-rule" style={{ borderColor: '#82BD39', opacity: 0.4 }} />
        <h2 className="poster-title" style={{ fontSize: '6.6cqw', fontWeight: 700 }}>
          {head}
        </h2>
        <p style={{
          fontSize: '3.2cqw', lineHeight: 1.35, fontWeight: 400, margin: 0, maxWidth: '92%',
          opacity: 0.78,
        }}>
          {body}
        </p>
      </div>
      <BrandBand tone="light" />
    </PosterFrame>
  );
}

function TipFinalEditorial({ width, height, cta, url }) {
  return (
    <PosterFrame width={width} height={height} variant="lime" id="tipfinal">
      <div style={{
        position: 'absolute', inset: '10% 8% 14% 8%',
        display: 'flex', flexDirection: 'column', justifyContent: 'center', gap: '4%',
        color: '#0C0D0B',
      }}>
        <p className="poster-eyebrow" style={{ fontSize: '2.2cqw' }}>{cta}</p>
        <h1 className="poster-title" style={{ fontSize: `${titleFs(width, height, 10)}cqw`, fontWeight: 900 }}>
          Бүрэн нийтлэлийг<br />блогоос уншина уу.
        </h1>
        <p style={{
          fontFamily: 'var(--primitive-font-mono)', fontSize: '2.6cqw',
          letterSpacing: '0.08em', marginTop: '3%', color: '#0C0D0B',
        }}>
          {url}  ·→
        </p>
      </div>
      <BrandBand tone="dark" />
    </PosterFrame>
  );
}

// ── EXPORT ALL ────────────────────────────────────────────
Object.assign(window, {
  BlogPromoEditorial, BlogPromoLime, BlogPromoDark, BlogPromoPhoto,
  QuoteEditorial, QuoteLime, QuoteDark,
  HotTakeBold, HotTakeDark,
  StatEditorial, StatLime,
  AnnounceEditorial, AnnounceDark,
  BeforeAfter,
  TipCoverEditorial, TipItemEditorial, TipItemDark, TipFinalEditorial,
});
