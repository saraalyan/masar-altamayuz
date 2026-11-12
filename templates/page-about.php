<?php
/**
 * Template Name: مسار — من نحن
 * Template Post Type: page
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/page-banner' );
	if ( trim( get_the_content() ) ) { echo '<div class="wrap narrow entry">'; the_content(); echo '</div>'; }
endwhile;
masar_section( 'about', array( 'kicker' => 'حكايتنا', 'title' => 'بدأنا بشغف وكبرنا بثقتكم', 'text' => "كل قطعة بنقدمها بتتختار بعناية وبتتراجع قبل ما توصلك.\n\nرسالتنا نخلي تجربتك معانا سهلة وراقية، وجودة بتدوم.", 'emoji' => '🌿' ) );
masar_section( 'stats', array( 'items' => array( array( '+10K', 'عميل سعيد' ), array( '+500', 'منتج مختار' ), array( '4.9', 'متوسط التقييم' ), array( '+5', 'سنوات خبرة' ) ) ) );
masar_section( 'process', array( 'title' => 'قيمنا', 'items' => array( array( 'جودة', 'مواد وخامات مختارة.' ), array( 'أمانة', 'شفافية في كل خطوة.' ), array( 'اهتمام', 'بنسمعك وبنتطور.' ), array( 'سرعة', 'التزام بالمواعيد.' ) ) ) );
masar_section( 'cta', array( 'title' => 'عايز تعرف أكتر؟', 'text' => 'تواصل معانا وهنرد عليك في أقرب وقت.', 'btn' => 'تواصل معنا' ) );
get_footer();
