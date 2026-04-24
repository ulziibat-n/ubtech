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

get_header();

$ub_is_home_first = is_home() && ! is_paged();
?>

<?php if ( $ub_is_home_first ) : ?>
<section class="bg-slate-50">
	<div class="container pt-[88px] pb-14">
		<p class="t-meta text-slate-400 mb-[18px]">Улаанбаатар · <?php echo esc_html( gmdate( 'Y' ) ); ?></p>
		<h1 class="t-display text-slate-900 max-w-[900px] mb-6">
			Дизайн, код,&amp;<br>
			хиймэл оюун<span class="text-lime-500">.</span>
		</h1>
		<?php
		$ub_hero_desc = get_bloginfo( 'description', 'display' );
		if ( $ub_hero_desc ) :
			?>
		<p class="t-lead text-slate-600 max-w-2xl mb-[28px]"><?php echo esc_html( $ub_hero_desc ); ?></p>
		<?php endif; ?>
		<div class="flex flex-wrap gap-[10px]">
			<a class="ds-btn ds-btn-primary" href="#posts">
				<?php esc_html_e( 'Сүүлийн нийтлэл', 'ulziibat-tech' ); ?>
				<?php ub_icon_arrow(); ?>
			</a>
			<?php
			$ub_about_page = get_page_by_path( 'about' );
			if ( $ub_about_page ) :
				?>
			<a class="ds-btn ds-btn-brand" href="<?php echo esc_url( get_permalink( $ub_about_page->ID ) ); ?>">
				<?php esc_html_e( 'Миний тухай', 'ulziibat-tech' ); ?>
			</a>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section id="posts" class="bg-slate-50">
	<div class="container pt-6 pb-[72px]">

		<?php if ( have_posts() ) : ?>

			<?php if ( $ub_is_home_first ) : ?>
			<div class="flex items-baseline justify-between mb-[22px]">
				<h2 class="t-h2 text-slate-900"><?php esc_html_e( 'Сүүлийн нийтлэл', 'ulziibat-tech' ); ?></h2>
			</div>
			<?php elseif ( is_home() && ! is_front_page() ) : ?>
			<header class="mb-8">
				<h1 class="t-h1 text-slate-900"><?php single_post_title(); ?></h1>
			</header>
			<?php endif; ?>

			<?php
			// Collect all posts from the main query, then render in two clean grids.
			global $post;
			$ub_posts = array();
			while ( have_posts() ) {
				the_post();
				$ub_posts[] = $post;
			}
			$ub_row1 = array_slice( $ub_posts, 0, 3 );
			$ub_row2 = array_slice( $ub_posts, 3 );
			?>

			<?php if ( ! empty( $ub_row1 ) ) : ?>
			<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr]">
				<?php
				foreach ( $ub_row1 as $ub_row_key => $post ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $post );
					get_template_part(
						'template-parts/content/content',
						'card',
						array(
							'featured'      => ( 0 === $ub_row_key && $ub_is_home_first ),
							'heading_level' => 3,
						)
					);
				endforeach;
				?>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $ub_row2 ) ) : ?>
			<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mt-5">
				<?php
				foreach ( $ub_row2 as $post ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $post );
					get_template_part(
						'template-parts/content/content',
						'card',
						array( 'heading_level' => 3 )
					);
				endforeach;
				wp_reset_postdata();
				?>
			</div>
			<?php endif; ?>

			<?php ub_the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
