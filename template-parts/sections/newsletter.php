<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$var   = masar_arg( $args, 'variant', 'band' );
$title = masar_arg( $args, 'title', get_theme_mod( 'masar_newsletter_title', 'انضم لقائمتنا' ) );
$text  = masar_arg( $args, 'text', get_theme_mod( 'masar_newsletter_text', 'اشترك ليوصلك كل جديد وعروض حصرية.' ) );
$act   = get_theme_mod( 'masar_newsletter_url', '' );
?>
<section class="newsletter nl-<?php echo esc_attr( $var ); ?>">
	<div class="wrap nl-in">
		<div class="nl-text"><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $text ); ?></p></div>
		<form class="nl-form js-newsletter" method="post" action="<?php echo esc_url( $act ?: '#' ); ?>">
			<input type="email" name="email" required placeholder="بريدك الإلكتروني" aria-label="البريد الإلكتروني">
			<button class="btn" type="submit">اشترك</button>
		</form>
	</div>
</section>
