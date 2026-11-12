<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="wrap page-pad notfound">
	<div class="big">🥀</div>
	<h1 class="page-title">الصفحة دي دبلت!</h1>
	<p>الرابط ده مش موجود أو اتنقل. جرّب البحث أو ارجع للرئيسية.</p>
	<?php get_search_form(); ?>
	<p style="margin-top:1.5rem"><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">الرئيسية</a></p>
</div>
<?php get_footer();
