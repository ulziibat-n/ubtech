<?php
/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'relative' ); ?>>
	<header class="relative w-full block overflow-hidden">
		<?php
		if ( 'full' === get_field( 'featured_image_type' ) && has_post_thumbnail() ) {
			the_post_thumbnail( 'full', array( 'class' => 'absolute w-full h-full inset-0 object-cover z-0' ) );
		}
		?>
		<div class=" absolute w-full h-full inset-0 z-10 bg-linear-to-b from-transparent to-black/50"></div>
		<div class="container relative z-20 pt-64 pb-32">
			<h1 class="t-h1 text-fg-inverse max-w-7xl"><?php the_title(); ?></h1>
			<?php
			if ( has_excerpt() ) :
				?>
				<div class="max-w-3xl text-fg-inverse t-lead mt-10">
					<?php the_excerpt(); ?>
				</div>
				<?php
			endif;
			?>

			<?php if ( ! is_page() ) : ?>
				<div class="">
					<?php ub_entry_meta(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</div>
		
	</header><!-- .entry-header -->

	<div class="py-24">
		<div class="container">
			<div class="flex">
				<div class="w-2/3 pr-24">
					<div data-post-content class="max-w-3xl">
						<?php
						the_content();
						?>
					</div>
				</div>
				<div class="w-1/3">
					<div data-post-toc class="sticky top-24">
						<h4 class="text-xs font-bold uppercase tracking-widest text-fg-muted mb-6"><?php echo esc_html__( 'Агуулга', 'ulziibat-tech' ); ?></h4>
						<ul data-post-toc-list class="p-0 max-w-xs">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .entry-content -->

	
	<?php
	$author_avatar = get_field( 'author_avatar' );
	$author_bio    = get_field( 'author_bio' );
	$social_links  = array(
		'fb' => array(
			'url'  => get_field( 'author_fb' ),
			'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
		),
		'ig' => array(
			'url'  => get_field( 'author_ig' ),
			'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
		),
		'tr' => array(
			'url'  => get_field( 'author_tr' ),
			'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.56 12.1a.95.95 0 0 1-.95-.95V7.08a.95.95 0 0 1 1.9 0v4.07a.95.95 0 0 1-.95.95zM12 24C5.38 24 0 18.62 0 12S5.38 0 12 0s12 5.38 12 12-5.38 12-12 12zm0-22C6.49 2 2 6.49 2 12s4.49 10 10 10 10-4.49 10-10S17.51 2 12 2zm3.32 15.32l-3.32-3.32-3.32 3.32a.95.95 0 0 1-1.34-1.34L10.66 12l-3.32-3.32a.95.95 0 0 1 1.34-1.34L12 10.66l3.32-3.32a.95.95 0 0 1 1.34 1.34L13.34 12l3.32 3.32a.95.95 0 1 1-1.34 1.34z"/></svg>', // Placeholder for Threads
		),
		'x'  => array(
			'url'  => get_field( 'author_x' ),
			'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932 6.064-6.932zm-1.292 19.494h2.039L6.486 3.24H4.298l13.311 17.407z"/></svg>',
		),
		'in' => array(
			'url'  => get_field( 'author_in' ),
			'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
		),
	);

	if ( $author_bio || $author_avatar || ! empty( array_filter( array_column( $social_links, 'url' ) ) ) ) :
		?>
		<div class="author-box container bg-surface-raised rounded-2xl p-6 md:p-8 my-12 flex flex-col md:flex-row gap-6 md:gap-8 items-start border border-stroke-default">
			<div class="author-avatar shrink-0">
				<?php if ( is_array( $author_avatar ) ) : ?>
					<img src="<?php echo esc_url( $author_avatar['url'] ); ?>" alt="<?php echo esc_attr( $author_avatar['alt'] ); ?>" class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover shadow-sm bg-surface-card">
				<?php elseif ( is_string( $author_avatar ) && ! empty( $author_avatar ) ) : ?>
					<img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php the_author(); ?>" class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover shadow-sm bg-surface-card">
				<?php else : ?>
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 96, '', '', array( 'class' => 'w-20 h-20 md:w-24 md:h-24 rounded-full shadow-sm bg-surface-card' ) ); ?>
				<?php endif; ?>
			</div>
			<div class="author-info flex-1">
				<h3 class="text-lg md:text-xl font-bold mb-3 text-fg-default"><?php the_author(); ?></h3>
				
				<?php if ( $author_bio ) : ?>
					<div class="author-bio max-w-none text-fg-subtle mb-6 leading-relaxed">
						<?php echo wp_kses_post( $author_bio ); ?>
					</div>
				<?php endif; ?>

				<div class="author-socials flex flex-wrap gap-3">
					<?php foreach ( $social_links as $id => $social ) : ?>
						<?php if ( $social['url'] ) : ?>
							<a href="<?php echo esc_url( $social['url'] ); ?>" 
								class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-surface-card border border-stroke-default text-fg-muted hover:text-fg-link hover:border-stroke-focus hover:shadow-md transition-all duration-300" 
								target="_blank" 
								rel="noopener noreferrer"
								title="<?php echo esc_attr( strtoupper( $id ) ); ?>">
								<?php echo $social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

</article><!-- #post-${ID} -->
