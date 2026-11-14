<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'single' ); ?>>
	<header class="single-head"><div class="wrap narrow"><?php echo masar_breadcrumbs(); // phpcs:ignore ?><h1 class="page-title"><?php the_title(); ?></h1></div></header>
	<div class="wrap narrow entry">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
		<?php if ( comments_open() ) { comments_template(); } ?>
	</div>
</article>
<?php endwhile;
get_footer();
