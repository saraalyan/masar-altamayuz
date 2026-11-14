<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'ابحث عن منتج أو مقال…', 'masar-altamayuz' ); ?>" aria-label="<?php esc_attr_e( 'بحث', 'masar-altamayuz' ); ?>">
	<button type="submit" class="btn"><?php esc_html_e( 'بحث', 'masar-altamayuz' ); ?></button>
</form>
