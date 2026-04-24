// Home page — hero + post grid + short bio strip.
// Reconstructs what theme/index.php renders via header + post loop + footer.

const Home = ({ onOpenPost }) => {
  return (
    <main>
      {/* Hero */}
      <section style={{ padding: '88px 32px 56px', background: 'var(--color-surface-base)' }}>
        <div style={{ maxWidth: 1120, margin: '0 auto' }}>
          <span style={{
            display:'inline-block', fontWeight: 900, fontSize: 12, letterSpacing: '.12em',
            textTransform: 'uppercase', color: 'var(--color-fg-muted)', marginBottom: 18,
          }}>Ulaanbaatar · 2025</span>
          <h1 style={{
            margin: 0, fontWeight: 900, fontSize: 80, lineHeight: .96, letterSpacing: '-0.02em',
            color: 'var(--color-fg-default)', maxWidth: 900,
          }}>
            Дизайн, код, &amp;<br/>
            хиймэл оюун<span style={{ color: 'var(--color-brand-primary)' }}>.</span>
          </h1>
          <p style={{
            margin: '24px 0 0', fontSize: 22, lineHeight: 1.4, maxWidth: 640,
            color: 'var(--color-fg-subtle)',
          }}>
            Би Улзийбат. WordPress, Tailwind v4 дээр суурилсан брэндийн систем,
            прототип, зөвлөгөө өгдөг. Энд би ажлаа, багаж хэрэгслээ хуваалцдаг.
          </p>
          <div style={{ marginTop: 28, display: 'flex', gap: 10 }}>
            <a href="#" style={{
              display:'inline-flex', alignItems:'center', gap: 6,
              background: 'var(--color-surface-inverse)', color: 'var(--color-fg-inverse)',
              fontSize: 14, fontWeight: 500, padding: '12px 16px 12px 20px',
              borderRadius: 9999, textDecoration: 'none',
            }}>Сүүлийн нийтлэл <ArrowRight size={18} /></a>
            <a href="#" style={{
              display:'inline-flex', alignItems:'center', gap: 6,
              background: 'var(--color-brand-primary)', color: 'var(--color-brand-fg)',
              fontSize: 14, fontWeight: 700, padding: '12px 18px',
              borderRadius: 9999, textDecoration: 'none',
            }}>Миний тухай</a>
          </div>
        </div>
      </section>

      {/* Post grid */}
      <section style={{ padding: '24px 32px 72px' }}>
        <div style={{ maxWidth: 1120, margin: '0 auto' }}>
          <div style={{ display:'flex', alignItems:'baseline', justifyContent: 'space-between', marginBottom: 22 }}>
            <h2 style={{ margin: 0, fontWeight: 800, fontSize: 30, letterSpacing: '-.01em' }}>Сүүлийн нийтлэл</h2>
            <a href="#" style={{ fontSize: 13, color: 'var(--color-fg-link)', textDecoration: 'none', fontWeight: 600 }}>Бүгд →</a>
          </div>
          <div style={{ display:'grid', gridTemplateColumns: '1.4fr 1fr 1fr', gap: 20 }}>
            <PostCard featured post={POSTS[0]} onClick={() => onOpenPost?.(POSTS[0])} />
            <PostCard post={POSTS[1]} onClick={() => onOpenPost?.(POSTS[1])} />
            <PostCard post={POSTS[2]} onClick={() => onOpenPost?.(POSTS[2])} />
          </div>
          <div style={{ display:'grid', gridTemplateColumns: 'repeat(3,1fr)', gap: 20, marginTop: 20 }}>
            <PostCard post={POSTS[3]} onClick={() => onOpenPost?.(POSTS[3])} />
            <PostCard post={POSTS[4]} onClick={() => onOpenPost?.(POSTS[4])} />
            <PostCard post={POSTS[5]} onClick={() => onOpenPost?.(POSTS[5])} />
          </div>
        </div>
      </section>
    </main>
  );
};

const POSTS = [
  { id: 1, title: 'Token систем — яагаад хэрэгтэй вэ?',
    excerpt: 'Raw өнгийг шууд HTML-д бичих нь дахин засахад нь хэцүү. Semantic token-уудаар энэ асуудлыг хэрхэн шийдэх вэ.',
    tag: 'Дизайн', date: '2026-03-13', accent: '#E3F2CE' },
  { id: 2, title: 'Tailwind v4-ийн @theme', tag: 'Код', date: '2026-02-28', accent: '#0C0D0B', excerpt: '' },
  { id: 3, title: 'WordPress + Vite workflow', tag: 'Код', date: '2026-02-10', accent: '#82BD39', excerpt: '' },
  { id: 4, title: 'Брэнд өнгө сонгох нь', tag: 'Дизайн', date: '2026-01-22', accent: '#0C0D0B', excerpt: '' },
  { id: 5, title: 'Prototype-аар ярих', tag: 'AI', date: '2025-12-30', accent: '#E3F2CE', excerpt: '' },
  { id: 6, title: 'Font stack дээр бодох нь', tag: 'Дизайн', date: '2025-12-10', accent: '#82BD39', excerpt: '' },
];

const PostCard = ({ post, featured = false, onClick }) => (
  <a href="#" onClick={e => { e.preventDefault(); onClick?.(); }} style={{
    display:'block', textDecoration: 'none', color: 'inherit',
    background: 'var(--color-surface-card)', borderRadius: 16,
    border: '1px solid var(--color-stroke-default)', overflow: 'hidden',
    transition: 'box-shadow 300ms var(--ease-primary), transform 300ms var(--ease-primary)',
  }}
  onMouseEnter={e => { e.currentTarget.style.boxShadow = 'var(--shadow-md)'; e.currentTarget.style.transform = 'translateY(-2px)'; }}
  onMouseLeave={e => { e.currentTarget.style.boxShadow = 'none'; e.currentTarget.style.transform = 'none'; }}>
    <div style={{
      aspectRatio: featured ? '1.6 / 1' : '1.4 / 1',
      background: post.accent, position: 'relative',
      display: 'flex', alignItems: 'flex-end', padding: 18,
    }}>
      <Badge variant={post.accent === '#0C0D0B' ? 'ink' : 'brand'}>{post.tag}</Badge>
      {featured && <span style={{
        position: 'absolute', top: 18, right: 18,
        width: 64, height: 64, borderRadius: 999, background: '#0C0D0B',
        display: 'flex', alignItems: 'center', justifyContent: 'center',
      }}><LogoMono size={44} /></span>}
    </div>
    <div style={{ padding: featured ? 22 : 18 }}>
      <h3 style={{
        margin: '0 0 8px', fontWeight: 800,
        fontSize: featured ? 26 : 18, lineHeight: 1.15, letterSpacing: '-.01em',
      }}>{post.title}</h3>
      {featured && post.excerpt && (
        <p style={{ margin: '0 0 12px', fontSize: 14, color: 'var(--color-fg-subtle)', lineHeight: 1.5 }}>
          {post.excerpt}
        </p>
      )}
      <div style={{
        fontWeight: 700, fontSize: 11, letterSpacing: '.12em', textTransform: 'uppercase',
        color: 'var(--color-fg-muted)',
      }}>{post.date}</div>
    </div>
  </a>
);

Object.assign(window, { Home, POSTS, PostCard });
