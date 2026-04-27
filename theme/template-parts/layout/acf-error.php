<?php
/**
 * Custom error page when ACF is missing.
 *
 * @package ulziibat-tech
 */

get_header();
?>

<section id="primary" class="flex flex-col justify-center grow">
	<main id="main" class="selection:bg-lime-500">
		<div class="container">
			<div class="flex flex-col gap-8 py-20 max-w-lg sm:gap-12">
				<header class="flex flex-col gap-6 items-start">
					<svg class="w-16 h-auto fill-red-500" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
					<h1 class="max-w-md text-4xl font-black sm:text-6xl text-slate-900"><?php esc_html_e( 'Системын алдаа', 'ulziibat-tech' ); ?></h1>
				</header>
				<div class="flex flex-col gap-8 items-start">
					<p class="text-lg text-slate-600"><?php esc_html_e( 'Вэб сайтын хэвийн ажиллагаанд шаардлагатай "Advanced Custom Fields PRO" плагин идэвхгүй байна. Систем хариуцсан админд хандана уу.', 'ulziibat-tech' ); ?></p>
				</div>
			</div>
		</div>
	</main>
</section>

<?php
get_footer();
