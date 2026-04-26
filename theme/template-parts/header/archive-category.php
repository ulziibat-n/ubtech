<?php
/**
 * Template part for displaying posts as cards in archive grids.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

$text_color    = ' text-slate-900';
$padding_class = 'pt-20';
$term_id       = get_queried_object_id();
$term_img      = get_field( 'archive_image', 'category_' . $term_id );

if ( $term_img ) {
	$text_color    = ' text-white';
	$padding_class = 'z-30 relative pt-64 pb-12';
}
?>

<header class="overflow-hidden relative w-full">
	<?php

	if ( $term_img ) :
		echo wp_get_attachment_image( $term_img, 'full', false, array( 'class' => 'absolute inset-0 w-full h-full object-cover z-0' ) );
		?>
		<div class="absolute inset-0 z-20 bg-slate-950/50"></div>
		<?php
	endif;
	?>
	<div class="container <?php echo esc_attr( $padding_class ); ?>">
		<div class="flex flex-col items-start">
			<span class="text-[0.75rem] pl-0.5 leading-none uppercase font-semibold rounded-xs 
			<?php
			if ( $term_img ) {
				echo 'text-white'; } else {
				echo 'text-lime-600'; }
				?>
				"><?php esc_html_e( 'Ангилал', 'ulziibat-tech' ); ?></span>
			<?php the_archive_title( '<h1 class="max-w-7xl text-2xl font-black leading-none sm:text-3xl lg:text-5xl xl:text-6xl' . $text_color . '">', '</h1>' ); ?>
		</div>
		<?php if ( term_description() ) : ?>
			<div class="mt-4 max-w-3xl leading-tight text-lg py-2 <?php echo esc_attr( $text_color ); ?>">
				<?php echo wp_kses_post( term_description() ); ?>
			</div>
		<?php endif; ?>
	</div>
	
</header><!-- .page-header -->
