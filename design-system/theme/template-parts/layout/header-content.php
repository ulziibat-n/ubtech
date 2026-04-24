<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

?>

<header id="masthead">
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
	<div class="container py-6">
		<div class="flex items-center gap-12 select-none">
			<div class="flex gap-8">
				<a class="flex items-center gap-2 focus:outline-0" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<svg class="w-8 h-auto fill-fg-inverse" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m443-340 74-101 73 101 148-202-85-63-63 86-74-102-73 102-74-101-147 202 85 63 62-86 74 101Zm37 294q-91 0-169.99-34.08-78.98-34.09-137.41-92.52-58.43-58.43-92.52-137.41Q46-389 46-480q0-91 34.08-169.99 34.09-78.98 92.52-137.41 58.43-58.43 137.41-92.52Q389-914 480-914q91 0 169.99 34.08 78.98 34.09 137.41 92.52 58.43 58.43 92.52 137.41Q914-571 914-480q0 91-34.08 169.99-34.09 78.98-92.52 137.41-58.43 58.43-137.41 92.52Q571-46 480-46Z"/></svg>
					<span class="w-20 text-sm font-black leading-3 tracking-wide uppercase" aria-label="ulziibat.tech"><span class="block">ulziibat</span><span class="block text-brand-primary">tech</span></span>
				</a>
				<?php
				$ub_description = get_bloginfo( 'description', 'display' );
				if ( $ub_description || is_customize_preview() ) :
					?>
					<p class="hidden text-xs max-w-44 text-fg-muted"><?php echo $ub_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div>
			
			<nav id="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'ulziibat-tech' ); ?>">
			
				<?php
				if ( has_nav_menu( 'menu-1' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'items_wrap'     => '<ul id="%1$s" class="%2$s flex gap-1" aria-label="submenu">%3$s</ul>',
						)
					);
				}
				?>
			</nav>
			<a class="flex py-2 pl-4 pr-2.5 rounded-full ml-auto items-center gap-1 transition-colors ease-primary duration-300 bg-surface-inverse hover:bg-surface-inverse-hover focus:ring-0 focus:bg-surface-inverse-hover focus:outline-0 text-fg-inverse" href="mailto:ulziibat.n@gmail.com">
				<span class="text-sm font-medium leading-none">Надтай холбогдох</span>
				<svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m560-240-56-58 142-142H160v-80h486L504-662l56-58 240 240-240 240Z"/></svg>
			</a>
		</div>
	</div>

</header><!-- #masthead -->
