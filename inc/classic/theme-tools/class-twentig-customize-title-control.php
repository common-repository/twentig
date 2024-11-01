<?php
/**
 * Customize Section Title Control class.
 *
 * @package twentig
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Title control.
	 */
	class Twentig_Customize_Title_Control extends WP_Customize_Control {
		/**
		 * Type.
		 *
		 * @var string
		 */
		public $type = 'section-title';

		/**
		 * Render a JS template for the content of the section title control.
		 */
		public function content_template() { ?>
				<# if ( data.label ) { #>
					<h4 class="tw-customize-section-title">{{{ data.label }}}</h4>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			<?php
		}
	}
}
