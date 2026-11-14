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
masar_section( 'about', array( 'kicker' => __( 'حكايتنا', 'masar-altamayuz' ), 'title' => __( 'بدأنا بشغف وكبرنا بثقتكم', 'masar-altamayuz' ), 'text' => __( "كل قطعة بنقدمها بتتختار بعناية وبتتراجع قبل ما توصلك.\n\nرسالتنا نخلي تجربتك معانا سهلة وراقية، وجودة بتدوم.", 'masar-altamayuz' ), 'emoji' => '🌿' ) );
masar_section( 'stats', array( 'items' => array( array( '+10K', __( 'عميل سعيد', 'masar-altamayuz' ) ), array( '+500', __( 'منتج مختار', 'masar-altamayuz' ) ), array( '4.9', __( 'متوسط التقييم', 'masar-altamayuz' ) ), array( '+5', __( 'سنوات خبرة', 'masar-altamayuz' ) ) ) ) );
masar_section( 'process', array( 'title' => __( 'قيمنا', 'masar-altamayuz' ), 'items' => array( array( __( 'جودة', 'masar-altamayuz' ), __( 'مواد وخامات مختارة.', 'masar-altamayuz' ) ), array( __( 'أمانة', 'masar-altamayuz' ), __( 'شفافية في كل خطوة.', 'masar-altamayuz' ) ), array( __( 'اهتمام', 'masar-altamayuz' ), __( 'بنسمعك وبنتطور.', 'masar-altamayuz' ) ), array( __( 'سرعة', 'masar-altamayuz' ), __( 'التزام بالمواعيد.', 'masar-altamayuz' ) ) ) ) );
masar_section( 'cta', array( 'title' => __( 'عايز تعرف أكتر؟', 'masar-altamayuz' ), 'text' => __( 'تواصل معانا وهنرد عليك في أقرب وقت.', 'masar-altamayuz' ), 'btn' => __( 'تواصل معنا', 'masar-altamayuz' ) ) );
get_footer();
