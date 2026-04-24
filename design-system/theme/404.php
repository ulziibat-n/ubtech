<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ulziibat-tech
 */

get_header();
?>

	<section id="primary" class="flex flex-col justify-center grow ">
		<main id="main" class="selection:bg-lime-500">

			<div class="container">
				<div class="flex flex-col max-w-lg gap-8 py-20 sm:gap-12">
					<header class="flex flex-col items-start gap-6">
						<svg class="w-16 h-auto fill-lime-500" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M480-420q-68 0-123.5 38.5T276-280h408q-25-63-80.5-101.5T480-420Zm-168-60 44-42 42 42 42-42-42-42 42-44-42-42-42 42-44-42-42 42 42 44-42 42 42 42Zm250 0 42-42 44 42 42-42-42-42 42-44-42-42-44 42-42-42-42 42 42 44-42 42 42 42ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
						<h1 class="max-w-xs text-4xl font-black text-white sm:text-6xl"><?php esc_html_e( 'Хуудас олдсонгүй', 'ulziibat-tech' ); ?></h1>
					</header><!-- .page-header -->
					<div class="flex flex-col items-start gap-8">
						<p class="text-white"><?php esc_html_e( 'Энэ хуудас олдсонгүй. Устгагдсан эсвэл нэр өөрчлөгдсөн байж магадгүй, эсвэл хэзээ ч байгаагүй байж болно.', 'ulziibat-tech' ); ?></p>
						<a class="flex items-center gap-2 px-6 py-2 text-sm font-semibold no-underline transition-colors duration-300 bg-white rounded-full select-none text-zinc-800 hover:bg-zinc-800 hover:text-white focus:bg-zinc-800 focus:text-white focus:outline-none ease-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<span><?php esc_html_e( 'Эхлэл хуудас', 'ulziibat-tech' ); ?></span>
							<svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m560-240-56-58 142-142H160v-80h486L504-662l56-58 240 240-240 240Z"/></svg>
					</a>
					</div><!-- .page-content -->
				</div>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
