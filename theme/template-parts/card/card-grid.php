<?php
/**
 * Пост лист хэлбэрээр харуулах карт.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */
?>
<article class="flex overflow-hidden flex-col bg-white rounded-sm shadow-xs shadow-slate-100 group/post-card">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" class="overflow-hidden relative bg-white rounded-sm aspect-video">
		<?php
		if ( has_post_thumbnail( get_the_ID() ) ) :
			echo get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'absolute scale-100 group-hover/post-card:scale-105 transition-transform duration-500 ease-out w-full h-full inset-0 object-cover' ) );
		endif;
		?>
	</a>
	<div class="flex flex-col gap-2 items-start p-6 w-full md:p-6 2xl:p-8 xl:gap-3 grow">
		<div class="flex gap-2 items-center">
			<?php ub_the_primary_category( 'text-[0.75rem] leading-none uppercase text-lime-600' ); ?>
			<span class="leading-none text-red-500">
				<svg class="w-1 h-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"></path></svg>
			</span>
			<?php ub_the_read_time( get_the_ID(), 'text-xs leading-none text-slate-500' ); ?>
		</div>
		<h2 class="leading-none text-xl font-black pr-4 tracking-[-0.03125rem]">
			<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" class="inline bg-bottom-left bg-linear-to-r from-lime-500 to-lime-500 bg-size-[0%_3px] bg-no-repeat group-hover/post-card:bg-size-[100%_3px] transition-[background-size] duration-500 ease-out"><?php echo esc_html( get_the_title( get_the_ID() ) ); ?></a>
		</h2>
		<?php
		if ( has_excerpt( get_the_ID() ) ) :
			?>
			<div class="text-sm font-normal leading-tight text-slate-600"><?php the_excerpt( get_the_ID() ); ?></div>
			<?php
		endif;
		?>
	</div>
</article>