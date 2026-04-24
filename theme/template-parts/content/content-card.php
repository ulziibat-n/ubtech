<?php
/**
 * Template part for displaying posts as cards in archive grids.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_featured   = ! empty( $args['featured'] );
$heading_level = ! empty( $args['heading_level'] ) ? absint( $args['heading_level'] ) : 2;
$categories    = get_the_category();
$first_cat     = ! empty( $categories ) ? $categories[0] : null;
$read_time     = ub_read_time();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'group flex flex-col overflow-hidden rounded-2xl border border-stroke-default bg-surface-card transition-all duration-300 ease-primary hover:shadow-md hover:-translate-y-0.5' ); ?>>

	<div class="relative overflow-hidden <?php echo $is_featured ? 'aspect-[1.6/1]' : 'aspect-[1.4/1]'; ?>">

		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" tabindex="-1" aria-hidden="true" class="block h-full">
				<?php
				the_post_thumbnail(
					'medium_large',
					array(
						'class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105',
						'alt'   => esc_attr( get_the_title() ),
					)
				);
				?>
			</a>
		<?php else : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" tabindex="-1" aria-hidden="true"
				class="block h-full w-full bg-brand-subtle"></a>
		<?php endif; ?>

		<?php if ( $first_cat ) : ?>
		<div class="absolute bottom-3 left-3">
			<a href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>"
				class="badge badge-brand hover:bg-brand-primary hover:text-fg-inverse transition-colors duration-300 ease-primary">
				<?php echo esc_html( $first_cat->name ); ?>
			</a>
		</div>
		<?php endif; ?>

		<?php if ( $is_featured ) : ?>
		<div class="absolute top-3 right-3 flex h-11 w-11 items-center justify-center rounded-full bg-surface-inverse" aria-hidden="true">
			<?php ub_icon_lightning(); ?>
		</div>
		<?php endif; ?>

	</div>

	<div class="flex flex-1 flex-col gap-3 <?php echo $is_featured ? 'p-[22px]' : 'p-[18px]'; ?>">

		<h<?php echo absint( $heading_level ); ?> class="<?php echo $is_featured ? 't-h3' : 'text-[18px] font-bold leading-snug'; ?> text-fg-default">
			<a href="<?php echo esc_url( get_permalink() ); ?>"
				class="transition-colors hover:text-fg-link"
				rel="bookmark">
				<?php echo esc_html( get_the_title() ); ?>
			</a>
		</<?php echo esc_attr( 'h' . $heading_level ); ?>>

		<?php if ( $is_featured && get_the_excerpt() ) : ?>
		<p class="text-sm leading-relaxed text-fg-subtle line-clamp-2">
			<?php echo esc_html( get_the_excerpt() ); ?>
		</p>
		<?php endif; ?>

		<footer class="mt-auto flex items-center justify-between pt-1">
			<span class="t-meta text-fg-muted">
				<?php ub_posted_on(); ?>
			</span>
			<span class="t-meta text-fg-muted">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %d: estimated minutes to read. */
						_n( '%d min', '%d min', $read_time, 'ulziibat-tech' ),
						$read_time
					)
				);
				?>
			</span>
		</footer>

	</div>

</article>
