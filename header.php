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
<a class="skip" href="#main">تخطي إلى المحتوى</a>

<?php if ( get_theme_mod( 'masar_topbar_on', 1 ) ) : ?>
<div class="topbar">
	<div class="wrap topbar-in">
		<span><?php echo esc_html( get_theme_mod( 'masar_announce', '' ) ); ?></span>
		<span class="topbar-links">
			<?php
			for ( $i = 1; $i <= 2; $i++ ) {
				$l = get_theme_mod( 'masar_topbar_link' . $i, '' );
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
		<button class="nav-toggle" aria-label="القائمة" aria-expanded="false"><span></span><span></span><span></span></button>
		<nav class="main-nav" aria-label="القائمة الرئيسية">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'menu',
				'fallback_cb'    => function () {
					echo '<ul class="menu"><li><a href="' . esc_url( home_url( '/' ) ) . '">الرئيسية</a></li></ul>';
				},
			) );
			?>
		</nav>
		<div class="hdr-actions">
			<?php if ( get_theme_mod( 'masar_show_search', 1 ) ) : ?>
				<button class="icon-btn search-toggle" aria-label="بحث" aria-expanded="false">🔍</button>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'masar_show_account', 1 ) ) : ?>
				<a class="icon-btn" href="<?php echo esc_url( masar_account_url() ); ?>" aria-label="حسابي">👤</a>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'masar_show_theme_toggle', 1 ) ) : ?>
				<button class="icon-btn theme-toggle" aria-label="تبديل الوضع الليلي" title="الوضع الليلي">🌙</button>
			<?php endif; ?>
			<?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
				<a class="icon-btn cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="السلة">🛒<span class="cart-count"><?php echo (int) WC()->cart->get_cart_contents_count(); ?></span></a>
			<?php endif; ?>
			<?php $cta = get_theme_mod( 'masar_header_cta', '' ); if ( $cta ) : ?>
				<a class="btn btn-sm hdr-cta" href="<?php echo esc_url( get_theme_mod( 'masar_header_cta_url', '' ) ?: '#' ); ?>"><?php echo esc_html( $cta ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="search-panel" hidden><div class="wrap"><?php get_search_form(); ?></div></div>
</header>
<main id="main" class="site-main">
