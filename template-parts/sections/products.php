<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$n    = (int) masar_arg( $args, 'count', 6 );
$cols = (int) masar_arg( $args, 'cols', 4 );
$var  = masar_arg( $args, 'variant', 'grid' );
$q    = masar_query_items( $n );
$shop = (bool) $q && function_exists( 'wc_get_product' );
$demo = array( array( 'قطعة مميزة 1', '490 ج.م', '🛍️' ), array( 'قطعة مميزة 2', '350 ج.م', '👜' ), array( 'قطعة مميزة 3', '620 ج.م', '🧥' ), array( 'قطعة مميزة 4', '280 ج.م', '👟' ), array( 'قطعة مميزة 5', '540 ج.م', '⌚' ), array( 'قطعة مميزة 6', '410 ج.م', '🕶️' ) );
?>
<section class="sec sec-tight products-sec products-<?php echo esc_attr( $var ); ?>"<?php if ( ! empty( $args['id'] ) ) { echo ' id="' . esc_attr( $args['id'] ) . '"'; } ?>>
	<div class="wrap<?php echo 'side' === $var ? ' side-layout' : ''; ?>">
		<?php if ( 'side' === $var ) : ?>
			<div class="side-head">
				<h2 class="sec-title"><?php echo esc_html( masar_arg( $args, 'title', 'وصل حديثاً' ) ); ?></h2>
				<p><?php echo esc_html( masar_arg( $args, 'subtitle', '' ) ); ?></p>
				<?php if ( ! empty( $args['btn'] ) ) : ?><a class="btn btn-sm" href="<?php echo esc_url( $shop ? wc_get_page_permalink( 'shop' ) : '#' ); ?>"><?php echo esc_html( $args['btn'] ); ?></a><?php endif; ?>
			</div>
		<?php else : masar_sec_head( $args, 'منتجاتنا' ); endif; ?>

		<div class="pgrid cols-<?php echo (int) $cols; ?>">
			<?php if ( $q && $q->have_posts() ) :
				while ( $q->have_posts() ) : $q->the_post();
					$p = $shop ? wc_get_product( get_the_ID() ) : null; ?>
					<article class="pcard">
						<a class="pcard-img" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'masar-tall' ); } else { echo masar_media( '', 'sparkle' ); } ?></a>
						<h3 class="pcard-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php if ( $p ) : ?><div class="price"><?php echo wp_kses_post( $p->get_price_html() ); ?></div><?php endif; ?>
					</article>
				<?php endwhile; wp_reset_postdata();
			else :
				foreach ( array_slice( $demo, 0, $n ) as $d ) : ?>
					<article class="pcard">
						<a class="pcard-img" href="#"><?php echo masar_media( '', $d[2] ); // phpcs:ignore ?></a>
						<h3 class="pcard-title"><a href="#"><?php echo esc_html( $d[0] ); ?></a></h3>
						<div class="price"><?php echo esc_html( $d[1] ); ?></div>
					</article>
				<?php endforeach;
			endif; ?>
		</div>
	</div>
</section>
