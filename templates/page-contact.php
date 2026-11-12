<?php
/**
 * Template Name: مسار — تواصل معنا
 * Template Post Type: page
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/page-banner' );
	masar_section( 'contact', array() );
	if ( trim( get_the_content() ) ) { echo '<div class="wrap narrow entry">'; the_content(); echo '</div>'; }
endwhile;
masar_section( 'faq', array() );
get_footer();
