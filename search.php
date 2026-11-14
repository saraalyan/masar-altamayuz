<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="wrap page-pad">
	<h1 class="page-title"><?php echo esc_html( sprintf( __( 'نتائج البحث عن: %s', 'masar-altamayuz' ), get_search_query() ) ); ?></h1>
	<?php get_search_form(); ?>
	<div class="content" style="margin-top:2rem">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/card' ); } ?>
			</div>
			<div class="pager"><?php the_posts_pagination( array( 'prev_text' => '→', 'next_text' => '←' ) ); ?></div>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'ما لقيناش نتائج، جرّب كلمات تانية 🌷', 'masar-altamayuz' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php get_footer();
