<?php
/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( get_field( 'normal_page' ) ) :
		?>
		<div class="container py-16">
			<header>
				<div class="flex flex-col gap-8 pt-4 pb-20">
					<?php
					if ( ! is_front_page() ) {
						the_title( '<h1 class="max-w-lg text-4xl font-black text-slate-900 sm:text-6xl">', '</h1>' );
					} else {
						the_title( '<h2 class="max-w-lg text-4xl font-black text-slate-900 sm:text-6xl">', '</h2>' );
					}
					?>
				</div>
			</header>
			<div class="flex gap-24 justify-between">
				<div class="w-full xl:max-w-4xl">
					<div data-post-content class="w-full content-single">
						<?php
						the_content();
						?>
					</div>
				</div>
				<div class="hidden flex-col items-end w-full max-w-sm xl:flex">
					<div data-post-toc class="sticky top-24 invisible p-4 w-full bg-white rounded-md shadow-md opacity-0 transition-all duration-500 shadow-slate-200/20 xl:p-8">
						<h4 class="text-base font-bold leading-none sm:text-xl xl:text-sm"><?php echo esc_html__( 'Нийтлэлийн агуулга', 'ulziibat-tech' ); ?></h4>
						<ul data-post-toc-list class="p-0 mt-2">
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
	endif;
	?>
</article><!-- #post-<?php the_ID(); ?> -->
