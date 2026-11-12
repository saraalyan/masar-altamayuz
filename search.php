<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="wrap page-pad">
	<h1 class="page-title">نتائج البحث عن: <?php echo esc_html( get_search_query() ); ?></h1>
	<?php get_search_form(); ?>
	<div class="content" style="margin-top:2rem">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/card' ); } ?>
			</div>
			<div class="pager"><?php the_posts_pagination( array( 'prev_text' => '→', 'next_text' => '←' ) ); ?></div>
		<?php else : ?>
			<p class="empty">ما لقيناش نتائج، جرّب كلمات تانية 🌷</p>
		<?php endif; ?>
	</div>
</div>
<?php get_footer();
