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
	<div class="container py-20">
		<header>
			<?php
			if ( ! is_front_page() ) {
				the_title( '<h1 class="max-w-lg text-4xl font-black text-slate-900 sm:text-6xl">', '</h1>' );
			} else {
				the_title( '<h2 class="max-w-lg text-4xl font-black text-slate-900 sm:text-6xl">', '</h2>' );
			}
			?>
		</header>
		<div class="mt-20 max-w-2xl">
			<?php
			the_content();
			?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
