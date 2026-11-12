<?php
/**
 * القوالب الجاهزة للصفحة الرئيسية.
 * كل قالب = ترتيب سكاشن + محتوى افتراضي. عدّل النصوص هنا أو من الـ Customizer،
 * أو استخدم فلتر masar_preset_sections من child theme.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_presets() {

	$features = array(
		array( '🚚', 'شحن سريع', 'توصيل لحد باب البيت' ),
		array( '↩️', 'استرجاع سهل', 'خلال 14 يوم' ),
		array( '🔒', 'دفع آمن', 'بياناتك محمية 100%' ),
		array( '💬', 'دعم مباشر', 'على واتساب في أي وقت' ),
	);

	$testi = array(
		array( 'سارة م.', 'الجودة أعلى من توقعي والتغليف شيك جداً. أكيد هطلب تاني.' ),
		array( 'كريم ع.', 'التوصيل كان قبل الميعاد والخدمة محترمة من أول رسالة.' ),
		array( 'ندى ه.', 'تشكيلة راقية وأسعار مظبوطة، بقيت عميلة دايمة.' ),
	);

	return array(

		/* ===== 1) أزياء وموضة — بيج دافئ ===== */
		'fashion' => array(
			'label'    => 'أزياء وموضة (بيج أنيق)',
			'skin'     => null,
			'sections' => array(
				array( 'hero', array( 'style' => 'full', 'eyebrow' => 'تشكيلة جديدة', 'title' => 'أناقة تدوم. أسلوب عصري.', 'subtitle' => 'قطع يومية راقية مصممة عشان تحسسك بالثقة في كل مناسبة.', 'btn1' => 'تسوّقي الجديد', 'btn1_url' => '#products', 'btn2' => 'استكشفي المجموعات', 'btn2_url' => '#cats', 'emoji' => '👗' ) ),
				array( 'cats-circles', array( 'id' => 'cats', 'items' => array(
					array( 'label' => 'فساتين', 'emoji' => '👗' ), array( 'label' => 'بلوزات', 'emoji' => '👚' ), array( 'label' => 'بناطيل', 'emoji' => '👖' ),
					array( 'label' => 'شنط', 'emoji' => '👜' ), array( 'label' => 'إكسسوارات', 'emoji' => '💍' ), array( 'label' => 'جاكيتات', 'emoji' => '🧥' ), array( 'label' => 'أحذية', 'emoji' => '👟' ),
				) ) ),
				array( 'products', array( 'id' => 'products', 'variant' => 'side', 'title' => 'وصل حديثاً', 'subtitle' => 'أحدث القطع وصلت. كوني أول من تختار.', 'btn' => 'شوفي الكل', 'count' => 4 ) ),
				array( 'promo-banners', array( 'items' => array(
					array( 'kicker' => 'مجموعة الصيف', 'title' => 'أساسيات الصيف', 'text' => 'خفيفة. مريحة. أساسية.', 'badge' => 'خصم حتى 30%', 'btn' => 'تسوّقي الآن', 'tone' => 'dark', 'emoji' => '👙' ),
					array( 'kicker' => 'لمسة أخيرة', 'title' => 'اختيارات الإكسسوار', 'text' => 'التفاصيل اللي تكمّل الإطلالة.', 'btn' => 'شوفي الإكسسوارات', 'tone' => 'mocha', 'emoji' => '👜' ),
				) ) ),
				array( 'testimonials', array( 'title' => 'قالوا عنّا', 'items' => $testi ) ),
				array( 'gallery', array( 'title' => 'تابعونا على إنستجرام', 'handle' => '@masar.style' ) ),
				array( 'newsletter', array() ),
			),
		),

		/* ===== 2) فخامة داكنة — إكسسوارات ===== */
		'luxe' => array(
			'label'    => 'فخامة داكنة (إكسسوارات وساعات)',
			'skin'     => 'dark',
			'sections' => array(
				array( 'hero', array( 'style' => 'center', 'eyebrow' => 'اختاري. عبّري. تألقي.', 'title' => 'إكسسوارات فاخرة', 'subtitle' => 'قطع تكمّل حكاية أسلوبك الخاص.', 'btn1' => 'تسوّق الجديد', 'btn1_url' => '#picks', 'emoji' => '⌚' ) ),
				array( 'features', array( 'variant' => 'dark', 'items' => $features ) ),
				array( 'cats-circles', array( 'items' => array(
					array( 'label' => 'حقائب', 'emoji' => '👜' ), array( 'label' => 'مجوهرات', 'emoji' => '📿' ), array( 'label' => 'نظارات', 'emoji' => '🕶️' ),
					array( 'label' => 'ساعات', 'emoji' => '⌚' ), array( 'label' => 'أحذية', 'emoji' => '👠' ), array( 'label' => 'إيشاربات', 'emoji' => '🧣' ), array( 'label' => 'عطور', 'emoji' => '🧴' ),
				) ) ),
				array( 'promo-banners', array( 'cols' => 3, 'items' => array(
					array( 'kicker' => 'موسم جديد', 'title' => 'وصل حديثاً', 'text' => 'قطع جديدة بلمسة خالدة.', 'btn' => 'تسوّق', 'tone' => 'mocha', 'emoji' => '👜' ),
					array( 'kicker' => 'خالدة', 'title' => 'الأكثر مبيعاً', 'text' => 'القطع اللي الكل بيحبها.', 'btn' => 'استكشف', 'tone' => 'dark', 'emoji' => '⌚' ),
					array( 'kicker' => 'عرض خاص', 'title' => 'خصم حتى 30%', 'text' => 'على تشكيلة مختارة لفترة محدودة.', 'btn' => 'تسوّق العروض', 'tone' => 'sand', 'emoji' => '🕶️' ),
				) ) ),
				array( 'products', array( 'id' => 'picks', 'variant' => 'grid', 'title' => 'اختياراتنا المميزة', 'count' => 6, 'cols' => 6 ) ),
				array( 'brands', array( 'title' => 'ثقة أشهر العلامات', 'items' => array( 'COACH', 'MICHAEL KORS', 'GUCCI', 'FOSSIL', 'PRADA', 'BURBERRY' ) ) ),
				array( 'journal', array( 'variant' => 'dark', 'title' => 'مجلة الأسلوب', 'subtitle' => 'أفكار واتجاهات وإرشادات لإطلالة أجمل.' ) ),
				array( 'newsletter', array( 'variant' => 'inline' ) ),
			),
		),

		/* ===== 3) خدمات وتصميم داخلي — أخضر زيتوني ===== */
		'services' => array(
			'label'    => 'خدمات وتصميم داخلي (طبيعي هادئ)',
			'skin'     => null,
			'sections' => array(
				array( 'hero', array( 'style' => 'arch', 'eyebrow' => 'مساحات بروح طبيعية', 'title' => 'تصميمات جميلة تهدّي الروح وتلهمك.', 'subtitle' => 'بنصمم بيوت تجمع بين الجمال الطبيعي والراحة والوظيفة.', 'btn1' => 'استكشف أعمالنا', 'btn1_url' => '#projects', 'emoji' => '🛋️' ) ),
				array( 'services', array( 'title' => 'تصميم مدروس لطريقة عيشك', 'kicker' => 'ماذا نقدّم', 'items' => array(
					array( '🛋️', 'تصميم داخلي متكامل', 'من الفكرة لحد التسليم بكل تفصيلة.' ),
					array( '🍳', 'مطابخ وحمامات', 'مساحات عملية بروح جميلة.' ),
					array( '🏺', 'تنسيق وديكور', 'قطع مختارة بعناية تكمّل المكان.' ),
					array( '💻', 'تصميم عن بُعد', 'خدمة أونلاين في أي مكان.' ),
				) ) ),
				array( 'gallery', array( 'id' => 'projects', 'variant' => 'projects', 'title' => 'مساحات تحسّها بيتك', 'kicker' => 'أعمالنا', 'items' => array(
					array( 'مقر الصنوبر', 'القاهرة' ), array( 'مطبخ الواحة', 'الإسكندرية' ), array( 'بيت الغروب', 'الجونة' ), array( 'حمام الندى', 'الشروق' ), array( 'ملاذ الزيتون', 'الساحل' ),
				) ) ),
				array( 'about', array( 'kicker' => 'قابلي المؤسسة', 'title' => 'نصمّم بنيّة. جذورنا في الطبيعة.', 'text' => "بدأنا من حبنا للمواد الطبيعية وإيماننا إن البيوت لازم تدعم راحتنا.\n\nكل مشروع هو تعاون؛ بنفهم حكايتك واحتياجك ونصمم مساحة جميلة بقدر ما هي مريحة.", 'btn' => 'اعرف أكتر عنّا', 'emoji' => '🌿' ) ),
				array( 'process', array( 'kicker' => 'طريقة شغلنا', 'title' => 'عملية مدروسة. تجربة سلسة.', 'items' => array(
					array( 'اكتشاف', 'بنتعرف عليك وعلى رؤيتك ومساحتك.' ), array( 'تصميم', 'بنعمل تصميم مفصّل يعكس أسلوبك.' ), array( 'تخطيط', 'بنظبط التفاصيل ونجهز الخطة.' ), array( 'تنفيذ', 'بننسق التنفيذ مع شركاء موثوقين.' ), array( 'استمتاع', 'تدخل بيتك الجديد وتحبّه.' ),
				) ) ),
				array( 'testimonials', array( 'kicker' => 'كلمات طيبة', 'title' => 'قصص من عملائنا', 'items' => $testi ) ),
				array( 'faq', array() ),
				array( 'cta', array( 'title' => 'جاهز نبدأ؟', 'text' => 'احجز استشارة وخلّينا نصمم مساحة تحسّها إنت.', 'btn' => 'احجز استشارة' ) ),
			),
		),

		/* ===== 4) ديكور ومنتجات المنزل — خريفي دافئ ===== */
		'decor' => array(
			'label'    => 'ديكور ومنتجات منزلية (دافئ)',
			'skin'     => null,
			'sections' => array(
				array( 'hero', array( 'style' => 'split', 'eyebrow' => 'بيت يشبهك', 'title' => 'تصميم. دفء. بيت أجمل.', 'subtitle' => 'أساسيات منزلية مختارة بعناية تجيب الراحة والستايل والهدوء ليومك.', 'btn1' => 'تسوّق المجموعة', 'btn1_url' => '#products', 'btn2' => 'حكايتنا', 'btn2_url' => '#about', 'emoji' => '🕯️', 'stats' => array( array( '+10K', 'عميل سعيد' ), array( '4.9', 'تقييم العملاء' ) ) ) ),
				array( 'features', array( 'items' => $features ) ),
				array( 'cats-cards', array( 'title' => 'تسوّق حسب القسم', 'items' => array(
					array( 'label' => 'إضاءة', 'emoji' => '💡' ), array( 'label' => 'مفروشات', 'emoji' => '🛏️' ), array( 'label' => 'ديكور', 'emoji' => '🏺' ), array( 'label' => 'أجواء وعطور', 'emoji' => '🕯️' ),
				) ) ),
				array( 'feature-banner', array( 'kicker' => 'مجموعة مميزة', 'title' => 'خريف دافئ', 'text' => 'شموع وسيراميك ومفروشات لأمسيات أدفأ وأهدى.', 'btn' => 'استكشف المجموعة', 'emoji' => '🍂' ) ),
				array( 'products', array( 'id' => 'products', 'variant' => 'grid', 'title' => 'الأكثر طلباً', 'count' => 4, 'cols' => 4 ) ),
				array( 'about', array( 'id' => 'about', 'kicker' => 'حكايتنا', 'title' => 'ندخل الدفء كل بيت', 'text' => 'بنختار كل قطعة بعناية، من خامات طبيعية وحرفية تعيش معاك سنين.', 'btn' => 'اقرأ حكايتنا', 'emoji' => '🏠' ) ),
				array( 'stats', array( 'items' => array( array( '+10K', 'عميل سعيد' ), array( '+500', 'منتج مختار' ), array( '4.9', 'متوسط التقييم' ), array( '24 س', 'سرعة الرد' ) ) ) ),
				array( 'testimonials', array( 'title' => 'آراء العملاء', 'items' => $testi ) ),
				array( 'newsletter', array() ),
			),
		),
	);
}
