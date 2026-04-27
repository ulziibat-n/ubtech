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

if ( ! function_exists( 'ub_button' ) ) :
	/**
	 * Handles ACF Link objects and applies design system classes.
	 *
	 * @param array   $link      ACF Link field.
	 * @param string  $type      Button type.
	 * @param string  $css_class Additional classes.
	 * @param boolean $icon      Whether to show an icon.
	 * @param array   $args      Optional arguments for inner elements (span_class, icon_class, icon_svg).
	 */
	function ub_button( $link, $type = 'primary', $css_class = '', $icon = false, $args = array() ) {
		if ( empty( $link['url'] ) || empty( $link['title'] ) ) {
			return;
		}

		// Default configuration for inner elements.
		$defaults = array(
			'span_class' => '',
			'icon_class' => 'w-5 h-5 fill-current',
			'icon_svg'   => '<path d="m560-240-56-58 142-142H160v-80h486L504-662l56-58 240 240-240 240Z"></path>',
		);
		$args     = wp_parse_args( $args, $defaults );

		$url    = $link['url'];
		$title  = $link['title'];
		$target = ! empty( $link['target'] ) ? $link['target'] : '_self';

		// Base classes based on your design system rules.
		$base_class = 'inline-flex items-center justify-center gap-1.5 rounded-full text-sm leading-none transition-all duration-300 ease-primary select-none';

		// Variant mappings.
		$type_classes = array(
			'primary' => 'bg-slate-900 text-white hover:bg-slate-800 font-medium px-4 py-2.5',
			'brand'   => 'bg-lime-500 text-xs text-white hover:bg-lime-600 hover:text-white font-bold px-4 py-1.5',
			'ghost'   => 'bg-transparent text-slate-900 border border-slate-200 hover:bg-slate-100 font-medium px-4 py-2.5',
			'link'    => 'bg-transparent text-lime-600 hover:text-lime-600 font-medium px-1 py-2.5',
		);

		$variant_class = isset( $type_classes[ $type ] ) ? $type_classes[ $type ] : $type_classes['primary'];
		$final_class   = trim( "$base_class $variant_class $css_class" );

		$icon_html = '';
		if ( $icon ) {
			$icon_html = sprintf(
				'<svg viewBox="0 -960 960 960" class="%s" aria-hidden="true">%s</svg>',
				esc_attr( $args['icon_class'] ),
				$args['icon_svg']
			);
		}

		printf(
			'<a href="%s" class="%s" target="%s" rel="%s" data-type="%s"><span class="%s">%s</span>%s</a>',
			esc_url( $url ),
			esc_attr( $final_class ),
			esc_attr( $target ),
			( '_blank' === $target ) ? 'noopener noreferrer' : 'bookmark',
			esc_attr( $type ),
			esc_attr( $args['span_class'] ),
			esc_html( $title ),
			$icon_html // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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

	/**
	 * Displays a fully custom numbers-only pagination.
	 *
	 * @param string $link_class    Optional CSS classes for page number elements (a, span).
	 * @param string $wrapper_class Optional CSS classes for the container.
	 * @param string $nav_class     Optional CSS classes for the nav wrapper.
	 */
function ub_the_posts_navigation( $link_class = '', $wrapper_class = '', $nav_class = '' ) {
	global $wp_query;

	$total_pages = $wp_query->max_num_pages;
	if ( $total_pages <= 1 ) {
		return;
	}

	$current_page = max( 1, get_query_var( 'paged' ) );

	$links = paginate_links(
		array(
			'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'    => '?paged=%#%',
			'current'   => $current_page,
			'total'     => $total_pages,
			'mid_size'  => 2,
			'prev_next' => true,
			'prev_text' => '<svg class="w-14 h-14" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256" fill="currentColor"><path d="M220,128a4,4,0,0,1-4,4H49.66l65.17,65.17a4,4,0,0,1-5.66,5.66l-72-72a4,4,0,0,1,0-5.66l72-72a4,4,0,0,1,5.66,5.66L49.66,124H216A4,4,0,0,1,220,128Z"></path></svg>',
			'next_text' => '<svg class="w-14 h-14" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256" fill="currentColor"><path d="M218.83,130.83l-72,72a4,4,0,0,1-5.66-5.66L206.34,132H40a4,4,0,0,1,0-8H206.34L141.17,58.83a4,4,0,0,1,5.66-5.66l72,72A4,4,0,0,1,218.83,130.83Z"></path></svg>',
			'type'      => 'array',
		)
	);

	if ( $links ) {
		$nav_class       = ! empty( $nav_class ) ? $nav_class : '';
		$wrapper_class   = ! empty( $wrapper_class ) ? $wrapper_class : 'flex items-center gap-4';
		$item_base_class = 'text-6xl font-thin text-slate-600 hover:text-lime-600 transition-colors duration-300';

		echo '<nav class="custom-pagination' . esc_attr( $nav_class ) . '" aria-label="' . esc_attr__( 'Хуудаслалт', 'ulziibat-tech' ) . '">';
		echo '<div class="' . esc_attr( $wrapper_class ) . '">';

		foreach ( $links as $link ) {
			// Inject our classes.
			$link = str_replace( 'page-numbers', $item_base_class . ' ' . esc_attr( $link_class ), $link );

			// Style the current page differently.
			if ( strpos( $link, 'current' ) !== false ) {
				$link = str_replace( ' current"', ' !text-lime-600 !shadow-lime-100"', $link );
			}

			echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo '</div>';
		echo '</nav>';
	}
}

if ( ! function_exists( 'ub_read_time' ) ) :
	/**
	 * Returns estimated read time formatted with Mongolian units for the current post.
	 *
	 * Result is cached per-request via the object cache.
	 *
	 * @param int    $post_id    Post ID.
	 * @param string $unit_class Optional CSS class for the time units (span).
	 * @return string Formatted read time string.
	 */
	function ub_read_time( $post_id, $unit_class = '' ) {
		$cache_key = 'ub_rt_' . $post_id . '_' . sanitize_title( $unit_class );
		$cached    = wp_cache_get( $cache_key, 'ub' );

		if ( false !== $cached ) {
			return (string) $cached;
		}

		$content       = get_post_field( 'post_content', $post_id );
		$clean_content = wp_strip_all_tags( $content );

		// Use regex split for more accurate word count with non-latin characters.
		$words      = preg_split( '/\s+/', trim( $clean_content ) );
		$word_count = ! empty( $words[0] ) ? count( $words ) : 0;

		// Average reading speed: 200 words per minute.
		$total_seconds = (int) ceil( ( $word_count / 200 ) * 60 );

		$output = '';

		// Translatable unit texts.
		$h_text = _x( 'цаг', 'hour abbreviation', 'ulziibat-tech' );
		$m_text = _x( 'мин', 'minute abbreviation', 'ulziibat-tech' );
		$s_text = _x( 'сек', 'second abbreviation', 'ulziibat-tech' );

		// Wrap units in spans if a class is provided.
		$h_unit = $unit_class ? sprintf( '<span class="%s">%s</span>', esc_attr( $unit_class ), $h_text ) : $h_text;
		$m_unit = $unit_class ? sprintf( '<span class="%s">%s</span>', esc_attr( $unit_class ), $m_text ) : $m_text;
		$s_unit = $unit_class ? sprintf( '<span class="%s">%s</span>', esc_attr( $unit_class ), $s_text ) : $s_text;

		if ( $total_seconds >= 3600 ) {
			$hours   = floor( $total_seconds / 3600 );
			$minutes = (int) round( ( $total_seconds % 3600 ) / 60 );
			$output  = $hours . ' ' . $h_unit . ( $minutes > 0 ? ' ' . $minutes . ' ' . $m_unit : '' );
		} elseif ( $total_seconds >= 60 ) {
			$minutes = floor( $total_seconds / 60 );
			$seconds = $total_seconds % 60;
			$output  = $minutes . ' ' . $m_unit . ( $seconds > 0 ? ' ' . $seconds . ' ' . $s_unit : '' );
		} else {
			$output = max( 1, $total_seconds ) . ' ' . $s_unit;
		}

		wp_cache_set( $cache_key, $output, 'ub' );
		return $output;
	}
endif;

if ( ! function_exists( 'ub_the_read_time' ) ) :
	/**
	 * Outputs the formatted read time wrapped in a span with a CSS class.
	 *
	 * @param int    $post_id    Post ID.
	 * @param string $class       CSS classes applied to the main wrapper <span> element.
	 * @param string $unit_class  Optional CSS classes applied to the time unit <span> elements.
	 */
	function ub_the_read_time( $post_id, $class = '', $unit_class = '' ) {
		$time = ub_read_time( $post_id, $unit_class );
		if ( $time ) {
			printf( '<span class="%s">%s</span>', esc_attr( $class ), $time );
		}
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

if ( ! function_exists( 'ub_the_primary_category' ) ) :
	/**
	 * Outputs the primary category link.
	 *
	 * Uses Yoast SEO primary category if available, falls back to the first category.
	 *
	 * @param string $class CSS classes applied to the <a> element.
	 */
	function ub_the_primary_category( $class = '' ) {
		$post_id  = get_the_ID();
		$category = null;

		// 1. Try Yoast SEO Primary Category.
		if ( class_exists( 'WPSEO_Primary_Term' ) ) {
			$wpseo_primary_term = new WPSEO_Primary_Term( 'category', $post_id );
			$primary_term_id    = $wpseo_primary_term->get_primary_term();
			if ( $primary_term_id ) {
				$category = get_term( $primary_term_id );
			}
		}

		// 2. Fallback to the first category.
		if ( ! $category || is_wp_error( $category ) ) {
			$categories = get_the_category( $post_id );
			if ( ! empty( $categories ) ) {
				$category = $categories[0];
			}
		}

		// 3. Output the link.
		if ( $category && ! is_wp_error( $category ) ) {
			printf(
				'<a href="%1$s" class="%2$s">%3$s</a>',
				esc_url( get_category_link( $category->term_id ) ),
				esc_attr( $class ),
				esc_html( $category->name )
			);
		}
	}
endif;


