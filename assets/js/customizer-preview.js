/**
 * GeekyPress Customizer Live Preview
 *
 * Provides real-time, non-reloading DOM and CSS updates inside
 * the Customizer preview iframe.
 *
 * @package GeekyPress
 */

(function($, api) {
	'use strict';

	if (!api) return;

	/**
	 * Helper to bind text updates to single or multiple selectors.
	 */
	function bindText(settingKey, selector, callback) {
		api(settingKey, function(value) {
			value.bind(function(newval) {
				if (callback) {
					callback(newval);
				} else {
					$(selector).text(newval);
				}
			});
		});
	}

	/**
	 * Helper to bind HTML updates.
	 */
	function bindHtml(settingKey, selector) {
		api(settingKey, function(value) {
			value.bind(function(newval) {
				$(selector).html(newval);
			});
		});
	}

	/**
	 * Helper to bind CSS variable on :root
	 */
	function bindCSSVar(settingKey, varName) {
		api(settingKey, function(value) {
			value.bind(function(newval) {
				document.documentElement.style.setProperty(varName, newval);
			});
		});
	}

	// ── Colors & Theme Mode ──
	api('geekypress_theme_mode', function(value) {
		value.bind(function(newval) {
			document.documentElement.setAttribute('data-theme-mode', newval);
		});
	});

	bindCSSVar('geekypress_color_green', '--pt-green');
	bindCSSVar('geekypress_color_cyan', '--pt-cyan');
	bindCSSVar('geekypress_color_bg', '--pt-bg');
	bindCSSVar('geekypress_color_surface', '--pt-surface');
	bindCSSVar('geekypress_color_text', '--pt-text');
	bindCSSVar('geekypress_color_muted', '--pt-muted');
	bindCSSVar('geekypress_color_link', '--pt-link');
	bindCSSVar('geekypress_color_link_hover', '--pt-link-hover');

	// ── Typography & Google Fonts Live Preview ──
	var fontLookup = {
		'fira-code': { family: '"Fira Code", "Geist Mono", monospace', google: 'Fira+Code:wght@400;500;600;700' },
		'jetbrains-mono': { family: '"JetBrains Mono", "Geist Mono", monospace', google: 'JetBrains+Mono:wght@400;500;600;700' },
		'space-mono': { family: '"Space Mono", "Geist Mono", monospace', google: 'Space+Mono:ital,wght@0,400;0,700;1,400' },
		'source-code-pro': { family: '"Source Code Pro", "Geist Mono", monospace', google: 'Source+Code+Pro:wght@400;600;700' },
		'inconsolata': { family: '"Inconsolata", "Geist Mono", monospace', google: 'Inconsolata:wght@400;600;700' },
		'share-tech-mono': { family: '"Share Tech Mono", "Geist Mono", monospace', google: 'Share+Tech+Mono' },
		'vt323': { family: '"VT323", monospace', google: 'VT323' },
		'roboto-mono': { family: '"Roboto Mono", monospace', google: 'Roboto+Mono:wght@400;500;700' },
		'geist-mono': { family: '"Geist Mono", monospace', google: null },
		'inter': { family: '"Inter", system-ui, sans-serif', google: 'Inter:wght@400;500;600;700' },
		'space-grotesk': { family: '"Space Grotesk", sans-serif', google: 'Space+Grotesk:wght@400;500;600;700' },
		'plus-jakarta-sans': { family: '"Plus Jakarta Sans", sans-serif', google: 'Plus+Jakarta+Sans:wght@400;500;600;700' },
		'outfit': { family: '"Outfit", sans-serif', google: 'Outfit:wght@400;500;600;700' },
		'geist-sans': { family: '"Geist Sans", system-ui, sans-serif', google: null },
		'system': { family: 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif', google: null }
	};

	function loadGoogleFontPreview(key) {
		if (!fontLookup[key] || !fontLookup[key].google) return;
		var linkId = 'gp-font-preview-' + key;
		if (!$('#' + linkId).length) {
			$('<link>', {
				id: linkId,
				rel: 'stylesheet',
				href: 'https://fonts.googleapis.com/css2?family=' + fontLookup[key].google + '&display=swap'
			}).appendTo('head');
		}
	}

	api('geekypress_font_mono', function(value) {
		value.bind(function(newval) {
			if (fontLookup[newval]) {
				loadGoogleFontPreview(newval);
				document.documentElement.style.setProperty('--font-mono', fontLookup[newval].family);
			}
		});
	});

	api('geekypress_font_body', function(value) {
		value.bind(function(newval) {
			if (fontLookup[newval]) {
				loadGoogleFontPreview(newval);
				document.documentElement.style.setProperty('--font-sans', fontLookup[newval].family);
			}
		});
	});

	api('geekypress_font_ligatures', function(value) {
		value.bind(function(newval) {
			if (newval) {
				document.documentElement.style.setProperty('font-variant-ligatures', 'normal');
				document.documentElement.style.setProperty('font-feature-settings', '"calt" 1, "liga" 1');
			} else {
				document.documentElement.style.setProperty('font-variant-ligatures', 'none');
				document.documentElement.style.setProperty('font-feature-settings', 'normal');
			}
		});
	});

	// ── Custom CSS ──
	api('geekypress_custom_css', function(value) {
		value.bind(function(newval) {
			var $style = $('#geekypress-custom-css-preview');
			if (!$style.length) {
				$style = $('<style id="geekypress-custom-css-preview"></style>').appendTo('head');
			}
			$style.text(newval);
		});
	});

	// ── Header ──
	bindText('geekypress_header_badge', '.terminal-brand > span');
	bindText('geekypress_header_title', '.terminal-brand > strong');
	bindText('geekypress_header_cta_text', '.terminal-header-cta .wp-block-button__link');
	api('geekypress_header_cta_url', function(value) {
		value.bind(function(newval) {
			$('.terminal-header-cta .wp-block-button__link').attr('href', newval);
		});
	});

	// ── Hero ──
	bindText('geekypress_hero_label', '#home .terminal-label');
	bindText('geekypress_hero_title_prefix', '#home .hero-title-prefix');
	bindText('geekypress_hero_name', '#home .hero-title-name');
	bindText('geekypress_hero_surname', '#home .hero-title-surname');
	api('geekypress_hero_description', function(value) {
		value.bind(function(newval) {
			var formatted = (newval || '').replace(/\n/g, '<br>');
			$('#home .terminal-hero-desc').html(formatted);
		});
	});
	bindText('geekypress_hero_btn1_text', '#home .terminal-hero-btn1');
	api('geekypress_hero_btn1_url', function(value) {
		value.bind(function(newval) {
			$('#home .terminal-hero-btn1').attr('href', newval);
		});
	});
	bindText('geekypress_hero_btn2_text', '#home .terminal-hero-btn2');
	api('geekypress_hero_btn2_url', function(value) {
		value.bind(function(newval) {
			$('#home .terminal-hero-btn2').attr('href', newval);
		});
	});
	bindText('geekypress_hero_terminal_cmd', '#home .terminal-json strong');
	bindText('geekypress_hero_terminal_json', '#home .terminal-json pre');
	bindText('geekypress_hero_status_label', '#home .terminal-status-prefix');
	bindText('geekypress_hero_status_text', '#home .terminal-status strong');

	// ── About ──
	bindText('geekypress_about_label', '#about .terminal-label');
	api('geekypress_about_heading', function(value) {
		value.bind(function(newval) {
			var formatted = (newval || '').replace(/\n/g, '<br>');
			$('#about .section-title').html(formatted);
		});
	});
	bindText('geekypress_about_p1', '#about .terminal-about-p1');
	bindText('geekypress_about_p2', '#about .terminal-about-p2');
	bindText('geekypress_about_p3', '#about .terminal-about-p3');
	bindText('geekypress_about_signature', '#about .terminal-signature');

	// ── Projects ──
	bindText('geekypress_projects_label', '#projects .terminal-label');
	api('geekypress_projects_title', function(value) {
		value.bind(function(newval) {
			$('#projects .section-title').html('<span aria-hidden="true">&gt;</span> ' + newval + '<i aria-hidden="true">_</i>');
		});
	});

	// ── Skills ──
	bindText('geekypress_skills_label', '#skills .terminal-label');
	api('geekypress_skills_title', function(value) {
		value.bind(function(newval) {
			$('#skills .section-title').html('<span aria-hidden="true">&gt;</span> ' + newval + '<i aria-hidden="true">_</i>');
		});
	});

	// ── Experience ──
	bindText('geekypress_experience_label', '#experience .terminal-label');
	api('geekypress_experience_title', function(value) {
		value.bind(function(newval) {
			$('#experience .section-title').html('<span aria-hidden="true">&gt;</span> ' + newval + '<i aria-hidden="true">_</i>');
		});
	});

	// ── Interests ──
	bindText('geekypress_interests_label', '#interests .terminal-label');
	bindText('geekypress_interests_title', '#interests .section-title');

	// ── Contact ──
	bindText('geekypress_contact_label', '#contact .terminal-label');
	bindText('geekypress_contact_title', '#contact .section-title');
	api('geekypress_contact_email', function(value) {
		value.bind(function(newval) {
			var $el = $('#contact .terminal-contact-email');
			$el.attr('href', 'mailto:' + newval);
			$el.text('@　' + newval);
		});
	});
	api('geekypress_contact_phone', function(value) {
		value.bind(function(newval) {
			var $el = $('#contact .terminal-contact-phone');
			$el.attr('href', 'tel:' + newval.replace(/\s+/g, ''));
			$el.text('⌕　' + newval);
		});
	});
	bindText('geekypress_contact_location', '#contact .terminal-contact-location', function(newval) {
		$('#contact .terminal-contact-location').text('⌖　' + newval);
	});

	// ── CTA ──
	bindText('geekypress_cta_label', '.terminal-cta .terminal-label');
	api('geekypress_cta_title_prefix', updateCtaTitle);
	api('geekypress_cta_title_highlight', updateCtaTitle);
	api('geekypress_cta_title_suffix', updateCtaTitle);

	function updateCtaTitle() {
		var prefix = api('geekypress_cta_title_prefix') ? api('geekypress_cta_title_prefix').get() : 'Have a';
		var highlight = api('geekypress_cta_title_highlight') ? api('geekypress_cta_title_highlight').get() : 'WordPress';
		var suffix = api('geekypress_cta_title_suffix') ? api('geekypress_cta_title_suffix').get() : 'problem worth solving?';
		$('.terminal-cta .section-title').html(prefix + ' <mark>' + highlight + '</mark> ' + suffix);
	}

	bindText('geekypress_cta_description', '.terminal-cta .content-text');
	bindText('geekypress_cta_btn_text', '.terminal-cta .wp-block-button__link');
	api('geekypress_cta_btn_url', function(value) {
		value.bind(function(newval) {
			$('.terminal-cta .wp-block-button__link').attr('href', newval);
		});
	});

	// ── Footer ──
	bindHtml('geekypress_footer_copyright', '.terminal-site-footer .terminal-copyright');
	bindHtml('geekypress_footer_credit', '.terminal-site-footer .terminal-credit');

})(jQuery, wp.customize);

/**
 * Click-to-Edit Deep Linking in Preview Iframe
 * Clicking preview elements navigates and focuses the respective Customizer control or section.
 */
(function($, api) {
	'use strict';
	if (!api) return;

	function focusControl(controlId, sectionId) {
		// Send message to parent Customizer frame
		if (api.preview && api.preview.send) {
			api.preview.send('focus-control-for-setting', controlId);
		}
		// Also send focus section/control message via postMessage if standard
		window.parent.postMessage({
			type: 'geekypress-focus-control',
			controlId: controlId,
			sectionId: sectionId
		}, '*');
	}

	// Visual hover indicator for editable elements inside the previewer
	$('<style id="geekypress-preview-click-to-edit-css">' +
		'.gp-customizer-editable { position: relative; cursor: pointer !important; transition: outline .15s ease, outline-offset .15s ease; }' +
		'.gp-customizer-editable:hover { outline: 2px dashed #39ff88 !important; outline-offset: 4px; }' +
		'.gp-customizer-editable::after { content: "✎"; position: absolute; top: -10px; right: -10px; width: 20px; height: 20px; background: #39ff88; color: #04110a; border-radius: 50%; font-size: 11px; font-weight: bold; display: none; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.4); pointer-events: none; z-index: 9999; }' +
		'.gp-customizer-editable:hover::after { display: flex; }' +
	'</style>').appendTo('head');

	var mappings = [
		// Brand / Header
		{ selector: '.terminal-brand', control: 'geekypress_header_title', section: 'geekypress_header' },
		{ selector: '.terminal-header-cta', control: 'geekypress_header_cta_text', section: 'geekypress_header' },

		// Hero elements
		{ selector: '#home .hero-title', control: 'geekypress_hero_name', section: 'geekypress_hero_section' },
		{ selector: '#home .terminal-label', control: 'geekypress_hero_label', section: 'geekypress_hero_section' },
		{ selector: '#home .terminal-hero-desc', control: 'geekypress_hero_description', section: 'geekypress_hero_section' },
		{ selector: '#home .terminal-hero-btn1', control: 'geekypress_hero_btn1_text', section: 'geekypress_hero_section' },
		{ selector: '#home .terminal-hero-btn2', control: 'geekypress_hero_btn2_text', section: 'geekypress_hero_section' },
		{ selector: '#home .terminal-socials', control: 'geekypress_hero_socials', section: 'geekypress_hero_section' },
		{ selector: '#home .terminal-window', control: 'geekypress_hero_terminal_json', section: 'geekypress_hero_section' },
		{ selector: '#home .terminal-status', control: 'geekypress_hero_status_text', section: 'geekypress_hero_section' },

		// About elements
		{ selector: '#about .terminal-label', control: 'geekypress_about_label', section: 'geekypress_about_section' },
		{ selector: '#about .section-title', control: 'geekypress_about_heading', section: 'geekypress_about_section' },
		{ selector: '#about .terminal-about-p1', control: 'geekypress_about_p1', section: 'geekypress_about_section' },
		{ selector: '#about .terminal-about-p2', control: 'geekypress_about_p2', section: 'geekypress_about_section' },
		{ selector: '#about .terminal-about-p3', control: 'geekypress_about_p3', section: 'geekypress_about_section' },
		{ selector: '#about .terminal-signature', control: 'geekypress_about_signature', section: 'geekypress_about_section' },
		{ selector: '#about .terminal-stat-grid', control: 'geekypress_about_stats', section: 'geekypress_about_section' },

		// Projects elements
		{ selector: '#projects .section-title', control: 'geekypress_projects_title', section: 'geekypress_projects_section' },
		{ selector: '#projects .terminal-card-grid', control: 'geekypress_projects_items', section: 'geekypress_projects_section' },

		// Skills elements
		{ selector: '#skills .section-title', control: 'geekypress_skills_title', section: 'geekypress_skills_section' },
		{ selector: '#skills .terminal-skill-grid', control: 'geekypress_skills_items', section: 'geekypress_skills_section' },

		// Experience elements
		{ selector: '#experience .section-title', control: 'geekypress_experience_title', section: 'geekypress_experience_section' },
		{ selector: '#experience .terminal-timeline', control: 'geekypress_experience_items', section: 'geekypress_experience_section' },

		// Interests elements
		{ selector: '#interests .section-title', control: 'geekypress_interests_title', section: 'geekypress_interests_section' },
		{ selector: '#interests .terminal-list', control: 'geekypress_interests_items', section: 'geekypress_interests_section' },

		// Contact elements
		{ selector: '#contact .section-title', control: 'geekypress_contact_title', section: 'geekypress_contact_section' },
		{ selector: '#contact .terminal-contact', control: 'geekypress_contact_email', section: 'geekypress_contact_section' },

		// CTA elements
		{ selector: '.terminal-cta .section-title', control: 'geekypress_cta_title_prefix', section: 'geekypress_cta_section' },
		{ selector: '.terminal-cta .content-text', control: 'geekypress_cta_description', section: 'geekypress_cta_section' },
		{ selector: '.terminal-cta .wp-block-button__link', control: 'geekypress_cta_btn_text', section: 'geekypress_cta_section' },

		// Footer elements
		{ selector: '.terminal-site-footer .terminal-copyright', control: 'geekypress_footer_copyright', section: 'geekypress_footer_section' },
		{ selector: '.terminal-site-footer .terminal-credit', control: 'geekypress_footer_credit', section: 'geekypress_footer_section' }
	];

	$(document).ready(function() {
		mappings.forEach(function(item) {
			var $el = $(item.selector);
			if ($el.length) {
				$el.addClass('gp-customizer-editable');
				$el.attr('title', 'Click to edit in Customizer');
				$el.on('click', function(e) {
					// Prevent navigation if anchor or button
					if ($(e.target).is('a') || $(e.target).closest('a').length) {
						e.preventDefault();
					}
					e.stopPropagation();
					focusControl(item.control, item.section);
				});
			}
		});
	});

})(jQuery, wp.customize);
