<?php
/**
 * Пост лист хэлбэрээр харуулах карт.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */
?>
<article class="flex flex-col max-lg:gap-4 lg:flex-row">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" class=" aspect-video rounded-sm bg-white relative overflow-hidden w-full lg:w-1/2">
		<?php
		if ( has_post_thumbnail( get_the_ID() ) ) :
			echo get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'absolute w-full h-full inset-0 object-cover' ) );
		endif;
		?>
	</a>
	<div class="w-full lg:w-1/2 lg:pl-8 flex flex-col gap-2 xl:gap-3 items-start">
		<div class="flex items-center gap-2">
			<?php ub_the_primary_category( 'text-[0.75rem] leading-none uppercase font-[400] text-lime-600' ); ?>
			<span class="text-red-500 leading-none">•</span>
			<?php ub_the_read_time( get_the_ID(), 'text-xs leading-none font-[500]] text-slate-500' ); ?>
		</div>
		<h2 class="leading-none text-xl font-black pr-4 tracking-[-0.03125rem]"><a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php echo esc_html( get_the_title( get_the_ID() ) ); ?></a></h2>
		<?php
		if ( has_excerpt( get_the_ID() ) ) :
			?>
			<div class="text-sm leading-snug text-slate-600 font-normal"><?php the_excerpt( get_the_ID() ); ?></div>
			<a class="px-3 py-1.5 rounded-lg bg-white group/readmore hover:gap-2.5 transition-discrete duration-300 text-slate-500 hover:text-lime-600 flex gap-2 items-center mt-2 shadow-xs shadow-slate-100" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
				<span class="text-xs font-semibold leading-none transition-colors duration-500"><?php esc_html_e( 'Нийтлэл унших', 'ulziibat-tech' ); ?></span>
				<svg class="w-4 h-4 transition-colors duration-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M1.99974 12.9999L1.9996 11L15.5858 11V5.58582L22 12L15.5858 18.4142V13L1.99974 12.9999Z"></path></svg>
			</a>
			<?php
		endif;
		?>
	</div>
</article>