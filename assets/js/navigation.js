/**
 * GeekyPress Navigation Controller
 *
 * Handles mobile hamburger navigation drawer, smooth scrolling,
 * and updates the active navigation state based on current scroll position.
 *
 * @package GeekyPress
 */
(function() {
	'use strict';

	function initNavigation() {
		var toggleBtn  = document.querySelector('.terminal-mobile-toggle');
		var navDrawer  = document.querySelector('#terminal-site-nav');
		var closeBtn   = document.querySelector('.terminal-mobile-close');
		var navLinks   = document.querySelectorAll('.terminal-navigation a[href^="#"]');

		// Query backdrop rendered in template
		var backdrop = document.querySelector('.terminal-navigation-wrapper .terminal-nav-backdrop');

		// Cleanup any lingering old backdrops directly under body from earlier versions
		var legacyBackdrops = document.querySelectorAll('body > .terminal-nav-backdrop');
		legacyBackdrops.forEach(function(el) {
			if (el && el.parentNode) {
				el.parentNode.removeChild(el);
			}
		});

		function openMenu() {
			if (!navDrawer) return;
			navDrawer.classList.add('is-open');
			if (backdrop) {
				backdrop.classList.add('is-visible');
			}
			if (toggleBtn) {
				toggleBtn.setAttribute('aria-expanded', 'true');
			}
			document.body.classList.add('gp-mobile-menu-open');
		}

		function closeMenu() {
			if (!navDrawer) return;
			navDrawer.classList.remove('is-open');
			if (backdrop) {
				backdrop.classList.remove('is-visible');
			}
			if (toggleBtn) {
				toggleBtn.setAttribute('aria-expanded', 'false');
			}
			document.body.classList.remove('gp-mobile-menu-open');
		}

		if (toggleBtn) {
			toggleBtn.addEventListener('click', function(e) {
				e.stopPropagation();
				if (navDrawer && navDrawer.classList.contains('is-open')) {
					closeMenu();
				} else {
					openMenu();
				}
			});
		}

		if (closeBtn) {
			closeBtn.addEventListener('click', function(e) {
				e.stopPropagation();
				closeMenu();
			});
		}

		if (backdrop) {
			backdrop.addEventListener('click', closeMenu);
		}

		// Close on Escape key
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && navDrawer && navDrawer.classList.contains('is-open')) {
				closeMenu();
			}
		});

		// Scrollspy & click handling for all navigation links
		var navLinks = document.querySelectorAll('.terminal-navigation a');
		if (!navLinks.length) return;

		var sections = [];
		navLinks.forEach(function(link) {
			var href = link.getAttribute('href') || '';
			var hashIndex = href.indexOf('#');
			if (hashIndex !== -1) {
				var id = href.substring(hashIndex + 1);
				var section = id ? document.getElementById(id) : null;
				if (section) {
					sections.push({ id: id, link: link, el: section });
				}
			}
		});

		function setActive(activeId) {
			if (!sections.length) return;
			sections.forEach(function(item) {
				if (item.id === activeId) {
					item.link.classList.add('is-active');
					if (item.link.parentElement) {
						item.link.parentElement.classList.add('is-active');
					}
				} else {
					item.link.classList.remove('is-active');
					if (item.link.parentElement) {
						item.link.parentElement.classList.remove('is-active');
					}
				}
			});
		}

		// Initial active link only if sections exist on this page
		if (sections.length) {
			var currentHash = window.location.hash.replace('#', '') || 'home';
			setActive(currentHash);

			if ('IntersectionObserver' in window) {
				var observer = new IntersectionObserver(function(entries) {
					entries.forEach(function(entry) {
						if (entry.isIntersecting) {
							setActive(entry.target.id);
						}
					});
				}, {
					rootMargin: '-20% 0px -60% 0px',
					threshold: 0
				});

				sections.forEach(function(item) {
					observer.observe(item.el);
				});
			}
		}

		navLinks.forEach(function(link) {
			link.addEventListener('click', function(e) {
				var href = link.getAttribute('href') || '';
				var hashIndex = href.indexOf('#');

				if (hashIndex !== -1) {
					var hash = href.substring(hashIndex);
					var targetId = hash.replace('#', '');
					var targetEl = targetId ? document.getElementById(targetId) : null;

					if (targetEl) {
						setActive(targetId);
						closeMenu();
					} else if (href.indexOf('#') === 0) {
						// Relative hash anchor clicked on a page where target doesn't exist (e.g. single post)
						e.preventDefault();
						var home = (window.geekypressData && window.geekypressData.homeUrl) ? window.geekypressData.homeUrl : '/';
						window.location.href = home + hash;
						closeMenu();
					} else {
						closeMenu();
					}
				} else {
					closeMenu();
				}
			});
		});
	}

	function initBackToTop() {
		var backTop = document.querySelector('.terminal-back-top');
		if (!backTop) return;

		var toggleBackTop = function() {
			if (window.scrollY > 300) {
				backTop.classList.add('is-visible');
			} else {
				backTop.classList.remove('is-visible');
			}
		};

		window.addEventListener('scroll', toggleBackTop, { passive: true });
		toggleBackTop();

		backTop.addEventListener('click', function(e) {
			e.preventDefault();
			window.scrollTo({
				top: 0,
				behavior: 'smooth'
			});
		});
	}

	function initThemeToggle() {
		var toggleBtn = document.getElementById('terminal-theme-toggle');
		if (!toggleBtn) return;

		function getPreferredTheme() {
			var stored = '';
			try {
				stored = localStorage.getItem('geekypress_theme');
			} catch (e) {}
			if (stored === 'dark' || stored === 'light') {
				return stored;
			}
			return (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) ? 'light' : 'dark';
		}

		function applyTheme(theme, save) {
			document.documentElement.setAttribute('data-theme-mode', theme);
			if (document.body) {
				document.body.setAttribute('data-theme-mode', theme);
			}
			if (save) {
				try {
					localStorage.setItem('geekypress_theme', theme);
				} catch (e) {}
			}
			var isDark = (theme === 'dark');
			toggleBtn.setAttribute('aria-label', isDark ? 'Switch to light theme' : 'Switch to dark theme');
			toggleBtn.setAttribute('title', isDark ? 'Switch to light theme' : 'Switch to dark theme');
		}

		// Sync initial button accessible state
		var current = document.documentElement.getAttribute('data-theme-mode') || getPreferredTheme();
		applyTheme(current, false);

		toggleBtn.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var cur = document.documentElement.getAttribute('data-theme-mode') || getPreferredTheme();
			var next = (cur === 'dark') ? 'light' : 'dark';
			applyTheme(next, true);
		});

		// Listen for system theme changes if user hasn't overridden
		if (window.matchMedia) {
			window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
				try {
					if (!localStorage.getItem('geekypress_theme')) {
						applyTheme(e.matches ? 'dark' : 'light', false);
					}
				} catch (err) {}
			});
		}
	}

	function initSinglePostFeatures() {
		// 1. Reading Progress Bar
		var progressBar = document.getElementById('gp-reading-progress');
		var article = document.querySelector('.terminal-post-article');
		if (progressBar && article) {
			var updateProgress = function() {
				var rect = article.getBoundingClientRect();
				var articleTop = rect.top + window.scrollY;
				var articleHeight = article.offsetHeight;
				var windowHeight = window.innerHeight;
				var scrollY = window.scrollY;

				var totalScrollable = articleHeight - windowHeight;
				if (totalScrollable <= 0) {
					progressBar.style.width = '0%';
					return;
				}

				var currentProgress = (scrollY - articleTop) / totalScrollable;
				var progressPercent = Math.min(100, Math.max(0, currentProgress * 100));
				progressBar.style.width = progressPercent + '%';
			};
			window.addEventListener('scroll', updateProgress, { passive: true });
			window.addEventListener('resize', updateProgress, { passive: true });
			updateProgress();
		}

		// 2. One-click Copy Article URL
		var copyLinkBtns = document.querySelectorAll('.gp-copy-link-btn');
		copyLinkBtns.forEach(function(btn) {
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				var url = btn.getAttribute('data-url') || window.location.href;
				var copyText = btn.querySelector('.gp-copy-text');
				var origText = copyText ? copyText.textContent : 'Copy Link';

				var doFeedback = function() {
					btn.classList.add('is-copied');
					if (copyText) copyText.textContent = 'Copied!';
					setTimeout(function() {
						btn.classList.remove('is-copied');
						if (copyText) copyText.textContent = origText;
					}, 2000);
				};

				if (navigator.clipboard && navigator.clipboard.writeText) {
					navigator.clipboard.writeText(url).then(doFeedback).catch(function() {});
				} else {
					var tempInput = document.createElement('input');
					tempInput.value = url;
					document.body.appendChild(tempInput);
					tempInput.select();
					try {
						document.execCommand('copy');
						doFeedback();
					} catch (err) {}
					document.body.removeChild(tempInput);
				}
			});
		});

		// 3. Code Block Copy Buttons & Terminal Shell
		var codeBlocks = document.querySelectorAll('.terminal-post-content pre');
		codeBlocks.forEach(function(pre) {
			if (pre.closest('.terminal-code-wrapper')) return;

			var wrapper = document.createElement('div');
			wrapper.className = 'terminal-code-wrapper';

			var codeEl = pre.querySelector('code');
			var lang = 'code';
			if (codeEl) {
				var langClasses = Array.from(codeEl.classList);
				for (var i = 0; i < langClasses.length; i++) {
					var c = langClasses[i];
					if (c.indexOf('language-') === 0 || c.indexOf('lang-') === 0) {
						lang = c.replace(/^(language-|lang-)/, '');
						break;
					}
				}
			}

			var bar = document.createElement('div');
			bar.className = 'terminal-code-bar';
			bar.innerHTML = '<div class="terminal-code-dots" aria-hidden="true"><i></i><i></i><i></i></div>' +
				'<span class="terminal-code-lang">' + (lang ? lang.toUpperCase() : 'SNIPPET') + '</span>' +
				'<button type="button" class="terminal-code-copy-btn" aria-label="Copy code to clipboard" title="Copy code">' +
				'<svg class="gp-icon gp-copy-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>' +
				'<svg class="gp-icon gp-check-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg>' +
				'<span>Copy</span>' +
				'</button>';

			pre.parentNode.insertBefore(wrapper, pre);
			wrapper.appendChild(bar);
			wrapper.appendChild(pre);

			var copyBtn = bar.querySelector('.terminal-code-copy-btn');
			if (copyBtn) {
				copyBtn.addEventListener('click', function() {
					var textToCopy = pre.innerText || pre.textContent || '';
					var label = copyBtn.querySelector('span');
					var origLabel = label ? label.textContent : 'Copy';

					var finish = function() {
						copyBtn.classList.add('is-copied');
						if (label) label.textContent = 'Copied!';
						setTimeout(function() {
							copyBtn.classList.remove('is-copied');
							if (label) label.textContent = origLabel;
						}, 2000);
					};

					if (navigator.clipboard && navigator.clipboard.writeText) {
						navigator.clipboard.writeText(textToCopy).then(finish).catch(function() {});
					} else {
						var ta = document.createElement('textarea');
						ta.value = textToCopy;
						document.body.appendChild(ta);
						ta.select();
						try {
							document.execCommand('copy');
							finish();
						} catch (e) {}
						document.body.removeChild(ta);
					}
				});
			}
		});
	}

	function start() {
		initNavigation();
		initBackToTop();
		initThemeToggle();
		initSinglePostFeatures();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', start);
	} else {
		start();
	}
})();
