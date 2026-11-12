<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$phone = get_theme_mod( 'masar_contact_phone', '' );
$mail  = get_theme_mod( 'masar_contact_email', '' );
$addr  = get_theme_mod( 'masar_contact_address', '' );
$wa    = preg_replace( '/\D/', '', (string) get_theme_mod( 'masar_whatsapp', '' ) );
?>
<section class="sec">
	<div class="wrap">
		<?php masar_sec_head( $args, 'تواصل معنا', 'يسعدنا نسمع منك، اختار الوسيلة الأنسب.' ); ?>
		<div class="svc-grid">
			<div class="svc"><span class="svc-ico"><?php echo masar_icon( 'phone' ); ?></span><h3>اتصل بنا</h3><p><?php echo esc_html( $phone ?: 'أضف الرقم من التخصيص ← التواصل' ); ?></p></div>
			<div class="svc"><span class="svc-ico"><?php echo masar_icon( 'mail' ); ?></span><h3>البريد</h3><p><?php echo esc_html( $mail ?: 'أضف البريد من التخصيص ← التواصل' ); ?></p></div>
			<div class="svc"><span class="svc-ico"><?php echo masar_icon( 'pin' ); ?></span><h3>العنوان</h3><p><?php echo esc_html( $addr ?: 'أضف العنوان من التخصيص ← التواصل' ); ?></p></div>
			<div class="svc"><span class="svc-ico"><?php echo masar_icon( 'chat' ); ?></span><h3>واتساب</h3><p><?php if ( $wa ) { echo '<a href="https://wa.me/' . esc_attr( $wa ) . '" target="_blank" rel="noopener">ابدأ محادثة</a>'; } else { echo 'أضف الرقم من التخصيص'; } ?></p></div>
		</div>
	</div>
</section>
