/**
 * GeekyPress Customizer Controls Pane Script
 *
 * Listens to messages from the preview iframe and focuses/expands
 * the target control and section in the left pane.
 *
 * @package GeekyPress
 */
(function($, api) {
	'use strict';

	if (!api) return;

	api.bind('ready', function() {
		// Listen for postMessage from the preview frame
		window.addEventListener('message', function(event) {
			if (!event.data || event.data.type !== 'geekypress-focus-control') {
				return;
			}

			var controlId = event.data.controlId;
			var sectionId = event.data.sectionId;

			if (controlId && api.control.has(controlId)) {
				api.control(controlId).focus();
			} else if (sectionId && api.section.has(sectionId)) {
				api.section(sectionId).focus();
			}
		});

		// Also handle native preview.bind message if available
		if (api.previewer) {
			api.previewer.bind('focus-control-for-setting', function(settingId) {
				if (api.control.has(settingId)) {
					api.control(settingId).focus();
				}
			});
		}
	});

})(jQuery, wp.customize);
