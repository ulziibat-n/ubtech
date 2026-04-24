<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some functionality here could be replaced by core features.
 *
 * @package ulziibat-tech
 */

if ( ! function_exists( 'ub_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function ub_posted_on() {
		$time_string = '<time class="published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
endif;

if ( ! function_exists( 'ub_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function ub_posted_by() {
		printf(
		/* translators: 1: posted by label, only visible to screen readers. 2: author link. 3: post author. */
			'<span class="sr-only">%1$s</span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span>',
			esc_html__( 'Posted by', 'ulziibat-tech' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'ub_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function ub_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="sr-only"> on %s</span>', 'ulziibat-tech' ), get_the_title() ) );
		}
	}
endif;

if ( ! function_exists( 'ub_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 * This template tag is used in the entry header.
	 */
	function ub_entry_meta() {

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by.
			ub_posted_by();

			// Posted on.
			ub_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ', 'ulziibat-tech' ) );
			if ( $categories_list ) {
				printf(
				/* translators: 1: posted in label, only visible to screen readers. 2: list of categories. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Posted in', 'ulziibat-tech' ),
					$categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'ulziibat-tech' ) );
			if ( $tags_list ) {
				printf(
				/* translators: 1: tags label, only visible to screen readers. 2: list of tags. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Tags:', 'ulziibat-tech' ),
					$tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
		}

		// Comment count.
		if ( ! is_singular() ) {
			ub_comment_count();
		}

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="sr-only">%s</span>', 'ulziibat-tech' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
	}
endif;

if ( ! function_exists( 'ub_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ub_entry_footer() {

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by.
			ub_posted_by();

			// Posted on.
			ub_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ', 'ulziibat-tech' ) );
			if ( $categories_list ) {
				printf(
				/* translators: 1: posted in label, only visible to screen readers. 2: list of categories. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Posted in', 'ulziibat-tech' ),
					$categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'ulziibat-tech' ) );
			if ( $tags_list ) {
				printf(
				/* translators: 1: tags label, only visible to screen readers. 2: list of tags. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Tags:', 'ulziibat-tech' ),
					$tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
		}

		// Comment count.
		if ( ! is_singular() ) {
			ub_comment_count();
		}

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="sr-only">%s</span>', 'ulziibat-tech' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
	}
endif;

if ( ! function_exists( 'ub_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail, wrapping the post thumbnail in an
	 * anchor element except when viewing a single post.
	 */
	function ub_post_thumbnail() {
		if ( ! ub_can_show_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<figure>
				<?php the_post_thumbnail(); ?>
			</figure><!-- .post-thumbnail -->

			<?php
		else :
			?>

			<figure>
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail(); ?>
				</a>
			</figure>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'ub_comment_avatar' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 *
	 * @param mixed $id_or_email The Gravatar to retrieve. Accepts a user_id, gravatar md5 hash,
	 *                           user email, WP_User object, WP_Post object, or WP_Comment object.
	 */
	function ub_get_user_avatar_markup( $id_or_email = null ) {

		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( '<div class="vcard">%s</div>', get_avatar( $id_or_email, ub_get_avatar_size() ) );
	}
endif;

if ( ! function_exists( 'ub_discussion_avatars_list' ) ) :
	/**
	 * Displays a list of avatars involved in a discussion for a given post.
	 *
	 * @param array $comment_authors Comment authors to list as avatars.
	 */
	function ub_discussion_avatars_list( $comment_authors ) {
		if ( empty( $comment_authors ) ) {
			return;
		}
		echo '<ol>', "\n";
		foreach ( $comment_authors as $id_or_email ) {
			printf(
				"<li>%s</li>\n",
				ub_get_user_avatar_markup( $id_or_email ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		echo '</ol>', "\n";
	}
endif;

if ( ! function_exists( 'ub_the_posts_navigation' ) ) :
	/**
	 * Wraps `the_posts_pagination` for use throughout the theme.
	 */
	function ub_the_posts_navigation() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => __( 'Newer posts', 'ulziibat-tech' ),
				'next_text' => __( 'Older posts', 'ulziibat-tech' ),
			)
		);
	}
endif;

if ( ! function_exists( 'ub_read_time' ) ) :
	/**
	 * Returns estimated read time in minutes for the current post.
	 *
	 * Result is cached per-request via the object cache to avoid
	 * repeated string processing when the same post renders multiple times.
	 *
	 * @return int Minutes to read, minimum 1.
	 */
	function ub_read_time() {
		$post_id   = get_the_ID();
		$cache_key = 'ub_rt_' . $post_id;
		$cached    = wp_cache_get( $cache_key, 'ub' );

		if ( false !== $cached ) {
			return (int) $cached;
		}

		$content = get_post_field( 'post_content', $post_id );
		$minutes = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( $content ) ) / 200 ) );

		wp_cache_set( $cache_key, $minutes, 'ub' );
		return $minutes;
	}
endif;

if ( ! function_exists( 'ub_icon_arrow' ) ) :
	/**
	 * Outputs the arrow-right SVG icon (Material Symbols Rounded).
	 *
	 * @param string $css_class CSS classes applied to the <svg> element.
	 */
	function ub_icon_arrow( $css_class = '' ) {
		echo '<svg class="' . esc_attr( $css_class ) . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" aria-hidden="true"><path d="m560-240-56-58 142-142H160v-80h486L504-662l56-58 240 240-240 240Z"/></svg>';
	}
endif;

if ( ! function_exists( 'ub_icon_logo' ) ) :
	/**
	 * Outputs the brand logomark SVG: circle + lime lightning bolt.
	 *
	 * Dark mode aware: circle fill switches via CSS custom property
	 * scoped to [data-theme=dark]. CSS is injected once via wp_head
	 * using the companion site_logo_mark_styles() function below.
	 *
	 * @since 0.3.0
	 * @param int $size Width and height in pixels.
	 */
	function ub_icon_logo( int $size = 32 ): void {
		$s = absint( $size );
		echo '<svg width="' . $s . '" height="' . $s . '" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">'
			. '<path class="logo-circle" d="M128 256C57.3075 256 0 198.693 0 128C0 57.3075 57.3075 0 128 0C198.693 0 256 57.3075 256 128C256 198.693 198.693 256 128 256Z"/>'
			. '<path d="M117.088 169.29L138.912 139.502L160.442 169.29L204.092 109.714L179.023 91.1336L160.442 116.498L138.618 86.4147L117.088 116.498L95.2627 86.7097L51.9078 146.286L76.977 164.866L95.2627 139.502L117.088 169.29Z" fill="#82BD39"/>'
			. '</svg>';
	}
endif;

if ( ! function_exists( 'site_logo_mark_styles' ) ) :
	/**
	 * Injects the logo-mark dark-mode CSS once into <head>.
	 *
	 * Light → dark circle toggle via [data-theme=dark] — matches tokens.css.
	 * Hooked at priority 1 (after charset meta, before other styles).
	 *
	 * @since 0.3.0
	 */
	function site_logo_mark_styles(): void {
		echo '<style id="site-logo-mark-css">'
			. '.logo-circle{fill:#0C0D0B}'
			. '[data-theme=dark] .logo-circle{fill:oklch(98.4% 0.003 247.86)}'
			. '</style>' . "\n";
	}
	add_action( 'wp_head', 'site_logo_mark_styles', 1 );
endif;


if ( ! function_exists( 'ub_icon_lightning' ) ) :
	/**
	 * Outputs the lightning bolt SVG path (no circle background).
	 *
	 * Intended for use inside a separately styled container,
	 * e.g. the featured card badge in the post grid.
	 *
	 * @param string $css_class CSS classes applied to the <svg> element.
	 */
	function ub_icon_lightning( $css_class = 'w-7 h-auto' ) {
		echo '<svg viewBox="0 0 256 256" class="' . esc_attr( $css_class ) . '" aria-hidden="true">'
			. '<path d="M117.088 169.29L138.912 139.502L160.442 169.29L204.092 109.714L179.023 91.1336L160.442 116.498L138.618 86.4147L117.088 116.498L95.2627 86.7097L51.9078 146.286L76.977 164.866L95.2627 139.502L117.088 169.29Z" fill="#82BD39"/>'
			. '</svg>';
	}
endif;
