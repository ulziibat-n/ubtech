<?php
/**
 * Template part for displaying search archive header.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

$text_color = ' text-slate-900';
?>

<header class="overflow-hidden relative z-10 pt-16 w-full">
	<div class="container">
		<?php ub_breadcrumb( 'text-xs text-slate-400 mb-2' ); ?>
		<div class="flex flex-col items-start">
			<span class="text-[0.75rem] pl-0.5 leading-none uppercase font-semibold text-lime-600 mb-2"><?php esc_html_e( 'Хайлт', 'ulziibat-tech' ); ?></span>
			<h1 class="max-w-7xl text-3xl font-black tracking-tight sm:text-4xl lg:text-5xl xl:text-6xl <?php echo esc_attr( $text_color ); ?>">
				<?php
				printf(
					/* translators: %s: search term */
					esc_html__( '“%s” хайлтын илэрц', 'ulziibat-tech' ),
					get_search_query()
				);
				?>
			</h1>

			<!-- Search Form Wrapper with more prominent visibility -->
			<div class="pb-2 mt-10 w-full max-w-md">
				<form role="search" method="get" class="flex relative items-center w-full search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="sr-only" for="search-input-header"><?php echo esc_html__( 'Хайх...', 'ulziibat-tech' ); ?></label>
					<input type="search" id="search-input-header" class="px-6 py-4 w-full text-base bg-white rounded-full border border-transparent transition-all duration-300 outline-none shadow-slate-100 shadow-xs search-field focus:border-lime-500 focus:bg-white focus:ring-4 focus:ring-lime-500/10" placeholder="<?php echo esc_attr__( 'Шинээр хайлт хийх...', 'ulziibat-tech' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
					<button type="submit" class="absolute right-3 p-2 transition-colors text-slate-500 hover:text-lime-600">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
						</svg>
					</button>
				</form>
			</div>
		</div>
	</div>
</header><!-- .page-header -->
