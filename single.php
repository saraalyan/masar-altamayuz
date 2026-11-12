<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'single' ); ?>>
	<header class="single-head">
		<div class="wrap narrow">
			<div class="meta"><?php the_category( ' · ' ); ?></div>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<div class="meta"><?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( get_the_author() ); ?> · <?php echo (int) masar_reading_time(); ?> د قراءة</div>
		</div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="wrap narrow"><div class="single-img"><?php the_post_thumbnail( 'large' ); ?></div></div>
	<?php endif; ?>
	<div class="wrap narrow entry">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
		<?php the_tags( '<div class="tags">', '', '</div>' ); ?>
		<nav class="post-nav">
			<div><?php previous_post_link( '%link', '→ %title' ); ?></div>
			<div><?php next_post_link( '%link', '%title ←' ); ?></div>
		</nav>
		<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
	</div>
</article>
<?php endwhile;
get_footer();
