<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$masar_sid = masar_sidebar_id();
if ( ! $masar_sid || 'none' === masar_sidebar_pos() ) { return; } ?>
<aside class="sidebar"><?php dynamic_sidebar( $masar_sid ); ?></aside>
