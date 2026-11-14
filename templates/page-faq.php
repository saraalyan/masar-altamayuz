<?php
/**
 * Template Name: مسار — الأسئلة الشائعة
 * Template Post Type: page
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/page-banner' );
endwhile;
masar_section( 'faq', array( 'title' => '' ) );
masar_section( 'cta', array( 'title' => __( 'لسه عندك سؤال؟', 'masar-altamayuz' ), 'text' => __( 'فريقنا جاهز يساعدك.', 'masar-altamayuz' ), 'btn' => __( 'كلّمنا', 'masar-altamayuz' ) ) );
get_footer();
