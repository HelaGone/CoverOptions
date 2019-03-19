<?php 
	//POSTS BARRA A //////////////////////////////////////////////////////////////
	function co_input_posts($barra_name, $offset, $tag_id ){
		global $post;
		$options = get_option($barra_name); 

		$args = array('post_type'=>'post','posts_per_page'=>10,'post_status'=>'publish','orderby'=>'date','order'=>'DESC', 'offset'=>$offset);
		$barra_a = new WP_Query($args);

		if($barra_a->have_posts()):?>
			<select name='<?php echo $barra_name."[$tag_id]"; ?>' >
				<option value="">Empty Field</option>
			<?php
				while($barra_a->have_posts()):
					$barra_a->the_post();
					setup_postdata($post);
					$is_selected = selected($post->ID, $options[$tag_id], false);
					?>
					<option value="<?php echo esc_attr($post->ID); ?>" <?php echo $is_selected; ?>><?php the_title(); ?></option>
			<?php
				endwhile; 
				wp_reset_postdata(); ?>
			</select>
			<?php
		endif;
	}