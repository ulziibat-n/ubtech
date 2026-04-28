/**
 * Front-end JavaScript
 */

/* ─── Main DOMContentLoaded ─────────────────────────────────────────────── */

document.addEventListener('DOMContentLoaded', () => {
	/**
	 * Table of Contents Logic
	 */
	const postContent = document.querySelector('[data-post-content]');
	const tocLists = document.querySelectorAll('[data-post-toc-list]');

	if (postContent && tocLists.length > 0) {
		const headings = Array.from(postContent.querySelectorAll('h2, h3'));
		if (headings.length > 0) {
			
			// Initialize each TOC list
			tocLists.forEach(tocList => {
				// Safe removal of children
				while (tocList.firstChild) {
					tocList.removeChild(tocList.firstChild);
				}

				let lastH2Li = null;

				headings.forEach((heading, index) => {
					const text = heading.textContent.trim();
					if (!text) return;

					// Only set ID once
					if (!heading.id) {
						heading.id = `toc-section-${Math.random().toString(36).substr(2, 5)}-${index}`;
					}

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
			});

			// Reveal TOC after content is ready
			const tocContainers = document.querySelectorAll('[data-post-toc], [data-post-toc-block]');
			tocContainers.forEach(container => {
				container.classList.remove('opacity-0', 'invisible');
				container.classList.add('opacity-100', 'visible');
			});

			const observer = new IntersectionObserver((entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						const id = entry.target.getAttribute('id');
						
						tocLists.forEach(tocList => {
							const currentLink = tocList.querySelector(`a[href="#${id}"]`);
							if (currentLink) {
								tocList.querySelectorAll('.toc-link').forEach(l => l.removeAttribute('data-current'));
								currentLink.setAttribute('data-current', '');
							}
						});
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

	/**
	 * Sync heights of all related slider slides
	 */
	const syncRelatedSliderHeights = () => {
		const slides = document.querySelectorAll('[data-related-slider] .swiper-slide');
		if (!slides.length) return;

		// Reset heights first to get natural height
		slides.forEach(slide => {
			slide.style.height = 'auto';
			const card = slide.querySelector('article');
			if (card) card.style.height = 'auto';
		});

		let maxHeight = 0;
		slides.forEach(slide => {
			const height = slide.offsetHeight;
			if (height > maxHeight) maxHeight = height;
		});

		if (maxHeight > 0) {
			slides.forEach(slide => {
				slide.style.height = `${maxHeight}px`;
				const card = slide.querySelector('article');
				if (card) card.style.height = '100%';
			});
		}
	};

	/**
	 * Initialize Related Posts Slider
	 */
	const initRelatedSlider = () => {
		const sliderElement = document.querySelector('[data-related-slider]');
		if (sliderElement && typeof Swiper !== 'undefined') {
			new Swiper(sliderElement, {
				slidesPerView: 'auto',
				spaceBetween: 10,
				loop: false,
				watchSlidesProgress: true,
				navigation: {
					nextEl: '[data-related-next]',
					prevEl: '[data-related-prev]',
				},
				on: {
					init: syncRelatedSliderHeights,
					resize: syncRelatedSliderHeights
				}
			});

			// Initial sync
			setTimeout(syncRelatedSliderHeights, 100);
		}
	};

	/**
	 * Copy Code Button Logic
	 */
	const copyButtons = document.querySelectorAll('.copy-code-btn');
	copyButtons.forEach(btn => {
		btn.addEventListener('click', () => {
			const code = btn.getAttribute('data-code');
			const textSpan = btn.querySelector('.copy-text');
			const originalText = textSpan.textContent;

			navigator.clipboard.writeText(code).then(() => {
				textSpan.textContent = 'Хуулагдлаа!';
				btn.classList.add('text-lime-600');
				
				setTimeout(() => {
					textSpan.textContent = originalText;
					btn.classList.remove('text-lime-600');
				}, 2000);
			});
		});
	});

	// Initialize all
	updateHeaderHeight();
	initRelatedSlider();

	window.addEventListener('resize', () => {
		updateHeaderHeight();
		syncRelatedSliderHeights();
	});
	updateHeaderHeight();
});
