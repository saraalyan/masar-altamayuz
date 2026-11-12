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
masar_section( 'cta', array( 'title' => 'لسه عندك سؤال؟', 'text' => 'فريقنا جاهز يساعدك.', 'btn' => 'كلّمنا' ) );
get_footer();
