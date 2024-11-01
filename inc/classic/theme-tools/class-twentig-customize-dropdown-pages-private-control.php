<?php
/**
 * Customize Dropdown Pages Private Control class.
 *
 * @package twentig
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Dropdown pages private control.
	 */
	class Twentig_Customize_Dropdown_Pages_Private_Control extends WP_Customize_Control {
		/**
		 * Type.
		 *
		 * @var string
		 */
		public $type = 'twentig-dropdown-pages-private';

		/**
		 * Render the content of the dropdown private pages control.
		 */
		public function render_content() {
			$input_id         = '_customize-input-' . $this->id;
			$description_id   = '_customize-description-' . $this->id;
			$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
			?>

			<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<?php
			$dropdown_name     = '_customize-dropdown-pages-' . $this->id;
			$show_option_none  = esc_html__( '&mdash; Select &mdash;' );
			$option_none_value = '0';
			$dropdown          = wp_dropdown_pages(
				array(
					'name'              => esc_attr( $dropdown_name ),
					'echo'              => 0,
					'show_option_none'  => esc_html( $show_option_none ),
					'option_none_value' => esc_attr( $option_none_value ),
					'selected'          => esc_attr( $this->value() ),
					'post_status'       => 'private',
				)
			);

			if ( empty( $dropdown ) ) {
				$dropdown  = sprintf( '<select id="%1$s" name="%1$s">', esc_attr( $dropdown_name ) );
				$dropdown .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $option_none_value ), esc_html( $show_option_none ) );
				$dropdown .= '</select>';
			}

			// Hackily add in the data link parameter.
			echo str_replace( '<select', '<select ' . $this->get_link() . ' id="' . esc_attr( $input_id ) . '" ' . $describedby_attr, $dropdown ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
			<?php
		}
	}
}
