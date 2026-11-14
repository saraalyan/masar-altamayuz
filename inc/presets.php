<?php
/**
 * القوالب الجاهزة للصفحة الرئيسية.
 * كل قالب = ترتيب سكاشن + محتوى افتراضي. عدّل النصوص هنا أو من الـ Customizer،
 * أو استخدم فلتر masar_preset_sections من child theme.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_presets() {

	$features = array(
		array( 'truck', __( 'شحن سريع', 'masar-altamayuz' ), __( 'توصيل لحد باب البيت', 'masar-altamayuz' ) ),
		array( 'undo-2', __( 'استرجاع سهل', 'masar-altamayuz' ), __( 'خلال 14 يوم', 'masar-altamayuz' ) ),
		array( 'shield-check', __( 'دفع آمن', 'masar-altamayuz' ), __( 'بياناتك محمية 100%', 'masar-altamayuz' ) ),
		array( 'message-circle', __( 'دعم مباشر', 'masar-altamayuz' ), __( 'على واتساب في أي وقت', 'masar-altamayuz' ) ),
	);

	$testi = array(
		array( __( 'سارة م.', 'masar-altamayuz' ), __( 'الجودة أعلى من توقعي والتغليف شيك جداً. أكيد هطلب تاني.', 'masar-altamayuz' ) ),
		array( __( 'كريم ع.', 'masar-altamayuz' ), __( 'التوصيل كان قبل الميعاد والخدمة محترمة من أول رسالة.', 'masar-altamayuz' ) ),
		array( __( 'ندى ه.', 'masar-altamayuz' ), __( 'تشكيلة راقية وأسعار مظبوطة، بقيت عميلة دايمة.', 'masar-altamayuz' ) ),
	);

	return array(

		/* ===== 1) أزياء وموضة — بيج دافئ ===== */
		'fashion' => array(
			'label'    => __( 'أزياء وموضة (بيج أنيق)', 'masar-altamayuz' ),
			'skin'     => null,
			'fonts'    => array( 'head' => 'Amiri', 'body' => 'Cairo' ),
			'sections' => array(
				array( 'hero', array( 'style' => 'full', 'eyebrow' => __( 'تشكيلة جديدة', 'masar-altamayuz' ), 'title' => __( 'أناقة تدوم. أسلوب عصري.', 'masar-altamayuz' ), 'subtitle' => __( 'قطع يومية راقية مصممة عشان تحسسك بالثقة في كل مناسبة.', 'masar-altamayuz' ), 'btn1' => __( 'تسوّقي الجديد', 'masar-altamayuz' ), 'btn1_url' => '#products', 'btn2' => __( 'استكشفي المجموعات', 'masar-altamayuz' ), 'btn2_url' => '#cats', 'emoji' => 'shirt' ) ),
				array( 'cats-circles', array( 'id' => 'cats', 'items' => array(
					array( 'label' => __( 'فساتين', 'masar-altamayuz' ), 'emoji' => 'shirt' ), array( 'label' => __( 'بلوزات', 'masar-altamayuz' ), 'emoji' => 'shirt' ), array( 'label' => __( 'بناطيل', 'masar-altamayuz' ), 'emoji' => 'ruler' ),
					array( 'label' => __( 'شنط', 'masar-altamayuz' ), 'emoji' => 'handbag' ), array( 'label' => __( 'إكسسوارات', 'masar-altamayuz' ), 'emoji' => 'gem' ), array( 'label' => __( 'جاكيتات', 'masar-altamayuz' ), 'emoji' => 'briefcase' ), array( 'label' => __( 'أحذية', 'masar-altamayuz' ), 'emoji' => 'footprints' ),
				) ) ),
				array( 'products', array( 'id' => 'products', 'variant' => 'side', 'title' => __( 'وصل حديثاً', 'masar-altamayuz' ), 'subtitle' => __( 'أحدث القطع وصلت. كوني أول من تختار.', 'masar-altamayuz' ), 'btn' => __( 'شوفي الكل', 'masar-altamayuz' ), 'count' => 4 ) ),
				array( 'promo-banners', array( 'items' => array(
					array( 'kicker' => __( 'مجموعة الصيف', 'masar-altamayuz' ), 'title' => __( 'أساسيات الصيف', 'masar-altamayuz' ), 'text' => __( 'خفيفة. مريحة. أساسية.', 'masar-altamayuz' ), 'badge' => __( 'خصم حتى 30%', 'masar-altamayuz' ), 'btn' => __( 'تسوّقي الآن', 'masar-altamayuz' ), 'tone' => 'dark', 'emoji' => 'sun' ),
					array( 'kicker' => __( 'لمسة أخيرة', 'masar-altamayuz' ), 'title' => __( 'اختيارات الإكسسوار', 'masar-altamayuz' ), 'text' => __( 'التفاصيل اللي تكمّل الإطلالة.', 'masar-altamayuz' ), 'btn' => __( 'شوفي الإكسسوارات', 'masar-altamayuz' ), 'tone' => 'mocha', 'emoji' => 'handbag' ),
				) ) ),
				array( 'testimonials', array( 'title' => __( 'قالوا عنّا', 'masar-altamayuz' ), 'items' => $testi ) ),
				array( 'gallery', array( 'title' => __( 'تابعونا على إنستجرام', 'masar-altamayuz' ), 'handle' => '@masar.style' ) ),
				array( 'newsletter', array() ),
			),
		),

		/* ===== 2) فخامة داكنة — إكسسوارات ===== */
		'luxe' => array(
			'label'    => __( 'فخامة داكنة (إكسسوارات وساعات)', 'masar-altamayuz' ),
			'skin'     => 'dark',
			'fonts'    => array( 'head' => 'Noto Naskh Arabic', 'body' => 'IBM Plex Sans Arabic' ),
			'sections' => array(
				array( 'hero', array( 'style' => 'center', 'eyebrow' => __( 'اختاري. عبّري. تألقي.', 'masar-altamayuz' ), 'title' => __( 'إكسسوارات فاخرة', 'masar-altamayuz' ), 'subtitle' => __( 'قطع تكمّل حكاية أسلوبك الخاص.', 'masar-altamayuz' ), 'btn1' => __( 'تسوّق الجديد', 'masar-altamayuz' ), 'btn1_url' => '#picks', 'emoji' => 'watch' ) ),
				array( 'features', array( 'variant' => 'dark', 'items' => $features ) ),
				array( 'cats-circles', array( 'items' => array(
					array( 'label' => __( 'حقائب', 'masar-altamayuz' ), 'emoji' => 'handbag' ), array( 'label' => __( 'مجوهرات', 'masar-altamayuz' ), 'emoji' => 'gem' ), array( 'label' => __( 'نظارات', 'masar-altamayuz' ), 'emoji' => 'glasses' ),
					array( 'label' => __( 'ساعات', 'masar-altamayuz' ), 'emoji' => 'watch' ), array( 'label' => __( 'أحذية', 'masar-altamayuz' ), 'emoji' => 'footprints' ), array( 'label' => __( 'إيشاربات', 'masar-altamayuz' ), 'emoji' => 'ribbon' ), array( 'label' => __( 'عطور', 'masar-altamayuz' ), 'emoji' => 'spray-can' ),
				) ) ),
				array( 'promo-banners', array( 'cols' => 3, 'items' => array(
					array( 'kicker' => __( 'موسم جديد', 'masar-altamayuz' ), 'title' => __( 'وصل حديثاً', 'masar-altamayuz' ), 'text' => __( 'قطع جديدة بلمسة خالدة.', 'masar-altamayuz' ), 'btn' => __( 'تسوّق', 'masar-altamayuz' ), 'tone' => 'mocha', 'emoji' => 'handbag' ),
					array( 'kicker' => __( 'خالدة', 'masar-altamayuz' ), 'title' => __( 'الأكثر مبيعاً', 'masar-altamayuz' ), 'text' => __( 'القطع اللي الكل بيحبها.', 'masar-altamayuz' ), 'btn' => __( 'استكشف', 'masar-altamayuz' ), 'tone' => 'dark', 'emoji' => 'watch' ),
					array( 'kicker' => __( 'عرض خاص', 'masar-altamayuz' ), 'title' => __( 'خصم حتى 30%', 'masar-altamayuz' ), 'text' => __( 'على تشكيلة مختارة لفترة محدودة.', 'masar-altamayuz' ), 'btn' => __( 'تسوّق العروض', 'masar-altamayuz' ), 'tone' => 'sand', 'emoji' => 'glasses' ),
				) ) ),
				array( 'products', array( 'id' => 'picks', 'variant' => 'grid', 'title' => __( 'اختياراتنا المميزة', 'masar-altamayuz' ), 'count' => 6, 'cols' => 6 ) ),
				array( 'brands', array( 'title' => __( 'ثقة أشهر العلامات', 'masar-altamayuz' ), 'items' => array( 'COACH', 'MICHAEL KORS', 'GUCCI', 'FOSSIL', 'PRADA', 'BURBERRY' ) ) ),
				array( 'journal', array( 'variant' => 'dark', 'title' => __( 'مجلة الأسلوب', 'masar-altamayuz' ), 'subtitle' => __( 'أفكار واتجاهات وإرشادات لإطلالة أجمل.', 'masar-altamayuz' ) ) ),
				array( 'newsletter', array( 'variant' => 'inline' ) ),
			),
		),

		/* ===== 3) خدمات وتصميم داخلي — أخضر زيتوني ===== */
		'services' => array(
			'label'    => __( 'خدمات وتصميم داخلي (طبيعي هادئ)', 'masar-altamayuz' ),
			'skin'     => null,
			'fonts'    => array( 'head' => 'El Messiri', 'body' => 'Tajawal' ),
			'sections' => array(
				array( 'hero', array( 'style' => 'arch', 'eyebrow' => __( 'مساحات بروح طبيعية', 'masar-altamayuz' ), 'title' => __( 'تصميمات جميلة تهدّي الروح وتلهمك.', 'masar-altamayuz' ), 'subtitle' => __( 'بنصمم بيوت تجمع بين الجمال الطبيعي والراحة والوظيفة.', 'masar-altamayuz' ), 'btn1' => __( 'استكشف أعمالنا', 'masar-altamayuz' ), 'btn1_url' => '#projects', 'emoji' => 'sofa' ) ),
				array( 'services', array( 'title' => __( 'تصميم مدروس لطريقة عيشك', 'masar-altamayuz' ), 'kicker' => __( 'ماذا نقدّم', 'masar-altamayuz' ), 'items' => array(
					array( 'sofa', __( 'تصميم داخلي متكامل', 'masar-altamayuz' ), __( 'من الفكرة لحد التسليم بكل تفصيلة.', 'masar-altamayuz' ) ),
					array( 'cooking-pot', __( 'مطابخ وحمامات', 'masar-altamayuz' ), __( 'مساحات عملية بروح جميلة.', 'masar-altamayuz' ) ),
					array( 'frame', __( 'تنسيق وديكور', 'masar-altamayuz' ), __( 'قطع مختارة بعناية تكمّل المكان.', 'masar-altamayuz' ) ),
					array( 'laptop', __( 'تصميم عن بُعد', 'masar-altamayuz' ), __( 'خدمة أونلاين في أي مكان.', 'masar-altamayuz' ) ),
				) ) ),
				array( 'gallery', array( 'id' => 'projects', 'variant' => 'projects', 'title' => __( 'مساحات تحسّها بيتك', 'masar-altamayuz' ), 'kicker' => __( 'أعمالنا', 'masar-altamayuz' ), 'items' => array(
					array( __( 'مقر الصنوبر', 'masar-altamayuz' ), __( 'القاهرة', 'masar-altamayuz' ) ), array( __( 'مطبخ الواحة', 'masar-altamayuz' ), __( 'الإسكندرية', 'masar-altamayuz' ) ), array( __( 'بيت الغروب', 'masar-altamayuz' ), __( 'الجونة', 'masar-altamayuz' ) ), array( __( 'حمام الندى', 'masar-altamayuz' ), __( 'الشروق', 'masar-altamayuz' ) ), array( __( 'ملاذ الزيتون', 'masar-altamayuz' ), __( 'الساحل', 'masar-altamayuz' ) ),
				) ) ),
				array( 'about', array( 'kicker' => __( 'قابلي المؤسسة', 'masar-altamayuz' ), 'title' => __( 'نصمّم بنيّة. جذورنا في الطبيعة.', 'masar-altamayuz' ), 'text' => __( "بدأنا من حبنا للمواد الطبيعية وإيماننا إن البيوت لازم تدعم راحتنا.\n\nكل مشروع هو تعاون؛ بنفهم حكايتك واحتياجك ونصمم مساحة جميلة بقدر ما هي مريحة.", 'masar-altamayuz' ), 'btn' => __( 'اعرف أكتر عنّا', 'masar-altamayuz' ), 'emoji' => 'leaf' ) ),
				array( 'process', array( 'kicker' => __( 'طريقة شغلنا', 'masar-altamayuz' ), 'title' => __( 'عملية مدروسة. تجربة سلسة.', 'masar-altamayuz' ), 'items' => array(
					array( __( 'اكتشاف', 'masar-altamayuz' ), __( 'بنتعرف عليك وعلى رؤيتك ومساحتك.', 'masar-altamayuz' ) ), array( __( 'تصميم', 'masar-altamayuz' ), __( 'بنعمل تصميم مفصّل يعكس أسلوبك.', 'masar-altamayuz' ) ), array( __( 'تخطيط', 'masar-altamayuz' ), __( 'بنظبط التفاصيل ونجهز الخطة.', 'masar-altamayuz' ) ), array( __( 'تنفيذ', 'masar-altamayuz' ), __( 'بننسق التنفيذ مع شركاء موثوقين.', 'masar-altamayuz' ) ), array( __( 'استمتاع', 'masar-altamayuz' ), __( 'تدخل بيتك الجديد وتحبّه.', 'masar-altamayuz' ) ),
				) ) ),
				array( 'testimonials', array( 'kicker' => __( 'كلمات طيبة', 'masar-altamayuz' ), 'title' => __( 'قصص من عملائنا', 'masar-altamayuz' ), 'items' => $testi ) ),
				array( 'faq', array() ),
				array( 'cta', array( 'title' => __( 'جاهز نبدأ؟', 'masar-altamayuz' ), 'text' => __( 'احجز استشارة وخلّينا نصمم مساحة تحسّها إنت.', 'masar-altamayuz' ), 'btn' => __( 'احجز استشارة', 'masar-altamayuz' ) ) ),
			),
		),

		/* ===== 4) ديكور ومنتجات المنزل — خريفي دافئ ===== */
		'decor' => array(
			'label'    => __( 'ديكور ومنتجات منزلية (دافئ)', 'masar-altamayuz' ),
			'skin'     => null,
			'fonts'    => array( 'head' => 'Readex Pro', 'body' => 'Cairo' ),
			'sections' => array(
				array( 'hero', array( 'style' => 'split', 'eyebrow' => __( 'بيت يشبهك', 'masar-altamayuz' ), 'title' => __( 'تصميم. دفء. بيت أجمل.', 'masar-altamayuz' ), 'subtitle' => __( 'أساسيات منزلية مختارة بعناية تجيب الراحة والستايل والهدوء ليومك.', 'masar-altamayuz' ), 'btn1' => __( 'تسوّق المجموعة', 'masar-altamayuz' ), 'btn1_url' => '#products', 'btn2' => __( 'حكايتنا', 'masar-altamayuz' ), 'btn2_url' => '#about', 'emoji' => 'flame', 'stats' => array( array( '+10K', __( 'عميل سعيد', 'masar-altamayuz' ) ), array( '4.9', __( 'تقييم العملاء', 'masar-altamayuz' ) ) ) ) ),
				array( 'features', array( 'items' => $features ) ),
				array( 'cats-cards', array( 'title' => __( 'تسوّق حسب القسم', 'masar-altamayuz' ), 'items' => array(
					array( 'label' => __( 'إضاءة', 'masar-altamayuz' ), 'emoji' => 'lamp' ), array( 'label' => __( 'مفروشات', 'masar-altamayuz' ), 'emoji' => 'bed-double' ), array( 'label' => __( 'ديكور', 'masar-altamayuz' ), 'emoji' => 'frame' ), array( 'label' => __( 'أجواء وعطور', 'masar-altamayuz' ), 'emoji' => 'flame' ),
				) ) ),
				array( 'feature-banner', array( 'kicker' => __( 'مجموعة مميزة', 'masar-altamayuz' ), 'title' => __( 'خريف دافئ', 'masar-altamayuz' ), 'text' => __( 'شموع وسيراميك ومفروشات لأمسيات أدفأ وأهدى.', 'masar-altamayuz' ), 'btn' => __( 'استكشف المجموعة', 'masar-altamayuz' ), 'emoji' => 'leaf' ) ),
				array( 'products', array( 'id' => 'products', 'variant' => 'grid', 'title' => __( 'الأكثر طلباً', 'masar-altamayuz' ), 'count' => 4, 'cols' => 4 ) ),
				array( 'about', array( 'id' => 'about', 'kicker' => __( 'حكايتنا', 'masar-altamayuz' ), 'title' => __( 'ندخل الدفء كل بيت', 'masar-altamayuz' ), 'text' => __( 'بنختار كل قطعة بعناية، من خامات طبيعية وحرفية تعيش معاك سنين.', 'masar-altamayuz' ), 'btn' => __( 'اقرأ حكايتنا', 'masar-altamayuz' ), 'emoji' => 'house' ) ),
				array( 'stats', array( 'items' => array( array( '+10K', __( 'عميل سعيد', 'masar-altamayuz' ) ), array( '+500', __( 'منتج مختار', 'masar-altamayuz' ) ), array( '4.9', __( 'متوسط التقييم', 'masar-altamayuz' ) ), array( __( '24 س', 'masar-altamayuz' ), __( 'سرعة الرد', 'masar-altamayuz' ) ) ) ) ),
				array( 'testimonials', array( 'title' => __( 'آراء العملاء', 'masar-altamayuz' ), 'items' => $testi ) ),
				array( 'newsletter', array() ),
			),
		),
	);
}
