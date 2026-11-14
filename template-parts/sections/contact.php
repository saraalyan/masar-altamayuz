<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$phone = get_theme_mod( 'masar_contact_phone', '' );
$mail  = get_theme_mod( 'masar_contact_email', '' );
$addr  = get_theme_mod( 'masar_contact_address', '' );
$wa    = preg_replace( '/\D/', '', (string) get_theme_mod( 'masar_whatsapp', '' ) );
?>
<section class="sec">
	<div class="wrap">
		<?php masar_sec_head( $args, __( 'تواصل معنا', 'masar-altamayuz' ), __( 'يسعدنا نسمع منك، اختار الوسيلة الأنسب.', 'masar-altamayuz' ) ); ?>
		<div class="svc-grid">
			<div class="svc"><span class="svc-ico"><?php echo masar_icon( 'phone' ); ?></span><h3><?php esc_html_e( 'اتصل بنا', 'masar-altamayuz' ); ?></h3><p><?php echo esc_html( $phone ?: __( 'أضف الرقم من التخصيص ← التواصل', 'masar-altamayuz' ) ); ?></p></div>
			<div class="svc"><span class="svc-ico"><?php echo masar_icon( 'mail' ); ?></span><h3><?php esc_html_e( 'البريد', 'masar-altamayuz' ); ?></h3><p><?php echo esc_html( $mail ?: __( 'أضف البريد من التخصيص ← التواصل', 'masar-altamayuz' ) ); ?></p></div>
			<div class="svc"><span class="svc-ico"><?php echo masar_icon( 'pin' ); ?></span><h3><?php esc_html_e( 'العنوان', 'masar-altamayuz' ); ?></h3><p><?php echo esc_html( $addr ?: __( 'أضف العنوان من التخصيص ← التواصل', 'masar-altamayuz' ) ); ?></p></div>
			<div class="svc"><span class="svc-ico"><?php echo masar_icon( 'chat' ); ?></span><h3><?php esc_html_e( 'واتساب', 'masar-altamayuz' ); ?></h3><p><?php if ( $wa ) { echo '<a href="https://wa.me/' . esc_attr( $wa ) . '" target="_blank" rel="noopener">' . esc_html__( 'ابدأ محادثة', 'masar-altamayuz' ) . '</a>'; } else { echo __( 'أضف الرقم من التخصيص', 'masar-altamayuz' ); } ?></p></div>
		</div>
	</div>
</section>
