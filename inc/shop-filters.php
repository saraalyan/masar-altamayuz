<?php
/**
 * مسار التميز — شريط فلترة المتجر: التصنيف، السعر، المتوفر فقط، التخفيضات فقط.
 * بيشتغل بروابط GET عادية (من غير JS)، وبيتحط فوق قائمة المنتجات في الأرشيف.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_filters_on() {
	return class_exists( 'WooCommerce' ) && (bool) get_theme_mod( 'masar_shop_filters', 1 );
}

/** القيم الحالية بعد التنقية */
function masar_filters_get() {
	$f = array(
		'fcat'  => isset( $_GET['fcat'] ) ? sanitize_title( wp_unslash( $_GET['fcat'] ) ) : '', // phpcs:ignore
		'min'   => isset( $_GET['min_price'] ) && '' !== $_GET['min_price'] ? max( 0, (float) wp_unslash( $_GET['min_price'] ) ) : '', // phpcs:ignore
		'max'   => isset( $_GET['max_price'] ) && '' !== $_GET['max_price'] ? max( 0, (float) wp_unslash( $_GET['max_price'] ) ) : '', // phpcs:ignore
		'stock' => ! empty( $_GET['fstock'] ) ? 1 : 0, // phpcs:ignore
		'sale'  => ! empty( $_GET['fsale'] ) ? 1 : 0, // phpcs:ignore
	);
	return $f;
}

/** تطبيق الفلاتر على استعلام المنتجات */
add_action( 'woocommerce_product_query', function ( $q ) {
	if ( ! masar_filters_on() ) { return; }
	$f = masar_filters_get();
	if ( $f['fcat'] ) {
		$tax = (array) $q->get( 'tax_query' );
		$tax[] = array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $f['fcat'] );
		$q->set( 'tax_query', $tax );
	}
	if ( $f['stock'] ) {
		$meta = (array) $q->get( 'meta_query' );
		$meta[] = array( 'key' => '_stock_status', 'value' => 'instock' );
		$q->set( 'meta_query', $meta );
	}
	if ( $f['sale'] ) {
		$ids = wc_get_product_ids_on_sale();
		$q->set( 'post__in', $ids ? array_map( 'absint', $ids ) : array( 0 ) );
	}
} );

/** السعر: ووكومرس بيطبق min_price/max_price من نفسه لو الودجت شغال، فنفعّله هنا لو مش شغال */
add_action( 'woocommerce_product_query', function ( $q ) {
	if ( ! masar_filters_on() ) { return; }
	$f = masar_filters_get();
	if ( '' === $f['min'] && '' === $f['max'] ) { return; }
	$min = '' === $f['min'] ? 0 : $f['min'];
	$max = '' === $f['max'] ? PHP_INT_MAX : $f['max'];
	$meta = (array) $q->get( 'meta_query' );
	$meta[] = array( 'key' => '_price', 'value' => array( $min, $max ), 'compare' => 'BETWEEN', 'type' => 'NUMERIC' );
	$q->set( 'meta_query', $meta );
}, 20 );

/** شريط الفلترة */
function masar_filters_bar() {
	if ( ! masar_filters_on() || ! ( is_shop() || is_product_taxonomy() ) ) { return; }
	$f    = masar_filters_get();
	$base = is_shop() ? wc_get_page_permalink( 'shop' ) : get_term_link( get_queried_object() );
	if ( is_wp_error( $base ) ) { return; }
	$cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
	$cur  = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : ''; // phpcs:ignore
	$active = ( $f['fcat'] || '' !== $f['min'] || '' !== $f['max'] || $f['stock'] || $f['sale'] );
	?>
	<form class="shop-filters" method="get" action="<?php echo esc_url( $base ); ?>">
		<?php if ( $cur ) : ?><input type="hidden" name="orderby" value="<?php echo esc_attr( $cur ); ?>"><?php endif; ?>
		<?php if ( ! get_option( 'permalink_structure' ) && is_shop() ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
		<?php if ( ! empty( $cats ) && ! is_wp_error( $cats ) && is_shop() ) : ?>
		<label class="sf-f"><span><?php esc_html_e( 'التصنيف', 'masar-altamayuz' ); ?></span>
			<select name="fcat">
				<option value=""><?php esc_html_e( 'كل التصنيفات', 'masar-altamayuz' ); ?></option>
				<?php foreach ( $cats as $c ) : ?>
					<option value="<?php echo esc_attr( $c->slug ); ?>" <?php selected( $f['fcat'], $c->slug ); ?>><?php echo esc_html( $c->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<?php endif; ?>
		<label class="sf-f sf-n"><span><?php esc_html_e( 'السعر من', 'masar-altamayuz' ); ?></span><input type="number" min="0" step="any" inputmode="decimal" name="min_price" value="<?php echo esc_attr( $f['min'] ); ?>"></label>
		<label class="sf-f sf-n"><span><?php esc_html_e( 'إلى', 'masar-altamayuz' ); ?></span><input type="number" min="0" step="any" inputmode="decimal" name="max_price" value="<?php echo esc_attr( $f['max'] ); ?>"></label>
		<label class="sf-c"><input type="checkbox" name="fstock" value="1" <?php checked( $f['stock'], 1 ); ?>> <?php esc_html_e( 'المتوفر فقط', 'masar-altamayuz' ); ?></label>
		<label class="sf-c"><input type="checkbox" name="fsale" value="1" <?php checked( $f['sale'], 1 ); ?>> <?php esc_html_e( 'التخفيضات فقط', 'masar-altamayuz' ); ?></label>
		<button type="submit" class="sf-go"><?php esc_html_e( 'تطبيق', 'masar-altamayuz' ); ?></button>
		<?php if ( $active ) : ?><a class="sf-reset" href="<?php echo esc_url( $cur ? add_query_arg( 'orderby', $cur, $base ) : $base ); ?>"><?php esc_html_e( 'مسح الفلاتر', 'masar-altamayuz' ); ?></a><?php endif; ?>
	</form>
	<?php
}
add_action( 'woocommerce_before_shop_loop', 'masar_filters_bar', 15 );
