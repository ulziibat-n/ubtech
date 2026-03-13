<?php
$title       = get_field( 'title' );
$subtitle    = get_field( 'subtitle' );
$bg_image    = get_field( 'background_image' );
$button_text = get_field( 'button_text' );
$button_url  = get_field( 'button_link' );
?>
<section class="hero-block">
	<?php if ( $bg_image ) : ?>
	<div class="hero-block__bg">
		<img src="<?php echo esc_url( $bg_image['url'] ); ?>" alt="<?php echo esc_attr( $bg_image['alt'] ?? '' ); ?>">
	</div>
	<?php endif; ?>

	<div class="hero-block__inner">
	<?php if ( $title ) : ?>
		<h1><?php echo esc_html( $title ); ?></h1>
	<?php endif; ?>

	<?php if ( $subtitle ) : ?>
		<p><?php echo esc_html( $subtitle ); ?></p>
	<?php endif; ?>

	<?php if ( $button_text && $button_url ) : ?>
		<a href="<?php echo esc_url( $button_url ); ?>" class="btn">
		<?php echo esc_html( $button_text ); ?>
		</a>
	<?php endif; ?>
	</div>
</section>
