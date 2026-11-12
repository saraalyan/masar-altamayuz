<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<article <?php post_class( 'card' ); ?>>
	<a class="card-img" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'masar-card' ); } else { echo '<span class="ph">🌸</span>'; } ?>
	</a>
	<div class="card-body">
		<div class="meta"><?php echo esc_html( get_the_date() ); ?> · <?php echo (int) masar_reading_time(); ?> د قراءة</div>
		<h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
		<a class="more" href="<?php the_permalink(); ?>">اقرأ المزيد ←</a>
	</div>
</article>
