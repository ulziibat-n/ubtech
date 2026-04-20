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

$categories  = get_the_category();
$first_cat   = ! empty( $categories ) ? $categories[0] : null;
$read_time   = ub_read_time();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'group flex flex-col overflow-hidden rounded-2xl border border-stroke-default bg-surface-card shadow-sm transition-all duration-300 hover:shadow-md' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="aspect-video overflow-hidden">
			<a href="<?php echo esc_url( get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
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
		</div>
	<?php endif; ?>

	<div class="flex flex-1 flex-col gap-4 p-6">

		<?php if ( $first_cat ) : ?>
			<div>
				<a
					href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>"
					class="inline-flex items-center rounded-full bg-brand-subtle px-2.5 py-1 text-xs font-semibold text-brand-fg transition-colors hover:bg-brand-primary hover:text-fg-inverse"
				>
					<?php echo esc_html( $first_cat->name ); ?>
				</a>
			</div>
		<?php endif; ?>

		<h2 class="text-lg font-bold leading-snug text-fg-default">
			<a
				href="<?php echo esc_url( get_permalink() ); ?>"
				class="transition-colors hover:text-fg-link"
				rel="bookmark"
			>
				<?php echo esc_html( get_the_title() ); ?>
			</a>
		</h2>

		<?php if ( get_the_excerpt() ) : ?>
			<p class="line-clamp-3 text-sm text-fg-subtle">
				<?php echo esc_html( get_the_excerpt() ); ?>
			</p>
		<?php endif; ?>

		<footer class="mt-auto flex items-center justify-between pt-2">
			<span class="text-xs text-fg-muted">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %d: estimated minutes to read. Singular/plural identical — Mongolian has no grammatical number distinction here. */
						_n( '%d min read', '%d min read', $read_time, 'ub' ),
						$read_time
					)
				);
				?>
			</span>
			<span class="text-xs text-fg-muted">
				<?php ub_posted_on(); ?>
			</span>
		</footer>

	</div>

</article>
