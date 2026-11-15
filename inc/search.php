<?php
/**
 * مسار التميز — البحث و404: البحث بيشمل المنتجات والصفحات، وصفحات «مفيش نتيجة» بتقترح تصنيفات وأحدث المنتجات/المقالات.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() || ! $q->is_search() ) { return; }
	$types = array( 'post', 'page' );
	if ( class_exists( 'WooCommerce' ) ) { $types[] = 'product'; }
	if ( ! $q->get( 'post_type' ) || 'any' === $q->get( 'post_type' ) ) { $q->set( 'post_type', $types ); }
} );

/** اقتراحات: تصنيفات + أحدث 3 منتجات (أو مقالات) */
function masar_suggest_block() {
	$shop = class_exists( 'WooCommerce' );
	$terms = get_terms( array( 'taxonomy' => $shop ? 'product_cat' : 'category', 'hide_empty' => true, 'number' => 8, 'exclude' => $shop ? array( (int) get_option( 'default_product_cat' ) ) : array( (int) get_option( 'default_category' ) ) ) );
	echo '<div class="suggest">';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		echo '<h2 class="suggest-h">' . esc_html__( 'تصفّحي حسب التصنيف', 'masar-altamayuz' ) . '</h2><div class="suggest-chips">';
		foreach ( $terms as $t ) { echo '<a class="chip" href="' . esc_url( get_term_link( $t ) ) . '">' . esc_html( $t->name ) . '</a>'; }
		echo '</div>';
	}
	$q = new WP_Query( array( 'post_type' => $shop ? 'product' : 'post', 'posts_per_page' => 3, 'post_status' => 'publish', 'no_found_rows' => true, 'ignore_sticky_posts' => true ) );
	if ( $q->have_posts() ) {
		echo '<h2 class="suggest-h">' . esc_html( $shop ? __( 'جديدنا', 'masar-altamayuz' ) : __( 'أحدث المقالات', 'masar-altamayuz' ) ) . '</h2>';
		if ( $shop ) {
			echo '<div class="woocommerce">';
			wc_set_loop_prop( 'columns', 3 );
			woocommerce_product_loop_start();
			while ( $q->have_posts() ) { $q->the_post(); wc_get_template_part( 'content', 'product' ); }
			woocommerce_product_loop_end();
			echo '</div>';
		} else {
			echo '<div class="posts">';
			while ( $q->have_posts() ) { $q->the_post(); get_template_part( 'template-parts/card' ); }
			echo '</div>';
		}
		wp_reset_postdata();
	}
	echo '</div>';
}
