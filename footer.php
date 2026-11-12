<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
$fs   = get_theme_mod( 'masar_footer_style', 'columns' );
$any  = false;
for ( $i = 1; $i <= 4; $i++ ) { if ( is_active_sidebar( 'footer-' . $i ) ) { $any = true; } }
$phone = get_theme_mod( 'masar_contact_phone', '' );
$mail  = get_theme_mod( 'masar_contact_email', '' );
$addr  = get_theme_mod( 'masar_contact_address', '' );
?>
</main>

<?php if ( get_theme_mod( 'masar_footer_newsletter', 1 ) && ! masar_preset_has( 'newsletter' ) && 'minimal' !== $fs ) { masar_section( 'newsletter', array( 'variant' => 'band' ) ); } ?>

<footer class="site-footer">
	<div class="wrap">
		<?php if ( 'minimal' !== $fs ) : ?>
		<div class="footer-cols">
			<div class="fcol fbrand">
				<div class="flogo"><?php if ( has_custom_logo() ) { the_custom_logo(); } else { echo '<a class="brand-text" href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>'; } ?></div>
				<p><?php echo esc_html( get_theme_mod( 'masar_footer_about', '' ) ); ?></p>
				<?php masar_social_links( 'socials' ); ?>
				<?php if ( $phone || $mail || $addr ) : ?>
				<ul class="contact-list">
					<?php if ( $phone ) { echo '<li>📞 <a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a></li>'; } ?>
					<?php if ( $mail ) { echo '<li>✉️ <a href="mailto:' . esc_attr( $mail ) . '">' . esc_html( $mail ) . '</a></li>'; } ?>
					<?php if ( $addr ) { echo '<li>📍 ' . esc_html( $addr ) . '</li>'; } ?>
				</ul>
				<?php endif; ?>
			</div>
			<?php if ( 'centered' !== $fs ) :
				for ( $i = 1; $i <= 4; $i++ ) { if ( is_active_sidebar( 'footer-' . $i ) ) { echo '<div class="fcol">'; dynamic_sidebar( 'footer-' . $i ); echo '</div>'; } }
				if ( ! $any ) {
					echo '<div class="fcol"><h3 class="widget-title">روابط سريعة</h3>';
					wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'flinks', 'depth' => 1, 'fallback_cb' => function () { echo '<ul class="flinks"><li><a href="' . esc_url( home_url( '/' ) ) . '">الرئيسية</a></li></ul>'; } ) );
					echo '</div>';
				}
			endif; ?>
		</div>
		<?php if ( 'centered' === $fs ) { wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer-menu', 'depth' => 1, 'fallback_cb' => '__return_empty_string' ) ); } ?>
		<?php endif; ?>

		<div class="footer-bottom">
			<p class="copy">© <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> — <?php echo esc_html( get_theme_mod( 'masar_footer_text', 'جميع الحقوق محفوظة' ) ); ?></p>
			<?php if ( 'minimal' === $fs ) { wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer-menu', 'depth' => 1, 'fallback_cb' => '__return_empty_string' ) ); masar_social_links( 'socials' ); } ?>
			<?php if ( get_theme_mod( 'masar_footer_payments', 1 ) ) : ?>
				<div class="pay" aria-label="وسائل الدفع"><span>VISA</span><span>Mastercard</span><span>PayPal</span><span>Apple Pay</span><span>فوري</span></div>
			<?php endif; ?>
		</div>
	</div>
</footer>

<div class="petals" aria-hidden="true"></div>
<?php wp_footer(); ?>
</body>
</html>
