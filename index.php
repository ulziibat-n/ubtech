<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$archive_type = 'grid';

get_header();
?>

	<div id="content">
		<section id="primary">
			<main id="main">

			<?php if ( have_posts() ) : ?>
				
				<?php if ( is_home() && ! is_paged() ) : ?>
					<section class="bg-slate-50">
						<div class="container pt-32">
							<p class="mb-4 text-xs font-medium tracking-widest uppercase text-slate-400">Улаанбаатар · <?php echo esc_html( gmdate( 'Y' ) ); ?></p>
							<h1 class="mb-6 text-4xl font-bold leading-none text-slate-900 sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl 2xl:text-9xl">
								Дизайн, код,<br>
								ба хиймэл оюун<span class="text-lime-500">.</span>
							</h1>
							<?php
							$ub_hero_desc = get_bloginfo( 'description', 'display' );
							if ( $ub_hero_desc ) :
								?>
								<p class="max-w-2xl text-xl leading-relaxed text-slate-600"><?php echo esc_html( $ub_hero_desc ); ?></p>
							<?php endif; ?>
						</div>
					</section>
				<?php endif; ?>

				<section class="relative w-full">
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
