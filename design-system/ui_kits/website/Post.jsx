// Blog post detail — single post layout with reading column, author strip, and related posts.

const Post = ({ post, onBack }) => {
  if (!post) return null;
  return (
    <main>
      <div style={{ padding: '24px 32px 8px', maxWidth: 1120, margin: '0 auto' }}>
        <a href="#" onClick={e => { e.preventDefault(); onBack?.(); }} style={{
          fontSize: 13, color: 'var(--color-fg-subtle)', textDecoration: 'none',
          display: 'inline-flex', alignItems: 'center', gap: 6,
        }}>← Буцах</a>
      </div>

      {/* Article header */}
      <article style={{ padding: '24px 32px 56px', maxWidth: 760, margin: '0 auto' }}>
        <div style={{ display: 'flex', gap: 10, marginBottom: 22 }}>
          <Badge>{post.tag}</Badge>
          <span style={{ fontWeight: 700, fontSize: 11, letterSpacing: '.12em',
            textTransform: 'uppercase', color: 'var(--color-fg-muted)',
            display: 'inline-flex', alignItems: 'center' }}>
            {post.date} · 6 мин унших
          </span>
        </div>
        <h1 style={{
          margin: 0, fontWeight: 900, fontSize: 56, lineHeight: 1.02, letterSpacing: '-.02em',
        }}>{post.title}</h1>
        <p style={{
          margin: '24px 0 32px', fontSize: 20, lineHeight: 1.5,
          color: 'var(--color-fg-subtle)',
        }}>
          Энэ нийтлэл дээр би {post.tag.toLowerCase()}-ын хүрээнд хийж байгаа туршилт,
          дүгнэлтүүдээ хуваалцаж байна. Богино уншилт, тодорхой дүгнэлт.
        </p>

        {/* Hero band */}
        <div style={{
          height: 320, background: post.accent, borderRadius: 16,
          display: 'flex', alignItems: 'center', justifyContent: 'center',
        }}>
          <span style={{ width: 120, height: 120, borderRadius: 999, background: '#0C0D0B',
            display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <LogoMono size={84} />
          </span>
        </div>

        {/* Body */}
        <div style={{ marginTop: 40, fontSize: 18, lineHeight: 1.65, color: 'var(--color-fg-default)' }}>
          <p style={{ marginTop: 0 }}>
            Token систем гэж юу вэ? Богинохон хариулт: <strong>дизайны шийдвэрүүдийн нэрлэгдсэн
            хувилбар</strong>. Raw hex биш, <code style={{
              fontFamily: 'var(--primitive-font-mono)', background: 'var(--color-surface-raised)',
              padding: '2px 6px', borderRadius: 6, fontSize: 15,
            }}>--color-brand-primary</code> гэдэг нэртэй.
          </p>
          <h2 style={{ fontWeight: 800, fontSize: 28, margin: '32px 0 12px', letterSpacing: '-.01em' }}>
            Primitive vs semantic
          </h2>
          <p>
            Primitive token бол raw утга. Semantic token бол хэрэглэгдэх газар, зорилго.
            Component нь зөвхөн semantic-г хэрэглэдэг — энэ нь theme-ыг бие даан солих
            боломж өгдөг.
          </p>
          <blockquote style={{
            margin: '28px 0', padding: '20px 24px', borderLeft: '3px solid var(--color-brand-primary)',
            background: 'var(--color-surface-raised)', borderRadius: '0 12px 12px 0',
            fontSize: 20, fontWeight: 600, fontStyle: 'italic', color: 'var(--color-fg-default)',
          }}>
            "Дизайн систем бол хязгаарлалт биш, шийдвэрийн санах ой."
          </blockquote>
          <p>
            Tailwind v4 дээр <code style={{ fontFamily: 'var(--primitive-font-mono)',
              background: 'var(--color-surface-raised)', padding: '2px 6px', borderRadius: 6, fontSize: 15,
            }}>@theme</code> хэсэгт token-уудаа бичиж өгснөөр utility class-уудыг
            тэр чигээр нь үүсгэдэг. Энэ нь repo-гоо цэвэр байлгахад тустай.
          </p>
        </div>

        {/* Author strip */}
        <div style={{
          marginTop: 48, padding: '22px 24px', borderRadius: 16,
          background: 'var(--color-surface-raised)',
          display: 'flex', alignItems: 'center', gap: 16,
        }}>
          <div style={{
            width: 56, height: 56, borderRadius: 999, background: '#0C0D0B',
            display: 'flex', alignItems: 'center', justifyContent: 'center',
          }}><LogoMono size={40} /></div>
          <div style={{ flex: 1 }}>
            <div style={{ fontWeight: 800, fontSize: 16 }}>Улзийбат</div>
            <div style={{ fontSize: 14, color: 'var(--color-fg-subtle)' }}>
              Брэнд систем, прототип, зөвлөх үйлчилгээ · Ulaanbaatar
            </div>
          </div>
          <a href="#" style={{
            fontSize: 13, fontWeight: 500, padding: '8px 14px', borderRadius: 9999,
            background: 'var(--color-surface-inverse)', color: 'var(--color-fg-inverse)', textDecoration: 'none',
          }}>Холбогдох</a>
        </div>
      </article>

      {/* Related */}
      <section style={{ padding: '0 32px 72px' }}>
        <div style={{ maxWidth: 1120, margin: '0 auto' }}>
          <h3 style={{ fontWeight: 800, fontSize: 22, margin: '0 0 18px' }}>Холбоотой нийтлэл</h3>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3,1fr)', gap: 20 }}>
            {POSTS.filter(p => p.id !== post.id).slice(0,3).map(p => (
              <PostCard key={p.id} post={p} />
            ))}
          </div>
        </div>
      </section>
    </main>
  );
};

Object.assign(window, { Post });
