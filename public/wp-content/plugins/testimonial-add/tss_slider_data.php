<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function tss_slider_data($post){
    // $post is already set, and contains an object: the WordPress post
    global $post;
 //////////////////////////////////////////////////////////////////////////
                                                                        //  
                               //START                                 //
                                                                      //  
                                                                     //
    ///////  MAIN SETTINGS var assign BOX Starts HERE!!! /////////////

   // $example = get_post_meta($post->ID,'example',true);

    $tss_name = get_post_meta($post->ID,'tss_name',true);
    $tss_ocupation = get_post_meta($post->ID,'tss_ocupation',true);
    $tss_image = get_post_meta($post->ID,'tss_image',true);
    $tss_testimonial = get_post_meta($post->ID,'tss_testimonial',true);
 



    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

?>
<div class='formLayout'>
<div id="mpsp_posts_settings">
<br>
<br>
 <label> Name :  </label>
 <input type="text" style="width:200px;" name="tss_name" value="<?php echo $tss_name;  ?>">

<br>
<br>
<label> Occupation :  </label>
<input type="text" style="width:200px;" name="tss_ocupation" value="<?php echo $tss_ocupation;  ?>">

<br>
<br>
<label> Clients Image URL :  </label>
<input id="image_profile" type="text" class="upload_image_button1"  name="tss_image" value='<?php echo $tss_image; ?>' style='width:200px;'  placeholder='Image URL'/>
<input id="image_profile" type="button" class="tss_upload_bg" data-id="1" value="Upload Image" />

<br>
<br>
<label> Testimonial :  </label>
<textarea rows="15" cols="30" name="tss_testimonial"><?php echo $tss_testimonial; ?></textarea>

 </div>

 </div>
 <script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us8.list-manage.com","uuid":"46b196269ed011acb6bee800c","lid":"bdaca95686"}) })</script>
 
 <?php

 } 


 ?>