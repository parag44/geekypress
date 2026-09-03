<?php
/**
 * GeekyPress Repeater Control
 *
 * A robust, drag-sortable repeater control for the native WordPress Customizer.
 * Supports add, duplicate, delete, collapse, drag-reorder, and media uploads.
 * Emits change events that trigger postMessage live preview updates.
 *
 * @package GeekyPress
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * Class GeekyPress_Repeater_Control
 */
class GeekyPress_Repeater_Control extends WP_Customize_Control {

	/**
	 * Control type identifier.
	 *
	 * @var string
	 */
	public $type = 'geekypress-repeater';

	/**
	 * Field definitions for each repeater item.
	 * Each field: array( 'key' => '', 'label' => '', 'type' => 'text|url|textarea|select|checkbox|image', 'choices' => [], 'default' => '' )
	 *
	 * @var array
	 */
	public $fields = array();

	/**
	 * Field key whose value is shown as the item's primary label when collapsed.
	 *
	 * @var string
	 */
	public $item_label_key = 'title';

	/**
	 * Field key whose value is shown as the item's secondary subtitle when collapsed.
	 *
	 * @var string
	 */
	public $item_subtitle_key = '';

	/**
	 * Label for the "Add Item" button.
	 *
	 * @var string
	 */
	public $add_item_label = 'Add Item';

	/**
	 * Pass extra data to JS.
	 */
	public function to_json() {
		parent::to_json();
		$this->json['fields']          = $this->fields;
		$this->json['itemLabelKey']    = $this->item_label_key;
		$this->json['itemSubtitleKey'] = $this->item_subtitle_key;
		$this->json['addItemLabel']    = $this->add_item_label;
	}

	/**
	 * Render the full repeater control HTML and inline JS.
	 */
	public function render_content() {
		$setting_value = $this->value();
		$items         = array();

		if ( ! empty( $setting_value ) ) {
			if ( is_array( $setting_value ) ) {
				$items = $setting_value;
			} else {
				$decoded = json_decode( $setting_value, true );
				if ( is_array( $decoded ) ) {
					$items = $decoded;
				}
			}
		}

		$control_id   = 'gp-repeater-' . esc_attr( preg_replace( '/[^a-z0-9_-]/i', '-', $this->id ) );
		$setting_link = $this->get_link();
		$fields_json  = wp_json_encode( $this->fields );
		$items_json   = wp_json_encode( $items );
		$setting_id   = wp_json_encode( $this->settings['default']->id );
		?>
		<div class="gp-repeater-control" id="<?php echo esc_attr( $control_id ); ?>">
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title gp-repeater-label"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<textarea class="gp-repeater-value" style="display:none;" <?php echo $setting_link; ?>><?php echo esc_textarea( is_string( $setting_value ) ? $setting_value : wp_json_encode( $setting_value ) ); ?></textarea>

			<div class="gp-repeater-list" role="list"></div>

			<button type="button" class="gp-repeater-add button button-secondary">
				<span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span>
				<?php echo esc_html( $this->add_item_label ); ?>
			</button>
		</div>

		<style>
		.gp-repeater-control { margin-top: 10px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
		.gp-repeater-label { display: block; margin-bottom: 6px; font-weight: 600; color: #1e1e1e; }
		.gp-repeater-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px; min-height: 4px; }
		.gp-repeater-item { background: #fff; border: 1px solid #dcdcde; border-radius: 4px; overflow: hidden; transition: border-color .15s, box-shadow .15s; }
		.gp-repeater-item:hover { border-color: #2271b1; }
		.gp-repeater-item.gp-drag-over { border-color: #39ff88; box-shadow: 0 0 0 2px rgba(57,255,136,.4); }
		.gp-repeater-item.gp-dragging { opacity: .35; }
		.gp-item-header { display: flex; align-items: center; gap: 8px; padding: 8px 10px; background: #f6f7f7; cursor: pointer; user-select: none; min-height: 40px; border-bottom: 1px solid transparent; }
		.gp-repeater-item.is-expanded .gp-item-header { border-bottom-color: #dcdcde; background: #f0f0f1; }
		.gp-drag-handle { cursor: grab; color: #8c8f94; flex-shrink: 0; display: flex; align-items: center; padding: 2px; }
		.gp-drag-handle:hover { color: #2271b1; }
		.gp-item-titles { flex: 1; min-width: 0; overflow: hidden; }
		.gp-item-primary { font-size: 13px; font-weight: 600; color: #1d2327; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
		.gp-item-subtitle { font-size: 11px; color: #646970; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; margin-top: 1px; }
		.gp-item-actions { display: flex; gap: 4px; flex-shrink: 0; align-items: center; }
		.gp-item-actions button { background: none; border: none; cursor: pointer; padding: 4px; border-radius: 3px; color: #646970; display: flex; align-items: center; line-height: 1; }
		.gp-item-actions button:hover { background: #dcdcde; color: #1d2327; }
		.gp-item-actions .gp-btn-delete:hover { background: #fcf0f1; color: #d63638; }
		.gp-item-actions .dashicons { font-size: 15px; width: 15px; height: 15px; }
		.gp-item-body { display: none; padding: 12px; background: #fff; }
		.gp-repeater-item.is-expanded .gp-item-body { display: block; }
		.gp-field-row { margin-bottom: 12px; }
		.gp-field-row:last-child { margin-bottom: 0; }
		.gp-field-label { display: block; font-size: 11px; font-weight: 600; color: #50575e; margin-bottom: 4px; text-transform: uppercase; letter-spacing: .03em; }
		.gp-field-row input[type=text], .gp-field-row input[type=url], .gp-field-row textarea, .gp-field-row select { width: 100%; box-sizing: border-box; border: 1px solid #8c8f94; border-radius: 4px; padding: 6px 8px; font-size: 12px; line-height: 1.4; background: #fff; color: #2c3338; }
		.gp-field-row input:focus, .gp-field-row textarea:focus, .gp-field-row select:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; outline: none; }
		.gp-field-row textarea { min-height: 64px; resize: vertical; }
		.gp-checkbox-row { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
		.gp-checkbox-row label { font-size: 12px; color: #2c3338; cursor: pointer; }
		.gp-image-preview { margin-top: 6px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
		.gp-image-preview img { width: 44px; height: 44px; object-fit: cover; border-radius: 4px; border: 1px solid #dcdcde; display: none; }
		.gp-image-preview img.gp-has-image { display: block; }
		.gp-btn-remove-image { display: none !important; }
		.gp-btn-remove-image.gp-has-image { display: inline-flex !important; }
		.gp-repeater-add { width: 100%; justify-content: center; display: flex; align-items: center; gap: 6px; padding: 8px 12px; font-size: 13px; border-radius: 4px; border: 1px dashed #2271b1; background: #f0f6fc; color: #2271b1; cursor: pointer; font-weight: 500; }
		.gp-repeater-add:hover { background: #e5f0fa; color: #135e96; border-color: #135e96; }

		/* Icon Picker UI */
		.gp-icon-picker-wrap { margin-top: 4px; }
		.gp-icon-picker-toggle { display: flex; align-items: center; gap: 8px; width: 100%; padding: 6px 10px; background: #f6f7f7; border: 1px solid #8c8f94; border-radius: 4px; cursor: pointer; text-align: left; box-sizing: border-box; }
		.gp-icon-picker-toggle:hover { border-color: #2271b1; background: #f0f0f1; }
		.gp-icon-preview { display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; background: #050d14; border: 1px solid #39ff88; border-radius: 3px; color: #39ff88; flex-shrink: 0; }
		.gp-icon-preview .dashicons { font-size: 18px; width: 18px; height: 18px; color: #39ff88; line-height: 1; }
		.gp-icon-name { flex: 1; font-family: monospace; font-size: 12px; color: #1d2327; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
		.gp-icon-toggle-arrow { margin-left: auto; color: #646970; }
		.gp-icon-dropdown { display: none; margin-top: 6px; padding: 8px; background: #fff; border: 1px solid #dcdcde; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,.1); max-height: 220px; overflow-y: auto; }
		.gp-icon-dropdown.is-open { display: block; }
		.gp-icon-search { width: 100% !important; margin-bottom: 8px !important; padding: 5px 8px !important; font-size: 11px !important; border: 1px solid #8c8f94 !important; border-radius: 3px !important; }
		.gp-icon-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 4px; }
		.gp-icon-btn { display: flex; align-items: center; justify-content: center; height: 32px; background: #f6f7f7; border: 1px solid #dcdcde; border-radius: 3px; cursor: pointer; color: #2c3338; transition: all .1s ease; }
		.gp-icon-btn:hover, .gp-icon-btn.is-selected { background: #050d14; color: #39ff88; border-color: #39ff88; }
		.gp-icon-btn .dashicons { font-size: 18px; width: 18px; height: 18px; line-height: 1; pointer-events: none; }
		</style>

		<script>
		(function(){
			'use strict';
			var controlId    = <?php echo wp_json_encode( $control_id ); ?>;
			var fields       = <?php echo $fields_json; ?>;
			var itemLabelKey = <?php echo wp_json_encode( $this->item_label_key ); ?>;
			var itemSubKey   = <?php echo wp_json_encode( $this->item_subtitle_key ); ?>;
			var initialItems = <?php echo $items_json; ?>;
			var settingId    = <?php echo $setting_id; ?>;
			var dragSrcEl    = null;

			function esc(str) {
				var d = document.createElement('div');
				d.appendChild(document.createTextNode(String(str || '')));
				return d.innerHTML;
			}
			function getContainer() { return document.getElementById(controlId); }
			function getList() { return getContainer() ? getContainer().querySelector('.gp-repeater-list') : null; }
			function getTextarea() { return getContainer() ? getContainer().querySelector('.gp-repeater-value') : null; }

			function getItemData(itemEl) {
				var data = {};
				fields.forEach(function(f) {
					if (f.type === 'checkbox') {
						var cb = itemEl.querySelector('[data-key="' + f.key + '"]');
						data[f.key] = cb && cb.checked ? '1' : '';
					} else if (f.type === 'image') {
						var hi = itemEl.querySelector('input[type="hidden"][data-key="' + f.key + '"]');
						data[f.key] = hi ? hi.value : '';
					} else {
						var el = itemEl.querySelector('[data-key="' + f.key + '"]');
						data[f.key] = el ? el.value : '';
					}
				});
				return data;
			}

			function serializeAll() {
				var list = getList();
				if (!list) return;
				var items = [];
				list.querySelectorAll('.gp-repeater-item').forEach(function(el) {
					items.push(getItemData(el));
				});
				var json = JSON.stringify(items);
				var textarea = getTextarea();
				if (textarea) {
					textarea.value = json;
					textarea.dispatchEvent(new Event('change', { bubbles: true }));
				}
				if (window.wp && wp.customize && wp.customize.has && wp.customize.has(settingId)) {
					wp.customize(settingId).set(json);
				}
			}

			function updateHeader(itemEl) {
				var data = getItemData(itemEl);
				var primary = itemEl.querySelector('.gp-item-primary');
				var sub = itemEl.querySelector('.gp-item-subtitle');
				if (primary) primary.textContent = data[itemLabelKey] || '(Item)';
				if (sub) sub.textContent = itemSubKey ? (data[itemSubKey] || '') : '';
			}

			var COMMON_DASHICONS = [
				'dashicons-admin-tools', 'dashicons-admin-site', 'dashicons-admin-site-alt3',
				'dashicons-wordpress', 'dashicons-wordpress-alt', 'dashicons-editor-code',
				'dashicons-desktop', 'dashicons-laptop', 'dashicons-smartphone', 'dashicons-tablet',
				'dashicons-database', 'dashicons-rest-api', 'dashicons-cloud', 'dashicons-networking',
				'dashicons-shield', 'dashicons-shield-alt', 'dashicons-lock', 'dashicons-unlock',
				'dashicons-portfolio', 'dashicons-clock', 'dashicons-calendar', 'dashicons-performance',
				'dashicons-chart-bar', 'dashicons-chart-line', 'dashicons-analytics', 'dashicons-visibility',
				'dashicons-groups', 'dashicons-buddicons-community', 'dashicons-sos', 'dashicons-tickets-alt',
				'dashicons-randomize', 'dashicons-flag', 'dashicons-star-filled', 'dashicons-heart',
				'dashicons-yes', 'dashicons-yes-alt', 'dashicons-marker', 'dashicons-location',
				'dashicons-email', 'dashicons-email-alt', 'dashicons-share', 'dashicons-external',
				'dashicons-media-code', 'dashicons-media-document', 'dashicons-format-aside', 'dashicons-format-status',
				'dashicons-layout', 'dashicons-welcome-widgets-menus', 'dashicons-category', 'dashicons-tag',
				'dashicons-superhero', 'dashicons-superhero-alt', 'dashicons-awards', 'dashicons-lightbulb',
				'dashicons-coffee', 'dashicons-beer', 'dashicons-art', 'dashicons-camera'
			];

			function renderField(f, value) {
				var uid = 'gp-' + f.key + '-' + Math.random().toString(36).substr(2, 6);
				if (f.type === 'checkbox') {
					return '<div class="gp-checkbox-row">'
						+ '<input type="checkbox" data-key="' + esc(f.key) + '" id="' + uid + '"' + (value === '1' || value === true || value === 1 ? ' checked' : '') + ' />'
						+ '<label for="' + uid + '">' + esc(f.label) + '</label>'
						+ '</div>';
				}
				var html = '<div class="gp-field-row">';
				html += '<label class="gp-field-label">' + esc(f.label) + '</label>';
				if (f.type === 'textarea') {
					html += '<textarea data-key="' + esc(f.key) + '" rows="3">' + esc(value || '') + '</textarea>';
				} else if (f.type === 'select') {
					html += '<select data-key="' + esc(f.key) + '">';
					if (f.choices) {
						Object.keys(f.choices).forEach(function(k) {
							html += '<option value="' + esc(k) + '"' + (String(k) === String(value) ? ' selected' : '') + '>' + esc(f.choices[k]) + '</option>';
						});
					}
					html += '</select>';
				} else if (f.type === 'icon') {
					var currentIcon = value || f.default || 'dashicons-admin-tools';
					html += '<div class="gp-icon-picker-wrap">';
					html += '<input type="hidden" data-key="' + esc(f.key) + '" value="' + esc(currentIcon) + '" />';
					html += '<button type="button" class="gp-icon-picker-toggle">';
					html += '<span class="gp-icon-preview"><span class="dashicons ' + esc(currentIcon) + '"></span></span>';
					html += '<span class="gp-icon-name">' + esc(currentIcon) + '</span>';
					html += '<span class="gp-icon-toggle-arrow dashicons dashicons-arrow-down-alt2"></span>';
					html += '</button>';
					html += '<div class="gp-icon-dropdown">';
					html += '<input type="text" class="gp-icon-search" placeholder="Search icons (e.g. code, tool, shield)..." />';
					html += '<div class="gp-icon-grid">';
					COMMON_DASHICONS.forEach(function(ic) {
						var isSel = (ic === currentIcon) ? ' is-selected' : '';
						html += '<button type="button" class="gp-icon-btn' + isSel + '" data-icon="' + esc(ic) + '" title="' + esc(ic) + '">';
						html += '<span class="dashicons ' + esc(ic) + '"></span>';
						html += '</button>';
					});
					html += '</div>';
					html += '</div>';
					html += '</div>';
				} else if (f.type === 'image') {
					var hasImg = !!(value && value.length > 0);
					html += '<input type="hidden" data-key="' + esc(f.key) + '" value="' + esc(value || '') + '" />';
					html += '<div class="gp-image-preview">';
					html += '<img src="' + esc(value || '') + '" class="' + (hasImg ? 'gp-has-image' : '') + '" alt="" />';
					html += '<button type="button" class="button button-small gp-btn-select-image">Select Image</button>';
					html += '<button type="button" class="button button-small gp-btn-remove-image' + (hasImg ? ' gp-has-image' : '') + '">Remove</button>';
					html += '</div>';
				} else {
					html += '<input type="' + (f.type === 'url' ? 'url' : 'text') + '" data-key="' + esc(f.key) + '" value="' + esc(value || '') + '" />';
				}
				html += '</div>';
				return html;
			}

			function buildItemEl(data) {
				data = data || {};
				var item = document.createElement('div');
				item.className = 'gp-repeater-item';
				item.setAttribute('draggable', 'true');
				item.setAttribute('role', 'listitem');

				var primaryText = data[itemLabelKey] || '(Item)';
				var subText = itemSubKey ? (data[itemSubKey] || '') : '';

				var header = document.createElement('div');
				header.className = 'gp-item-header';
				header.innerHTML = '<span class="gp-drag-handle" title="Drag to reorder"><span class="dashicons dashicons-menu"></span></span>'
					+ '<div class="gp-item-titles">'
					+ '<span class="gp-item-primary">' + esc(primaryText) + '</span>'
					+ (subText ? '<span class="gp-item-subtitle">' + esc(subText) + '</span>' : '<span class="gp-item-subtitle"></span>')
					+ '</div>'
					+ '<div class="gp-item-actions">'
					+ '<button type="button" class="gp-btn-duplicate" title="Duplicate"><span class="dashicons dashicons-admin-page"></span></button>'
					+ '<button type="button" class="gp-btn-delete" title="Delete"><span class="dashicons dashicons-trash"></span></button>'
					+ '<button type="button" class="gp-btn-toggle" title="Expand/Collapse"><span class="dashicons dashicons-arrow-down-alt2"></span></button>'
					+ '</div>';

				var body = document.createElement('div');
				body.className = 'gp-item-body';
				var fieldsHtml = '';
				fields.forEach(function(f) {
					var val = (data[f.key] !== undefined) ? data[f.key] : (f.default || '');
					fieldsHtml += renderField(f, val);
				});
				body.innerHTML = fieldsHtml;

				item.appendChild(header);
				item.appendChild(body);

				header.addEventListener('click', function(e) {
					if (e.target.closest('.gp-drag-handle') || e.target.closest('.gp-item-actions button')) return;
					item.classList.toggle('is-expanded');
				});

				header.querySelector('.gp-btn-toggle').addEventListener('click', function(e) {
					e.stopPropagation();
					item.classList.toggle('is-expanded');
				});

				header.querySelector('.gp-btn-delete').addEventListener('click', function(e) {
					e.stopPropagation();
					if (confirm('Delete this item?')) {
						item.remove();
						serializeAll();
					}
				});

				header.querySelector('.gp-btn-duplicate').addEventListener('click', function(e) {
					e.stopPropagation();
					var currentData = getItemData(item);
					var copy = buildItemEl(currentData);
					item.parentNode.insertBefore(copy, item.nextSibling);
					serializeAll();
				});

				body.addEventListener('input', function(e) {
					updateHeader(item);
					serializeAll();
				});
				body.addEventListener('change', function(e) {
					updateHeader(item);
					serializeAll();
				});

				body.querySelectorAll('.gp-btn-select-image').forEach(function(btn) {
					btn.addEventListener('click', function(e) {
						e.preventDefault();
						var fieldRow = btn.closest('.gp-field-row');
						var hidden = fieldRow.querySelector('input[type="hidden"]');
						var img = fieldRow.querySelector('img');
						var removeBtn = fieldRow.querySelector('.gp-btn-remove-image');

						var frame = wp.media({
							title: 'Select Image',
							button: { text: 'Use this image' },
							multiple: false
						});

						frame.on('select', function() {
							var attachment = frame.state().get('selection').first().toJSON();
							hidden.value = attachment.url;
							img.src = attachment.url;
							img.classList.add('gp-has-image');
							removeBtn.classList.add('gp-has-image');
							updateHeader(item);
							serializeAll();
						});

						frame.open();
					});
				});

				body.querySelectorAll('.gp-btn-remove-image').forEach(function(btn) {
					btn.addEventListener('click', function(e) {
						e.preventDefault();
						var fieldRow = btn.closest('.gp-field-row');
						var hidden = fieldRow.querySelector('input[type="hidden"]');
						var img = fieldRow.querySelector('img');
						hidden.value = '';
						img.src = '';
						img.classList.remove('gp-has-image');
						btn.classList.remove('gp-has-image');
						updateHeader(item);
						serializeAll();
					});
				});

				// Icon picker toggle, search, and selection
				body.querySelectorAll('.gp-icon-picker-wrap').forEach(function(wrap) {
					var toggle = wrap.querySelector('.gp-icon-picker-toggle');
					var dropdown = wrap.querySelector('.gp-icon-dropdown');
					var search = wrap.querySelector('.gp-icon-search');
					var hidden = wrap.querySelector('input[type="hidden"]');
					var previewIcon = wrap.querySelector('.gp-icon-preview .dashicons');
					var nameLabel = wrap.querySelector('.gp-icon-name');
					var iconButtons = wrap.querySelectorAll('.gp-icon-btn');

					if (toggle && dropdown) {
						toggle.addEventListener('click', function(e) {
							e.preventDefault();
							e.stopPropagation();
							var isOpen = dropdown.classList.contains('is-open');
							// Close all open dropdowns first
							document.querySelectorAll('.gp-icon-dropdown.is-open').forEach(function(d) {
								if (d !== dropdown) d.classList.remove('is-open');
							});
							dropdown.classList.toggle('is-open', !isOpen);
							if (!isOpen && search) {
								search.focus();
							}
						});
					}

					if (search) {
						search.addEventListener('input', function(e) {
							var query = (e.target.value || '').toLowerCase().trim();
							iconButtons.forEach(function(btn) {
								var ic = (btn.getAttribute('data-icon') || '').toLowerCase();
								btn.style.display = (!query || ic.indexOf(query) !== -1) ? '' : 'none';
							});
						});
					}

					iconButtons.forEach(function(btn) {
						btn.addEventListener('click', function(e) {
							e.preventDefault();
							e.stopPropagation();
							var selectedIcon = btn.getAttribute('data-icon');
							if (hidden) hidden.value = selectedIcon;
							if (nameLabel) nameLabel.textContent = selectedIcon;
							if (previewIcon) {
								previewIcon.className = 'dashicons ' + selectedIcon;
							}
							iconButtons.forEach(function(b) {
								b.classList.toggle('is-selected', b === btn);
							});
							if (dropdown) dropdown.classList.remove('is-open');
							updateHeader(item);
							serializeAll();
						});
					});
				});

				item.addEventListener('dragstart', function(e) {
					dragSrcEl = item;
					e.dataTransfer.effectAllowed = 'move';
					e.dataTransfer.setData('text/plain', '');
					item.classList.add('gp-dragging');
				});
				item.addEventListener('dragover', function(e) {
					if (e.preventDefault) e.preventDefault();
					e.dataTransfer.dropEffect = 'move';
					item.classList.add('gp-drag-over');
					return false;
				});
				item.addEventListener('dragleave', function() {
					item.classList.remove('gp-drag-over');
				});
				item.addEventListener('drop', function(e) {
					if (e.stopPropagation) e.stopPropagation();
					item.classList.remove('gp-drag-over');
					if (dragSrcEl && dragSrcEl !== item) {
						var list = getList();
						var items = Array.prototype.slice.call(list.children);
						var srcIdx = items.indexOf(dragSrcEl);
						var targetIdx = items.indexOf(item);
						if (srcIdx < targetIdx) {
							list.insertBefore(dragSrcEl, item.nextSibling);
						} else {
							list.insertBefore(dragSrcEl, item);
						}
						serializeAll();
					}
					return false;
				});
				item.addEventListener('dragend', function() {
					item.classList.remove('gp-dragging');
					getList().querySelectorAll('.gp-repeater-item').forEach(function(el) {
						el.classList.remove('gp-drag-over');
					});
				});

				return item;
			}

			function init() {
				var container = getContainer();
				if (!container) return;
				var list = getList();
				var addBtn = container.querySelector('.gp-repeater-add');

				if (Array.isArray(initialItems)) {
					initialItems.forEach(function(itemData) {
						list.appendChild(buildItemEl(itemData));
					});
				}

				addBtn.addEventListener('click', function() {
					var defaults = {};
					fields.forEach(function(f) {
						defaults[f.key] = f.default || '';
					});
					var newItem = buildItemEl(defaults);
					newItem.classList.add('is-expanded');
					list.appendChild(newItem);
					serializeAll();
				});
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', init);
			} else {
				init();
			}
		})();
		</script>
		<?php
	}
}
