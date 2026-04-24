// About page — bio block, services grid, contact CTA.

const About = () => (
  <main style={{ padding: '72px 32px 88px' }}>
    <div style={{ maxWidth: 880, margin: '0 auto' }}>
      <span style={{ display: 'inline-block', fontWeight: 900, fontSize: 12,
        letterSpacing: '.12em', textTransform: 'uppercase', color: 'var(--color-fg-muted)', marginBottom: 16 }}>
        Тухай</span>
      <h1 style={{ margin: 0, fontWeight: 900, fontSize: 64, lineHeight: 1.02, letterSpacing: '-.02em' }}>
        Сайн байна уу, би Улзийбат<span style={{ color: 'var(--color-brand-primary)' }}>.</span>
      </h1>
      <p style={{ marginTop: 20, fontSize: 20, lineHeight: 1.5, color: 'var(--color-fg-subtle)', maxWidth: 680 }}>
        Би дизайны систем, брэндийн хэрэглээ, прототип дээр мэргэшсэн. WordPress,
        Tailwind v4, мөн AI багажуудыг өдөр тутамдаа хэрэглэдэг.
      </p>

      <div style={{ marginTop: 56, display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 16 }}>
        {[
          { t: 'Брэнд систем', d: 'Token, component, guideline — хайчилж авахад бэлэн.' },
          { t: 'Web прототип', d: 'WordPress + Vite workflow-оор туршилтаас production хүртэл.' },
          { t: 'AI тусламж', d: 'Claude, агент багажуудаар үйлдвэрлэлийг хурдасгах.' },
        ].map(card => (
          <div key={card.t} style={{
            padding: 24, borderRadius: 16,
            background: 'var(--color-surface-card)', border: '1px solid var(--color-stroke-default)',
          }}>
            <div style={{ width: 40, height: 40, borderRadius: 999, background: 'var(--color-brand-subtle)',
              display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: 14 }}>
              <LogoMono size={28} />
            </div>
            <h3 style={{ margin: '0 0 8px', fontWeight: 800, fontSize: 18 }}>{card.t}</h3>
            <p style={{ margin: 0, fontSize: 14, color: 'var(--color-fg-subtle)', lineHeight: 1.5 }}>{card.d}</p>
          </div>
        ))}
      </div>

      <div style={{ marginTop: 56, padding: '32px 32px', borderRadius: 20,
        background: 'var(--color-surface-inverse)', color: 'var(--color-fg-inverse)',
        display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 24 }}>
        <div>
          <div style={{ fontWeight: 900, fontSize: 12, letterSpacing: '.12em',
            textTransform: 'uppercase', color: 'var(--color-brand-primary)', marginBottom: 10 }}>
            Хамтран ажиллах</div>
          <h2 style={{ margin: 0, fontWeight: 800, fontSize: 32, letterSpacing: '-.01em' }}>
            Төсөл ярих уу?
          </h2>
        </div>
        <a href="#" style={{
          display: 'inline-flex', alignItems: 'center', gap: 6,
          background: 'var(--color-brand-primary)', color: 'var(--color-brand-fg)',
          fontSize: 14, fontWeight: 700, padding: '14px 22px',
          borderRadius: 9999, textDecoration: 'none',
        }}>Надтай холбогдох <ArrowRight size={18} /></a>
      </div>
    </div>
  </main>
);

Object.assign(window, { About });
