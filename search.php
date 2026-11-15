<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
global $wp_query;
$products = array();
$others   = array();
foreach ( $wp_query->posts as $p ) {
	if ( 'product' === $p->post_type ) { $products[] = $p; } else { $others[] = $p; }
}
?>
<div class="wrap page-pad">
	<?php echo masar_breadcrumbs(); // phpcs:ignore ?>
	<h1 class="page-title"><?php echo esc_html( sprintf( __( 'نتائج البحث عن: %s', 'masar-altamayuz' ), get_search_query() ) ); ?></h1>
	<?php get_search_form(); ?>
	<?php if ( have_posts() ) : ?>
		<p class="search-count"><?php echo esc_html( sprintf( _n( 'لقينا %s نتيجة', 'لقينا %s نتيجة', (int) $wp_query->found_posts, 'masar-altamayuz' ), number_format_i18n( (int) $wp_query->found_posts ) ) ); ?></p>
		<div class="content" style="margin-top:1.5rem">
			<?php if ( $products && function_exists( 'wc_get_template_part' ) ) : ?>
				<h2 class="suggest-h"><?php esc_html_e( 'المنتجات', 'masar-altamayuz' ); ?></h2>
				<div class="woocommerce">
					<?php
					wc_set_loop_prop( 'columns', 3 );
					woocommerce_product_loop_start();
					foreach ( $products as $post ) { setup_postdata( $post ); wc_get_template_part( 'content', 'product' ); }
					woocommerce_product_loop_end();
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
			<?php if ( $others ) : ?>
				<h2 class="suggest-h"><?php esc_html_e( 'مقالات وصفحات', 'masar-altamayuz' ); ?></h2>
				<div class="posts">
					<?php foreach ( $others as $post ) { setup_postdata( $post ); get_template_part( 'template-parts/card' ); } wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>
			<div class="pager"><?php the_posts_pagination( array( 'prev_text' => '→', 'next_text' => '←' ) ); ?></div>
		</div>
	<?php else : ?>
		<p class="empty"><?php esc_html_e( 'ما لقيناش نتائج، جرّبي كلمات تانية أو شوفي الاقتراحات 🌷', 'masar-altamayuz' ); ?></p>
		<?php masar_suggest_block(); ?>
	<?php endif; ?>
</div>
<?php get_footer();
