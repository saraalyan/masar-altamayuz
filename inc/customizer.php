<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_sanitize_check( $v ) { return ( isset( $v ) && $v ) ? 1 : 0; }
function masar_sanitize_layout( $v ) { return in_array( $v, array( 'full', 'boxed', 'padded', 'fluid' ), true ) ? $v : 'full'; }
function masar_sanitize_side( $v ) { return in_array( $v, array( 'none', 'start', 'end' ), true ) ? $v : 'none'; }
function masar_sanitize_choice( $v, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return array_key_exists( $v, $choices ) ? $v : $setting->default;
}

function masar_customize_register( $wp_customize ) {
	$palettes = array();
	foreach ( masar_palettes() as $k => $p ) { $palettes[ $k ] = $p['label']; }
	$fonts = array();
	foreach ( masar_fonts_map() as $k => $v ) { $fonts[ $k ] = $k; }
	$fonts['@upload'] = __( 'خطي المرفوع', 'masar-altamayuz' );
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

	$wp_customize->add_panel( 'masar_panel', array( 'title' => __( '✨ إعدادات مسار التميز', 'masar-altamayuz' ), 'priority' => 20 ) );

	/* ---------- القالب الرئيسي ---------- */
	$wp_customize->add_section( 'masar_home', array( 'title' => __( 'القالب الرئيسي للموقع', 'masar-altamayuz' ), 'panel' => 'masar_panel', 'priority' => 1, 'description' => __( 'اختار تصميم الصفحة الرئيسية الجاهز. كمان تقدر تعمل صفحة جديدة وتختار لها "قالب" من إعدادات الصفحة.', 'masar-altamayuz' ) ) );
	$add( 'masar_home_preset', 'fashion', array( 'label' => __( 'تصميم الصفحة الرئيسية', 'masar-altamayuz' ), 'choices' => $presets ), 'masar_sanitize_choice', 'select', 'masar_home' );

	/* ---------- الألوان والخطوط ---------- */
	$wp_customize->add_section( 'masar_look', array( 'title' => __( 'الألوان والخطوط', 'masar-altamayuz' ), 'panel' => 'masar_panel' ) );
	$add( 'masar_palette', 'beige', array( 'label' => __( 'لوحة الألوان الجاهزة', 'masar-altamayuz' ), 'choices' => $palettes ), 'masar_sanitize_choice', 'select', 'masar_look' );
	$color( 'masar_custom_primary', __( 'لون رئيسي مخصص (اختياري)', 'masar-altamayuz' ), 'masar_look' );
	$color( 'masar_custom_accent', __( 'لون ثانوي مخصص (اختياري)', 'masar-altamayuz' ), 'masar_look' );
	$pairs = array();
	foreach ( masar_font_pairs() as $k => $v ) { $pairs[ $k ] = $v['label']; }
	$add( 'masar_font_pair', 'messiri', array( 'label' => __( 'تنسيق الخطوط', 'masar-altamayuz' ), 'description' => __( 'اختاري «مخصص» لو عايزة تحددي الخطين بنفسك.', 'masar-altamayuz' ), 'choices' => $pairs ), 'masar_sanitize_choice', 'select', 'masar_look' );
	$add( 'masar_font_body', '', array( 'label' => __( 'خط النصوص (للتنسيق المخصص)', 'masar-altamayuz' ), 'choices' => $fonts ), 'masar_sanitize_choice', 'select', 'masar_look' );
	$add( 'masar_font_head', '', array( 'label' => __( 'خط العناوين (للتنسيق المخصص)', 'masar-altamayuz' ), 'choices' => $fonts ), 'masar_sanitize_choice', 'select', 'masar_look' );

	/* رفع خط خاص */
	$add( 'masar_cf_name', '', array( 'label' => __( 'اسم خطك المرفوع', 'masar-altamayuz' ), 'description' => __( 'أي اسم تحبيه (مثلاً: خط البراند). بعد الرفع اختاري «خطي المرفوع» من تنسيق الخطوط. صيغ مدعومة: woff2 وwoff وttf وotf.', 'masar-altamayuz' ) ), 'masar_sanitize_font_name', 'text', 'masar_look' );
	foreach ( array( 'masar_cf_regular' => __( 'ملف الخط (عادي 400)', 'masar-altamayuz' ), 'masar_cf_bold' => __( 'ملف الخط الثقيل 700 (اختياري)', 'masar-altamayuz' ) ) as $fid => $flabel ) {
		$wp_customize->add_setting( $fid, array( 'default' => '', 'sanitize_callback' => 'masar_sanitize_font_url', 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $fid, array( 'label' => $flabel, 'section' => 'masar_look' ) ) );
	}
	/* تحكم الخطوط */
	$add( 'masar_fs_base', 17, array( 'label' => __( 'حجم خط النصوص (px)', 'masar-altamayuz' ), 'input_attrs' => array( 'min' => 14, 'max' => 22, 'step' => 1 ) ), 'absint', 'range', 'masar_look' );
	$add( 'masar_fs_head', 100, array( 'label' => __( 'حجم العناوين (%)', 'masar-altamayuz' ), 'input_attrs' => array( 'min' => 80, 'max' => 140, 'step' => 5 ) ), 'absint', 'range', 'masar_look' );
	$add( 'masar_lh', 185, array( 'label' => __( 'تباعد الأسطر (%)', 'masar-altamayuz' ), 'input_attrs' => array( 'min' => 150, 'max' => 220, 'step' => 5 ) ), 'absint', 'range', 'masar_look' );
	$add( 'masar_fw_head', 700, array( 'label' => __( 'سُمك العناوين', 'masar-altamayuz' ), 'description' => __( 'بيظهر الفرق على قد الأوزان المتاحة في الخط.', 'masar-altamayuz' ), 'choices' => array( 400 => __( 'عادي', 'masar-altamayuz' ), 500 => __( 'متوسط', 'masar-altamayuz' ), 600 => __( 'شبه ثقيل', 'masar-altamayuz' ), 700 => __( 'ثقيل', 'masar-altamayuz' ), 800 => __( 'ثقيل جداً', 'masar-altamayuz' ) ) ), 'absint', 'select', 'masar_look' );

	/* ---------- الهيدر ---------- */
	$wp_customize->add_section( 'masar_header', array( 'title' => __( 'الهيدر', 'masar-altamayuz' ), 'panel' => 'masar_panel' ) );
	$add( 'masar_header_style', 'split', array( 'label' => __( 'شكل الهيدر', 'masar-altamayuz' ), 'choices' => array(
		'split'   => __( 'كلاسيك: لوجو يمين وقائمة', 'masar-altamayuz' ),
		'center'  => __( 'لوجو بالمنتصف والقائمة تحته', 'masar-altamayuz' ),
		'luxe'    => __( 'فاخر: قائمة — لوجو بالمنتصف — أيقونات', 'masar-altamayuz' ),
		'minimal' => __( 'بسيط شفاف', 'masar-altamayuz' ),
	) ), 'masar_sanitize_choice', 'select', 'masar_header' );
	$add( 'masar_sticky', 1, array( 'label' => __( 'تثبيت الهيدر عند التمرير', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_sticky_type', 'fixed', array( 'label' => __( 'نوع التثبيت', 'masar-altamayuz' ), 'description' => __( 'يعمل لما يكون "تثبيت الهيدر" شغال.', 'masar-altamayuz' ), 'choices' => array(
		'fixed'  => __( 'ثابت كما هو', 'masar-altamayuz' ),
		'shrink' => __( 'يصغر عند التمرير', 'masar-altamayuz' ),
		'hide'   => __( 'يختفي عند النزول ويظهر عند الطلوع', 'masar-altamayuz' ),
	) ), 'masar_sanitize_choice', 'select', 'masar_header' );
	$add( 'masar_mobile_menu', 'drop', array( 'label' => __( 'قائمة الموبايل', 'masar-altamayuz' ), 'choices' => array(
		'drop' => __( 'تنزل تحت الهيدر', 'masar-altamayuz' ),
		'side' => __( 'قائمة جانبية منزلقة', 'masar-altamayuz' ),
	) ), 'masar_sanitize_choice', 'select', 'masar_header' );
	$add( 'masar_subbar_on', 0, array( 'label' => __( 'صف إضافي تحت الهيدر', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_subbar_text', __( 'عروض الموسم بدأت — خصم حتى 30%', 'masar-altamayuz' ), array( 'label' => __( 'نص الصف الإضافي', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_subbar_link', __( 'تسوّق الآن', 'masar-altamayuz' ), array( 'label' => __( 'نص رابط الصف الإضافي', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_subbar_url', '', array( 'label' => __( 'رابط الصف الإضافي', 'masar-altamayuz' ) ), 'esc_url_raw', 'url', 'masar_header' );
	$add( 'masar_header_overlay', 0, array( 'label' => __( 'هيدر شفاف فوق الهيرو (يعمل مع هيرو الصورة الخلفية فقط)', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_show_search', 1, array( 'label' => __( 'أيقونة البحث', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_show_account', 1, array( 'label' => __( 'أيقونة حسابي', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_show_theme_toggle', 1, array( 'label' => __( 'زر الوضع الليلي', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_header_cta', '', array( 'label' => __( 'نص زر الهيدر (اتركه فاضي لإخفائه)', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_header_cta_url', '', array( 'label' => __( 'رابط زر الهيدر', 'masar-altamayuz' ) ), 'esc_url_raw', 'url', 'masar_header' );
	$add( 'masar_topbar_on', 1, array( 'label' => __( 'شريط علوي (إعلان + روابط)', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_header' );
	$add( 'masar_announce', __( 'شحن مجاني للطلبات فوق 500 جنيه  |  استرجاع سهل خلال 14 يوم', 'masar-altamayuz' ), array( 'label' => __( 'نص الشريط العلوي', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_topbar_link1', __( 'تتبّع طلبك', 'masar-altamayuz' ), array( 'label' => __( 'رابط الشريط 1: النص', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_topbar_link1_url', '', array( 'label' => __( 'رابط الشريط 1: العنوان', 'masar-altamayuz' ) ), 'esc_url_raw', 'url', 'masar_header' );
	$add( 'masar_topbar_link2', __( 'مركز المساعدة', 'masar-altamayuz' ), array( 'label' => __( 'رابط الشريط 2: النص', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_header' );
	$add( 'masar_topbar_link2_url', '', array( 'label' => __( 'رابط الشريط 2: العنوان', 'masar-altamayuz' ) ), 'esc_url_raw', 'url', 'masar_header' );

	/* ---------- الفوتر ---------- */
	$wp_customize->add_section( 'masar_footer', array( 'title' => __( 'الفوتر', 'masar-altamayuz' ), 'panel' => 'masar_panel' ) );
	$add( 'masar_footer_style', 'columns', array( 'label' => __( 'شكل الفوتر', 'masar-altamayuz' ), 'choices' => array(
		'columns' => __( 'أعمدة (تعريف + ويدجت)', 'masar-altamayuz' ),
		'centered' => __( 'مركّز بالمنتصف', 'masar-altamayuz' ),
		'dark'    => __( 'داكن فاخر', 'masar-altamayuz' ),
		'minimal' => __( 'سطر واحد بسيط', 'masar-altamayuz' ),
	) ), 'masar_sanitize_choice', 'select', 'masar_footer' );
	$add( 'masar_footer_layout', 'wide', array( 'label' => __( 'توزيع أعمدة الفوتر', 'masar-altamayuz' ), 'choices' => array(
		'wide'  => __( 'عمود التعريف أعرض', 'masar-altamayuz' ),
		'equal' => __( 'أعمدة متساوية', 'masar-altamayuz' ),
		'stack' => __( 'التعريف فوق والأعمدة تحته', 'masar-altamayuz' ),
	) ), 'masar_sanitize_choice', 'select', 'masar_footer' );
	$add( 'masar_footer_bottom', 'spread', array( 'label' => __( 'الشريط السفلي', 'masar-altamayuz' ), 'choices' => array(
		'spread' => __( 'الحقوق ووسائل الدفع على الجانبين', 'masar-altamayuz' ),
		'center' => __( 'كل شيء بالمنتصف', 'masar-altamayuz' ),
	) ), 'masar_sanitize_choice', 'select', 'masar_footer' );
	$add( 'masar_backtop', 1, array( 'label' => __( 'زر العودة للأعلى', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_footer' );
	$add( 'masar_footer_newsletter', 1, array( 'label' => __( 'شريط الاشتراك بالنشرة', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_footer' );
	$add( 'masar_newsletter_title', __( 'انضم لقائمتنا', 'masar-altamayuz' ), array( 'label' => __( 'عنوان الاشتراك', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_footer' );
	$add( 'masar_newsletter_text', __( 'اشترك ليوصلك كل جديد وعروض حصرية.', 'masar-altamayuz' ), array( 'label' => __( 'نص الاشتراك', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_footer' );
	$add( 'masar_newsletter_url', '', array( 'label' => __( 'رابط معالجة النموذج (Mailchimp / Formspree...)', 'masar-altamayuz' ) ), 'esc_url_raw', 'url', 'masar_footer' );
	$add( 'masar_footer_about', __( 'نقدّم لك تجربة تسوّق راقية بجودة تدوم وخدمة تستاهلها.', 'masar-altamayuz' ), array( 'label' => __( 'نبذة عن الموقع في الفوتر', 'masar-altamayuz' ) ), 'sanitize_textarea_field', 'textarea', 'masar_footer' );
	$add( 'masar_footer_payments', 1, array( 'label' => __( 'عرض شعارات وسائل الدفع', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_footer' );
	$add( 'masar_footer_text', __( 'جميع الحقوق محفوظة', 'masar-altamayuz' ), array( 'label' => __( 'نص الحقوق', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_footer' );

	/* ---------- المتجر ---------- */
	$wp_customize->add_section( 'masar_shop', array( 'title' => __( 'المتجر (WooCommerce)', 'masar-altamayuz' ), 'panel' => 'masar_panel', 'description' => __( 'بتشتغل لما تفعّلي ووكومرس.', 'masar-altamayuz' ) ) );
	$add( 'masar_wishlist', 1, array( 'label' => __( 'قائمة الأمنيات (قلب على المنتجات + صفحة خاصة)', 'masar-altamayuz' ), 'description' => __( 'بتتحفظ في متصفح الزائر بدون تسجيل دخول. صفحة «قائمة الأمنيات» بتتعمل لوحدها أول ما المدير يفتح لوحة التحكم.', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_shop' );
	$add( 'masar_compare', 1, array( 'label' => __( 'مقارنة المنتجات (زر «قارن» + صفحة مقارنة لحد 4 منتجات)', 'masar-altamayuz' ), 'description' => __( 'صفحة «مقارنة المنتجات» بتتعمل لوحدها أول ما المدير يفتح لوحة التحكم.', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_shop' );
	$add( 'masar_shop_filters', 1, array( 'label' => __( 'شريط فلترة فوق المنتجات (تصنيف / سعر / متوفر / تخفيضات)', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_shop' );
	$add( 'masar_quick_view', 1, array( 'label' => __( 'زر «نظرة سريعة» على المنتجات', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_shop' );
	$add( 'masar_ajax_single', 1, array( 'label' => __( 'الإضافة للسلة بدون تحميل الصفحة (المنتج البسيط)', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_shop' );
	$add( 'masar_sticky_atc', 1, array( 'label' => __( 'شريط «أضف للسلة» الثابت في صفحة المنتج', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_shop' );

	/* ---------- المدونة والمقالات ---------- */
	$wp_customize->add_section( 'masar_blogx', array( 'title' => __( 'المدونة والمقالات', 'masar-altamayuz' ), 'panel' => 'masar_panel' ) );
	$add( 'masar_breadcrumbs', 1, array( 'label' => __( 'مسار التنقل (الرئيسية › القسم › الصفحة)', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_blogx' );
	$add( 'masar_related_posts', 1, array( 'label' => __( 'مقالات ذات صلة تحت المقال', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_blogx' );
	$add( 'masar_author_box', 1, array( 'label' => __( 'صندوق الكاتب تحت المقال', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_blogx' );
	$add( 'masar_share_buttons', 1, array( 'label' => __( 'أزرار مشاركة المقال', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_blogx' );

	/* ---------- الشكل ---------- */
	$wp_customize->add_section( 'masar_layout', array( 'title' => __( 'الشكل والتخطيط', 'masar-altamayuz' ), 'panel' => 'masar_panel' ) );
	$add( 'masar_card_style', 'soft', array( 'label' => __( 'شكل الكروت', 'masar-altamayuz' ), 'choices' => array( 'soft' => __( 'ظل ناعم', 'masar-altamayuz' ), 'outline' => __( 'إطار خفيف', 'masar-altamayuz' ), 'glass' => __( 'زجاجي', 'masar-altamayuz' ), 'flat' => __( 'مسطح ملوّن', 'masar-altamayuz' ) ) ), 'masar_sanitize_choice', 'select', 'masar_layout' );
	$add( 'masar_btn_style', 'pill', array( 'label' => __( 'شكل الأزرار', 'masar-altamayuz' ), 'choices' => array( 'pill' => __( 'كبسولة', 'masar-altamayuz' ), 'round' => __( 'حواف مدورة', 'masar-altamayuz' ), 'square' => __( 'مربع', 'masar-altamayuz' ) ) ), 'masar_sanitize_choice', 'select', 'masar_layout' );
	$add( 'masar_blog_layout', 'grid', array( 'label' => __( 'عرض المقالات', 'masar-altamayuz' ), 'choices' => array( 'grid' => __( 'شبكة', 'masar-altamayuz' ), 'list' => __( 'قائمة', 'masar-altamayuz' ), 'masonry' => __( 'بنترست', 'masar-altamayuz' ) ) ), 'masar_sanitize_choice', 'select', 'masar_layout' );
	$add( 'masar_site_layout', 'full', array( 'label' => __( 'تخطيط الموقع', 'masar-altamayuz' ), 'choices' => array( 'full' => __( 'عرض كامل (الافتراضي)', 'masar-altamayuz' ), 'boxed' => __( 'محدود في صندوق بالنص', 'masar-altamayuz' ), 'padded' => __( 'بحواف حوالين الموقع', 'masar-altamayuz' ), 'fluid' => __( 'ممتد على عرض الشاشة', 'masar-altamayuz' ) ) ), 'masar_sanitize_layout', 'select', 'masar_layout' );
	$sp = array( 'none' => __( 'بدون سايدبار', 'masar-altamayuz' ), 'start' => __( 'على اليمين', 'masar-altamayuz' ), 'end' => __( 'على اليسار', 'masar-altamayuz' ) );
	$add( 'masar_side_blog', 'end', array( 'label' => __( 'السايدبار: المدونة والأرشيف', 'masar-altamayuz' ), 'choices' => $sp ), 'masar_sanitize_side', 'select', 'masar_layout' );
	$add( 'masar_side_single', 'none', array( 'label' => __( 'السايدبار: صفحة المقال', 'masar-altamayuz' ), 'choices' => $sp ), 'masar_sanitize_side', 'select', 'masar_layout' );
	$add( 'masar_side_page', 'none', array( 'label' => __( 'السايدبار: الصفحات', 'masar-altamayuz' ), 'choices' => $sp ), 'masar_sanitize_side', 'select', 'masar_layout' );
	$add( 'masar_side_shop', 'none', array( 'label' => __( 'السايدبار: الشوب وصفحة المنتج', 'masar-altamayuz' ), 'choices' => $sp, 'description' => __( 'السايدبار بيظهر بس لو فيه ودجتس جواه (المظهر ← الودجتس).', 'masar-altamayuz' ) ), 'masar_sanitize_side', 'select', 'masar_layout' );
	$add( 'masar_radius', 18, array( 'label' => __( 'استدارة الحواف (px)', 'masar-altamayuz' ), 'input_attrs' => array( 'min' => 0, 'max' => 36, 'step' => 2 ) ), 'absint', 'range', 'masar_layout' );
	$add( 'masar_width', 1180, array( 'label' => __( 'عرض المحتوى (px)', 'masar-altamayuz' ), 'input_attrs' => array( 'min' => 960, 'max' => 1440, 'step' => 20 ) ), 'absint', 'range', 'masar_layout' );
	$add( 'masar_petals', 0, array( 'label' => __( '🌸 تأثير بتلات متساقطة', 'masar-altamayuz' ) ), 'masar_sanitize_check', 'checkbox', 'masar_layout' );
	$add( 'masar_petals_count', 14, array( 'label' => __( 'عدد البتلات', 'masar-altamayuz' ), 'input_attrs' => array( 'min' => 4, 'max' => 40, 'step' => 2 ) ), 'absint', 'range', 'masar_layout' );

	/* ---------- الهيرو (فاضي = يستخدم نص القالب الجاهز) ---------- */
	$wp_customize->add_section( 'masar_hero', array( 'title' => __( 'الهيرو (يغيّر نص القالب)', 'masar-altamayuz' ), 'panel' => 'masar_panel', 'description' => __( 'اترك أي حقل فاضي ليظهر النص الافتراضي للقالب.', 'masar-altamayuz' ) ) );
	$add( 'masar_hero_style', '', array( 'label' => __( 'نمط الهيرو', 'masar-altamayuz' ), 'choices' => array( '' => __( 'حسب القالب', 'masar-altamayuz' ), 'center' => __( 'صورة خلفية ونص بالمنتصف', 'masar-altamayuz' ), 'split' => __( 'نص وصورة جنب بعض', 'masar-altamayuz' ), 'arch' => __( 'صورة داخل قوس', 'masar-altamayuz' ), 'full' => __( 'صورة كبيرة بحافة الشاشة', 'masar-altamayuz' ) ) ), 'masar_sanitize_choice', 'select', 'masar_hero' );
	$add( 'masar_hero_title', '', array( 'label' => __( 'العنوان', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_hero' );
	$add( 'masar_hero_sub', '', array( 'label' => __( 'النص الفرعي', 'masar-altamayuz' ) ), 'sanitize_textarea_field', 'textarea', 'masar_hero' );
	$add( 'masar_hero_btn1', '', array( 'label' => __( 'زر 1: النص', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_hero' );
	$add( 'masar_hero_btn1_url', '', array( 'label' => __( 'زر 1: الرابط', 'masar-altamayuz' ) ), 'esc_url_raw', 'url', 'masar_hero' );
	$add( 'masar_hero_btn2', '', array( 'label' => __( 'زر 2: النص', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_hero' );
	$add( 'masar_hero_btn2_url', '', array( 'label' => __( 'زر 2: الرابط', 'masar-altamayuz' ) ), 'esc_url_raw', 'url', 'masar_hero' );
	$image( 'masar_hero_image', __( 'صورة الهيرو', 'masar-altamayuz' ), 'masar_hero' );
	$add( 'masar_hero_height', 78, array( 'label' => __( 'ارتفاع الهيرو (% من الشاشة)', 'masar-altamayuz' ), 'input_attrs' => array( 'min' => 50, 'max' => 100, 'step' => 2 ) ), 'absint', 'range', 'masar_hero' );
	$add( 'masar_hero_overlay', 35, array( 'label' => __( 'عتامة الطبقة فوق الصورة (%)', 'masar-altamayuz' ), 'input_attrs' => array( 'min' => 0, 'max' => 80, 'step' => 5 ) ), 'absint', 'range', 'masar_hero' );

	/* ---------- التواصل ---------- */
	$wp_customize->add_section( 'masar_social', array( 'title' => __( 'التواصل والسوشيال', 'masar-altamayuz' ), 'panel' => 'masar_panel' ) );
	$add( 'masar_whatsapp', '', array( 'label' => __( 'رقم واتساب (بصيغة دولية 2010xxxxxxxx)', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_social' );
	$add( 'masar_whatsapp_msg', __( 'أهلاً، عايز أستفسر عن المنتجات', 'masar-altamayuz' ), array( 'label' => __( 'رسالة واتساب الجاهزة', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_social' );
	foreach ( array( 'facebook' => __( 'فيسبوك', 'masar-altamayuz' ), 'instagram' => __( 'إنستجرام', 'masar-altamayuz' ), 'tiktok' => __( 'تيك توك', 'masar-altamayuz' ), 'youtube' => __( 'يوتيوب', 'masar-altamayuz' ), 'pinterest' => __( 'بنترست', 'masar-altamayuz' ) ) as $k => $l ) {
		$add( 'masar_social_' . $k, '', array( 'label' => sprintf( __( 'رابط %s', 'masar-altamayuz' ), $l ) ), 'esc_url_raw', 'url', 'masar_social' );
	}
	$add( 'masar_contact_phone', '', array( 'label' => __( 'رقم التليفون (يظهر في الفوتر وصفحة التواصل)', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_social' );
	$add( 'masar_contact_email', '', array( 'label' => __( 'البريد الإلكتروني', 'masar-altamayuz' ) ), 'sanitize_email', 'text', 'masar_social' );
	$add( 'masar_contact_address', '', array( 'label' => __( 'العنوان', 'masar-altamayuz' ) ), 'sanitize_text_field', 'text', 'masar_social' );
}
add_action( 'customize_register', 'masar_customize_register' );
