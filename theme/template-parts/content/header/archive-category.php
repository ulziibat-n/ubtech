<?php
/**
 * Template part for displaying posts as cards in archive grids.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */
?>

<header class="w-full relative overflow-hidden">
	<?php
		$term_id  = get_queried_object_id();
		$term_img = get_field( 'archive_image', 'category_' . $term_id );
	if ( $term_img ) :
		echo wp_get_attachment_image( $term_img, 'full', false, array( 'class' => 'absolute inset-0 w-full h-full object-cover z-0' ) );
		endif;
	?>
	<div class="container z-10 relative pt-64 pb-32">
		<?php the_archive_title( '<h1 class="d-t-h1 text-white">', '</h1>' ); ?>
		<?php if ( term_description() ) : ?>
			<div class="mt-4 max-w-3xl leading-tight text-lg text-white">
				<?php echo wp_kses_post( term_description() ); ?>
			</div>
		<?php endif; ?>
	</div>
	
</header><!-- .page-header -->
