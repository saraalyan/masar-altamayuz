<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', array(
	array( 'كم يستغرق التوصيل؟', 'من 1 إلى 3 أيام عمل داخل المدن الكبرى، وحتى 5 أيام للمحافظات.' ),
	array( 'هل يمكنني استرجاع المنتج؟', 'نعم، خلال 14 يوم من الاستلام بشرط أن يكون بحالته الأصلية.' ),
	array( 'ما وسائل الدفع المتاحة؟', 'الدفع عند الاستلام، بطاقات الائتمان، والمحافظ الإلكترونية.' ),
	array( 'كيف أتواصل معكم؟', 'عبر واتساب أو الهاتف أو البريد، وبنرد خلال ساعات العمل.' ),
) );
?>
<section class="sec sec-soft">
	<div class="wrap narrow">
		<?php masar_sec_head( $args, 'أسئلة شائعة' ); ?>
		<div class="faq">
			<?php foreach ( $items as $it ) : ?>
				<details><summary><?php echo esc_html( $it[0] ); ?></summary><p><?php echo esc_html( $it[1] ); ?></p></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
