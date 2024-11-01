<?php
/**
 * Customize Starter Control class.
 *
 * @package twentig
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Starter control.
	 */
	class Twentig_Customize_Starter_Control extends WP_Customize_Control {
		/**
		 * Type.
		 *
		 * @var string
		 */
		public $type = 'starter';

		/**
		 * Render the content of the starter control.
		 */
		public function render_content() {
			$starters = twentig_get_starter_library();
			?>
			<p class="twentig-customizer-starter-description">
			<?php
				printf(
					/* translators: link to external demos site */
					__( 'Choose a starting point to set up your site. <br><a href="%1$s" %2$s>Preview demos</a>', 'twentig' ),
					'https://twentig.com/starter-sites/#previous-themes',
					'class="external-link" target="_blank" rel="noopener noreferrer"'
				);
			?>
			</p>

			<label for="twentig-customize-starter-content"><?php esc_html_e( 'Starter Website', 'twentig' ); ?></label>
			<select id="twentig-customize-starter-content">
				<option value=""><?php esc_html_e( '&mdash; Select &mdash;', 'twentig' ); ?></option>
				<?php foreach ( $starters as $starter ) : ?>
					<option value="<?php echo esc_attr( $starter['id'] ); ?>" data-screenshot="<?php echo esc_url( $starter['screenshot'] ); ?>"><?php echo esc_html( $starter['title'] ); ?></option>
				<?php endforeach; ?>
			</select>

			<label for="twentig-customize-starter-import-type"><?php esc_html_e( 'Import Type', 'twentig' ); ?>
				<button id="twentig-customize-starter-help" type="button" class="dashicons dashicons-editor-help">
					<span class="screen-reader-text">Help</span>
				</button>
			</label>
			<select id="twentig-customize-starter-import-type">
				<option value="all"><?php esc_html_e( 'All', 'twentig' ); ?></option>
				<option value="content"><?php esc_html_e( 'Content (pages, posts, menus, widgets)', 'twentig' ); ?></option>
				<option value="pages"><?php esc_html_e( 'Pages', 'twentig' ); ?></option>
				<option value="style"><?php esc_html_e( 'Customizer style', 'twentig' ); ?></option>
			</select>

			<button id="twentig-customize-starter-button" type="button" class="button"><?php esc_html_e( 'Load', 'twentig' ); ?></button>

			<div id="twentig-customize-starter-screenshot"></div>

			<p class="twentig-customize-starter-terms hidden">
			<?php
				printf(
					/* translators: links to Unsplash site */
					__( 'The photos are provided by Unsplash. By loading a starter website, you are agreeing to Unsplash’s <a href="%1$s" %2$s>Terms</a> and <a href="%3$s" %4$s>Privacy Policy</a>.', 'twentig' ),
					'https://unsplash.com/terms',
					'target="_blank" rel="noopener noreferrer"',
					'https://unsplash.com/privacy',
					'target="_blank" rel="noopener noreferrer"'
				);
			?>
			</p>

			<?php
		}
	}
}
