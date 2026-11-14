<?php
/**
 * استيراد/حذف المحتوى التجريبي: صفحات + مقالات + صور + قائمة + منتجات (لو WooCommerce مفعّلة).
 * كل ما يتم إنشاؤه بيتسجّل في option 'masar_demo_ids' عشان نقدر نحذفه بأمان.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** صورة تجريبية متدرجة اللون (GD) بدون تحميل من الإنترنت */
function masar_demo_image( $seed, $w = 1000, $h = 1250 ) {
	$n   = ( abs( crc32( (string) $seed ) ) % 8 ) + 1;
	$src = get_template_directory() . '/assets/images/art-' . $n . '.jpg';
	if ( ! file_exists( $src ) ) { return 0; }
	$data = file_get_contents( $src ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	$up = wp_upload_bits( 'masar-demo-' . sanitize_file_name( (string) $seed ) . '-' . wp_rand( 1000, 9999 ) . '.jpg', null, $data );
	if ( ! empty( $up['error'] ) ) { return 0; }
	$att = wp_insert_attachment( array( 'post_mime_type' => 'image/jpeg', 'post_title' => 'masar demo ' . $seed, 'post_status' => 'inherit' ), $up['file'] );
	if ( ! $att || is_wp_error( $att ) ) { return 0; }
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $att, wp_generate_attachment_metadata( $att, $up['file'] ) );
	return (int) $att;
}

function masar_demo_import( $preset = 'fashion' ) {
	if ( get_option( 'masar_demo_ids' ) ) { return 'exists'; }
	$ids = array( 'posts' => array(), 'pages' => array(), 'att' => array(), 'terms' => array(), 'menus' => array() );

	/* مقالات */
	$cat = wp_insert_term( __( 'نصائح وأفكار', 'masar-altamayuz' ), 'category' );
	$cid = is_wp_error( $cat ) ? 0 : (int) $cat['term_id'];
	if ( $cid ) { $ids['terms'][] = array( $cid, 'category' ); }
	$titles = array( __( 'كيف تختار الإطلالة المناسبة لكل مناسبة', 'masar-altamayuz' ), __( 'أفكار لتنسيق البيت بلمسة دافئة', 'masar-altamayuz' ), __( 'دليلك لاختيار الهدية المثالية', 'masar-altamayuz' ), __( 'ثلاث خطوات لتجديد ديكور غرفتك', 'masar-altamayuz' ), __( 'اتجاهات الموسم الجديد', 'masar-altamayuz' ), __( 'العناية بالقطع لتدوم أطول', 'masar-altamayuz' ) );
	foreach ( $titles as $n => $t ) {
		$img = masar_demo_image( 'post' . $n, 1200, 900 );
		$pid = wp_insert_post( array(
			'post_title'    => $t,
			'post_status'   => 'publish',
			'post_content'  => __( 'هذا مقال تجريبي لعرض شكل المدونة في الثيم.', 'masar-altamayuz' ) . "\n\n" . str_repeat( __( 'نص تجريبي يُستبدل بمحتواك الحقيقي لاحقاً، اكتب هنا أفكارك ونصائحك لعملائك. ', 'masar-altamayuz' ), 6 ) . "\n\n" . __( 'يمكنك حذف هذا المحتوى بضغطة واحدة من استوديو مسار.', 'masar-altamayuz' ),
			'post_category' => $cid ? array( $cid ) : array(),
			'post_date'     => gmdate( 'Y-m-d H:i:s', time() - $n * DAY_IN_SECONDS ),
		) );
		if ( $pid && ! is_wp_error( $pid ) ) {
			$ids['posts'][] = (int) $pid;
			if ( $img ) { set_post_thumbnail( $pid, $img ); $ids['att'][] = $img; }
		}
	}

	/* صفحات */
	$pages = array(
		array( __( 'من نحن', 'masar-altamayuz' ), 'page-about' ), array( __( 'الأسئلة الشائعة', 'masar-altamayuz' ), 'page-faq' ), array( __( 'تواصل معنا', 'masar-altamayuz' ), 'page-contact' ),
		array( __( 'رئيسية — أزياء', 'masar-altamayuz' ), 'home-fashion' ), array( __( 'رئيسية — فخامة داكنة', 'masar-altamayuz' ), 'home-luxe' ), array( __( 'رئيسية — خدمات', 'masar-altamayuz' ), 'home-services' ), array( __( 'رئيسية — ديكور', 'masar-altamayuz' ), 'home-decor' ),
	);
	$menu_pages = array();
	foreach ( $pages as $i => $p ) {
		$pid = wp_insert_post( array( 'post_title' => $p[0], 'post_type' => 'page', 'post_status' => 'publish', 'post_content' => '', 'page_template' => 'templates/' . $p[1] . '.php' ) );
		if ( $pid && ! is_wp_error( $pid ) ) {
			$ids['pages'][] = (int) $pid;
			if ( $i < 3 ) { $menu_pages[] = array( $pid, $p[0] ); }
		}
	}

	/* قائمة */
	$mid = wp_create_nav_menu( __( 'مسار — القائمة الرئيسية', 'masar-altamayuz' ) );
	if ( $mid && ! is_wp_error( $mid ) ) {
		$ids['menus'][] = (int) $mid;
		wp_update_nav_menu_item( $mid, 0, array( 'menu-item-title' => __( 'الرئيسية', 'masar-altamayuz' ), 'menu-item-url' => home_url( '/' ), 'menu-item-type' => 'custom', 'menu-item-status' => 'publish' ) );
		foreach ( $menu_pages as $mp ) {
			wp_update_nav_menu_item( $mid, 0, array( 'menu-item-title' => $mp[1], 'menu-item-object' => 'page', 'menu-item-object-id' => $mp[0], 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		}
		$locs = get_theme_mod( 'nav_menu_locations', array() );
		$locs['primary'] = $mid;
		$locs['footer']  = $mid;
		set_theme_mod( 'nav_menu_locations', $locs );
	}

	/* منتجات WooCommerce */
	if ( class_exists( 'WC_Product_Simple' ) && taxonomy_exists( 'product_cat' ) ) {
		$cats = array();
		foreach ( array( __( 'فساتين', 'masar-altamayuz' ), __( 'حقائب', 'masar-altamayuz' ), __( 'ساعات', 'masar-altamayuz' ), __( 'ديكور', 'masar-altamayuz' ) ) as $cn ) {
			$t = wp_insert_term( $cn, 'product_cat' );
			if ( ! is_wp_error( $t ) ) {
				$cats[ $cn ] = (int) $t['term_id'];
				$ids['terms'][] = array( (int) $t['term_id'], 'product_cat' );
				$tm = masar_demo_image( 'cat' . $cn, 600, 600 );
				if ( $tm ) { update_term_meta( $t['term_id'], 'thumbnail_id', $tm ); $ids['att'][] = $tm; }
			}
		}
		$prods = array( array( __( 'فستان صيفي أنيق', 'masar-altamayuz' ), 690, __( 'فساتين', 'masar-altamayuz' ) ), array( __( 'فستان سهرة', 'masar-altamayuz' ), 1290, __( 'فساتين', 'masar-altamayuz' ) ), array( __( 'حقيبة جلد كلاسيك', 'masar-altamayuz' ), 890, __( 'حقائب', 'masar-altamayuz' ) ), array( __( 'حقيبة كتف صغيرة', 'masar-altamayuz' ), 540, __( 'حقائب', 'masar-altamayuz' ) ), array( __( 'ساعة ذهبية', 'masar-altamayuz' ), 1490, __( 'ساعات', 'masar-altamayuz' ) ), array( __( 'ساعة جلد بني', 'masar-altamayuz' ), 990, __( 'ساعات', 'masar-altamayuz' ) ), array( __( 'مزهرية سيراميك', 'masar-altamayuz' ), 320, __( 'ديكور', 'masar-altamayuz' ) ), array( __( 'شمعة معطرة', 'masar-altamayuz' ), 180, __( 'ديكور', 'masar-altamayuz' ) ) );
		foreach ( $prods as $n => $pr ) {
			$p = new WC_Product_Simple();
			$p->set_name( $pr[0] );
			$p->set_status( 'publish' );
			$p->set_regular_price( (string) $pr[1] );
			if ( isset( $cats[ $pr[2] ] ) ) { $p->set_category_ids( array( $cats[ $pr[2] ] ) ); }
			$im = masar_demo_image( 'prod' . $n, 800, 1000 );
			if ( $im ) { $p->set_image_id( $im ); $ids['att'][] = $im; }
			$pid = $p->save();
			if ( $pid ) { $ids['posts'][] = (int) $pid; }
		}
	}

	if ( isset( masar_presets()[ $preset ] ) ) { set_theme_mod( 'masar_home_preset', $preset ); }
	update_option( 'masar_demo_ids', $ids, false );
	return 'imported';
}

function masar_demo_remove() {
	$ids = get_option( 'masar_demo_ids' );
	if ( ! is_array( $ids ) ) { return 'none'; }
	foreach ( array( 'posts', 'pages', 'att' ) as $k ) { foreach ( (array) $ids[ $k ] as $id ) { wp_delete_post( (int) $id, true ); } }
	foreach ( (array) $ids['terms'] as $t ) { wp_delete_term( (int) $t[0], $t[1] ); }
	foreach ( (array) $ids['menus'] as $m ) { wp_delete_nav_menu( (int) $m ); }
	$locs = get_theme_mod( 'nav_menu_locations', array() );
	unset( $locs['primary'], $locs['footer'] );
	set_theme_mod( 'nav_menu_locations', $locs );
	delete_option( 'masar_demo_ids' );
	return 'removed';
}

if ( is_admin() ) {
	add_action( 'admin_post_masar_demo', function () {
		if ( ! current_user_can( 'manage_options' ) ) { wp_die( __( 'غير مسموح', 'masar-altamayuz' ) ); }
		check_admin_referer( 'masar_demo' );
		$do  = isset( $_POST['do'] ) ? sanitize_key( wp_unslash( $_POST['do'] ) ) : '';
		$pre = isset( $_POST['preset'] ) ? sanitize_key( wp_unslash( $_POST['preset'] ) ) : 'fashion';
		@set_time_limit( 300 ); // phpcs:ignore
		$res = ( 'remove' === $do ) ? masar_demo_remove() : masar_demo_import( $pre );
		wp_safe_redirect( admin_url( 'themes.php?page=masar-studio&tab=demo&msg=' . $res ) );
		exit;
	} );

	function masar_studio_demo_tab() {
		$has = (bool) get_option( 'masar_demo_ids' );
		echo '<div style="max-width:680px;margin-top:16px">';
		$b = array( 'b' => array() );
		echo '<p>' . wp_kses( __( 'بضغطة واحدة بنضيف: <b>7 صفحات</b> (من نحن، الأسئلة، تواصل + 4 رئيسيات)، <b>6 مقالات بصور</b>، <b>قائمة رئيسية وقائمة فوتر</b>', 'masar-altamayuz' ), $b )
			. ( class_exists( 'WC_Product_Simple' ) ? wp_kses( __( '، و<b>8 منتجات + 4 تصنيفات</b> (WooCommerce)', 'masar-altamayuz' ), $b ) : esc_html__( ' (ولو فعّلتي WooCommerce قبل الاستيراد هنضيف منتجات كمان)', 'masar-altamayuz' ) )
			. esc_html__( '. الصور بتتولّد محلياً بألوان هادئة وتقدري تغيريها بعدين.', 'masar-altamayuz' ) . '</p>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		wp_nonce_field( 'masar_demo' );
		echo '<input type="hidden" name="action" value="masar_demo">';
		if ( ! $has ) {
			echo '<p><label>' . esc_html__( 'تصميم الصفحة الرئيسية: ', 'masar-altamayuz' ) . '<select name="preset">';
			foreach ( masar_presets() as $k => $p ) { echo '<option value="' . esc_attr( $k ) . '">' . esc_html( $p['label'] ) . '</option>'; }
			echo '</select></label></p><p><button class="button button-primary button-large" name="do" value="import">' . esc_html__( '⬇️ استيراد المحتوى التجريبي', 'masar-altamayuz' ) . '</button></p>';
		} else {
			echo '<p><b>' . esc_html__( 'المحتوى التجريبي مستورد.', 'masar-altamayuz' ) . '</b>' . esc_html__( ' الحذف بيشيل اللي اتضاف بالاستيراد بس (مش أي محتوى كتبتيه إنتي).', 'masar-altamayuz' ) . '</p><p><button class="button button-large" name="do" value="remove" onclick="return confirm(' . esc_attr( wp_json_encode( __( 'حذف كل المحتوى التجريبي؟', 'masar-altamayuz' ) ) ) . ')">' . esc_html__( '🗑️ حذف المحتوى التجريبي', 'masar-altamayuz' ) . '</button></p>';
		}
		echo '</form></div>';
	}
}
