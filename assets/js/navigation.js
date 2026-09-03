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

		// Scrollspy & smooth click handling
		if (!navLinks.length) return;

		var sections = [];
		navLinks.forEach(function(link) {
			var id = link.getAttribute('href').replace('#', '');
			var section = document.getElementById(id);
			if (section) {
				sections.push({ id: id, link: link, el: section });
			}
		});

		function setActive(activeId) {
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

		// Initial active link
		var currentHash = window.location.hash.replace('#', '') || 'home';
		setActive(currentHash);

		if ('IntersectionObserver' in window && sections.length) {
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

		navLinks.forEach(function(link) {
			link.addEventListener('click', function() {
				var targetId = link.getAttribute('href').replace('#', '');
				setActive(targetId);
				closeMenu();
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initNavigation);
	} else {
		initNavigation();
	}
})();
