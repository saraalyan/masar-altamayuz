<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="ابحث عن ورد أو مقال…" aria-label="بحث">
	<button type="submit" class="btn">بحث</button>
</form>
