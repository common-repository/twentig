<?php
/**
 * Template Name: Twentig - No header, no footer
 *
 * @package twentig
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<main id="site-content">

		<?php

		if ( have_posts() ) :

			while ( have_posts() ) :
				the_post();
				?>

				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class="post-inner">

						<div class="entry-content">

							<?php the_content(); ?>

						</div><!-- .entry-content -->

					</div><!-- .post-inner -->

					<?php do_action( 'twentig_article_end' ); ?>
				</article><!-- .post -->

				<?php
			endwhile;

		endif;

		?>

	</main><!-- #site-content -->

	<?php wp_footer(); ?>

	</body>
</html>
