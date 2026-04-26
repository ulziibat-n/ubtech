<?php declare(strict_types=1);

/**
 * Template part for displaying author archive header.
 *
 * @package ulziibat-tech
 * @since 1.0.0
 */

$site_author = get_queried_object();

if ( ! $site_author instanceof WP_User ) {
	return;
}

$site_author_id = $site_author->ID;

// ACF Custom Fields with Fallbacks.
$site_acf_name   = get_field( 'author_name', 'user_' . $site_author_id );
$site_acf_avatar = get_field( 'author_avatar', 'user_' . $site_author_id );
$site_acf_bio    = get_field( 'author_bio', 'user_' . $site_author_id );

$site_author_name        = ! empty( $site_acf_name ) ? $site_acf_name : $site_author->display_name;
$site_author_description = ! empty( $site_acf_bio ) ? $site_acf_bio : get_the_author_meta( 'description', $site_author_id );

// Avatar Logic.
if ( ! empty( $site_acf_avatar ) ) {
	$site_author_avatar = wp_get_attachment_image(
		$site_acf_avatar,
		'medium',
		false,
		array( 'class' => 'absolute inset-0 w-full h-full obect-cover' )
	);
} else {
	$site_author_avatar = get_avatar(
		$site_author_id,
		160,
		'',
		$site_author_name,
		array( 'class' => 'absolute inset-0 w-full h-full obect-cover' )
	);
}

$site_post_count = (int) count_user_posts( $site_author_id );

// Social Links Mapping.
$site_social_fields = array(
	'fb' => array(
		'name'  => 'author_fb',
		'label' => 'Facebook',
		'icon'  => '<path d="M12.001 2C6.47813 2 2.00098 6.47715 2.00098 12C2.00098 16.9913 5.65783 21.1283 10.4385 21.8785V14.8906H7.89941V12H10.4385V9.79688C10.4385 7.29063 11.9314 5.90625 14.2156 5.90625C15.3097 5.90625 16.4541 6.10156 16.4541 6.10156V8.5625H15.1931C13.9509 8.5625 13.5635 9.33334 13.5635 10.1242V12H16.3369L15.8936 14.8906H13.5635V21.8785C18.3441 21.1283 22.001 16.9913 22.001 12C22.001 6.47715 17.5238 2 12.001 2Z"></path>',
	),
	'ig' => array(
		'name'  => 'author_ig',
		'label' => 'Instagram',
		'icon'  => '<path d="M13.0281 2.00073C14.1535 2.00259 14.7238 2.00855 15.2166 2.02322L15.4107 2.02956C15.6349 2.03753 15.8561 2.04753 16.1228 2.06003C17.1869 2.1092 17.9128 2.27753 18.5503 2.52503C19.2094 2.7792 19.7661 3.12253 20.3219 3.67837C20.8769 4.2342 21.2203 4.79253 21.4753 5.45003C21.7219 6.0867 21.8903 6.81337 21.9403 7.87753C21.9522 8.1442 21.9618 8.3654 21.9697 8.58964L21.976 8.78373C21.9906 9.27647 21.9973 9.84686 21.9994 10.9723L22.0002 11.7179C22.0003 11.809 22.0003 11.903 22.0003 12L22.0002 12.2821L21.9996 13.0278C21.9977 14.1532 21.9918 14.7236 21.9771 15.2163L21.9707 15.4104C21.9628 15.6347 21.9528 15.8559 21.9403 16.1225C21.8911 17.1867 21.7219 17.9125 21.4753 18.55C21.2211 19.2092 20.8769 19.7659 20.3219 20.3217C19.7661 20.8767 19.2069 21.22 18.5503 21.475C17.9128 21.7217 17.1869 21.89 16.1228 21.94C15.8561 21.9519 15.6349 21.9616 15.4107 21.9694L15.2166 21.9757C14.7238 21.9904 14.1535 21.997 13.0281 21.9992L12.2824 22C12.1913 22 12.0973 22 12.0003 22L11.7182 22L10.9725 21.9993C9.8471 21.9975 9.27672 21.9915 8.78397 21.9768L8.58989 21.9705C8.36564 21.9625 8.14444 21.9525 7.87778 21.94C6.81361 21.8909 6.08861 21.7217 5.45028 21.475C4.79194 21.2209 4.23444 20.8767 3.67861 20.3217C3.12278 19.7659 2.78028 19.2067 2.52528 18.55C2.27778 17.9125 2.11028 17.1867 2.06028 16.1225C2.0484 15.8559 2.03871 15.6347 2.03086 15.4104L2.02457 15.2163C2.00994 14.7236 2.00327 14.1532 2.00111 13.0278L2.00098 10.9723C2.00284 9.84686 2.00879 9.27647 2.02346 8.78373L2.02981 8.58964C2.03778 8.3654 2.04778 8.1442 2.06028 7.87753C2.10944 6.81253 2.27778 6.08753 2.52528 5.45003C2.77944 4.7917 3.12278 4.2342 3.67861 3.67837C4.23444 3.12253 4.79278 2.78003 5.45028 2.52503C6.08778 2.27753 6.81278 2.11003 7.87778 2.06003C8.14444 2.04816 8.36564 2.03847 8.58989 2.03062L8.78397 2.02433C9.27672 2.00969 9.8471 2.00302 10.9725 2.00086L13.0281 2.00073ZM12.0003 7.00003C9.23738 7.00003 7.00028 9.23956 7.00028 12C7.00028 14.7629 9.23981 17 12.0003 17C14.7632 17 17.0003 14.7605 17.0003 12C17.0003 9.23713 14.7607 7.00003 12.0003 7.00003ZM12.0003 9.00003C13.6572 9.00003 15.0003 10.3427 15.0003 12C15.0003 13.6569 13.6576 15 12.0003 15C10.3434 15 9.00028 13.6574 9.00028 12C9.00028 10.3431 10.3429 9.00003 12.0003 9.00003ZM17.2503 5.50003C16.561 5.50003 16.0003 6.05994 16.0003 6.74918C16.0003 7.43843 16.5602 7.9992 17.2503 7.9992C17.9395 7.9992 18.5003 7.4393 18.5003 6.74918C18.5003 6.05994 17.9386 5.49917 17.2503 5.50003Z"></path>',
	),
	'tr' => array(
		'name'  => 'author_tr',
		'label' => 'Threads',
		'icon'  => '<path d="M12.1835 1.41016L12.1822 1.41016C9.09012 1.43158 6.70036 2.47326 5.09369 4.51569C3.66581 6.33087 2.93472 8.86436 2.91016 12.0068V12.0082C2.93472 15.1508 3.66586 17.6696 5.09369 19.4847C6.70043 21.5271 9.10257 22.5688 12.1946 22.5902H12.1958C14.944 22.5711 16.8929 21.8504 18.4985 20.2463C20.6034 18.1434 20.5408 15.5048 19.8456 13.8832C19.3163 12.6493 18.2709 11.6618 16.8701 11.0477C16.6891 8.06345 15.0097 6.32178 12.2496 6.30415C10.6191 6.29409 9.14792 7.02378 8.24685 8.39104L9.90238 9.5267C10.4353 8.71818 11.2789 8.32815 12.2371 8.33701C13.6244 8.34586 14.5362 9.11128 14.7921 10.4541C14.02 10.3333 13.1902 10.2982 12.3076 10.3488C9.66843 10.5008 7.9399 12.061 8.05516 14.2244C8.17571 16.4862 10.367 17.7186 12.4476 17.605C14.9399 17.4684 16.4209 15.6292 16.7722 13.2836C17.3493 13.6575 17.7751 14.1344 18.0163 14.6969C18.4559 15.7222 18.4838 17.4132 17.1006 18.7952C15.8838 20.0108 14.4211 20.5407 12.1891 20.5572C9.71428 20.5388 7.85698 19.746 6.65154 18.2136C5.51973 16.7748 4.92843 14.6882 4.90627 12.0002C4.92843 9.31211 5.51973 7.22549 6.65154 5.78673C7.85698 4.25433 9.71424 3.46156 12.189 3.44303C14.6819 3.4617 16.5728 4.25837 17.8254 5.79937C18.5162 6.64934 18.949 7.66539 19.2379 8.71407L21.1776 8.19656C20.8148 6.85917 20.2414 5.58371 19.363 4.50305C17.7098 2.46918 15.2816 1.43166 12.1835 1.41016ZM12.4204 12.3782C13.3044 12.3272 14.1239 12.3834 14.8521 12.5345C14.7114 14.1116 14.0589 15.4806 12.3401 15.575C11.2282 15.6376 10.1031 15.1413 10.0484 14.114C10.0077 13.3503 10.5726 12.4847 12.4204 12.3782Z"></path>',
	),
	'x'  => array(
		'name'  => 'author_x',
		'label' => 'X',
		'icon'  => '<path d="M22.2125 5.65605C21.4491 5.99375 20.6395 6.21555 19.8106 6.31411C20.6839 5.79132 21.3374 4.9689 21.6493 4.00005C20.8287 4.48761 19.9305 4.83077 18.9938 5.01461C18.2031 4.17106 17.098 3.69303 15.9418 3.69434C13.6326 3.69434 11.7597 5.56661 11.7597 7.87683C11.7597 8.20458 11.7973 8.52242 11.8676 8.82909C8.39047 8.65404 5.31007 6.99005 3.24678 4.45941C2.87529 5.09767 2.68005 5.82318 2.68104 6.56167C2.68104 8.01259 3.4196 9.29324 4.54149 10.043C3.87737 10.022 3.22788 9.84264 2.64718 9.51973C2.64654 9.5373 2.64654 9.55487 2.64654 9.57148C2.64654 11.5984 4.08819 13.2892 6.00199 13.6731C5.6428 13.7703 5.27232 13.8194 4.90022 13.8191C4.62997 13.8191 4.36771 13.7942 4.11279 13.7453C4.64531 15.4065 6.18886 16.6159 8.0196 16.6491C6.53813 17.8118 4.70869 18.4426 2.82543 18.4399C2.49212 18.4402 2.15909 18.4205 1.82812 18.3811C3.74004 19.6102 5.96552 20.2625 8.23842 20.2601C15.9316 20.2601 20.138 13.8875 20.138 8.36111C20.138 8.1803 20.1336 7.99886 20.1256 7.81997C20.9443 7.22845 21.651 6.49567 22.2125 5.65605Z"></path>',
	),
	'in' => array(
		'name'  => 'author_in',
		'label' => 'LinkedIn',
		'icon'  => '<path d="M18.3362 18.339H15.6707V14.1622C15.6707 13.1662 15.6505 11.8845 14.2817 11.8845C12.892 11.8845 12.6797 12.9683 12.6797 14.0887V18.339H10.0142V9.75H12.5747V10.9207H12.6092C12.967 10.2457 13.837 9.53325 15.1367 9.53325C17.8375 9.53325 18.337 11.3108 18.337 13.6245V18.339H18.3362ZM7.00373 8.57475C6.14573 8.57475 5.45648 7.88025 5.45648 7.026C5.45648 6.1725 6.14648 5.47875 7.00373 5.47875C7.85873 5.47875 8.55173 6.1725 8.55173 7.026C8.55173 7.88025 7.85798 8.57475 7.00373 8.57475ZM8.34023 18.339H5.66723V9.75H8.34023V18.339ZM19.6697 3H4.32923C3.59498 3 3.00098 3.5805 3.00098 4.29675V19.7033C3.00098 20.4202 3.59498 21 4.32923 21H19.6675C20.401 21 21.001 20.4202 21.001 19.7033V4.29675C21.001 3.5805 20.401 3 19.6675 3H19.6697Z"></path>',
	),
);

$site_active_socials = array();
foreach ( $site_social_fields as $site_key => $site_config ) {
	$site_url = get_field( $site_config['name'], 'user_' . $site_author_id );
	if ( ! empty( $site_url ) ) {
		$site_active_socials[ $site_key ] = array(
			'url'   => $site_url,
			'label' => $site_config['label'],
			'icon'  => $site_config['icon'],
		);
	}
}

?>

<header class="pt-16">
	<!-- Massive Vibrant Gradient Decoration -->
	<div class="absolute top-0 right-0 -mr-48 -mt-48 opacity-40 blur-[100px] pointer-events-none transition-opacity duration-1000">
		<div class="aspect-square w-[700px] rounded-full bg-linear-to-br from-lime-400 via-emerald-500 to-teal-600"></div>
	</div>
	<div class="absolute bottom-0 left-0 -ml-48 -mb-48 opacity-20 blur-[80px] pointer-events-none">
		<div class="aspect-square w-[500px] rounded-full bg-linear-to-tr from-blue-600 to-indigo-700"></div>
	</div>

	<div class="container relative z-10">
		<div class="flex flex-col gap-10 md:flex-row md:items-start">
			
			<!-- Author Image with Glassmorphism Effect -->
			<div class="overflow-hidden relative w-36 h-36 rounded-sm shrink-0">
				<?php echo $site_author_avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<!-- Content Section -->
			<div class="grow">
				<div class="flex flex-col gap-0">
					<span class="text-[0.75rem] pl-0.5 leading-none uppercase font-semibold text-lime-600"><?php esc_html_e( 'Нийтлээч', 'ulziibat-tech' ); ?></span>
					<!-- Title: Matching archive-category.php font size but white -->
					<h1 class="text-3xl font-black tracking-tight lg:h1">
						<?php echo esc_html( $site_author_name ); ?>
					</h1>
				</div>

				<!-- Description -->
				<?php if ( ! empty( $site_author_description ) ) : ?>
					<div class="py-2 mt-4 max-w-3xl text-lg leading-tight">
						<?php echo wp_kses_post( wpautop( $site_author_description ) ); ?>
					</div>
				<?php endif; ?>


				<!-- Social Links Group -->
				<?php if ( ! empty( $site_active_socials ) ) : ?>
					<div class="flex gap-3 items-center mt-4">
						<?php foreach ( $site_active_socials as $site_social ) : ?>
							<a href="<?php echo esc_url( $site_social['url'] ); ?>" 
								class=""
								target="_blank"
								rel="noopener noreferrer"
								title="<?php echo esc_attr( $site_social['label'] ); ?>">
								<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
									<?php echo $site_social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</svg>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>
