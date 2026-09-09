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

		var isThemeTransitioning = false;
		toggleBtn.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			if (isThemeTransitioning) {
				return;
			}

			var cur = document.documentElement.getAttribute('data-theme-mode') || getPreferredTheme();
			var next = (cur === 'dark') ? 'light' : 'dark';

			// Fallback if View Transitions API is unsupported or user prefers reduced motion
			if (!document.startViewTransition || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches)) {
				applyTheme(next, true);
				return;
			}

			isThemeTransitioning = true;
			var transition = document.startViewTransition(function() {
				applyTheme(next, true);
			});

			transition.finished.finally(function() {
				isThemeTransitioning = false;
			});
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
			var ticking = false;
			var updateProgress = function() {
				var rect = article.getBoundingClientRect();
				var articleTop = rect.top + window.scrollY;
				var articleHeight = article.offsetHeight;
				var windowHeight = window.innerHeight;
				var scrollY = window.scrollY;

				var totalScrollable = articleHeight - windowHeight;
				if (totalScrollable <= 0) {
					progressBar.style.width = '0%';
					ticking = false;
					return;
				}

				var currentProgress = (scrollY - articleTop) / totalScrollable;
				var progressPercent = Math.min(100, Math.max(0, currentProgress * 100));
				progressBar.style.width = progressPercent + '%';
				ticking = false;
			};

			var onScrollOrResize = function() {
				if (!ticking) {
					window.requestAnimationFrame(updateProgress);
					ticking = true;
				}
			};

			window.addEventListener('scroll', onScrollOrResize, { passive: true });
			window.addEventListener('resize', onScrollOrResize, { passive: true });
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

	function initTerminalContactForm() {
		var form = document.getElementById('gp-terminal-contact-form');
		if (!form) return;

		form.addEventListener('submit', function(e) {
			e.preventDefault();

			var recipient = form.getAttribute('data-recipient') || 'hello@example.com';
			var successMsg = form.getAttribute('data-success') || '[OK] Opening your email client to dispatch...';
			var nameInput = form.querySelector('#gp_sender_name');
			var emailInput = form.querySelector('#gp_sender_email');
			var msgInput = form.querySelector('#gp_sender_message');
			var statusEl = form.querySelector('.gp-form-status');
			var submitBtn = form.querySelector('.gp-terminal-submit-btn');

			var name = nameInput ? nameInput.value.trim() : '';
			var email = emailInput ? emailInput.value.trim() : '';
			var msg = msgInput ? msgInput.value.trim() : '';

			if (!name || !email || !msg) {
				if (statusEl) {
					statusEl.textContent = '[ERR] All fields are required.';
					statusEl.className = 'gp-form-status gp-form-error';
				}
				return;
			}

			if (statusEl) {
				statusEl.textContent = successMsg;
				statusEl.className = 'gp-form-status gp-form-success';
			}
			if (submitBtn) {
				submitBtn.disabled = true;
			}

			var subject = encodeURIComponent('Inquiry from ' + name + ' via GeekyPress Portfolio');
			var body = encodeURIComponent(
				'Sender: ' + name + ' (' + email + ')\n\n' +
				'Message:\n' + msg + '\n\n' +
				'--\nSent from GeekyPress Developer Portfolio'
			);
			var mailtoUrl = 'mailto:' + recipient + '?subject=' + subject + '&body=' + body;

			setTimeout(function() {
				window.location.href = mailtoUrl;
				if (submitBtn) {
					submitBtn.disabled = false;
				}
			}, 300);
		});
	}

	function initBlogSlider() {
		var sliderWraps = document.querySelectorAll('.terminal-blog-slider-wrap');
		if (!sliderWraps.length) {
			return;
		}

		sliderWraps.forEach(function(wrap) {
			var track = wrap.querySelector('.terminal-blog-slider-track');
			var section = wrap.closest('.terminal-blog');
			if (!track || !section) {
				return;
			}

			var prevBtn = section.querySelector('.terminal-blog-prev');
			var nextBtn = section.querySelector('.terminal-blog-next');
			if (!prevBtn || !nextBtn) {
				return;
			}

			var cards = track.querySelectorAll('.terminal-blog-card');
			var totalCards = cards.length;
			if (!totalCards) {
				return;
			}

			var currentIndex = 0;

			function getVisibleCount() {
				var firstCard = cards[0];
				if (!firstCard) return 1;
				var cardWidth = firstCard.getBoundingClientRect().width;
				var wrapWidth = wrap.clientWidth;
				if (cardWidth <= 0 || wrapWidth <= 0) return 1;
				return Math.max(1, Math.round(wrapWidth / cardWidth));
			}

			function updateSlider() {
				var visibleCount = getVisibleCount();
				var maxIndex = Math.max(0, totalCards - visibleCount);

				if (currentIndex > maxIndex) {
					currentIndex = maxIndex;
				}
				if (currentIndex < 0) {
					currentIndex = 0;
				}

				var firstCard = cards[0];
				if (firstCard) {
					var cardRect = firstCard.getBoundingClientRect();
					var style = window.getComputedStyle(track);
					var gap = parseFloat(style.columnGap || style.gap) || 24;
					var step = cardRect.width + gap;
					var offset = currentIndex * step;
					track.style.transform = 'translateX(-' + offset + 'px)';
				}

				var isAtStart = currentIndex <= 0;
				var isAtEnd = currentIndex >= maxIndex;

				prevBtn.disabled = isAtStart;
				prevBtn.setAttribute('aria-disabled', isAtStart ? 'true' : 'false');

				nextBtn.disabled = isAtEnd;
				nextBtn.setAttribute('aria-disabled', isAtEnd ? 'true' : 'false');
			}

			prevBtn.addEventListener('click', function(e) {
				e.preventDefault();
				var visibleCount = getVisibleCount();
				currentIndex = Math.max(0, currentIndex - visibleCount);
				updateSlider();
			});

			nextBtn.addEventListener('click', function(e) {
				e.preventDefault();
				var visibleCount = getVisibleCount();
				var maxIndex = Math.max(0, totalCards - visibleCount);
				currentIndex = Math.min(maxIndex, currentIndex + visibleCount);
				updateSlider();
			});

			// Touch swipe gestures without intercepting vertical page scrolling
			var touchStartX = 0;
			var touchStartY = 0;

			wrap.addEventListener('touchstart', function(e) {
				if (e.touches && e.touches[0]) {
					touchStartX = e.touches[0].screenX;
					touchStartY = e.touches[0].screenY;
				}
			}, { passive: true });

			wrap.addEventListener('touchend', function(e) {
				if (e.changedTouches && e.changedTouches[0]) {
					var touchEndX = e.changedTouches[0].screenX;
					var touchEndY = e.changedTouches[0].screenY;
					var diffX = touchStartX - touchEndX;
					var diffY = touchStartY - touchEndY;

					// Only trigger horizontal slide if swipe is primarily horizontal
					if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
						var visibleCount = getVisibleCount();
						var maxIndex = Math.max(0, totalCards - visibleCount);
						if (diffX > 0) {
							currentIndex = Math.min(maxIndex, currentIndex + 1);
						} else {
							currentIndex = Math.max(0, currentIndex - 1);
						}
						updateSlider();
					}
				}
			}, { passive: true });

			window.addEventListener('resize', updateSlider, { passive: true });

			// Initial evaluation
			updateSlider();
			window.addEventListener('load', updateSlider);
		});
	}

	function initScrollAnimations() {
		if (!document.body.classList.contains('has-gp-animations')) {
			return;
		}
		if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			return;
		}
		if (!('IntersectionObserver' in window)) {
			return;
		}

		var targets = document.querySelectorAll(
			'.terminal-section-header, .gp-stats-header, ' +
			'.terminal-hero-copy, .terminal-window, ' +
			'.terminal-about-copy, .terminal-stat-grid > p, .terminal-stat-card, ' +
			'.terminal-skill-grid > p, ' +
			'.terminal-timeline > .terminal-experience, ' +
			'.terminal-card-grid > .terminal-card, ' +
			'.gp-stat-card, ' +
			'.terminal-blog-card, ' +
			'.terminal-contact, ' +
			'.terminal-cta-content'
		);
		if (!targets.length) {
			return;
		}

		var observer = new IntersectionObserver(function(entries) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('gp-is-visible');
					observer.unobserve(entry.target);
				}
			});
		}, {
			root: null,
			rootMargin: '0px 0px -40px 0px',
			threshold: 0.08
		});

		targets.forEach(function(el) {
			el.classList.add('gp-animate-on-scroll');

			var parent = el.parentElement;
			if (parent) {
				var isGrid = parent.classList.contains('gp-stats-grid') ||
					parent.classList.contains('terminal-card-grid') ||
					parent.classList.contains('terminal-skill-grid') ||
					parent.classList.contains('terminal-timeline') ||
					parent.classList.contains('terminal-stat-grid') ||
					parent.classList.contains('terminal-blog-grid') ||
					parent.classList.contains('terminal-blog-slider-track');

				if (isGrid) {
					var childIndex = Array.prototype.indexOf.call(parent.children, el);
					if (childIndex >= 0 && childIndex < 12) {
						el.classList.add('gp-delay-' + (childIndex + 1));
					}
				}
			}

			if (el.classList.contains('terminal-window')) {
				el.classList.add('gp-delay-1');
			}

			observer.observe(el);
		});
	}

	function initTerminalTyping() {
		var termContainers = document.querySelectorAll('.terminal-json');
		if (!termContainers.length) {
			return;
		}

		termContainers.forEach(function(container) {
			var cmdEl = container.querySelector('.terminal-cmd-text');
			var outputEl = container.querySelector('.terminal-json-output');
			if (!cmdEl || !outputEl) {
				return;
			}

			var fullCmd = (container.getAttribute('data-cmd') || cmdEl.textContent || '>_ cat developer.json').trim();
			var rawJson = container.getAttribute('data-raw-json') || outputEl.textContent;

			function formatJsonLine(line) {
				var trimmed = line.trim();
				if (!trimmed) {
					return '&nbsp;';
				}

				if (/^[{}\[\]],?$/.test(trimmed)) {
					return line.replace(/([{}\[\]])/g, '<span class="gp-json-bracket">$1</span>')
						.replace(/(,)/g, '<span class="gp-json-comma">$1</span>');
				}

				return line.replace(/^(\s*)(".*?")(\s*:\s*)(.*)$/, function(match, indent, key, colon, val) {
					var formattedVal = val.replace(/(".*?")/g, '<span class="gp-json-string">$1</span>')
						.replace(/([\[\]{}])/g, '<span class="gp-json-bracket">$1</span>')
						.replace(/(true|false)/g, '<span class="gp-json-bracket">$1</span>')
						.replace(/(,)/g, '<span class="gp-json-comma">$1</span>');

					return indent +
						'<span class="gp-json-key">' + key + '</span>' +
						'<span class="gp-json-colon">' + colon + '</span>' +
						formattedVal;
				});
			}

			// Pre-render syntax highlighted lines
			var lines = rawJson.split('\n');
			var formattedLinesHtml = lines.map(function(line) {
				return '<span class="gp-json-line">' + formatJsonLine(line) + '</span>';
			}).join('');

			outputEl.innerHTML = formattedLinesHtml;

			// Set initial hidden state so typing & stream are visibly perceived
			container.classList.add('is-typing-ready');
			cmdEl.textContent = '';

			var lineElements = outputEl.querySelectorAll('.gp-json-line');
			lineElements.forEach(function(lineEl) {
				lineEl.classList.remove('gp-line-visible');
			});

			var isTyping = false;

			function runTypingSequence() {
				if (isTyping) return;
				isTyping = true;

				container.classList.add('is-typing-ready');
				cmdEl.textContent = '';
				lineElements.forEach(function(lineEl) {
					lineEl.classList.remove('gp-line-visible');
				});

				var charIndex = 0;
				var typeSpeed = 38;

				function typeNextChar() {
					if (charIndex < fullCmd.length) {
						cmdEl.textContent += fullCmd.charAt(charIndex);
						charIndex++;
						setTimeout(typeNextChar, typeSpeed);
					} else {
						// Command typed! Short pause then load lines sequentially
						setTimeout(revealLinesOneByOne, 220);
					}
				}

				function revealLinesOneByOne() {
					var lineIndex = 0;
					var lineInterval = 85;

					function showNextLine() {
						if (lineIndex < lineElements.length) {
							lineElements[lineIndex].classList.add('gp-line-visible');
							lineIndex++;
							setTimeout(showNextLine, lineInterval);
						} else {
							isTyping = false;
						}
					}
					showNextLine();
				}

				typeNextChar();
			}

			// Delay initial start by 400ms so the user visibly watches the typing begin
			setTimeout(runTypingSequence, 400);

			// Replay on click anywhere on terminal window or title bar
			var terminalWindow = container.closest('.terminal-window');
			if (terminalWindow) {
				terminalWindow.addEventListener('click', function(e) {
					if (e.target.closest('a') || e.target.closest('img') || e.target.closest('picture')) {
						return;
					}
					isTyping = false;
					runTypingSequence();
				});
				terminalWindow.style.cursor = 'pointer';
				terminalWindow.setAttribute('title', 'Click to replay terminal output');
			}
		});
	}

	function start() {
		initNavigation();
		initBackToTop();
		initThemeToggle();
		initSinglePostFeatures();
		initTerminalContactForm();
		initBlogSlider();
		initScrollAnimations();
		initTerminalTyping();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', start);
	} else {
		start();
	}
})();
