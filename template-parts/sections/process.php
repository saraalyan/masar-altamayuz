<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', array() );
if ( ! $items ) { return; }
?>
<section class="sec sec-soft">
	<div class="wrap">
		<?php masar_sec_head( $args, 'خطوات العمل' ); ?>
		<ol class="steps">
			<?php foreach ( $items as $i => $it ) : ?>
				<li><span class="step-n"><?php echo (int) ( $i + 1 ); ?></span><b><?php echo esc_html( $it[0] ); ?></b><small><?php echo esc_html( $it[1] ); ?></small></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
