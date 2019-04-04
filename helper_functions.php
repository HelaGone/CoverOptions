<?php 
	//POSTS BARRA A //////////////////////////////////////////////////////////////
	function co_input_posts($barra_name, $offset, $tag_id ){
		global $post;
		$options = get_option($barra_name); 

		$args = array('post_type'=>'post','posts_per_page'=>10,'post_status'=>'publish','orderby'=>'date','order'=>'DESC', 'offset'=>$offset);
		$barra_a = new WP_Query($args);

		if($barra_a->have_posts()):?>
			<select name='<?php echo $barra_name."[$tag_id]"; ?>' class="custom_input">
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

	function co_get_term_taxonomy($barra_name, $input_name){
		global $post;
		$options = get_option($barra_name);
		$args = array('taxonomy'=>'post_tag','hide_empty'=>false,'orderby'=>'count','order'=>'DESC');
		$terms = get_terms($args);
		if(is_array($terms)&&!empty($terms)): ?>
			<select name='<?php echo $barra_name."[$input_name]"; ?>' class="custom_input">
				<option value="">Empty Field</option>
				<?php 
					foreach ($terms as $term): 
						if($term->count >= 9):
							$is_selected = selected($term->term_id, $options[$input_name], false); ?>
							<option value="<?php echo esc_attr($term->term_id); ?>" <?php echo $is_selected;?>><?php echo esc_html($term->name); ?></option>
				<?php 
						endif;
					endforeach; ?>
			</select>
	<?php
		endif;
	}

	function co_get_tema_posts($barra_name, $input_name, $term_id){
		global $post;
		$options = get_option($barra_name);
		$args = array('post_type'=>'post','posts_per_page'=>10,'post_status'=>'publish','orderby'=>'date','order'=>'DESC','tax_query'=>array(array('taxonomy'=>'post_tag','field'=>'term_id','terms'=>array($term_id))));
		$posts = new WP_Query($args);
		if($posts->have_posts()): ?>
			<select name='<?php echo $barra_name."[$input_name]"; ?>' class="custom_input">
				<option value="">Empty Field</option>
				<?php
					while($posts->have_posts()):
						$posts->the_post();
						setup_postdata($post); 
						$is_selected = selected($post->ID, $options[$input_name], false); ?>
						<option value="<?php echo esc_attr($post->ID); ?>" <?php echo $is_selected?> >
							<?php echo esc_html($post->post_title); ?>
						</option>
				<?php		
					endwhile;
					wp_reset_postdata(); ?>
			</select>
		<?php
		endif;
	}

