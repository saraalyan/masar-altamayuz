<?php
/**
 * مسار التميز — إضافات المدونة: مسار التنقل، مقالات ذات صلة، صندوق الكاتب، أزرار المشاركة.
 * كل واحدة بتتحكم فيها من التخصيص ← إعدادات مسار التميز ← المدونة والمقالات.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** هل الخاصية دي مفعّلة؟ (الافتراضي: مفعّلة) */
function masar_blog_on( $key ) {
	return (bool) get_theme_mod( 'masar_' . $key, 1 );
}

/** عناصر مسار التنقل: مصفوفة [ عنوان, رابط أو '' ] */
function masar_breadcrumb_items() {
	$items = array( array( __( 'الرئيسية', 'masar-altamayuz' ), home_url( '/' ) ) );

	$posts_page = (int) get_option( 'page_for_posts' );
	$blog       = $posts_page ? array( get_the_title( $posts_page ), get_permalink( $posts_page ) ) : null;

	if ( is_singular( 'post' ) ) {
		if ( $blog ) { $items[] = $blog; }
		$cats = get_the_category();
		if ( $cats ) {
			$cat = $cats[0];
			$chain = array();
			foreach ( array_reverse( get_ancestors( $cat->term_id, 'category' ) ) as $aid ) {
				$a = get_term( $aid, 'category' );
				if ( $a && ! is_wp_error( $a ) ) { $chain[] = array( $a->name, get_term_link( $a ) ); }
			}
			$chain[] = array( $cat->name, get_term_link( $cat ) );
			$items   = array_merge( $items, $chain );
		}
		$items[] = array( get_the_title(), '' );
	} elseif ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $pid ) {
			$items[] = array( get_the_title( $pid ), get_permalink( $pid ) );
		}
		$items[] = array( get_the_title(), '' );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		if ( $blog && is_category() ) { $items[] = $blog; }
		$term = get_queried_object();
		if ( $term && ! empty( $term->term_id ) ) {
			if ( is_category() ) {
				foreach ( array_reverse( get_ancestors( $term->term_id, 'category' ) ) as $aid ) {
					$a = get_term( $aid, 'category' );
					if ( $a && ! is_wp_error( $a ) ) { $items[] = array( $a->name, get_term_link( $a ) ); }
				}
			}
			$items[] = array( $term->name, '' );
		}
	} elseif ( is_author() ) {
		$items[] = array( get_the_author_meta( 'display_name', (int) get_queried_object_id() ), '' );
	} elseif ( is_search() ) {
		/* translators: %s: search query */
		$items[] = array( sprintf( __( 'بحث: %s', 'masar-altamayuz' ), get_search_query() ), '' );
	} elseif ( is_404() ) {
		$items[] = array( __( 'الصفحة مش موجودة', 'masar-altamayuz' ), '' );
	} elseif ( is_home() ) {
		$items[] = array( $blog ? $blog[0] : __( 'المدونة', 'masar-altamayuz' ), '' );
	} elseif ( is_archive() ) {
		$items[] = array( wp_strip_all_tags( get_the_archive_title() ), '' );
	} else {
		return array();
	}
	return apply_filters( 'masar_breadcrumb_items', $items );
}

/** مسار التنقل (HTML). بيرجع '' في الرئيسية أو لو متوقف من التخصيص. */
function masar_breadcrumbs( $force = false ) {
	if ( ! $force && ( ! masar_blog_on( 'breadcrumbs' ) || is_front_page() ) ) { return ''; }
	$items = masar_breadcrumb_items();
	if ( count( $items ) < 2 ) { return ''; }
	$last = count( $items ) - 1;
	$out  = '<nav class="crumbs" aria-label="' . esc_attr__( 'مسار التنقل', 'masar-altamayuz' ) . '"><ol>';
	foreach ( $items as $i => $it ) {
		if ( $i === $last || '' === $it[1] || is_wp_error( $it[1] ) ) {
			$out .= '<li aria-current="page"><span>' . esc_html( $it[0] ) . '</span></li>';
		} else {
			$out .= '<li><a href="' . esc_url( $it[1] ) . '">' . esc_html( $it[0] ) . '</a></li>';
		}
	}
	return $out . '</ol></nav>';
}
add_shortcode( 'masar_breadcrumbs', function () { return masar_breadcrumbs( true ); } );

/** مقالات ذات صلة (بنفس التصنيف) داخل صفحة المقال */
function masar_related_posts( $count = 3 ) {
	if ( ! masar_blog_on( 'related_posts' ) || ! is_singular( 'post' ) ) { return; }
	$cats = wp_get_post_categories( get_the_ID() );
	$args = array( 'post_type' => 'post', 'posts_per_page' => (int) $count, 'post__not_in' => array( get_the_ID() ), 'ignore_sticky_posts' => true, 'no_found_rows' => true );
	if ( $cats ) { $args['category__in'] = $cats; }
	$q = new WP_Query( $args );
	if ( ! $q->have_posts() ) { wp_reset_postdata(); return; }
	echo '<section class="related"><h3 class="related-t">' . esc_html__( 'مقالات ذات صلة', 'masar-altamayuz' ) . '</h3><div class="posts">';
	while ( $q->have_posts() ) { $q->the_post(); get_template_part( 'template-parts/card' ); }
	echo '</div></section>';
	wp_reset_postdata();
}

/** صندوق الكاتب */
function masar_author_box() {
	if ( ! masar_blog_on( 'author_box' ) || ! is_singular( 'post' ) ) { return; }
	$id = (int) get_the_author_meta( 'ID' );
	if ( ! $id ) { return; }
	$bio = get_the_author_meta( 'description', $id );
	echo '<aside class="author-box">' . get_avatar( $id, 72, '', '', array( 'class' => 'author-av' ) ) . '<div><span class="author-k">' . esc_html__( 'كتبه', 'masar-altamayuz' ) . '</span><b class="author-n"><a href="' . esc_url( get_author_posts_url( $id ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $id ) ) . '</a></b>';
	if ( $bio ) { echo '<p>' . esc_html( $bio ) . '</p>'; }
	echo '</div></aside>';
}

/** أزرار المشاركة (روابط عادية، بدون سكربتات خارجية) */
function masar_share_buttons() {
	if ( ! masar_blog_on( 'share_buttons' ) || ! is_singular( 'post' ) ) { return; }
	$u = rawurlencode( get_permalink() );
	$t = rawurlencode( wp_strip_all_tags( get_the_title() ) );
	$b = array(
		array( 'facebook', __( 'فيسبوك', 'masar-altamayuz' ), 'https://www.facebook.com/sharer/sharer.php?u=' . $u ),
		array( 'x', __( 'إكس', 'masar-altamayuz' ), 'https://twitter.com/intent/tweet?url=' . $u . '&text=' . $t ),
		array( 'whatsapp', __( 'واتساب', 'masar-altamayuz' ), 'https://wa.me/?text=' . $t . '%20' . $u ),
	);
	echo '<div class="share"><span class="share-k">' . esc_html__( 'شاركي المقال:', 'masar-altamayuz' ) . '</span>';
	foreach ( $b as $x ) {
		/* translators: %s: network name */
		echo '<a class="share-b" href="' . esc_url( $x[2] ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( sprintf( __( 'مشاركة على %s', 'masar-altamayuz' ), $x[1] ) ) . '">' . masar_icon( $x[0] ) . '</a>'; // phpcs:ignore
	}
	echo '<button type="button" class="share-b share-copy" data-url="' . esc_url( get_permalink() ) . '" data-done="' . esc_attr__( 'تم النسخ ✓', 'masar-altamayuz' ) . '">' . esc_html__( 'نسخ الرابط', 'masar-altamayuz' ) . '</button></div>';
}
