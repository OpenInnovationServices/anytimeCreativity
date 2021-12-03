<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('wp_head','tss_form_options_set_to_head');
function tss_form_options_set_to_head(){
 // $option = get_option('some option');

  //SLider 
  $tss_post_testimonial_message = get_option('tss_post_testimonial_message');
  $tss_testimonial_type = get_option('tss_testimonial_type');
  
}


register_activation_hook(__FILE__,'tss_subscribe_me_add_options');
function tss_subscribe_me_add_options() {

	add_option('tss_post_testimonial_message','');
	add_option('tss_testimonial_type','');


}





add_action('admin_init','tss_forms_register_options');
function tss_forms_register_options(){
  // register_setting('mpsp_options_group','option');
	register_setting('tss_form_options_group','tss_post_testimonial_message');
	register_setting('tss_form_options_group','tss_testimonial_type');

}


function Tss_Settings(){
	$tss_post_testimonial_message = get_option('tss_post_testimonial_message');
  	$tss_testimonial_type = get_option('tss_testimonial_type');
  	?>
  	<h3>Testimonial Settings</h3>
	<form method="post" action="options.php" class="lpp_form">
	      <?php settings_fields( 'tss_form_options_group' );?>
	      <?php do_settings_sections( 'tss_form_options_group' );?>
	      <label for="tss_testimonial_type" class="lpp_label">Select default status of published testimonial : </label>
	      <select id='tss_testimonial_type' name="tss_testimonial_type" class="lpp_input">
	      	<option value="publish" <?php echo selected('publish', $tss_testimonial_type);  ?> > Publish  </option>
	      	<option value="pending" <?php echo selected('pending', $tss_testimonial_type);  ?> > Pending  </option>
	      </select>
	      <br>
	      <br>  

	      <?php
	      $tss_post_testimonial_message = get_option('tss_post_testimonial_message' );
	      if (!empty($tss_post_testimonial_message)) {
	      		$settings = array('media_buttons'=> true,'tss_post_testimonial_message','textarea_rows' => 23);
				wp_editor( $tss_post_testimonial_message, 'tss_post_testimonial_message', $settings ); 
	      }else{
	      	$settings = array('media_buttons'=> true,'tss_post_testimonial_message','textarea_rows' => 23);
			wp_editor( 'Enter post testimonial submission message.', 'tss_post_testimonial_message', $settings ); 
	      }
		
		submit_button();?>


	</form>

	<style type="text/css">
	.lpp_form{
		width:800px;
	}
	.lpp_input{
		display: block;
		width:200px; 
		height:40px;
		font-size:16px;
		text-align: left;
	}
	.lpp_label{
		display: block;
		float: left;
		font-size: 12px;
		width: 300px;
		margin-right: 20px;
	}
	</style>


<?php 
}



 ?>