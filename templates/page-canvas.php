<?php
/**
 * Template Name: مسار — مساحة حرة (للسكاشن والشورت كود)
 * Template Post Type: page
 *
 * اكتب في المحرر: [masar_section name="faq"] [masar_section name="stats"] ... إلخ
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post();
	the_content();
endwhile;
get_footer();
