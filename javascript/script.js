/**
 * Front-end JavaScript
 */

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
				listItem.className = 'p-0 m-0 list-none';

				const link = document.createElement('a');
				link.href = `#${heading.id}`;
				link.className = 'block no-underline toc-link group';
				
				const span = document.createElement('span');
				span.textContent = text;
				const levelClass = level === 'h2' ? 'toc-text-h2' : 'toc-text-h3';
				span.className = `${levelClass} toc-text transition-all duration-300 block py-0.5 leading-none`;
				
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
							nestedUl.className = 'border-l border-slate-200/50';
							lastH2Li.appendChild(nestedUl);
						}
						nestedUl.appendChild(listItem);
					} else {
						tocList.appendChild(listItem);
					}
				}
			});

			// Reveal TOC after content is ready
			const tocContainer = document.querySelector('[data-post-toc]');
			if (tocContainer) {
				tocContainer.classList.remove('opacity-0', 'invisible');
				tocContainer.classList.add('opacity-100', 'visible');
			}

			const observer = new IntersectionObserver((entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						const id = entry.target.getAttribute('id');
						const currentLink = tocList.querySelector(`a[href="#${id}"]`);
						if (currentLink) {
							tocList.querySelectorAll('.toc-link').forEach(l => l.removeAttribute('data-current'));
							currentLink.setAttribute('data-current', '');
						}
					}
				});
			}, { root: null, rootMargin: '-5% 0px -80% 0px', threshold: 0 });

			headings.forEach(heading => observer.observe(heading));
		}
	}

	/**
	 * Calculate and set header height as CSS variable
	 */
	const updateHeaderHeight = () => {
		const header = document.querySelector('[data-site-header]');
		if (header) {
			const height = header.offsetHeight;
			const rem = height / 16;
			document.documentElement.style.setProperty('--header-height', `${rem}rem`);
		}
	};

	window.addEventListener('resize', updateHeaderHeight);
	updateHeaderHeight();
});
