<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

?>

<header data-site-header id="masthead" class="site-header group-[.is-header-transparent]/body:absolute group-[.is-header-transparent]/body:top-0 group-[.is-header-transparent]/body:left-0 group-[.is-header-transparent]/body:w-full group-[.is-header-transparent]/body:z-50 z-50">
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

		<div class="py-4">
			<div class="flex gap-8 items-center select-none">
				<a class="block shrink-0 focus:outline-0" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-black.svg" class="h-9 w-auto shrink block group-[.is-header-transparent]/body:hidden" alt="<?php bloginfo( 'name' ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-white.svg" class="h-9 w-auto shrink hidden group-[.is-header-transparent]/body:block" alt="<?php bloginfo( 'name' ); ?>">
				</a>

				<nav id="site-navigation" class="ml-4 ds-nav-menu" aria-label="<?php esc_attr_e( 'Main Navigation', 'ulziibat-tech' ); ?>">
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

				<div class="flex gap-4 items-center ml-auto">
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
