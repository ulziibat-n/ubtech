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

$term_id      = get_queried_object_id();
$archive_type = 'grid';

if ( is_author() ) {
	$archive_type = 'list';
} elseif ( is_category() ) {
	$archive_type = 'list';
	if ( function_exists( 'get_field' ) && get_field( 'archive_image', 'category_' . $term_id ) ) {
		$archive_type = get_field( 'archive_image', 'category_' . $term_id );
	}
} elseif ( is_tag() ) {
	$archive_type = 'list';
}

get_header();
?>

	<div id="content">
		<section id="primary">
			<main id="main">

			<?php if ( have_posts() ) : ?>
				<?php
				if ( is_author() ) {
					get_template_part( 'template-parts/header/archive', 'author' );
				} elseif ( is_category() ) {
					get_template_part( 'template-parts/header/archive', 'category' );
				} elseif ( is_tag() ) {
					get_template_part( 'template-parts/header/archive', 'tag' );
				}
				?>

				<section class="w-full relative">
					<div class="container">
						<div class="<?php echo esc_attr( $archive_type ); ?>">
							<?php
							if ( 'grid' === $archive_type ) {
								get_template_part( 'template-parts/archive/archive', 'grid' );
							} else {
								get_template_part( 'template-parts/archive/archive', 'list' );
							}
							?>
						</div>
					</div>
				</section>

			<?php else : ?>

				<?php get_template_part( 'template-parts/archive/archive', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</section><!-- #primary -->
	</div><!-- #content -->

<?php
get_footer();
