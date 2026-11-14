<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( post_password_required() ) { return; } ?>
<section class="comments" id="comments">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title"><?php echo esc_html( sprintf( __( '%d تعليق', 'masar-altamayuz' ), (int) get_comments_number() ) ); ?></h3>
		<ol class="comment-list"><?php wp_list_comments( array( 'style' => 'ol', 'avatar_size' => 48 ) ); ?></ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>
	<?php comment_form( array( 'title_reply' => __( 'اترك تعليقك', 'masar-altamayuz' ), 'label_submit' => __( 'إرسال', 'masar-altamayuz' ), 'class_submit' => 'btn' ) ); ?>
</section>
