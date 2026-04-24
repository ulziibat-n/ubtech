<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<div id="content">
		<section id="primary">
			<main id="main">

			<?php if ( have_posts() ) : ?>
				<?php
				if ( is_author() ) {
					get_template_part( 'template-parts/content/header/archive', 'author' );
				} elseif ( is_category() ) {
					get_template_part( 'template-parts/content/header/archive', 'category' );
				} elseif ( is_tag() ) {
					get_template_part( 'template-parts/content/header/archive', 'tag' );
				}
				?>

				<div class="container">
					<div class="grid grid-cols-1 gap-2 sm:grid-cols-3 lg:grid-cols-4">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/card', 'archive' );
						endwhile;
						?>
					</div>

					<?php ub_the_posts_navigation(); ?>
				</div>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</section><!-- #primary -->
	</div><!-- #content -->

<?php
get_footer();
