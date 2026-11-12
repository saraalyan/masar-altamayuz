<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$q = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) );
?>
<section class="journal journal-<?php echo esc_attr( masar_arg( $args, 'variant', 'light' ) ); ?>">
	<div class="wrap journal-in">
		<div class="journal-text">
			<span class="kicker">المجلة</span>
			<h2><?php echo esc_html( masar_arg( $args, 'title', 'من مدونتنا' ) ); ?></h2>
			<p><?php echo esc_html( masar_arg( $args, 'subtitle', '' ) ); ?></p>
			<a class="btn btn-ghost btn-sm" href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/' ) ); ?>">اقرأ المجلة</a>
		</div>
		<div class="journal-posts">
			<?php if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post(); ?>
				<a class="jp" href="<?php the_permalink(); ?>"><span class="jp-img"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'masar-card' ); } else { echo masar_media( '', 'sparkle' ); } ?></span><b><?php the_title(); ?></b></a>
			<?php endwhile; wp_reset_postdata(); else : foreach ( array( 'sparkle', 'gift', 'bag' ) as $e ) { echo '<a class="jp" href="#"><span class="jp-img">' . masar_media( '', $e ) . '</span><b>مقال قريباً</b></a>'; } endif; ?>
		</div>
	</div>
</section>
