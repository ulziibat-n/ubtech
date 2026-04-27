<?php
/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'relative' ); ?>>
	<header class="flex overflow-hidden relative flex-col justify-end items-start w-full bg-lime-600 min-h-200">
		<?php
		if ( function_exists( 'get_field' ) && 'full' === get_field( 'featured_image_type' ) && has_post_thumbnail() ) {
			the_post_thumbnail( 'full', array( 'class' => 'absolute w-full h-full inset-0 object-cover z-0' ) );
		} else {
			?>
			<div class="absolute inset-0 z-10 w-full h-full bg-lime-600"></div>
			<?php
		}
		?>
		<div class="overflow-hidden relative pt-64 pb-16 w-full">
			<?php
			if ( function_exists( 'get_field' ) && 'full' === get_field( 'featured_image_type' ) && has_post_thumbnail() ) {
				?>
				<div class="absolute inset-0 w-full h-full to-transparent z-11 bg-linear-to-t from-slate-950/80"></div>
				<?php
			}
			?>
						<div class="container flex relative z-20 flex-col gap-4 items-start">
				<div class="flex gap-2 items-center">
					<?php ub_the_primary_category( 'text-sm leading-none uppercase font-medium text-white' ); ?>
					<span class="leading-none text-white">
						<svg class="w-1 h-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"></path></svg>
					</span>
					<?php ub_the_read_time( get_the_ID(), 'text-sm leading-none font-medium text-white' ); ?>
				</div>
				<h1 class="max-w-7xl text-2xl font-black leading-none text-white sm:text-3xl lg:text-5xl xl:text-6xl"><?php the_title(); ?></h1>
				<?php
				if ( has_excerpt() ) :
					?>
					<div class="max-w-3xl text-lg leading-tight text-white">
						<?php the_excerpt(); ?>
					</div>
					<?php
				endif;
				?>
				<div class="flex flex-col gap-1 items-start mt-2 text-xs font-medium leading-none text-white uppercase opacity-70">
					<div class="flex gap-2 items-center">
						<span><?php esc_html_e( 'Нийтэлсэн:', 'ulziibat-tech' ); ?></span>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</div>
					<?php
					$published_time = get_the_time( 'U' );
					$modified_time  = get_the_modified_time( 'U' );
					$seven_days     = 7 * 24 * 60 * 60;

					if ( $modified_time > ( $published_time + $seven_days ) ) :
						?>
						<div class="flex gap-2 items-center">
							<span><?php esc_html_e( 'Шинэчлэгдсэн:', 'ulziibat-tech' ); ?></span>
							<time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date() ); ?></time>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
	</header><!-- .entry-header -->

	<div class="py-16">
		<div class="container">
			<div class="flex gap-24 justify-between">
				<div class="w-full xl:max-w-3xl">
					<div data-post-content class="w-full content-single">
						<?php
						the_content();
						?>
					</div>
					<?php
					$site_author_id = get_the_author_meta( 'ID' );

					// ACF Custom Fields with Fallbacks.
					$site_acf_name   = '';
					$site_acf_avatar = '';
					$site_acf_bio    = '';

					if ( function_exists( 'get_field' ) ) {
						$site_acf_name   = get_field( 'author_name', 'user_' . $site_author_id );
						$site_acf_avatar = get_field( 'author_avatar', 'user_' . $site_author_id );
						$site_acf_bio    = get_field( 'author_bio', 'user_' . $site_author_id );
					}

					$site_author_name        = ! empty( $site_acf_name ) ? $site_acf_name : get_the_author_meta( 'display_name', $site_author_id );
					$site_author_description = ! empty( $site_acf_bio ) ? $site_acf_bio : get_the_author_meta( 'description', $site_author_id );

					// Avatar Logic.
					if ( ! empty( $site_acf_avatar ) ) {
						$site_author_avatar = wp_get_attachment_image(
							$site_acf_avatar,
							'medium',
							false,
							array( 'class' => 'absolute inset-0 w-full h-full object-cover' )
						);
					} else {
						$site_author_avatar = get_avatar(
							$site_author_id,
							160,
							'',
							$site_author_name,
							array( 'class' => 'absolute inset-0 w-full h-full object-cover' )
						);
					}

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
					);

					$site_active_socials = array();
					if ( function_exists( 'get_field' ) ) {
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
					}
					?>

					<div class="flex flex-col gap-10 pt-16 mt-16 border-t md:flex-row md:items-start border-slate-200">
							
						<!-- Author Image -->
						<div class="overflow-hidden relative w-36 h-36 rounded-sm shrink-0">
							<?php echo $site_author_avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>

						<!-- Content Section -->
						<div class="grow">
							<div class="flex flex-col gap-0">
								<span class="text-[0.75rem] pl-0.5 leading-none uppercase font-semibold text-lime-600"><?php esc_html_e( 'Нийтлээч', 'ulziibat-tech' ); ?></span>
								<h3 class="text-3xl font-black tracking-tight text-slate-900">
									<?php echo esc_html( $site_author_name ); ?>
								</h3>
							</div>

							<!-- Description -->
							<?php if ( ! empty( $site_author_description ) ) : ?>
								<div class="py-2 mt-4 max-w-3xl text-lg leading-tight text-slate-600">
									<?php echo wp_kses_post( wpautop( $site_author_description ) ); ?>
								</div>
							<?php endif; ?>


							<!-- Social Links Group -->
							<?php if ( ! empty( $site_active_socials ) ) : ?>
								<div class="flex gap-4 items-center mt-4">
									<?php foreach ( $site_active_socials as $site_social ) : ?>
										<a href="<?php echo esc_url( $site_social['url'] ); ?>" 
											class="transition-colors hover:text-lime-600"
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
				<div class="hidden flex-col items-end w-full max-w-sm xl:flex">
					<div data-post-toc class="sticky top-24 invisible p-4 w-full bg-white rounded-md shadow-md opacity-0 transition-all duration-500 shadow-slate-200/20 xl:p-8">
						<h4 class="text-base font-bold leading-none sm:text-xl xl:text-sm"><?php echo esc_html__( 'Нийтлэлийн агуулга', 'ulziibat-tech' ); ?></h4>
						<ul data-post-toc-list class="p-0 mt-2">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php
$categories = get_the_category( get_the_ID() );
if ( $categories ) {
	$category_ids = array();
	foreach ( $categories as $category ) {
		$category_ids[] = $category->term_id;
	}

	$related_query = new WP_Query(
		array(
			'category__in'   => $category_ids,
			'post__not_in'   => array( get_the_ID() ),
			'posts_per_page' => 6,
			'no_found_rows'  => true,
		)
	);

	if ( $related_query->have_posts() ) :
		?>
		<section class="overflow-hidden bg-slate-50">
			<div class="container">
				<div class="py-16">
					<div class="flex flex-col gap-8 justify-between items-start mb-10 w-full sm:flex-row sm:items-end">
						<div class="flex flex-col gap-0">
							<span class="text-[0.75rem] font-semibold leading-none uppercase text-lime-600"><?php esc_html_e( 'Санал болгох', 'ulziibat-tech' ); ?></span>
							<h2 class="text-4xl font-black tracking-tight leading-none text-slate-900"><?php esc_html_e( 'Холбоотой нийтлэлүүд', 'ulziibat-tech' ); ?></h2>
						</div>
						<!-- Swiper Navigation -->
						<div class="flex gap-2">
							<button data-related-prev class="flex justify-center items-center w-12 h-12 bg-white rounded-full shadow-md transition-colors cursor-pointer shadow-slate-200/20 text-slate-400 hover:border-lime-500 hover:text-lime-600">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
							</button>
							<button data-related-next class="flex justify-center items-center w-12 h-12 bg-white rounded-full shadow-md transition-colors cursor-pointer shadow-slate-200/20 text-slate-400 hover:border-lime-500 hover:text-lime-600">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
							</button>
						</div>
					</div>
					<!-- Swiper -->
					<div data-related-slider class="overflow-visible! swiper group">
						<div class="swiper-wrapper gap-[10px] group-[.swiper-initialized]:gap-0">
							<?php
							while ( $related_query->have_posts() ) :
								$related_query->the_post();
								?>
								<div class="h-auto swiper-slide max-w-[20rem]">
									<?php
									get_template_part(
										'template-parts/card/card',
										'carousel',
										array( 'class' => 'h-full w-full' )
									);
									?>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
		wp_reset_postdata();
	endif;
}
?>
