<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_sanitize_check( $v ) { return ( isset( $v ) && $v ) ? 1 : 0; }
function masar_sanitize_choice( $v, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return array_key_exists( $v, $choices ) ? $v : $setting->default;
}

function masar_customize_register( $wp_customize ) {
	$palettes = array();
	foreach ( masar_palettes() as $k => $p ) { $palettes[ $k ] = $p['label']; }
	$fonts = array();
	foreach ( masar_fonts_map() as $k => $v ) { $fonts[ $k ] = $k; }
	$presets = array();
	foreach ( masar_presets() as $k => $p ) { $presets[ $k ] = $p['label']; }

	$add = function ( $id, $default, $args, $sanitize = 'sanitize_text_field', $type = 'text', $section = '' ) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => $sanitize, 'transport' => 'refresh' ) );
		$args['section'] = $section;
		$args['type']    = $type;
		$wp_customize->add_control( $id, $args );
	};
	$color = function ( $id, $label, $section ) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => 'sanitize_hex_color' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $label, 'section' => $section ) ) );
	};
	$image = function ( $id, $label, $section ) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array( 'label' => $label, 'section' => $section ) ) );
	};

	$wp_customize->add_panel( 'masar_panel', array( 'title' => '✨ إعدادات مسار التميز', 'priority' => 20 ) );

	/* ---------- القالب الرئيسي ---------- */
	$wp_customize->add_section( 'masar_home', array( 'title' => 'القالب الرئيسي للموقع', 'panel' => 'masar_panel', 'priority' => 1, 'description' => 'اختار تصميم الصفحة الرئيسية الجاهز. كمان تقدر تعمل صفحة جديدة وتختار لها "قالب" من إعدادات الصفحة.' ) );
	$add( 'masar_home_preset', 'fashion', array( 'label' => 'تصميم الصفحة الرئيسية', 'choices' => $presets ), 'masar_sanitize_choice', 'select', 'masar_home' );

	/* ---------- الألوان والخطوط ---------- */
	$wp_customize->add_section( 'masar_look', array( 'title' => 'الألوان والخطوط', 'panel' => 'masar_panel' ) );
	$add( 'masar_palette', 'beige', array( 'label' => 'لوحة الألوان الجاهزة', 'choices' => $palettes ), 'masar_sanitize_choice', 'select', 'masar_look' );
	$color( 'masar_custom_primary', 'لون رئيسي مخصص (اختياري)', 'masar_look' );
	$color( 'masar_custom_accent', 'لون ثانوي مخصص (اختياري)', 'masar_look' );
	$pairs = array();
	foreach ( masar_font_pairs() as $k => $v ) { $pairs[ $k ] = $v['label']; }
	$add( 'masar_font_pair', 'messiri', array( 'label' => 'تنسيق الخطوط', 'description' => 'اختاري «مخصص» لو عايزة تحددي الخطين بنفسك.', 'choices' => $pairs ), 'masar_sanitize_choice', 'select', 'masar_look' );
	$add( 'masar_font_body', '', array( 'label' => 'خط النصوص (للتنسيق المخصص)', 'choices' => $fonts ), 'masar_sanitize_choice', 'select', 'masar_look' );
	$add( 'masar_font_head', '', array( 'label' => 'خط العناوين (للتنسيق المخصص)', 'choices' => $fonts ), 'masar_sanitize_choice', 'select', 'masar_look' );

	/* ---------- الهيدر ---------- */
	$wp_customize->add_section( 'masar_header', array( 'title' => 'الهيدر', 'panel' => 'masar_panel' ) );
	$add( 'masar_header_style', 'split', array( 'label' => 'شكل الهيدر', 'choices' => array(
		'split'   => 'كلاسيك: لوجو يمين وقائمة',
		'center'  => 'لوجو بالمنتصف والقائمة تحته',
		'luxe'    => 'فاخر: قائمة — لوجو بالمنتصف — أيقونات',
		'minimal' => 'بسيط شفاف',
	) ), 'masar_sanitize_choice', 'select', 'masar_header' );
	$add( 'masar_sticky', 1, array( 'label' => 'تثبيت الهيدر عند التمرير' ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_header_overlay', 0, array( 'label' => 'هيدر شفاف فوق الهيرو (يعمل مع هيرو الصورة الخلفية فقط)' ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_show_search', 1, array( 'label' => 'أيقونة البحث' ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_show_account', 1, array( 'label' => 'أيقونة حسابي' ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_show_theme_toggle', 1, array( 'label' => 'زر الوضع الليلي' ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_header_cta', '', array( 'label' => 'نص زر الهيدر (اتركه فاضي لإخفائه)' ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_header_cta_url', '', array( 'label' => 'رابط زر الهيدر' ), 'esc_url_raw', 'url', 'masar_header' );
	$add( 'masar_topbar_on', 1, array( 'label' => 'شريط علوي (إعلان + روابط)' ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_announce', 'شحن مجاني للطلبات فوق 500 جنيه  |  استرجاع سهل خلال 14 يوم', array( 'label' => 'نص الشريط العلوي' ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_topbar_link1', 'تتبّع طلبك', array( 'label' => 'رابط الشريط 1: النص' ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_topbar_link1_url', '', array( 'label' => 'رابط الشريط 1: العنوان' ), 'esc_url_raw', 'url', 'masar_header' );
	$add( 'masar_topbar_link2', 'مركز المساعدة', array( 'label' => 'رابط الشريط 2: النص' ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_topbar_link2_url', '', array( 'label' => 'رابط الشريط 2: العنوان' ), 'esc_url_raw', 'url', 'masar_header' );

	/* ---------- الفوتر ---------- */
	$wp_customize->add_section( 'masar_footer', array( 'title' => 'الفوتر', 'panel' => 'masar_panel' ) );
	$add( 'masar_footer_style', 'columns', array( 'label' => 'شكل الفوتر', 'choices' => array(
		'columns' => 'أعمدة (تعريف + ويدجت)',
		'centered' => 'مركّز بالمنتصف',
		'dark'    => 'داكن فاخر',
		'minimal' => 'سطر واحد بسيط',
	) ), 'masar_sanitize_choice', 'select', 'masar_footer' );
	$add( 'masar_footer_newsletter', 1, array( 'label' => 'شريط الاشتراك بالنشرة' ), 'masar_sanitize_check', 'checkbox', 'masar_footer' );
	$add( 'masar_newsletter_title', 'انضم لقائمتنا', array( 'label' => 'عنوان الاشتراك' ), 'sanitize_text_field', 'text', 'masar_footer' );
	$add( 'masar_newsletter_text', 'اشترك ليوصلك كل جديد وعروض حصرية.', array( 'label' => 'نص الاشتراك' ), 'sanitize_text_field', 'text', 'masar_footer' );
	$add( 'masar_newsletter_url', '', array( 'label' => 'رابط معالجة النموذج (Mailchimp / Formspree...)' ), 'esc_url_raw', 'url', 'masar_footer' );
	$add( 'masar_footer_about', 'نقدّم لك تجربة تسوّق راقية بجودة تدوم وخدمة تستاهلها.', array( 'label' => 'نبذة عن الموقع في الفوتر' ), 'sanitize_textarea_field', 'textarea', 'masar_footer' );
	$add( 'masar_footer_payments', 1, array( 'label' => 'عرض شعارات وسائل الدفع' ), 'masar_sanitize_check', 'checkbox', 'masar_footer' );
	$add( 'masar_footer_text', 'جميع الحقوق محفوظة', array( 'label' => 'نص الحقوق' ), 'sanitize_text_field', 'text', 'masar_footer' );

	/* ---------- الشكل ---------- */
	$wp_customize->add_section( 'masar_layout', array( 'title' => 'الشكل والتخطيط', 'panel' => 'masar_panel' ) );
	$add( 'masar_card_style', 'soft', array( 'label' => 'شكل الكروت', 'choices' => array( 'soft' => 'ظل ناعم', 'outline' => 'إطار خفيف', 'glass' => 'زجاجي', 'flat' => 'مسطح ملوّن' ) ), 'masar_sanitize_choice', 'select', 'masar_layout' );
	$add( 'masar_btn_style', 'pill', array( 'label' => 'شكل الأزرار', 'choices' => array( 'pill' => 'كبسولة', 'round' => 'حواف مدورة', 'square' => 'مربع' ) ), 'masar_sanitize_choice', 'select', 'masar_layout' );
	$add( 'masar_blog_layout', 'grid', array( 'label' => 'عرض المقالات', 'choices' => array( 'grid' => 'شبكة', 'list' => 'قائمة', 'masonry' => 'بنترست' ) ), 'masar_sanitize_choice', 'select', 'masar_layout' );
	$add( 'masar_radius', 18, array( 'label' => 'استدارة الحواف (px)', 'input_attrs' => array( 'min' => 0, 'max' => 36, 'step' => 2 ) ), 'absint', 'range', 'masar_layout' );
	$add( 'masar_width', 1180, array( 'label' => 'عرض المحتوى (px)', 'input_attrs' => array( 'min' => 960, 'max' => 1440, 'step' => 20 ) ), 'absint', 'range', 'masar_layout' );
	$add( 'masar_petals', 0, array( 'label' => '🌸 تأثير بتلات متساقطة' ), 'masar_sanitize_check', 'checkbox', 'masar_layout' );
	$add( 'masar_petals_count', 14, array( 'label' => 'عدد البتلات', 'input_attrs' => array( 'min' => 4, 'max' => 40, 'step' => 2 ) ), 'absint', 'range', 'masar_layout' );

	/* ---------- الهيرو (فاضي = يستخدم نص القالب الجاهز) ---------- */
	$wp_customize->add_section( 'masar_hero', array( 'title' => 'الهيرو (يغيّر نص القالب)', 'panel' => 'masar_panel', 'description' => 'اترك أي حقل فاضي ليظهر النص الافتراضي للقالب.' ) );
	$add( 'masar_hero_style', '', array( 'label' => 'نمط الهيرو', 'choices' => array( '' => 'حسب القالب', 'center' => 'صورة خلفية ونص بالمنتصف', 'split' => 'نص وصورة جنب بعض', 'arch' => 'صورة داخل قوس', 'full' => 'صورة كبيرة بحافة الشاشة' ) ), 'masar_sanitize_choice', 'select', 'masar_hero' );
	$add( 'masar_hero_title', '', array( 'label' => 'العنوان' ), 'sanitize_text_field', 'text', 'masar_hero' );
	$add( 'masar_hero_sub', '', array( 'label' => 'النص الفرعي' ), 'sanitize_textarea_field', 'textarea', 'masar_hero' );
	$add( 'masar_hero_btn1', '', array( 'label' => 'زر 1: النص' ), 'sanitize_text_field', 'text', 'masar_hero' );
	$add( 'masar_hero_btn1_url', '', array( 'label' => 'زر 1: الرابط' ), 'esc_url_raw', 'url', 'masar_hero' );
	$add( 'masar_hero_btn2', '', array( 'label' => 'زر 2: النص' ), 'sanitize_text_field', 'text', 'masar_hero' );
	$add( 'masar_hero_btn2_url', '', array( 'label' => 'زر 2: الرابط' ), 'esc_url_raw', 'url', 'masar_hero' );
	$image( 'masar_hero_image', 'صورة الهيرو', 'masar_hero' );
	$add( 'masar_hero_height', 78, array( 'label' => 'ارتفاع الهيرو (% من الشاشة)', 'input_attrs' => array( 'min' => 50, 'max' => 100, 'step' => 2 ) ), 'absint', 'range', 'masar_hero' );
	$add( 'masar_hero_overlay', 35, array( 'label' => 'عتامة الطبقة فوق الصورة (%)', 'input_attrs' => array( 'min' => 0, 'max' => 80, 'step' => 5 ) ), 'absint', 'range', 'masar_hero' );

	/* ---------- التواصل ---------- */
	$wp_customize->add_section( 'masar_social', array( 'title' => 'التواصل والسوشيال', 'panel' => 'masar_panel' ) );
	$add( 'masar_whatsapp', '', array( 'label' => 'رقم واتساب (بصيغة دولية 2010xxxxxxxx)' ), 'sanitize_text_field', 'text', 'masar_social' );
	$add( 'masar_whatsapp_msg', 'أهلاً، عايز أستفسر عن المنتجات', array( 'label' => 'رسالة واتساب الجاهزة' ), 'sanitize_text_field', 'text', 'masar_social' );
	foreach ( array( 'facebook' => 'فيسبوك', 'instagram' => 'إنستجرام', 'tiktok' => 'تيك توك', 'youtube' => 'يوتيوب', 'pinterest' => 'بنترست' ) as $k => $l ) {
		$add( 'masar_social_' . $k, '', array( 'label' => 'رابط ' . $l ), 'esc_url_raw', 'url', 'masar_social' );
	}
	$add( 'masar_contact_phone', '', array( 'label' => 'رقم التليفون (يظهر في الفوتر وصفحة التواصل)' ), 'sanitize_text_field', 'text', 'masar_social' );
	$add( 'masar_contact_email', '', array( 'label' => 'البريد الإلكتروني' ), 'sanitize_email', 'text', 'masar_social' );
	$add( 'masar_contact_address', '', array( 'label' => 'العنوان' ), 'sanitize_text_field', 'text', 'masar_social' );
}
add_action( 'customize_register', 'masar_customize_register' );
