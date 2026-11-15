<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="wrap page-pad notfound">
	<p class="nf-code" aria-hidden="true">404</p>
	<h1 class="page-title"><?php esc_html_e( 'الصفحة دي دبلت!', 'masar-altamayuz' ); ?></h1>
	<p class="nf-sub"><?php esc_html_e( 'الرابط ده مش موجود أو اتنقل. جرّبي البحث أو اختاري من الاقتراحات تحت.', 'masar-altamayuz' ); ?></p>
	<?php get_search_form(); ?>
	<p style="margin-top:1.5rem"><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'الرئيسية', 'masar-altamayuz' ); ?></a></p>
	<?php masar_suggest_block(); ?>
</div>
<?php get_footer();
