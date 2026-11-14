<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="wrap page-pad notfound">
	<div class="big"><?php echo masar_icon( 'flower' ); ?></div>
	<h1 class="page-title"><?php esc_html_e( 'الصفحة دي دبلت!', 'masar-altamayuz' ); ?></h1>
	<p><?php esc_html_e( 'الرابط ده مش موجود أو اتنقل. جرّب البحث أو ارجع للرئيسية.', 'masar-altamayuz' ); ?></p>
	<?php get_search_form(); ?>
	<p style="margin-top:1.5rem"><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'الرئيسية', 'masar-altamayuz' ); ?></a></p>
</div>
<?php get_footer();
