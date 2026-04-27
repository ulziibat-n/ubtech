<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ulziibat-tech
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ub_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'ub_pingback_header' );

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function ub_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'ub_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function ub_get_the_archive_title() {
	if ( is_category() || is_tag() || is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author_meta( 'display_name' );
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format', 'ulziibat-tech' ) );
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'ulziibat-tech' ) );
	} elseif ( is_day() ) {
		$title = get_the_date();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} else {
		$title = __( 'Архив', 'ulziibat-tech' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'ub_get_the_archive_title' );

/**
 * Determines whether the post thumbnail can be displayed.
 */
function ub_can_show_post_thumbnail() {
	return apply_filters( 'ub_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns the size for avatars used in the theme.
 */
function ub_get_avatar_size() {
	return 60;
}

/**
 * Create the continue reading link
 *
 * @param string $more_string The string shown within the more link.
 */
function ub_continue_reading_link( $more_string ) {

	if ( ! is_admin() ) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'ulziibat-tech' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="sr-only">"', '"</span>', false )
		);

		$more_string = '<a href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}

	return $more_string;
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'ub_continue_reading_link' );

// Filter the content more link.
add_filter( 'the_content_more_link', 'ub_continue_reading_link' );

/**
 * Outputs a comment in the HTML5 format.
 *
 * This function overrides the default WordPress comment output in HTML5
 * format, adding the required class for Tailwind Typography. Based on the
 * `html5_comment()` function from WordPress core.
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function ub_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	$commenter          = wp_get_current_commenter();
	$show_pending_links = ! empty( $commenter['comment_author'] );

	if ( $commenter['comment_author_email'] ) {
		$moderation_note = __( 'Your comment is awaiting moderation.', 'ulziibat-tech' );
	} else {
		$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'ulziibat-tech' );
	}
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<?php
					$comment_author = get_comment_author_link( $comment );

					if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
						$comment_author = get_comment_author( $comment );
					}

					printf(
						/* translators: %s: Comment author link. */
						wp_kses_post( __( '%s <span class="says">says:</span>', 'ulziibat-tech' ) ),
						sprintf( '<b class="fn">%s</b>', wp_kses_post( $comment_author ) )
					);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<?php
					printf(
						'<a href="%s"><time datetime="%s">%s</time></a>',
						esc_url( get_comment_link( $comment, $args ) ),
						esc_attr( get_comment_time( 'c' ) ),
						esc_html(
							sprintf(
							/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s', 'ulziibat-tech' ),
								get_comment_date( '', $comment ),
								get_comment_time()
							)
						)
					);

					edit_comment_link( __( 'Edit', 'ulziibat-tech' ), ' <span class="edit-link">', '</span>' );
					?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			if ( '1' === $comment->comment_approved || $show_pending_links ) {
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
			}
			?>
		</article><!-- .comment-body -->
	<?php
}

/**
 * ACF JSON Sync Configuration
 */

/**
 * Save ACF JSON files to the /json directory.
 *
 * @param string $path The path to save the JSON files.
 * @return string
 */
function ub_acf_json_save_point( $path ) {
	// Update path.
	$path = get_stylesheet_directory() . '/json';

	return $path;
}
add_filter( 'acf/settings/save_json', 'ub_acf_json_save_point' );

/**
 * Load ACF JSON files from the /json directory.
 *
 * @param array $paths The paths to load the JSON files from.
 * @return array
 */
function ub_acf_json_load_point( $paths ) {
	// Remove original path (optional).
	unset( $paths[0] );

	// Append path
	$paths[] = get_stylesheet_directory() . '/json';

	return $paths;
}
add_filter( 'acf/settings/load_json', 'ub_acf_json_load_point' );

/**
 * Add 'group' class to menu items
 *
 * @param array  $classes The CSS classes that are applied to the menu item's <li> element.
 * @param object $item    The current menu item.
 * @param object $args    An object of wp_nav_menu() arguments.
 * @return array Modified classes array.
 */
function ub_add_group_class_to_menu_items( $classes, $item, $args ) {
	if ( 'menu-1' === $args->theme_location ) {
		$classes[] = 'group';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'ub_add_group_class_to_menu_items', 10, 3 );

/**
 * Add classes to menu item anchor tags
 *
 * @param array  $atts The HTML attributes applied to the menu item's <a> element.
 * @param object $item The current menu item.
 * @param object $args An object of wp_nav_menu() arguments.
 * @return array Modified attributes array.
 */
function ub_add_classes_to_menu_links( $atts, $item, $args ) {
	if ( 'menu-1' === $args->theme_location ) {
		$atts['class'] = ' text-sm text-slate-600 hover:text-lime-600 duration-300 ease-primary [*.is-active]:bg-white [*.is-active]:text-lime-600 px-3 py-1.5 rounded-md font-semibold transition-colors focus:text-slate-500 focus:outline-none focus:ring-0 group-[.is-header-transparent]/body:text-white group-[.is-header-transparent]/body:hover:text-lime-400 group-[.is-header-transparent]/body:[*.is-active]:bg-white/20 group-[.is-header-transparent]/body:[*.is-active]:text-lime-500';
		if ( in_array( 'current-menu-item', $item->classes, true ) ) {
			$atts['class'] .= ' is-active';
		}
	}

	if ( 'menu-2' === $args->theme_location ) {
		$atts['class'] = 'text-xs font-semibold leading-none text-slate-600 duration-300 ease-primary hover:text-slate-900 transition-colors focus:text-white group-[.current-menu-item]:bg-slate-100 group-[.current-menu-item]:text-lime-600 group-[.current-menu-item]:hover:text-lime-600 focus:outline-none focus:ring-0';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'ub_add_classes_to_menu_links', 10, 3 );

/**
 * Add custom classes to the body tag
 *
 * @param array $classes Classes for the body element.
 * @return array Modified classes array.
 */
function ub_body_classes( $classes ) {

	// ✅ Add 'no-js' by default for CSS reliance.
	$classes[] = 'no-js';

	// ✅ Add body classes for Tailwind Typography.
	$classes[] = 'antialiased';
	$classes[] = 'bg-white';
	$classes[] = 'text-slate-900';
	$classes[] = 'group/body';

	// ✅ Transparent header for category archives with images.
	if ( is_category() ) {
		$term_id  = get_queried_object_id();
		$term_img = get_field( 'archive_image', 'category_' . $term_id );
		if ( $term_img ) {
			$classes[] = 'is-header-transparent';
		}
	}

	// ✅ Transparent header for single posts with featured images.
	if ( is_singular( 'post' ) ) {
		$classes[] = 'is-header-transparent';
	}

	return $classes;
}
add_filter( 'body_class', 'ub_body_classes' );

/**
 * Restrict Gutenberg blocks to a specific set.
 *
 * @param bool|array              $allowed_block_types Array of block type slugs, or boolean to enable/disable all.
 * @param WP_Block_Editor_Context $block_editor_context The current block editor context.
 *
 * @return array|bool
 */
function ub_allowed_block_types( $allowed_block_types, $block_editor_context ) {
	// Restrict blocks for the 'post' post type.
	if ( isset( $block_editor_context->post ) && 'post' === $block_editor_context->post->post_type ) {
		return array(
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/list-item',
			'core/quote',
			'core/table',
			'core/image',
			'core/separator',
		);
	}

	return $allowed_block_types;
}
add_filter( 'allowed_block_types_all', 'ub_allowed_block_types', 10, 2 );


