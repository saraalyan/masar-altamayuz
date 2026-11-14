<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$wa  = preg_replace( '/\D/', '', (string) get_theme_mod( 'masar_whatsapp', '' ) );
$url = masar_arg( $args, 'url', $wa ? 'https://wa.me/' . $wa : '#' );
?>
<section class="cta" id="contact">
	<div class="wrap">
		<h2><?php echo esc_html( masar_arg( $args, 'title', __( 'جاهز نبدأ؟', 'masar-altamayuz' ) ) ); ?></h2>
		<p><?php echo esc_html( masar_arg( $args, 'text', '' ) ); ?></p>
		<a class="btn btn-light" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( masar_arg( $args, 'btn', __( 'تواصل معنا', 'masar-altamayuz' ) ) ); ?></a>
	</div>
</section>
