<?php
/**
 * مسار التميز — وسوم المشاركة (Open Graph / Twitter) وبيانات منظمة (JSON-LD).
 * بتتعطل تلقائياً لو إضافة SEO معروفة مفعّلة عشان ما يحصلش تكرار.
 * لتعطيلها يدوياً: add_filter( 'masar_enable_seo', '__return_false' );
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_seo_enabled() {
	$plugin = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'THE_SEO_FRAMEWORK_VERSION' );
	return (bool) apply_filters( 'masar_enable_seo', ! $plugin );
}

function masar_seo_clean( $text, $max = 160 ) {
	$text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( strip_shortcodes( (string) $text ) ) ) );
	return mb_strlen( $text ) > $max ? rtrim( mb_substr( $text, 0, $max - 1 ) ) . '…' : $text;
}

function masar_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		$u = get_the_post_thumbnail_url( null, 'large' );
		if ( $u ) { return $u; }
	}
	$logo = get_theme_mod( 'custom_logo' );
	if ( $logo ) {
		$u = wp_get_attachment_image_url( (int) $logo, 'large' );
		if ( $u ) { return $u; }
	}
	$icon = get_site_icon_url( 512 );
	return $icon ? $icon : '';
}

function masar_seo_url() {
	global $wp;
	if ( is_singular() ) { return get_permalink(); }
	if ( is_front_page() ) { return home_url( '/' ); }
	return trailingslashit( home_url( $wp->request ) );
}

function masar_seo_description() {
	if ( is_singular() ) { return masar_seo_clean( get_the_excerpt() ); }
	if ( is_category() || is_tag() || is_tax() ) { return masar_seo_clean( term_description() ); }
	if ( is_front_page() || is_home() ) { return masar_seo_clean( get_bloginfo( 'description' ) ); }
	return '';
}

function masar_seo_head() {
	if ( ! masar_seo_enabled() || is_404() || is_search() ) { return; }
	$title = wp_get_document_title();
	$desc  = masar_seo_description();
	$img   = masar_seo_image();
	$url   = masar_seo_url();
	$type  = ( is_singular( 'post' ) ) ? 'article' : 'website';

	if ( $desc ) { echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n"; }
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc ) { echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n"; }
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:locale" content="' . esc_attr( str_replace( '-', '_', get_locale() ) ) . '">' . "\n";
	if ( $img ) { echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n"; }
	echo '<meta name="twitter:card" content="' . ( $img ? 'summary_large_image' : 'summary' ) . '">' . "\n";

	$data = array();
	if ( is_front_page() ) {
		$org = array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) );
		$logo = get_theme_mod( 'custom_logo' ) ? wp_get_attachment_image_url( (int) get_theme_mod( 'custom_logo' ), 'full' ) : '';
		if ( $logo ) { $org['logo'] = $logo; }
		$data[] = array_merge( array( '@context' => 'https://schema.org' ), $org );
		$data[] = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'WebSite',
			'name'            => get_bloginfo( 'name' ),
			'url'             => home_url( '/' ),
			'potentialAction' => array( '@type' => 'SearchAction', 'target' => home_url( '/?s={search_term_string}' ), 'query-input' => 'required name=search_term_string' ),
		);
	}
	if ( is_singular( 'post' ) ) {
		$art = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'Article',
			'headline'         => masar_seo_clean( get_the_title(), 110 ),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'publisher'        => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ) ),
			'mainEntityOfPage' => get_permalink(),
		);
		if ( get_the_author() ) { $art['author'] = array( '@type' => 'Person', 'name' => get_the_author() ); }
		if ( $img ) { $art['image'] = $img; }
		$data[] = $art;
	}
	foreach ( $data as $d ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $d, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'masar_seo_head', 5 );
