/**
 * Front-end JavaScript
 */

/* ─── Dark Mode Toggle ───────────────────────────────────────────────────── */
/**
 * DS: <html data-theme="light"|"dark"> attribute-г toggle хийнэ.
 * functions.php-д FOUC-аас сэргийлэх inline script байгаа тул
 * энд зөвхөн toggle handler + icon state л хариуцна.
 */
(function site_init_dark_mode() {
	/**
	 * Toggle buttons-ийн icon state-г шинэчлэнэ.
	 *
	 * @param {string} theme - 'light' | 'dark'
	 */
	function site_update_toggle_icons(theme) {
		document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
			const sunIcon  = btn.querySelector('[data-icon-light]');
			const moonIcon = btn.querySelector('[data-icon-dark]');
			if (sunIcon)  sunIcon.style.display  = theme === 'dark'  ? 'none'  : 'block';
			if (moonIcon) moonIcon.style.display  = theme === 'light' ? 'none'  : 'block';
			btn.setAttribute('aria-label', theme === 'dark' ? 'Light mode-рүү шилжих' : 'Dark mode-рүү шилжих');
		});
	}

	/**
	 * Toggle хийнэ: dark ↔ light.
	 */
	function site_toggle_theme() {
		const html    = document.documentElement;
		const current = html.dataset.theme === 'dark' ? 'dark' : 'light';
		const next    = current === 'dark' ? 'light' : 'dark';
		html.dataset.theme = next;
		localStorage.setItem('ub_theme', next);
		site_update_toggle_icons(next);
	}

	// Init icons on load.
	document.addEventListener('DOMContentLoaded', () => {
		const saved = document.documentElement.dataset.theme ?? 'light';
		site_update_toggle_icons(saved);

		document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
			btn.addEventListener('click', site_toggle_theme);
		});
	});
})();

/* ─── Main DOMContentLoaded ─────────────────────────────────────────────── */

document.addEventListener('DOMContentLoaded', () => {
	/**
	 * Table of Contents Logic
	 */
	const postContent = document.querySelector('[data-post-content]');
	const tocList = document.querySelector('[data-post-toc-list]');

	if (postContent && tocList) {
		const headings = Array.from(postContent.querySelectorAll('h2, h3'));
		if (headings.length > 0) {
			// Safe removal of children
			while (tocList.firstChild) {
				tocList.removeChild(tocList.firstChild);
			}

			let lastH2Li = null;

			headings.forEach((heading, index) => {
				const text = heading.textContent.trim();
				if (!text) return;

				const randomId = `toc-section-${Math.random().toString(36).substr(2, 5)}-${index}`;
				heading.id = randomId;

				const level = heading.tagName.toLowerCase();
				const listItem = document.createElement('li');
				listItem.className = 'list-none p-0 m-0';

				const link = document.createElement('a');
				link.href = `#${heading.id}`;
				link.className = 'no-underline text-fg-subtle/70 hover:text-fg-link transition-colors duration-200 block';
				
				const span = document.createElement('span');
				span.textContent = text;
				const fontSizeClass = level === 'h2' ? 'text-sm' : 'text-xs';
				span.className = `${fontSizeClass} data-current:text-fg-default transition-colors duration-200 data-current:font-medium leading-none block py-1`;
				
				link.appendChild(span);
				listItem.appendChild(link);

				if (level === 'h2') {
					tocList.appendChild(listItem);
					lastH2Li = listItem;
				} else if (level === 'h3') {
					if (lastH2Li) {
						let nestedUl = lastH2Li.querySelector('ul');
						if (!nestedUl) {
							nestedUl = document.createElement('ul');
							nestedUl.className = 'border-l border-stroke-default/50 pl-2 my-2';
							lastH2Li.appendChild(nestedUl);
						}
						nestedUl.appendChild(listItem);
					} else {
						tocList.appendChild(listItem);
					}
				}
			});

			const observer = new IntersectionObserver((entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						const id = entry.target.getAttribute('id');
						const currentLink = tocList.querySelector(`a[href="#${id}"]`);
						if (currentLink) {
							const currentSpan = currentLink.querySelector('span');
							tocList.querySelectorAll('span').forEach(s => s.removeAttribute('data-current'));
							if (currentSpan) currentSpan.setAttribute('data-current', '');
						}
					}
				});
			}, { root: null, rootMargin: '-5% 0px -80% 0px', threshold: 0 });

			headings.forEach(heading => observer.observe(heading));
		}
	}
});
