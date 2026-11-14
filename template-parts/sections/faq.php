<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', masar_faq_defaults() );
?>
<section class="sec sec-soft">
	<div class="wrap narrow">
		<?php masar_sec_head( $args, __( 'أسئلة شائعة', 'masar-altamayuz' ) ); ?>
		<div class="faq">
			<?php foreach ( $items as $it ) : ?>
				<details><summary><?php echo esc_html( $it[0] ); ?></summary><p><?php echo esc_html( $it[1] ); ?></p></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
