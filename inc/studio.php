<?php
/**
 * استوديو مسار: تعديل السكاشن (إظهار/إخفاء، ترتيب، نصوص) من لوحة التحكم.
 * التعديلات تتخزن في option لكل قالب وتتطبّق فوق الإعدادات الافتراضية في presets.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** مواصفات الحقول القابلة للتعديل لكل سكشن */
function masar_section_specs() {
	$t = function ( $n, $hint ) { return array( 'type' => 'tuple', 'n' => $n, 'hint' => $hint ); };
	return array(
		'hero'           => array( 'label' => __( 'الهيرو (الواجهة الرئيسية)', 'masar-altamayuz' ), 'fields' => array( 'eyebrow' => __( 'عبارة صغيرة', 'masar-altamayuz' ), 'title' => __( 'العنوان', 'masar-altamayuz' ), 'subtitle' => __( 'النص الفرعي', 'masar-altamayuz' ), 'btn1' => __( 'نص الزر 1', 'masar-altamayuz' ), 'btn1_url' => __( 'رابط الزر 1', 'masar-altamayuz' ), 'btn2' => __( 'نص الزر 2', 'masar-altamayuz' ), 'btn2_url' => __( 'رابط الزر 2', 'masar-altamayuz' ), 'image' => __( 'رابط الصورة', 'masar-altamayuz' ) ) ),
		'features'       => array( 'label' => __( 'شريط المميزات', 'masar-altamayuz' ), 'fields' => array(), 'items' => $t( 3, __( 'إيموجي | العنوان | الوصف', 'masar-altamayuz' ) ) ),
		'cats-circles'   => array( 'label' => __( 'تصنيفات دائرية', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ) ), 'items' => array( 'type' => 'assoc', 'keys' => array( 'label', 'emoji' ), 'hint' => __( 'الاسم | إيموجي (يتجاهل لو عندك تصنيفات حقيقية)', 'masar-altamayuz' ) ) ),
		'cats-cards'     => array( 'label' => __( 'تصنيفات ككروت', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ) ), 'items' => array( 'type' => 'assoc', 'keys' => array( 'label', 'emoji' ), 'hint' => __( 'الاسم | إيموجي', 'masar-altamayuz' ) ) ),
		'products'       => array( 'label' => __( 'المنتجات', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'subtitle' => __( 'النص الفرعي', 'masar-altamayuz' ), 'btn' => __( 'نص الزر', 'masar-altamayuz' ), 'count' => __( 'عدد المنتجات', 'masar-altamayuz' ) ) ),
		'promo-banners'  => array( 'label' => __( 'بانرات ترويجية', 'masar-altamayuz' ), 'fields' => array(), 'items' => array( 'type' => 'assoc', 'keys' => array( 'kicker', 'title', 'text', 'badge', 'btn', 'tone', 'emoji', 'image' ), 'hint' => __( 'عنوان صغير | العنوان | الوصف | شارة | نص الزر | اللون (dark/mocha/sand) | إيموجي | رابط صورة', 'masar-altamayuz' ) ) ),
		'feature-banner' => array( 'label' => __( 'بانر المجموعة الكبير', 'masar-altamayuz' ), 'fields' => array( 'kicker' => __( 'عنوان صغير', 'masar-altamayuz' ), 'title' => __( 'العنوان', 'masar-altamayuz' ), 'text' => __( 'الوصف', 'masar-altamayuz' ), 'btn' => __( 'نص الزر', 'masar-altamayuz' ), 'url' => __( 'رابط الزر', 'masar-altamayuz' ), 'image' => __( 'رابط صورة الخلفية', 'masar-altamayuz' ) ) ),
		'testimonials'   => array( 'label' => __( 'آراء العملاء', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'kicker' => __( 'عنوان صغير', 'masar-altamayuz' ) ), 'items' => $t( 2, __( 'الاسم | الرأي', 'masar-altamayuz' ) ) ),
		'gallery'        => array( 'label' => __( 'معرض (إنستجرام/مشاريع)', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'kicker' => __( 'عنوان صغير', 'masar-altamayuz' ), 'handle' => __( 'حساب إنستجرام', 'masar-altamayuz' ), 'images' => __( 'صور المعرض (6 أو 12 صورة، صورة في كل سطر)', 'masar-altamayuz' ) ) ),
		'newsletter'     => array( 'label' => __( 'النشرة البريدية', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'text' => __( 'النص', 'masar-altamayuz' ) ) ),
		'brands'         => array( 'label' => __( 'شريط العلامات', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ) ), 'items' => array( 'type' => 'strings', 'hint' => __( 'اسم في كل سطر', 'masar-altamayuz' ) ) ),
		'services'       => array( 'label' => __( 'الخدمات', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'kicker' => __( 'عنوان صغير', 'masar-altamayuz' ) ), 'items' => $t( 3, __( 'إيموجي | الخدمة | الوصف', 'masar-altamayuz' ) ) ),
		'process'        => array( 'label' => __( 'خطوات العمل', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'kicker' => __( 'عنوان صغير', 'masar-altamayuz' ) ), 'items' => $t( 2, __( 'الخطوة | الوصف', 'masar-altamayuz' ) ) ),
		'about'          => array( 'label' => __( 'من نحن', 'masar-altamayuz' ), 'fields' => array( 'kicker' => __( 'عنوان صغير', 'masar-altamayuz' ), 'title' => __( 'العنوان', 'masar-altamayuz' ), 'text' => __( 'النص', 'masar-altamayuz' ), 'btn' => __( 'نص الرابط', 'masar-altamayuz' ), 'url' => __( 'رابط', 'masar-altamayuz' ), 'image' => __( 'رابط الصورة', 'masar-altamayuz' ) ) ),
		'stats'          => array( 'label' => __( 'الإحصائيات', 'masar-altamayuz' ), 'fields' => array(), 'items' => $t( 2, __( 'الرقم | الوصف', 'masar-altamayuz' ) ) ),
		'faq'            => array( 'label' => __( 'الأسئلة الشائعة', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ) ), 'items' => $t( 2, __( 'السؤال | الجواب', 'masar-altamayuz' ) ), 'default_items' => 'faq' ),
		'cta'            => array( 'label' => __( 'دعوة للتواصل', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'text' => __( 'النص', 'masar-altamayuz' ), 'btn' => __( 'نص الزر', 'masar-altamayuz' ), 'url' => __( 'رابط الزر', 'masar-altamayuz' ) ) ),
		'journal'        => array( 'label' => __( 'المدونة', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'subtitle' => __( 'النص', 'masar-altamayuz' ) ) ),
		'contact'        => array( 'label' => __( 'وسائل التواصل', 'masar-altamayuz' ), 'fields' => array( 'title' => __( 'العنوان', 'masar-altamayuz' ), 'subtitle' => __( 'النص', 'masar-altamayuz' ) ) ),
	);
}

function masar_items_to_text( $items, $spec ) {
	$lines = array();
	foreach ( (array) $items as $it ) {
		if ( 'strings' === $spec['type'] ) { $lines[] = (string) $it; continue; }
		if ( 'assoc' === $spec['type'] ) {
			$row = array();
			foreach ( $spec['keys'] as $k ) { $row[] = isset( $it[ $k ] ) ? $it[ $k ] : ''; }
			$lines[] = rtrim( implode( ' | ', $row ), ' |' );
			continue;
		}
		$lines[] = implode( ' | ', array_values( (array) $it ) );
	}
	return implode( "\n", $lines );
}

function masar_items_from_text( $text, $spec ) {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) { continue; }
		if ( 'strings' === $spec['type'] ) { $out[] = $line; continue; }
		$parts = array_map( 'trim', explode( '|', $line ) );
		if ( 'assoc' === $spec['type'] ) {
			$row = array();
			foreach ( $spec['keys'] as $i => $k ) { $row[ $k ] = isset( $parts[ $i ] ) ? $parts[ $i ] : ''; }
			$out[] = $row;
		} else {
			$out[] = array_pad( $parts, (int) $spec['n'], '' );
		}
	}
	return $out;
}

/** تطبيق التعديلات المحفوظة على قالب */
function masar_apply_layout( $sections, $key ) {
	$saved = get_option( 'masar_layout_' . $key );
	if ( ! is_array( $saved ) || ! $saved ) { return $sections; }
	$specs = masar_section_specs();
	$out   = array();
	$used  = array();
	foreach ( $saved as $row ) {
		$i = isset( $row['idx'] ) ? (int) $row['idx'] : -1;
		if ( ! isset( $sections[ $i ] ) || isset( $used[ $i ] ) ) { continue; }
		$used[ $i ] = true;
		if ( empty( $row['on'] ) ) { continue; }
		$name = $sections[ $i ][0];
		$args = isset( $sections[ $i ][1] ) ? $sections[ $i ][1] : array();
		if ( ! empty( $row['args'] ) && is_array( $row['args'] ) ) {
			foreach ( $row['args'] as $k => $v ) { if ( '' !== $v ) { $args[ $k ] = $v; } }
		}
		if ( ! empty( $row['items'] ) && isset( $specs[ $name ]['items'] ) ) {
			$args['items'] = masar_items_from_text( $row['items'], $specs[ $name ]['items'] );
		}
		$out[] = array( $name, $args );
	}
	foreach ( $sections as $i => $s ) { if ( ! isset( $used[ $i ] ) ) { $out[] = $s; } }
	return $out;
}
add_filter( 'masar_preset_sections', 'masar_apply_layout', 10, 2 );

/* ====================== واجهة لوحة التحكم ====================== */
if ( is_admin() ) {

	add_action( 'admin_menu', function () {
		add_theme_page( __( 'استوديو مسار التميز', 'masar-altamayuz' ), __( '✨ استوديو مسار', 'masar-altamayuz' ), 'manage_options', 'masar-studio', 'masar_studio_page' );
	} );

	/** مكتبة الوسائط وسكربت اختيار الصور في صفحة الاستوديو بس */
	add_action( 'admin_enqueue_scripts', function ( $hook ) {
		if ( 'appearance_page_masar-studio' !== $hook ) { return; }
		wp_enqueue_media();
		wp_enqueue_script( 'masar-studio', get_template_directory_uri() . '/assets/js/studio.js', array(), MASAR_VER, true );
	} );

	/** حفظ ترتيب وتعديلات السكاشن */
	add_action( 'admin_post_masar_save_layout', function () {
		if ( ! current_user_can( 'manage_options' ) ) { wp_die( __( 'غير مسموح', 'masar-altamayuz' ) ); }
		check_admin_referer( 'masar_layout' );
		$presets = masar_presets();
		$key     = isset( $_POST['preset'] ) ? sanitize_key( wp_unslash( $_POST['preset'] ) ) : '';
		if ( ! isset( $presets[ $key ] ) ) { wp_die( __( 'قالب غير معروف', 'masar-altamayuz' ) ); }
		$specs   = masar_section_specs();
		$defaults = $presets[ $key ]['sections'];
		$order   = isset( $_POST['order'] ) ? array_map( 'intval', (array) wp_unslash( $_POST['order'] ) ) : array();
		$rows    = isset( $_POST['layout'] ) ? (array) wp_unslash( $_POST['layout'] ) : array();
		$saved   = array();
		foreach ( $order as $i ) {
			if ( ! isset( $defaults[ $i ], $rows[ $i ] ) ) { continue; }
			$name = $defaults[ $i ][0];
			$r    = (array) $rows[ $i ];
			$args = array();
			if ( ! empty( $specs[ $name ]['fields'] ) && ! empty( $r['args'] ) ) {
				foreach ( $specs[ $name ]['fields'] as $fk => $fl ) {
					if ( ! isset( $r['args'][ $fk ] ) ) { continue; }
					$v = (string) $r['args'][ $fk ];
					if ( 'images' === $fk ) { $v = implode( "\n", array_filter( array_map( 'esc_url_raw', preg_split( '/\s+/', trim( $v ), -1, PREG_SPLIT_NO_EMPTY ) ) ) ); }
					elseif ( in_array( $fk, array( 'text' ), true ) ) { $v = sanitize_textarea_field( $v ); }
					elseif ( false !== strpos( $fk, 'url' ) || 'image' === $fk ) { $v = esc_url_raw( $v ); }
					elseif ( 'count' === $fk ) { $v = $v === '' ? '' : (string) max( 1, min( 24, (int) $v ) ); }
					else { $v = sanitize_text_field( $v ); }
					if ( '' !== $v ) { $args[ $fk ] = $v; }
				}
			}
			$items = '';
			if ( isset( $specs[ $name ]['items'], $r['items'] ) ) {
				$items = sanitize_textarea_field( (string) $r['items'] );
				$orig  = isset( $defaults[ $i ][1]['items'] ) ? $defaults[ $i ][1]['items'] : ( isset( $specs[ $name ]['default_items'] ) ? masar_faq_defaults() : array() );
				if ( trim( $items ) === trim( masar_items_to_text( $orig, $specs[ $name ]['items'] ) ) ) { $items = ''; }
			}
			$saved[] = array( 'idx' => $i, 'on' => empty( $r['on'] ) ? 0 : 1, 'args' => $args, 'items' => $items );
		}
		update_option( 'masar_layout_' . $key, $saved, false );
		wp_safe_redirect( admin_url( 'themes.php?page=masar-studio&preset=' . $key . '&msg=saved' ) );
		exit;
	} );

	add_action( 'admin_post_masar_reset_layout', function () {
		if ( ! current_user_can( 'manage_options' ) ) { wp_die( __( 'غير مسموح', 'masar-altamayuz' ) ); }
		check_admin_referer( 'masar_layout' );
		$key = isset( $_POST['preset'] ) ? sanitize_key( wp_unslash( $_POST['preset'] ) ) : '';
		delete_option( 'masar_layout_' . $key );
		wp_safe_redirect( admin_url( 'themes.php?page=masar-studio&preset=' . $key . '&msg=reset' ) );
		exit;
	} );

	/** صفحة الاستوديو */
	function masar_studio_page() {
		if ( ! current_user_can( 'manage_options' ) ) { return; }
		$presets = masar_presets();
		$key     = isset( $_GET['preset'] ) ? sanitize_key( wp_unslash( $_GET['preset'] ) ) : get_theme_mod( 'masar_home_preset', 'fashion' ); // phpcs:ignore WordPress.Security.NonceVerification
		if ( ! isset( $presets[ $key ] ) ) { $key = 'fashion'; }
		$tab   = ( isset( $_GET['tab'] ) && 'demo' === $_GET['tab'] ) ? 'demo' : 'layout'; // phpcs:ignore WordPress.Security.NonceVerification
		$msg   = isset( $_GET['msg'] ) ? sanitize_key( wp_unslash( $_GET['msg'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
		$base  = admin_url( 'themes.php?page=masar-studio' );
		$notes = array( 'saved' => __( 'تم حفظ التعديلات ✅', 'masar-altamayuz' ), 'reset' => __( 'رجّعنا القالب لوضعه الأصلي ✅', 'masar-altamayuz' ), 'imported' => __( 'تم استيراد المحتوى التجريبي ✅', 'masar-altamayuz' ), 'removed' => __( 'تم حذف المحتوى التجريبي ✅', 'masar-altamayuz' ), 'exists' => __( 'المحتوى التجريبي مستورد بالفعل.', 'masar-altamayuz' ) );
		echo '<div class="wrap masar-studio" dir="rtl"><h1>' . esc_html__( '✨ استوديو مسار التميز', 'masar-altamayuz' ) . '</h1>';
		if ( isset( $notes[ $msg ] ) ) { echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $notes[ $msg ] ) . '</p></div>'; }
		echo '<h2 class="nav-tab-wrapper"><a class="nav-tab ' . ( 'layout' === $tab ? 'nav-tab-active' : '' ) . '" href="' . esc_url( add_query_arg( 'preset', $key, $base ) ) . '">' . esc_html__( 'تعديل السكاشن', 'masar-altamayuz' ) . '</a><a class="nav-tab ' . ( 'demo' === $tab ? 'nav-tab-active' : '' ) . '" href="' . esc_url( add_query_arg( 'tab', 'demo', $base ) ) . '">' . esc_html__( 'محتوى تجريبي', 'masar-altamayuz' ) . '</a></h2>';
		echo '<style>.masar-studio .mrow{background:#fff;border:1px solid #dcdcde;border-radius:8px;margin:10px 0;padding:0}.masar-studio .mhead{display:flex;gap:10px;align-items:center;padding:10px 14px;background:#f6f7f7;border-radius:8px 8px 0 0}.masar-studio .mhead b{flex:1}.masar-studio .mbody{padding:12px 14px;display:grid;grid-template-columns:1fr 1fr;gap:10px 16px}.masar-studio .mbody label{display:block;font-size:12px;color:#50575e;margin-bottom:3px}.masar-studio .mbody input[type=text],.masar-studio .mbody textarea{width:100%}.masar-studio .mfull{grid-column:1/-1}.masar-studio .off .mbody{opacity:.45}.masar-studio .hint{color:#787c82;font-size:12px}.masar-studio .masar-img{display:flex;gap:6px;align-items:center}.masar-studio .masar-img input{flex:1}.masar-studio .masar-prev{width:44px;height:44px;object-fit:cover;border-radius:6px;border:1px solid #dcdcde}.masar-studio .masar-pick-multi,.masar-studio .masar-pick-ins{margin-top:6px}</style>';
		if ( 'demo' === $tab ) { masar_studio_demo_tab(); } else { masar_studio_layout_tab( $key, $presets, $base ); }
		echo '</div>';
	}

	function masar_studio_layout_tab( $key, $presets, $base ) {
		$specs    = masar_section_specs();
		$defaults = $presets[ $key ]['sections'];
		$saved    = get_option( 'masar_layout_' . $key );
		$rows     = array();
		if ( is_array( $saved ) && $saved ) {
			$seen = array();
			foreach ( $saved as $s ) { if ( isset( $defaults[ (int) $s['idx'] ] ) ) { $rows[] = $s; $seen[ (int) $s['idx'] ] = 1; } }
			foreach ( $defaults as $i => $d ) { if ( ! isset( $seen[ $i ] ) ) { $rows[] = array( 'idx' => $i, 'on' => 1, 'args' => array(), 'items' => '' ); } }
		} else {
			foreach ( $defaults as $i => $d ) { $rows[] = array( 'idx' => $i, 'on' => 1, 'args' => array(), 'items' => '' ); }
		}
		echo '<form method="get" action="' . esc_url( admin_url( 'themes.php' ) ) . '" style="margin:14px 0"><input type="hidden" name="page" value="masar-studio"><label>' . esc_html__( 'القالب: ', 'masar-altamayuz' ) . '<select name="preset" onchange="this.form.submit()">';
		foreach ( $presets as $k => $p ) { echo '<option value="' . esc_attr( $k ) . '"' . selected( $k, $key, false ) . '>' . esc_html( $p['label'] ) . '</option>'; }
		echo '</select></label> <span class="hint">' . esc_html__( 'كل تعديل هنا بيتطبق على القالب ده سواء كرئيسية أو كصفحة بقالب.', 'masar-altamayuz' ) . '</span></form>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" id="masar-layout-form">';
		wp_nonce_field( 'masar_layout' );
		echo '<input type="hidden" name="action" value="masar_save_layout"><input type="hidden" name="preset" value="' . esc_attr( $key ) . '"><div id="masar-rows">';
		foreach ( $rows as $r ) {
			$i    = (int) $r['idx'];
			$name = $defaults[ $i ][0];
			$dargs = isset( $defaults[ $i ][1] ) ? $defaults[ $i ][1] : array();
			$spec = isset( $specs[ $name ] ) ? $specs[ $name ] : array( 'label' => $name, 'fields' => array() );
			echo '<div class="mrow' . ( empty( $r['on'] ) ? ' off' : '' ) . '" data-i="' . (int) $i . '"><input type="hidden" name="order[]" value="' . (int) $i . '">';
			echo '<div class="mhead"><label><input type="hidden" name="layout[' . (int) $i . '][on]" value="0"><input type="checkbox" class="mon" name="layout[' . (int) $i . '][on]" value="1"' . checked( ! empty( $r['on'] ), true, false ) . '>' . esc_html__( ' إظهار', 'masar-altamayuz' ) . '</label><b>' . esc_html( $spec['label'] ) . '</b><button type="button" class="button mup">▲</button><button type="button" class="button mdn">▼</button></div>';
			echo '<div class="mbody">';
			foreach ( $spec['fields'] as $fk => $fl ) {
				$val = isset( $r['args'][ $fk ] ) ? $r['args'][ $fk ] : '';
				$ph  = isset( $dargs[ $fk ] ) ? $dargs[ $fk ] : '';
				$full = in_array( $fk, array( 'subtitle', 'text', 'images' ), true ) ? ' mfull' : '';
				echo '<div class="' . esc_attr( trim( $full ) ) . '"><label>' . esc_html( $fl ) . '</label>';
				if ( 'text' === $fk ) { echo '<textarea rows="3" name="layout[' . (int) $i . '][args][' . esc_attr( $fk ) . ']" placeholder="' . esc_attr( $ph ) . '">' . esc_textarea( $val ) . '</textarea>'; }
				elseif ( 'images' === $fk ) {
					echo '<textarea rows="4" name="layout[' . (int) $i . '][args][' . esc_attr( $fk ) . ']" placeholder="' . esc_attr( __( 'روابط الصور، رابط في كل سطر', 'masar-altamayuz' ) ) . '">' . esc_textarea( is_array( $val ) ? implode( "\n", $val ) : $val ) . '</textarea>';
					echo '<button type="button" class="button masar-pick-multi">' . esc_html__( '🖼️ إضافة صور من المكتبة', 'masar-altamayuz' ) . '</button>';
				} elseif ( 'image' === $fk ) {
					echo '<div class="masar-img"><input type="text" class="masar-img-url" name="layout[' . (int) $i . '][args][' . esc_attr( $fk ) . ']" value="' . esc_attr( $val ) . '" placeholder="' . esc_attr( $ph ) . '">';
					echo '<button type="button" class="button masar-pick">' . esc_html__( '🖼️ اختيار صورة', 'masar-altamayuz' ) . '</button><button type="button" class="button masar-clear">' . esc_html__( 'حذف', 'masar-altamayuz' ) . '</button>';
					echo '<img class="masar-prev" alt=""' . ( $val ? ' src="' . esc_url( $val ) . '"' : ' hidden' ) . '></div>';
				}
				else { echo '<input type="text" name="layout[' . (int) $i . '][args][' . esc_attr( $fk ) . ']" value="' . esc_attr( $val ) . '" placeholder="' . esc_attr( $ph ) . '">'; }
				echo '</div>';
			}
			if ( isset( $spec['items'] ) ) {
				$orig = isset( $dargs['items'] ) ? $dargs['items'] : ( isset( $spec['default_items'] ) ? masar_faq_defaults() : array() );
				$txt  = ! empty( $r['items'] ) ? $r['items'] : masar_items_to_text( $orig, $spec['items'] );
				echo '<div class="mfull"><label>' . esc_html__( 'العناصر — سطر لكل عنصر: ', 'masar-altamayuz' ) . '<span class="hint">' . esc_html( $spec['items']['hint'] ) . '</span></label><textarea rows="5" name="layout[' . (int) $i . '][items]">' . esc_textarea( $txt ) . '</textarea>';
					if ( isset( $spec['items']['keys'] ) && in_array( 'image', $spec['items']['keys'], true ) ) {
						echo '<button type="button" class="button masar-pick-ins">' . esc_html__( '🖼️ إدراج رابط صورة من المكتبة', 'masar-altamayuz' ) . '</button> <span class="hint">' . esc_html__( 'حطي المؤشر مكان خانة الصورة في السطر الأول، واضغطي الزر.', 'masar-altamayuz' ) . '</span>';
					}
					echo '</div>';
			}
			if ( ! $spec['fields'] && ! isset( $spec['items'] ) ) { echo '<p class="hint mfull">' . esc_html__( 'السكشن ده محتواه تلقائي، تقدري تظهريه/تخفيه وترتبيه بس.', 'masar-altamayuz' ) . '</p>'; }
			echo '</div></div>';
		}
		echo '</div><p><button class="button button-primary button-large">' . esc_html__( '💾 حفظ التعديلات', 'masar-altamayuz' ) . '</button> ';
		echo '<button class="button" type="submit" name="action" value="masar_reset_layout" onclick="return confirm(' . esc_attr( wp_json_encode( __( 'ترجيع القالب للوضع الأصلي؟', 'masar-altamayuz' ) ) ) . ')">' . esc_html__( '↩️ رجوع للأصل', 'masar-altamayuz' ) . '</button></p></form>';
		echo '<script>(function(){var box=document.getElementById("masar-rows");box.addEventListener("click",function(e){var r=e.target.closest(".mrow");if(!r)return;if(e.target.classList.contains("mup")&&r.previousElementSibling){box.insertBefore(r,r.previousElementSibling)}if(e.target.classList.contains("mdn")&&r.nextElementSibling){box.insertBefore(r.nextElementSibling,r)}});box.addEventListener("change",function(e){if(e.target.classList.contains("mon")){e.target.closest(".mrow").classList.toggle("off",!e.target.checked)}});})();</script>';
	}
}
