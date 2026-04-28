<?php
/**
 * Template part for displaying a default archive header.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

?>

<header class="overflow-hidden relative pt-16 w-full">
	<div class="container">
		<div class="flex flex-col items-start">
			<span class="text-[0.75rem] pl-0.5 leading-none uppercase font-semibold text-lime-600"><?php esc_html_e( 'Архив', 'ulziibat-tech' ); ?></span>
			<?php the_archive_title( '<h1 class="max-w-7xl text-2xl font-black leading-none sm:text-3xl lg:text-5xl xl:text-6xl">', '</h1>' ); ?>
		</div>
		<?php if ( get_the_archive_description() ) : ?>
			<div class="py-2 mt-4 max-w-3xl text-lg leading-tight">
				<?php the_archive_description(); ?>
			</div>
		<?php endif; ?>
	</div>
</header><!-- .page-header -->
