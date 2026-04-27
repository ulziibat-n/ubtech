<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

?>

<section class="no-results not-found flex flex-col justify-center grow">
	<div class="container">
		<div class="flex flex-col gap-8 py-20 max-w-lg sm:gap-12">
			<header class="flex flex-col gap-6 items-start">
				<svg class="w-16 h-auto fill-lime-500" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M480-420q-68 0-123.5 38.5T276-280h408q-25-63-80.5-101.5T480-420Zm-168-60 44-42 42 42 42-42-42-42 42-44-42-42-42 42-44-42-42 42 42 44-42 42 42 42Zm250 0 42-42 44 42 42-42-42-42 42-44-42-42-44 42-42-42-42 42 42 44-42 42 42 42ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
				<h1 class="max-w-xs text-4xl font-black sm:text-6xl">
					<?php
					if ( is_search() ) {
						esc_html_e( 'Илэрц олдсонгүй', 'ulziibat-tech' );
					} else {
						esc_html_e( 'Агуулга олдсонгүй', 'ulziibat-tech' );
					}
					?>
				</h1>
			</header><!-- .page-header -->

			<div class="flex flex-col gap-8 items-start">
				<?php if ( is_search() ) : ?>
					<p><?php esc_html_e( 'Уучлаарай, таны хайсан илэрц олдсонгүй. Өөр түлхүүр үгээр хайж үзнэ үү.', 'ulziibat-tech' ); ?></p>
				<?php else : ?>
					<p><?php esc_html_e( 'Бид таны хайж буй агуулгыг олж чадсангүй. Магадгүй хайлт хийх нь тус болж болох юм.', 'ulziibat-tech' ); ?></p>
				<?php endif; ?>

				<form role="search" method="get" class="search-form w-full max-w-md relative flex items-center" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="sr-only" for="search-input"><?php echo esc_html__( 'Хайх...', 'ulziibat-tech' ); ?></label>
					<input type="search" id="search-input" class="search-field w-full px-6 py-3 text-sm bg-slate-100 rounded-full border-0 focus:ring-2 focus:ring-lime-500 outline-none transition-all duration-300" placeholder="<?php echo esc_attr__( 'Хайх утгаа оруулна уу...', 'ulziibat-tech' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
					<button type="submit" class="absolute right-2 p-2 text-slate-500 hover:text-lime-600 transition-colors">
						<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
					</button>
				</form>

				<a class="inline-flex gap-1.5 justify-center items-center px-4 py-1.5 text-xs font-bold leading-none text-white bg-lime-500 rounded-full transition-all duration-300 select-none ease-primary hover:bg-lime-600 hover:text-white" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span><?php esc_html_e( 'Эхлэл хуудас', 'ulziibat-tech' ); ?></span>
					<svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m560-240-56-58 142-142H160v-80h486L504-662l56-58 240 240-240 240Z"/></svg>
				</a>
			</div><!-- .page-content -->
		</div>
	</div>
</section><!-- .no-results -->
