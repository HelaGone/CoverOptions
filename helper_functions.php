<?php 
	//POSTS BARRA A //////////////////////////////////////////////////////////////
	public function co_input_first_post(){
		global $post;
		$options = get_option('co_barra_a_option'); 

		$args = array('post_type'=>'post','posts_per_page'=>10,'post_status'=>'publish','orderby'=>'date','order'=>'DESC');
		$barra_a = new WP_Query($args);

		if($barra_a->have_posts()):?>
			<select name="co_barra_a_option[co_first_post]" >
				<option value="">Empty Field</option>
			<?php
				while($barra_a->have_posts()):
					$barra_a->the_post();
					setup_postdata($post);
					$is_selected = selected($post->ID, $options['co_first_post'], false);
					?>
					<option value="<?php echo esc_attr($post->ID); ?>" <?php echo $is_selected; ?>><?php the_title(); ?></option>
			<?php
				endwhile; 
				wp_reset_postdata(); ?>
			</select>
			<?php
		endif;
	}