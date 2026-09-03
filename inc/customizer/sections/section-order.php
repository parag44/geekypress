<?php
/**
 * Customizer: Section Order & Visibility
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_section_order_sec',
	array(
		'title'    => __( 'Section Order & Visibility', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 110,
	)
);

$wp_customize->add_setting(
	'geekypress_section_order',
	array(
		'default'           => wp_json_encode( geekypress_get_section_defaults() ),
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);

/**
 * Class GeekyPress_Section_Order_Control
 */
class GeekyPress_Section_Order_Control extends WP_Customize_Control {
	public $type = 'geekypress-section-order';

	public function render_content() {
		$value    = $this->value();
		$sections = json_decode( $value, true );
		if ( ! is_array( $sections ) || empty( $sections ) ) {
			$sections = geekypress_get_section_defaults();
		}

		$all_defaults  = geekypress_get_section_defaults();
		$default_names = array();
		foreach ( $all_defaults as $def ) {
			$default_names[ $def['slug'] ] = $def['label'];
		}
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
		</label>

		<textarea id="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?> style="display:none;"><?php echo esc_textarea( is_string( $value ) ? $value : wp_json_encode( $value ) ); ?></textarea>

		<ul id="geekypress-section-order-list" style="margin: 10px 0 0; padding: 0; list-style: none;">
			<?php
			foreach ( $sections as $section ) :
				$slug    = isset( $section['slug'] ) ? $section['slug'] : '';
				$enabled = isset( $section['enabled'] ) ? (bool) $section['enabled'] : false;
				$name    = isset( $default_names[ $slug ] ) ? $default_names[ $slug ] : ucfirst( $slug );
				?>
				<li class="gp-order-item" data-slug="<?php echo esc_attr( $slug ); ?>" draggable="true" style="background: #fff; border: 1px solid #dcdcde; border-radius: 4px; padding: 10px 12px; margin-bottom: 6px; cursor: grab; display: flex; justify-content: space-between; align-items: center; user-select: none;">
					<span style="display: flex; align-items: center; gap: 8px;">
						<span class="dashicons dashicons-menu" style="color: #8c8f94; font-size: 16px; width: 16px; height: 16px;"></span>
						<strong style="font-size: 13px; color: #1d2327;"><?php echo esc_html( $name ); ?></strong>
					</span>
					<label style="margin: 0; display: flex; align-items: center; cursor: pointer;">
						<input type="checkbox" class="gp-order-toggle" <?php checked( $enabled ); ?> style="margin: 0; cursor: pointer;">
					</label>
				</li>
			<?php endforeach; ?>
		</ul>

		<script>
		(function() {
			var list = document.getElementById('geekypress-section-order-list');
			var textarea = document.getElementById('<?php echo esc_attr( $this->id ); ?>');
			if (!list || !textarea) return;

			function updateValue() {
				var items = list.querySelectorAll('.gp-order-item');
				var data = [];
				items.forEach(function(item) {
					data.push({
						slug: item.getAttribute('data-slug'),
						enabled: item.querySelector('.gp-order-toggle').checked
					});
				});
				var json = JSON.stringify(data);
				textarea.value = json;
				textarea.dispatchEvent(new Event('change', { bubbles: true }));
				if (window.wp && wp.customize && wp.customize.has && wp.customize.has('geekypress_section_order')) {
					wp.customize('geekypress_section_order').set(json);
				}
			}

			list.addEventListener('change', function(e) {
				if (e.target.classList.contains('gp-order-toggle')) {
					updateValue();
				}
			});

			var dragSrcEl = null;

			function bindDrag(el) {
				el.addEventListener('dragstart', function(e) {
					dragSrcEl = this;
					e.dataTransfer.effectAllowed = 'move';
					this.style.opacity = '0.4';
				});
				el.addEventListener('dragover', function(e) {
					if (e.preventDefault) e.preventDefault();
					e.dataTransfer.dropEffect = 'move';
					this.style.borderColor = '#2271b1';
					return false;
				});
				el.addEventListener('dragleave', function() {
					this.style.borderColor = '#dcdcde';
				});
				el.addEventListener('drop', function(e) {
					if (e.stopPropagation) e.stopPropagation();
					this.style.borderColor = '#dcdcde';
					if (dragSrcEl && dragSrcEl !== this) {
						var items = Array.prototype.slice.call(list.children);
						var srcIdx = items.indexOf(dragSrcEl);
						var targetIdx = items.indexOf(this);
						if (srcIdx < targetIdx) {
							list.insertBefore(dragSrcEl, this.nextSibling);
						} else {
							list.insertBefore(dragSrcEl, this);
						}
						updateValue();
					}
					return false;
				});
				el.addEventListener('dragend', function() {
					this.style.opacity = '1';
					list.querySelectorAll('.gp-order-item').forEach(function(item) {
						item.style.borderColor = '#dcdcde';
					});
				});
			}

			list.querySelectorAll('.gp-order-item').forEach(bindDrag);
		})();
		</script>
		<?php
	}
}

$wp_customize->add_control(
	new GeekyPress_Section_Order_Control(
		$wp_customize,
		'geekypress_section_order',
		array(
			'label'       => __( 'Drag to Reorder Homepage Sections', 'geekypress' ),
			'description' => __( 'Reorder sections or toggle checkboxes to show/hide them.', 'geekypress' ),
			'section'     => 'geekypress_section_order_sec',
		)
	)
);
