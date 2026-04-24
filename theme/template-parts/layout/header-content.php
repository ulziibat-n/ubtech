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
					<!-- DS logomark: design-system/assets/logo-color-black.svg (circle + lightning M) -->
					<svg width="32" height="32" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M128 256C57.3075 256 0 198.693 0 128C0 57.3075 57.3075 0 128 0C198.693 0 256 57.3075 256 128C256 198.693 198.693 256 128 256Z" fill="#0C0D0B"/>
						<path d="M117.088 169.29L138.912 139.502L160.442 169.29L204.092 109.714L179.023 91.1336L160.442 116.498L138.618 86.4147L117.088 116.498L95.2627 86.7097L51.9078 146.286L76.977 164.866L95.2627 139.502L117.088 169.29Z" fill="#82BD39"/>
					</svg>
					<!-- DS wordmark: font-weight 900, 12px, 0.04em tracking, uppercase, two-line stack -->
					<span class="text-[12px] font-black leading-[1] tracking-[0.04em] uppercase" aria-label="ulziibat.tech">
						<span class="block text-fg-default">ulziibat</span>
						<span class="block text-brand-primary">tech</span>
					</span>
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
			<!-- Dark mode toggle — DS: data-theme-toggle attribute, script.js handler -->
			<button
				data-theme-toggle
				aria-label="Dark mode-рүү шилжих"
				class="flex items-center justify-center w-9 h-9 rounded-full text-fg-subtle hover:text-fg-default hover:bg-surface-raised transition-colors ease-primary duration-300 focus:outline-1 focus:outline-stroke-strong focus:outline-offset-2 focus:rounded-xs"
			>
				<!-- Sun icon: light mode-д харагдана -->
				<svg data-icon-light xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 -960 960 960">
					<path d="M480-360q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0 80q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-57 96 100-52 54Zm492 496-97-101 53-53 101 97-57 57Zm-98-550 97-101 57 57-100 96-54-52ZM154-212l101-97 53 53-97 101-57-57Z"/>
				</svg>
				<!-- Moon icon: dark mode-д харагдана -->
				<svg data-icon-dark xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 -960 960 960" style="display:none">
					<path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z"/>
				</svg>
			</button>
			<a class="flex py-2 pl-4 pr-2.5 rounded-full ml-auto items-center gap-1 transition-colors ease-primary duration-300 bg-surface-inverse hover:bg-surface-inverse-hover focus:ring-0 focus:bg-surface-inverse-hover focus:outline-0 text-fg-inverse" href="mailto:ulziibat.n@gmail.com">
				<span class="text-sm font-medium leading-none">Надтай холбогдох</span>
				<svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m560-240-56-58 142-142H160v-80h486L504-662l56-58 240 240-240 240Z"/></svg>
			</a>
		</div>
	</div>

</header><!-- #masthead -->
