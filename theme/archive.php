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

				<header class="container pt-16 pb-8">
					<?php the_archive_title( '<h1 class="text-4xl font-black text-fg-default sm:text-5xl">', '</h1>' ); ?>
					<?php the_archive_description( '<div class="mt-4 max-w-2xl text-fg-subtle">', '</div>' ); ?>
				</header>

				<div class="container pb-16">
					<div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/content', 'card' );
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
