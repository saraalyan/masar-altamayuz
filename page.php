<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
if ( ! masar_elementor_location( 'single' ) ) :
while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'single' ); ?>>
	<?php if ( ! masar_is_elementor_page() ) : ?>
	<header class="single-head"><div class="wrap narrow"><?php echo masar_breadcrumbs(); // phpcs:ignore ?><h1 class="page-title"><?php the_title(); ?></h1></div></header>
	<?php endif; ?>
	<?php masar_entry_open( 'page' ); ?>
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
		<?php if ( comments_open() ) { comments_template(); } ?>
	<?php masar_entry_close( 'page' ); ?>
</article>
<?php endwhile;
endif;
get_footer();
