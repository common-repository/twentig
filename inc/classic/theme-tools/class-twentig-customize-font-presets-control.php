<?php
/**
 * Customize Font Presets Control class.
 *
 * @package twentig
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Font presets control.
	 */
	class Twentig_Customize_Font_Presets_Control extends WP_Customize_Control {
		/**
		 * Type.
		 *
		 * @var string
		 */
		public $type = 'twentig-font-presets';

		/**
		 * Render the content of the font presets control.
		 */
		public function render_content() {
			$presets   = apply_filters( 'twentig_font_presets', array() );
			$imagepath = TWENTIG_ASSETS_URI . '/images/font-presets/';
			?>

			<h4 class="tw-customize-section-title"><?php esc_html_e( 'Presets', 'twentig' ); ?></h4>
			<p class="customize-control-description"><?php esc_html_e( 'Choosing a preset will override all the font settings.', 'twentig' ); ?></p>

			<div class="twentig-preset-panel">
				<h3 class="twentig-preset-panel-title">
					<button type="button" class="twentig-preset-panel-toggle" aria-expanded="false">
					<?php esc_html_e( 'View Presets', 'twentig' ); ?>
					<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
				</h3>
				<div class="twentig-preset-list tw-font-preset-<?php echo esc_attr( get_template() ); ?>">
					<?php foreach ( $presets as $index => $item ) { ?>
						<?php if ( isset( $item['image'] ) ) : ?>
							<div class="twentig-preset-item has-image" tabindex="0" role="button" aria-label="<?php echo esc_attr( $item['name'] ); ?>" data-value="<?php echo esc_attr( $item['name'] ); ?>">
								<img src="<?php echo esc_url( $imagepath . $item['image'] ); ?>" alt="<?php echo esc_html( $item['name'] ); ?>"/>
							</div>
						<?php else : ?>
							<div class="twentig-preset-item" tabindex="0" role="button" aria-label="<?php echo esc_attr( $item['name'] ); ?>" data-value="<?php echo esc_attr( $item['name'] ); ?>" style="background-position-y:-<?php echo esc_attr( $index * 78 ); ?>px">
								<div class="twentig-preset-item-image" style="background-position-y:-<?php echo esc_attr( $index * 78 ); ?>px"></div>
							</div>
						<?php endif; ?>
					<?php } ?>
				</div>
			</div>
			<?php
		}
	}
}
