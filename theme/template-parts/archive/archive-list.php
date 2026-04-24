<?php
/**
 * Архивын жагсаалыг листээр харуулдаг темплейт.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ulziibat-tech
 */
?>
<div class="flex flex-col gap-16 justify-between items-start py-16 xl:flex-row">
	<div class="flex flex-col gap-16 w-full xl:w-3/4">
		<div class="flex flex-col gap-12 lg:gap-8">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card/card', 'list' );
			endwhile;
			?>
		</div>
	
		<?php ub_the_posts_navigation(); ?>
	</div>
	<div class="flex relative flex-col items-start self-stretch w-full grow xl:max-w-64">
		<div class="sticky top-12 w-full">
			<div class="p-6 bg-white rounded-md shadow-md shadow-slate-200/20 xl:p-4">
				<h2 class="text-base font-bold leading-none sm:text-xl xl:text-sm">ChatGPT-ийн үнэгүй сургалт нэмэгдлээ!</h2>
				<p class="mt-2 text-sm leading-tight sm:text-base xl:text-xs">Та сар бүр ChatGPT-д мөнгө төлчихөөд хангалттай ашилаж чадахгүй байгаа юм шиг санагдаж байна уу? Тэгвэл танд зориулсан үнэгүй сургалтыг сонирхоорой.</p>
				<a class="flex gap-2 justify-between items-center pt-3 mt-4 border-t duration-300 group/readmore hover:gap-2.5 border-slate-100 transition-discrete text-slate-500 hover:text-lime-600 shadow-slate-100" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
					<span class="text-xs font-medium leading-none transition-colors duration-500"><?php esc_html_e( 'Сургалт үзэх', 'ulziibat-tech' ); ?></span>
					<svg class="w-4 h-4 transition-colors duration-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M1.99974 12.9999L1.9996 11L15.5858 11V5.58582L22 12L15.5858 18.4142V13L1.99974 12.9999Z"></path></svg>
				</a>
			</div>
		</div>
	</div>
</div>