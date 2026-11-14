<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="wrap page-pad">
	<header class="archive-head">
		<h1 class="page-title"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<p class="archive-desc">', '</p>' ); ?>
	</header>
	<div class="layout<?php echo is_active_sidebar( 'sidebar-1' ) ? ' has-side' : ''; ?>">
		<div class="content">
			<?php if ( have_posts() ) : ?>
				<div class="posts">
					<?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/card' ); } ?>
				</div>
				<div class="pager"><?php the_posts_pagination( array( 'prev_text' => '→', 'next_text' => '←' ) ); ?></div>
			<?php else : ?>
				<p class="empty"><?php esc_html_e( 'لا توجد نتائج.', 'masar-altamayuz' ); ?></p>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer();
