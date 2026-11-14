<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="wrap page-pad woo-wrap">
	<div class="layout<?php echo esc_attr( masar_layout_class( 'shop' ) ); ?>">
		<div class="content"><?php woocommerce_content(); ?></div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer();
