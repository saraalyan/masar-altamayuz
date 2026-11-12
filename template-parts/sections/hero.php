<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$st    = masar_override( 'hero_style', masar_arg( $args, 'style', 'split' ) );
$img   = masar_override( 'hero_image', masar_arg( $args, 'image', '' ) );
$title = masar_override( 'hero_title', masar_arg( $args, 'title', get_bloginfo( 'name' ) ) );
$sub   = masar_override( 'hero_sub', masar_arg( $args, 'subtitle', '' ) );
$b1    = masar_override( 'hero_btn1', masar_arg( $args, 'btn1', '' ) );
$b1u   = masar_override( 'hero_btn1_url', masar_arg( $args, 'btn1_url', '#' ) );
$b2    = masar_override( 'hero_btn2', masar_arg( $args, 'btn2', '' ) );
$b2u   = masar_override( 'hero_btn2_url', masar_arg( $args, 'btn2_url', '#' ) );
$eye   = masar_arg( $args, 'eyebrow', '' );
$emoji = masar_arg( $args, 'emoji', '✦' );
$stats = isset( $args['stats'] ) ? (array) $args['stats'] : array();
$bg    = ( 'center' === $st && $img ) ? ' style="background-image:url(' . esc_url( $img ) . ')"' : '';
?>
<section class="hero hero-<?php echo esc_attr( $st ); ?>"<?php echo $bg; // phpcs:ignore ?>>
	<div class="wrap hero-inner">
		<div class="hero-text">
			<?php if ( $eye ) : ?><span class="eyebrow"><?php echo esc_html( $eye ); ?></span><?php endif; ?>
			<h1><?php echo esc_html( $title ); ?></h1>
			<?php if ( $sub ) : ?><p><?php echo esc_html( $sub ); ?></p><?php endif; ?>
			<div class="hero-btns">
				<?php if ( $b1 ) : ?><a class="btn" href="<?php echo esc_url( $b1u ); ?>"><?php echo esc_html( $b1 ); ?></a><?php endif; ?>
				<?php if ( $b2 ) : ?><a class="btn btn-ghost" href="<?php echo esc_url( $b2u ); ?>"><?php echo esc_html( $b2 ); ?></a><?php endif; ?>
			</div>
			<?php if ( $stats ) : ?>
			<div class="hero-stats">
				<?php foreach ( $stats as $s ) { echo '<div><b>' . esc_html( $s[0] ) . '</b><small>' . esc_html( $s[1] ) . '</small></div>'; } ?>
			</div>
			<?php endif; ?>
		</div>
		<?php if ( ! in_array( $st, array( 'center', 'full' ), true ) ) : ?>
			<div class="hero-media"><?php echo masar_media( $img, $emoji ); // phpcs:ignore ?></div>
		<?php endif; ?>
	</div>
	<?php if ( 'full' === $st ) : ?>
		<div class="hero-media"><?php echo masar_media( $img, $emoji ); // phpcs:ignore ?></div>
	<?php endif; ?>
</section>
