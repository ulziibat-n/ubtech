<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

?>

<header id="masthead" class="site-header">
	<div class="container">
		<div class="hidden">
			<?php
			if ( is_front_page() ) :
				?>
				<h1 class="hidden"><?php bloginfo( 'name' ); ?></h1>
				<?php
			else :
				?>
				<p class="hidden"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			?>
		</div>

		<div class=" py-4">
			<div class="select-none flex items-center gap-8">
				<a class="block shrink-0 focus:outline-0" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-black.svg" class="h-9 w-auto shrink block dark:hidden" alt="<?php bloginfo( 'name' ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-white.svg" class="h-9 w-auto shrink hidden dark:block" alt="<?php bloginfo( 'name' ); ?>">
				</a>

				<nav id="site-navigation" class="ds-nav-menu ml-4" aria-label="<?php esc_attr_e( 'Main Navigation', 'ulziibat-tech' ); ?>">
					<?php
					if ( has_nav_menu( 'menu-1' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'container'      => false,
								'items_wrap'     => '<ul id="%1$s" class="%2$s flex gap-1 list-none p-0 m-0">%3$s</ul>',
							)
						);
					}
					?>
				</nav>

				<div class="flex items-center gap-4 ml-auto">
					<?php
					$header_link      = get_field( 'header_link', 'option' );
					$header_link_type = get_field( 'header_link_type', 'option' );
					if ( $header_link ) :
						ub_button( $header_link, $header_link_type, '', true );
					endif;
					?>
				</div>
			</div>
		</div>
	</div>

</header><!-- #masthead -->
