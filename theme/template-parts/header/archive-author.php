<?php
/**
 * Template part for displaying posts as cards in archive grids.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */
?>

<header class="">
	<div class="container">
	<?php the_archive_title( '<h1 class="text-4xl font-black text-slate-900 sm:text-5xl">', '</h1>' ); ?>
	<?php if ( term_description() ) : ?>
		<div class="mt-4 max-w-3xl">
			<?php echo wp_kses_post( term_description() ); ?>
		</div>
	<?php endif; ?>
	</div>
	
</header><!-- .page-header -->
