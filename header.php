<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
$hs = get_theme_mod( 'masar_header_style', 'split' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>try{var t=localStorage.getItem('masar-theme');if(t){document.documentElement.setAttribute('data-theme',t)}}catch(e){}</script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'تخطي إلى المحتوى', 'masar-altamayuz' ); ?></a>

<?php if ( get_theme_mod( 'masar_topbar_on', 1 ) ) : ?>
<div class="topbar">
	<div class="wrap topbar-in">
		<span><?php echo esc_html( get_theme_mod( 'masar_announce', __( 'شحن مجاني للطلبات فوق 500 جنيه  |  استرجاع سهل خلال 14 يوم', 'masar-altamayuz' ) ) ); ?></span>
		<span class="topbar-links">
			<?php
			for ( $i = 1; $i <= 2; $i++ ) {
				$l = get_theme_mod( 'masar_topbar_link' . $i, array( 1 => __( 'تتبّع طلبك', 'masar-altamayuz' ), 2 => __( 'مركز المساعدة', 'masar-altamayuz' ) )[ $i ] );
				if ( $l ) { echo '<a href="' . esc_url( get_theme_mod( 'masar_topbar_link' . $i . '_url', '' ) ?: '#' ) . '">' . esc_html( $l ) . '</a>'; }
			}
			?>
		</span>
	</div>
</div>
<?php endif; ?>

<header class="site-header<?php echo get_theme_mod( 'masar_sticky', 1 ) ? ' is-sticky' : ''; ?>">
	<div class="wrap hdr-inner">
		<div class="brand">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<a class="brand-text" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
		</div>
		<button class="nav-toggle" aria-label="<?php esc_attr_e( 'القائمة', 'masar-altamayuz' ); ?>" aria-expanded="false"><span></span><span></span><span></span></button>
		<nav class="main-nav" aria-label="<?php esc_attr_e( 'القائمة الرئيسية', 'masar-altamayuz' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'menu',
				'fallback_cb'    => function () {
					echo '<ul class="menu"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'الرئيسية', 'masar-altamayuz' ) . '</a></li></ul>';
				},
			) );
			?>
		</nav>
		<div class="hdr-actions">
			<?php if ( get_theme_mod( 'masar_show_search', 1 ) ) : ?>
				<button class="icon-btn search-toggle" aria-label="<?php esc_attr_e( 'بحث', 'masar-altamayuz' ); ?>" aria-expanded="false"><?php echo masar_icon( 'search' ); ?></button>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'masar_show_account', 1 ) ) : ?>
				<a class="icon-btn" href="<?php echo esc_url( masar_account_url() ); ?>" aria-label="<?php esc_attr_e( 'حسابي', 'masar-altamayuz' ); ?>"><?php echo masar_icon( 'user' ); ?></a>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'masar_show_theme_toggle', 1 ) ) : ?>
				<button class="icon-btn theme-toggle" aria-label="<?php esc_attr_e( 'تبديل الوضع الليلي', 'masar-altamayuz' ); ?>" title="<?php esc_attr_e( 'الوضع الليلي', 'masar-altamayuz' ); ?>"><?php echo masar_icon( 'moon', 'ico-dark' ); echo masar_icon( 'sun', 'ico-light' ); ?></button>
			<?php endif; ?>
			<?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
				<a class="icon-btn cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'السلة', 'masar-altamayuz' ); ?>"><?php echo masar_icon( 'cart' ); ?><span class="cart-count"><?php echo (int) WC()->cart->get_cart_contents_count(); ?></span></a>
			<?php endif; ?>
			<?php $cta = get_theme_mod( 'masar_header_cta', '' ); if ( $cta ) : ?>
				<a class="btn btn-sm hdr-cta" href="<?php echo esc_url( get_theme_mod( 'masar_header_cta_url', '' ) ?: '#' ); ?>"><?php echo esc_html( $cta ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="search-panel" hidden><div class="wrap"><?php get_search_form(); ?></div></div>
</header>
<main id="main" class="site-main">
