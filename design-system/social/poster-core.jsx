// Social poster — primitives & export helpers
// =============================================
// Exposes:
//   <PosterFrame width height variant theme copyable> — wraps a poster, draws
//     the "Copy SVG" overlay button, applies cream/lime/ink/tint/photo.
//   <BrandBand variant="band|watermark|inline"> — the author footer.
//   <Photo overlay=bool> — placeholder photo.
//   copyPosterSVG(el) — walk a DOM poster node, serialize it to a standalone
//     SVG string using <foreignObject>, copy to clipboard.
//
// Why <foreignObject>?
//   Posters are typographically heavy with tight layout — recreating them as
//   SVG shapes/text would be enormous work AND lose live editing in Figma.
//   Wrapping the rendered HTML in an SVG <foreignObject> gives Figma a
//   vector-preserving import that retains live text (Figma supports this
//   import path via "Paste SVG").
//
// The exported SVG is self-contained: inline font stylesheet + inline tokens.

// ── One-time: inline the tokens + fonts CSS so exported SVG is portable ──
window.__posterCSSPromise = window.__posterCSSPromise || (async () => {
  // Fetch both stylesheets and inline them — this way SVG opened standalone
  // or pasted into Figma has the correct typography.
  const [tokensCSS, postersCSS, fontsCSS] = await Promise.all([
    fetch('../colors_and_type.css').then((r) => r.text()).catch(() => ''),
    fetch('./posters.css').then((r) => r.text()).catch(() => ''),
    fetch('../fonts/fonts.css').then((r) => r.text()).catch(() => ''),
  ]);
  // Rewrite relative @font-face urls inside fonts.css → absolute to this page
  const fontsBase = new URL('../fonts/', window.location.href).href;
  const rewrittenFonts = fontsCSS.replace(/url\(['"]?\.?\/?([^)'"]+)['"]?\)/g, (_m, p) => `url("${fontsBase}${p}")`);
  // Strip the @import from tokens (we already have fonts inline)
  const rewrittenTokens = tokensCSS.replace(/@import\s+url\(['"]?[^)]*fonts\.css['"]?\);?/g, '');
  return rewrittenFonts + '\n' + rewrittenTokens + '\n' + postersCSS;
})();

function BrandBand({ variant = "band", tone = "auto", handle = "@ulziibat.tech" }) {
  // tone: "auto" picks light/dark logo based on surrounding poster bg
  // variant: "band" = full footer strip; "watermark" = corner-only logo; "inline" = logo+handle in flow
  const logoSrc = tone === "light"
    ? "../assets/logo-color-white.svg"
    : tone === "dark"
    ? "../assets/logo-color-black.svg"
    : "../assets/logo-color-black.svg";

  if (variant === "watermark") {
    return (
      <div style={{
        position: 'absolute', bottom: '4%', right: '4.5%',
        display: 'flex', alignItems: 'center', gap: '0.6em',
      }}>
        <img src={logoSrc} style={{ height: '3.6%', minHeight: 16, width: 'auto', opacity: 0.85 }} alt="" />
      </div>
    );
  }

  if (variant === "inline") {
    return (
      <div style={{ display: 'flex', alignItems: 'center', gap: '0.8em' }}>
        <img src={logoSrc} style={{ height: '1.4em', width: 'auto' }} alt="" />
        <span className="poster-meta" style={{ fontSize: '0.55em' }}>{handle}</span>
      </div>
    );
  }

  // band
  return (
    <div className="poster-band">
      <div className="left">
        <img className="logo" src={logoSrc} alt="Ulziibat.tech" />
      </div>
      <div className="right">
        <span className="handle">{handle}</span>
      </div>
    </div>
  );
}

function Photo({ overlay = true, tone }) {
  return <div className={`poster-photo ${overlay ? 'poster-photo--overlay' : ''}`} />;
}

function PosterFrame({ width, height, variant = "cream", children, style, copyable = true, id }) {
  const ref = React.useRef(null);
  const [state, setState] = React.useState("idle");
  const onCopy = async () => {
    if (!ref.current) return;
    setState("copying");
    try {
      const svg = await domToSVG(ref.current, width, height);
      await navigator.clipboard.writeText(svg);
      setState("copied");
      setTimeout(() => setState("idle"), 1400);
    } catch (err) {
      console.error(err);
      setState("error");
      setTimeout(() => setState("idle"), 1400);
    }
  };
  return (
    <div
      ref={ref}
      className="poster"
      data-variant={variant}
      data-poster-id={id}
      style={{
        width: `${width}px`,
        height: `${height}px`,
        containerType: 'size',
        ...style,
      }}
    >
      {children}
      {copyable && (
        <button className="poster-copybtn" data-state={state} onClick={onCopy} data-export-hide>
          {state === "copied" ? "✓ Copied" : state === "copying" ? "…" : "Copy SVG"}
        </button>
      )}
    </div>
  );
}

// ── DOM → SVG serializer ──────────────────────────────────
async function domToSVG(el, width, height) {
  const css = await window.__posterCSSPromise;
  // Clone node, strip elements marked [data-export-hide]
  const clone = el.cloneNode(true);
  clone.querySelectorAll('[data-export-hide]').forEach((n) => n.remove());
  // Explicit dimensions
  clone.style.width = width + 'px';
  clone.style.height = height + 'px';

  // Rewrite <img src="../..."> relative URLs → absolute for portability.
  const base = new URL('.', window.location.href).href;
  clone.querySelectorAll('img').forEach((img) => {
    const src = img.getAttribute('src');
    if (src && !/^(https?:|data:)/.test(src)) {
      img.setAttribute('src', new URL(src, base).href);
    }
  });

  const serializer = new XMLSerializer();
  // foreignObject requires xhtml namespace
  clone.setAttribute('xmlns', 'http://www.w3.org/1999/xhtml');
  const htmlBody = serializer.serializeToString(clone);
  const svg = `<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
     width="${width}" height="${height}" viewBox="0 0 ${width} ${height}">
  <defs>
    <style><![CDATA[
${css}
    ]]></style>
  </defs>
  <foreignObject x="0" y="0" width="${width}" height="${height}">
    ${htmlBody}
  </foreignObject>
</svg>`;
  return svg;
}

Object.assign(window, { PosterFrame, BrandBand, Photo, domToSVG });
