<?php
/**
 * Архивын жагсаалтыг гридээр харуулдаг тэмплэйт.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */
?>
<div class="grid grid-cols-1 gap-2 sm:grid-cols-3 lg:grid-cols-4">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/card/card', 'grid' );
	endwhile;
	?>
</div>

<?php ub_the_posts_navigation(); ?>