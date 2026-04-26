<?php
/**
 * Пост лист хэлбэрээр харуулах карт.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */
?>
<article class="flex flex-col max-lg:gap-4 lg:flex-row group/post-card">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" class="overflow-hidden relative w-full bg-white rounded-sm aspect-video lg:w-1/2">
		<?php
		if ( has_post_thumbnail( get_the_ID() ) ) :
			echo get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'absolute scale-100 group-hover/post-card:scale-105 transition-transform duration-500 ease-out w-full h-full inset-0 object-cover absolute w-full h-full inset-0 object-cover' ) );
		endif;
		?>
	</a>
	<div class="flex flex-col gap-2 items-start w-full lg:w-1/2 lg:pl-8 xl:gap-3">
		<div class="flex gap-2 items-center">
			<?php ub_the_primary_category( 'text-[0.75rem] leading-none uppercase text-lime-600' ); ?>
			<span class="leading-none text-red-500">
				<svg class="w-1 h-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"></path></svg>
			</span>
			<?php ub_the_read_time( get_the_ID(), 'text-xs leading-none text-slate-500' ); ?>
		</div>
		<h2 class="leading-none text-xl font-black pr-4 tracking-[-0.03125rem]">
			<a class="inline bg-bottom-left bg-linear-to-r from-lime-500 to-lime-500 bg-size-[0%_3px] bg-no-repeat group-hover/post-card:bg-size-[100%_3px] transition-[background-size] duration-500 ease-out" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php echo esc_html( get_the_title( get_the_ID() ) ); ?></a>
		</h2>
		<?php
		if ( has_excerpt( get_the_ID() ) ) :
			?>
			<div class="text-sm font-normal leading-snug text-slate-600"><?php the_excerpt( get_the_ID() ); ?></div>
			<a class="flex gap-2 items-center px-3 py-1.5 mt-2 bg-white rounded-lg duration-300 group/readmore hover:gap-2.5 transition-discrete text-slate-500 hover:text-lime-600 shadow-xs shadow-slate-100" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
				<span class="text-xs font-semibold leading-none transition-colors duration-500"><?php esc_html_e( 'Нийтлэл унших', 'ulziibat-tech' ); ?></span>
				<svg class="w-4 h-4 transition-colors duration-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M1.99974 12.9999L1.9996 11L15.5858 11V5.58582L22 12L15.5858 18.4142V13L1.99974 12.9999Z"></path></svg>
			</a>
			<?php
		endif;
		?>
	</div>
</article>