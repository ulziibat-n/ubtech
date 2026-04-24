// Shared UI primitives for the ULZIIBAT.TECH website recreation.
// Exports everything to window so sibling script tags can use them.

const LogoMono = ({ size = 32 }) => (
  <span style={{
    width: size, height: size, borderRadius: 999, background: '#0C0D0B',
    display: 'inline-flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0,
  }}>
    <svg viewBox="0 0 256 256" style={{ width: size * 0.62, height: 'auto' }}>
      <path d="M117.088 169.29L138.912 139.502L160.442 169.29L204.092 109.714L179.023 91.1336L160.442 116.498L138.618 86.4147L117.088 116.498L95.2627 86.7097L51.9078 146.286L76.977 164.866L95.2627 139.502L117.088 169.29Z" fill="#82BD39"/>
    </svg>
  </span>
);

const Wordmark = () => (
  <span style={{
    fontWeight: 900, fontSize: 12, letterSpacing: '.04em', lineHeight: 1,
    textTransform: 'uppercase', color: 'var(--color-fg-default)', display: 'inline-block',
  }}>
    <span style={{ display: 'block' }}>ulziibat</span>
    <span style={{ display: 'block', color: 'var(--color-brand-primary)' }}>tech</span>
  </span>
);

const ArrowRight = ({ size = 20 }) => (
  <svg width={size} height={size} viewBox="0 -960 960 960" fill="currentColor">
    <path d="m560-240-56-58 142-142H160v-80h486L504-662l56-58 240 240-240 240Z"/>
  </svg>
);

const ContactCTA = () => (
  <a href="#" style={{
    display: 'inline-flex', alignItems: 'center', gap: 6,
    padding: '8px 10px 8px 14px', borderRadius: 9999,
    background: 'var(--color-surface-inverse)', color: 'var(--color-fg-inverse)',
    fontSize: 13, fontWeight: 500, textDecoration: 'none',
    transition: 'background 300ms var(--ease-primary)',
  }}
  onMouseEnter={e => e.currentTarget.style.background = 'var(--color-surface-inverse-hover)'}
  onMouseLeave={e => e.currentTarget.style.background = 'var(--color-surface-inverse)'}>
    Надтай холбогдох <ArrowRight size={18} />
  </a>
);

const Header = ({ active = 'home', onNav }) => {
  const items = [
    { id: 'home', label: 'Нүүр' },
    { id: 'blog', label: 'Нийтлэл' },
    { id: 'work', label: 'Төслүүд' },
    { id: 'about', label: 'Тухай' },
  ];
  return (
    <header style={{
      padding: '20px 32px', display: 'flex', alignItems: 'center', gap: 32,
      borderBottom: '1px solid var(--color-stroke-default)',
      background: 'var(--color-surface-card)', position: 'sticky', top: 0, zIndex: 20,
    }}>
      <a href="#" onClick={e => { e.preventDefault(); onNav?.('home'); }}
         style={{ display:'flex', alignItems:'center', gap: 8, textDecoration:'none' }}>
        <LogoMono size={28} /><Wordmark />
      </a>
      <nav style={{ display:'flex', gap: 4 }}>
        {items.map(it => (
          <a key={it.id} href="#" onClick={e => { e.preventDefault(); onNav?.(it.id); }}
             style={{
               fontSize: 13, fontWeight: 500, textDecoration: 'none',
               padding: '6px 10px', borderRadius: 8,
               color: active === it.id ? 'var(--color-fg-default)' : 'var(--color-fg-subtle)',
               background: active === it.id ? 'var(--color-surface-raised)' : 'transparent',
             }}>
            {it.label}
          </a>
        ))}
      </nav>
      <div style={{ marginLeft: 'auto' }}><ContactCTA /></div>
    </header>
  );
};

const Footer = () => (
  <footer style={{ padding: '32px 32px 24px' }}>
    <div style={{
      paddingTop: 24, borderTop: '1px solid var(--color-stroke-default)',
      display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 32,
    }}>
      <p style={{
        margin: 0, fontWeight: 900, fontSize: 12, letterSpacing: '.08em',
        textTransform: 'uppercase', color: 'var(--color-fg-subtle)',
      }}>
        ULZIIBAT.<span style={{ color: 'var(--color-brand-primary)' }}>TECH</span> © 2025
      </p>
      <div style={{ display: 'flex', gap: 8 }}>
        {['Нийтлэл','Төслүүд','Холбоо'].map(t => (
          <a key={t} href="#" style={{ fontSize: 12, color: 'var(--color-fg-subtle)', textDecoration: 'none' }}>{t}</a>
        ))}
      </div>
    </div>
  </footer>
);

const Badge = ({ children, variant = 'brand' }) => {
  const styles = {
    brand: { background: 'var(--color-brand-subtle)', color: 'var(--color-brand-on-subtle)' },
    ink:   { background: 'var(--color-surface-inverse)', color: 'var(--color-fg-inverse)' },
    soft:  { background: 'var(--color-surface-raised)', color: 'var(--color-fg-subtle)' },
  };
  return <span style={{
    display:'inline-flex', alignItems:'center', gap: 6,
    fontSize: 10, fontWeight: 800, letterSpacing: '.08em', textTransform: 'uppercase',
    padding: '5px 10px', borderRadius: 9999, lineHeight: 1,
    ...styles[variant],
  }}>{children}</span>;
};

Object.assign(window, { LogoMono, Wordmark, ArrowRight, ContactCTA, Header, Footer, Badge });
