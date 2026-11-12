<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
masar_render_preset( masar_current_preset() ?: 'fashion' );
get_footer();
