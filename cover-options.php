<?php
/**
 * Plugin Name: Cover options
 * Plugin URI:  https://github.com/HelaGone/CoverOptions
 * Description: Cover Options for wordpress
 * Version:     1.0.0
 * Author:      Holkan Luna
 * Author URI:  https://cubeinthebox.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cover-options
 * Domain Path: /languages
 */

/*
 * Options:
 * co_banner_option
 * co_barra_a_option
 * co_barra_b_option
 * co_barra_c_option
*/

function co_activation_plugin(){
	//Plugin activation actions
}
register_activation_hook( __FILE__, 'co_activation_plugin' );

function co_deactivation(){
	//Plugin deactivation actions
}
register_deactivation_hook( __FILE__, 'co_deactivation' );

function co_uninstall(){
	//Plugin delete actions
}
register_uninstall_hook(__FILE__, 'co_uninstall');


if(!class_exists('CoverOptionsNew')):
	class CoverOptionsNew{
		public function __construct(){
			 add_action('admin_menu', array($this, 'co_add_admin_menu'));
			 add_action('admin_init', array($this, 'co_settings_init'));
		}//end construct

		public function co_add_admin_menu(){
			add_menu_page('Cover Options', 'Cover Options', 'manage_options', 'cover_options', array($this, 'co_cover_options_page'));
		}//end co_add_admin_menu

		public function co_settings_init(){
			//BANNER OPTION
			register_setting('coverOptionsPage', 'co_banner_option');
			add_settings_section('co_banner_options_section','Top Banner',array($this, 'co_banner_section_callback'),'coverOptionsPage');
			add_settings_field('co_banner_input_url','Url del banner',array($this, 'co_input_url_field_render'),'coverOptionsPage','co_banner_options_section');
			add_settings_field('co_banner_input_link','Link del banner',array($this, 'co_input_link_field_render'),'coverOptionsPage','co_banner_options_section');

			//BARRA A OPTION
			register_setting('coverOptionsPage', 'co_barra_a_option');
			add_settings_section('co_barra_a_options_section','Barra A',array($this, 'co_barra_a_section_callback'),'coverOptionsPage');
			//Nota 1
			add_settings_field('co_first_post','Nota 1:',array($this, 'co_input_first_post'),'coverOptionsPage','co_barra_a_options_section');
			//Nota 2
			add_settings_field('co_second_post','Nota 2: (opcional)',array($this, 'co_input_second_post'),'coverOptionsPage','co_barra_a_options_section');
			//Nota 3
			add_settings_field('co_third_post','Nota 3: (opcional)',array($this, 'co_input_third_post'),'coverOptionsPage','co_barra_a_options_section');
			//Nota 4
			add_settings_field(
				'co_fourth_post',
				'Nota 4: (opcional)', 
				array($this, 'co_input_fourth_post'), 
				'coverOptionsPage',
				'co_barra_a_options_section'
			);

			//BARRA B OPTION
			register_setting('coverOptionsPage', 'co_barra_b_option');
			add_settings_section(
				'co_barra_b_options_section',
				'Barra B',
				array($this, 'co_barra_b_section_callback'),
				'coverOptionsPage'
			);
			//Nota 1
			
			//Nota 2

			//Nota 3

			//BARRA C OPTION
			register_setting('coverOptionsPage', 'co_barra_c_option');
			add_settings_section(
				'co_barra_c_options_section',
				'Barra C',
				array($this, 'co_barra_c_section_callback'),
				'coverOptionsPage'
			);
			//Nota 1

			//Nota 2

			//Nota 3
		}

		public function co_input_url_field_render(){
			$options = get_option('co_banner_option'); ?>
			<input type="text" name="co_banner_option[co_banner_input_url]" value="<?php echo $options['co_banner_input_url']; ?>">
		<?php	
		}
		public function co_input_link_field_render(){ 
			$options = get_option('co_banner_option'); ?>
			<input type="text" name="co_banner_option[co_banner_input_link]" value="<?php echo $options['co_banner_input_link']; ?>">
		<?php	
		}

		//SECTION BANNER
		public function co_banner_section_callback(){
			echo 'Selecciona un banner para el home del sitio';
		}

		//SECTION BARRA A
		public function co_barra_a_section_callback(){
			echo 'Selecciona las publicaciones para la Barra A de la portada (home)';
		}

		//SECTION BARA B
		public function co_barra_b_section_callback(){
			echo 'Selecciona las publicaciones para la Barra B de la portada (home)';
		}

		//SECTION BARA C
		public function co_barra_c_section_callback(){
			echo 'Selecciona las publicaciones para la Barra C de la portada (home)';
		}

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

		public function co_input_second_post(){
			global $post;
			$options = get_option('co_barra_a_option'); 

			$args = array('post_type'=>'post','posts_per_page'=>10,'post_status'=>'publish','orderby'=>'date','order'=>'DESC', 'offset'=>10);
			$barra_a = new WP_Query($args);

			if($barra_a->have_posts()):?>
				<select name="co_barra_a_option[co_second_post]" >
					<option value="">Empty Field</option>
				<?php
					while($barra_a->have_posts()):
						$barra_a->the_post();
						setup_postdata($post);
						$is_selected = selected($post->ID, $options['co_second_post'], false);
						?>
						<option value="<?php echo esc_attr($post->ID); ?>" <?php echo $is_selected; ?>><?php the_title(); ?></option>
				<?php
					endwhile; 
					wp_reset_postdata(); ?>
				</select>
				<?php
			endif;
		}

		public function co_input_third_post(){
			global $post;
			$options = get_option('co_barra_a_option'); 

			$args = array('post_type'=>'post','posts_per_page'=>10,'post_status'=>'publish','orderby'=>'date','order'=>'DESC', 'offset'=>20);
			$barra_a = new WP_Query($args);

			if($barra_a->have_posts()):?>
				<select name="co_barra_a_option[co_third_post]" >
					<option value="">Empty Field</option>
				<?php
					while($barra_a->have_posts()):
						$barra_a->the_post();
						setup_postdata($post);
						$is_selected = selected($post->ID, $options['co_third_post'], false);
						?>
						<option value="<?php echo esc_attr($post->ID); ?>" <?php echo $is_selected; ?>><?php the_title(); ?></option>
				<?php
					endwhile; 
					wp_reset_postdata(); ?>
				</select>
				<?php
			endif;
		}

		public function co_input_fourth_post(){
			global $post;
			$options = get_option('co_barra_a_option'); 

			$args = array('post_type'=>'post','posts_per_page'=>10,'post_status'=>'publish','orderby'=>'date','order'=>'DESC', 'offset'=>30);
			$barra_a = new WP_Query($args);

			if($barra_a->have_posts()):?>
				<select name="co_barra_a_option[co_fourth_post]" >
					<option value="">Empty Field</option>
				<?php
					while($barra_a->have_posts()):
						$barra_a->the_post();
						setup_postdata($post);
						$is_selected = selected($post->ID, $options['co_fourth_post'], false);
						?>
						<option value="<?php echo esc_attr($post->ID); ?>" <?php echo $is_selected; ?>><?php the_title(); ?></option>
				<?php
					endwhile; 
					wp_reset_postdata(); ?>
				</select>
				<?php
			endif;
		}

		//POSTS BARRA A //////////////////////////////////////////////////////////////
		public function co_input_first_post_b(){
			global $post;
			$options = get_option();
		}



		public function co_cover_options_page(){ ?>
			<form action="options.php" method="post">
				<h2>Cover Options</h2>
				<?php 
					settings_fields('coverOptionsPage');
					do_settings_sections('coverOptionsPage');
					submit_button();
				?>
			</form>
		<?php
		}// end co_cover_options_page


	}// end class
endif;

if(is_admin()):
	$options_page = new CoverOptionsNew();
endif;







