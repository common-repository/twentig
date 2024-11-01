<?php
/**
 * Template Name: Cover Template for Page with Excerpt
 *
 * @package twentig
 */

get_header();
?>

<main id="site-content">

	<?php

	if ( have_posts() ) :

		while ( have_posts() ) :
			the_post();
			?>

			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<?php
			// On the cover page template, output the cover header.
			$cover_header_style   = '';
			$cover_header_classes = '';

			$color_overlay_style   = '';
			$color_overlay_classes = '';

			$image_url = ! post_password_required() ? get_the_post_thumbnail_url( get_the_ID(), 'twentytwenty-fullscreen' ) : '';

			if ( $image_url ) {
				$cover_header_style   = ' style="background-image: url( ' . esc_url( $image_url ) . ' );"';
				$cover_header_classes = ' bg-image';
			}

			// Get the color used for the color overlay.
			$color_overlay_color = get_theme_mod( 'cover_template_overlay_background_color' );
			if ( $color_overlay_color ) {
				$color_overlay_style = ' style="color: ' . esc_attr( $color_overlay_color ) . ';"';
			} else {
				$color_overlay_style = '';
			}

			// Get the fixed background attachment option.
			if ( get_theme_mod( 'cover_template_fixed_background', true ) ) {
				$cover_header_classes .= ' bg-attachment-fixed';
			}

			// Get the opacity of the color overlay.
			$color_overlay_opacity  = get_theme_mod( 'cover_template_overlay_opacity' );
			$color_overlay_opacity  = ( false === $color_overlay_opacity ) ? 80 : $color_overlay_opacity;
			$color_overlay_classes .= ' opacity-' . $color_overlay_opacity;

			?>

			<div class="cover-header <?php echo $cover_header_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>"<?php echo $cover_header_style; ?>>
				<div class="cover-header-inner-wrapper screen-height">
					<div class="cover-header-inner">
						<div class="cover-color-overlay color-accent<?php echo esc_attr( $color_overlay_classes ); ?>"<?php echo $color_overlay_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>

							<header class="entry-header has-text-align-center">
								<div class="entry-header-inner section-inner medium">

									<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

									<div class="intro-text section-inner max-percentage small">
										<?php the_excerpt(); ?>
									</div>

									<div class="to-the-content-wrapper">

										<a href="#post-inner" class="to-the-content fill-children-current-color">
											<?php twentytwenty_the_theme_svg( 'arrow-down' ); ?>
											<div class="screen-reader-text"><?php esc_html_e( 'Scroll Down', 'twentytwenty' ); ?></div>
										</a>

									</div>							

								</div><!-- .entry-header-inner -->
							</header><!-- .entry-header -->

					</div><!-- .cover-header-inner -->
				</div><!-- .cover-header-inner-wrapper -->
			</div><!-- .cover-header -->

			<div class="post-inner" id="post-inner">

				<div class="entry-content">

					<?php the_content(); ?>

				</div><!-- .entry-content -->

				<?php
				wp_link_pages(
					array(
						'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
						'after'       => '</nav>',
						'link_before' => '<span class="page-number">',
						'link_after'  => '</span>',
					)
				);

				edit_post_link();
				?>

			</div><!-- .post-inner -->

			<?php if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) { ?>

				<div class="comments-wrapper section-inner">

					<?php comments_template(); ?>

				</div><!-- .comments-wrapper -->

			<?php } ?>

		</article><!-- .post -->

			<?php
		endwhile;

	endif;

	?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
