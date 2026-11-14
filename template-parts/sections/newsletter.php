<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$var   = masar_arg( $args, 'variant', 'band' );
$title = masar_arg( $args, 'title', get_theme_mod( 'masar_newsletter_title', __( 'انضم لقائمتنا', 'masar-altamayuz' ) ) );
$text  = masar_arg( $args, 'text', get_theme_mod( 'masar_newsletter_text', __( 'اشترك ليوصلك كل جديد وعروض حصرية.', 'masar-altamayuz' ) ) );
$act   = get_theme_mod( 'masar_newsletter_url', '' );
?>
<section class="newsletter nl-<?php echo esc_attr( $var ); ?>">
	<div class="wrap nl-in">
		<div class="nl-text"><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $text ); ?></p></div>
		<form class="nl-form js-newsletter" method="post" action="<?php echo esc_url( $act ?: '#' ); ?>">
			<input type="email" name="email" required placeholder="<?php esc_attr_e( 'بريدك الإلكتروني', 'masar-altamayuz' ); ?>" aria-label="<?php esc_attr_e( 'البريد الإلكتروني', 'masar-altamayuz' ); ?>">
			<button class="btn" type="submit"><?php esc_html_e( 'اشترك', 'masar-altamayuz' ); ?></button>
		</form>
	</div>
</section>
