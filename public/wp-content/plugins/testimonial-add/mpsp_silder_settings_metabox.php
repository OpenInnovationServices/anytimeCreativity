<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function tss_mpsp_slider_settings($post){
    // $post is already set, and contains an object: the WordPress post
    global $post;
 //////////////////////////////////////////////////////////////////////////
                                                                        //  
                               //START                                 //
                                                                      //  
                                                                     //
    ///////  MAIN SETTINGS var assign BOX Starts HERE!!! /////////////

    $example = get_post_meta($post->ID,'example',true);

    $mpsp_posts_bg_color = get_post_meta($post->ID,'mpsp_posts_bg_color',true);
    $mpsp_posts_heading_color = get_post_meta($post->ID,'mpsp_posts_heading_color',true);
    $mpsp_posts_description_color = get_post_meta($post->ID,'mpsp_posts_description_color',true);
    $mpsp_slide_speed = get_post_meta($post->ID,'mpsp_slide_speed',true);
    $mpsp_slide_transistion = get_post_meta($post->ID,'mpsp_slide_transistion',true);
    $mpsp_slide_single = get_post_meta($post->ID,'mpsp_slide_single',true);
    $mpsp_slide_autoplay = get_post_meta($post->ID,'mpsp_slide_autoplay',true);
    $mpsp_slide_pagination = get_post_meta($post->ID,'mpsp_slide_pagination',true);
    $mpsp_slide_pagination_numbers = get_post_meta($post->ID,'mpsp_slide_pagination_numbers',true);
    $mpsp_slide_main_head_bar = get_post_meta($post->ID,'mpsp_slide_main_head_bar',true);
    $mpsp_slide_main_heading = get_post_meta($post->ID,'mpsp_slide_main_heading',true);
    $mpsp_slide_navigation = get_post_meta($post->ID,'mpsp_slide_navigation',true);
    $mpsp_slide_nav_button_position = get_post_meta($post->ID,'mpsp_slide_nav_button_position',true);
    $mpsp_slide_nav_button_color = get_post_meta($post->ID,'mpsp_slide_nav_button_color',true);
    $mpsp_slide_custom_width = get_post_meta($post->ID,'mpsp_slide_custom_width',true);
    $mpsp_slider_id = get_post_meta($post->ID,'mpsp_slider_id',true);
    $tss_mpsp_slider_img_border = get_post_meta($post->ID,'tss_mpsp_slider_img_border',true);
    $mpsp_postid = $post->ID;



    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );


    ?>
   
    </style>
	<div class='formLayout'> 
    <div id="mpsp__slider_settings">
    <input type='hidden' name='mpsp_slider_id' value='<?php echo $mpsp_postid; ?>'>

      <br>
      <br>
      <br>

      <label for="mpsp_posts_bg_color">Background Color :</label>
      <input type="text" class='tss-color-picker' name="mpsp_posts_bg_color" value="<?php echo $mpsp_posts_bg_color; ?>">
      <br>
      <br>
     
    <label for="mpsp_posts_description_color">Text Color :</label>
      <input type="text" class='tss-color-picker' name="mpsp_posts_description_color" value="<?php echo $mpsp_posts_description_color; ?>">

      <br>
      <br>
      

      <label for="mpsp_slide_speed">Slide Speed :</label>
      <input type="number" name="mpsp_slide_speed" value="<?php echo $mpsp_slide_speed; ?>" placeholder="200" required='required'>
      <p class='field_desc'>This will be the speed of slides delay when auto play enabled (In seconds)</p>
      <br>
      <br>

    <label for="mpsp_slide_transistion">Select Transition :</label>
    <select name="mpsp_slide_transistion">
      <option value="false"

      <?php selected( 'false', $mpsp_slide_transistion); ?> >none</option>
      <option value="'fade'"

      <?php selected( "'fade'",$mpsp_slide_transistion ); ?> >fade</option>
      <option value="'backSlide'"
      <?php selected( "'backSlide'", $mpsp_slide_transistion ); ?>
      >backSlide</option>
      <option value="'goDown'"
<?php selected( "'goDown'",$mpsp_slide_transistion ); ?>

      >goDown</option>
      <option value="'fadeUp'"
<?php selected( "'fadeUp'", $mpsp_slide_transistion ); ?>

      >fadeUp</option>

      </select>

      <br>
     <br>

    
      <label for="mpsp_slide_single"> Carousel :</label>
      <input type="number" placeholder="Number of testimonials" name="mpsp_slide_single" value="<?php echo $mpsp_slide_single; ?>" style="width:190px;" min="1" max="4" required='required' >
      <p class='field_desc'> To display more than one testimonial in single slide.</p>
      <br>

      <label for="mpsp_slide_autoplay">Auto Play :</label>
      <select name="mpsp_slide_autoplay">
        <option value="true"
<?php selected( "true", $mpsp_slide_autoplay ); ?>


        >Enable</option>
        <option value="false"
<?php selected( "false", $mpsp_slide_autoplay ); ?>


        >Disable</option>

      </select>
      <br>
      <br>


      <label for="mpsp_slide_pagination"> Pagination :</label>
      <select name="mpsp_slide_pagination">
        <option value="true"
<?php selected( "true", $mpsp_slide_pagination ); ?>


        >Enable</option>
        <option value="false"
<?php selected( "false",$mpsp_slide_pagination ); ?>


        >Disable</option>

      </select>
      <br>
      <br>
      <label for="mpsp_slide_pagination_numbers">Pagination Numbers :</label>
      <select name="mpsp_slide_pagination_numbers">
        <option value="true"
<?php selected( "true", $mpsp_slide_pagination_numbers ); ?>


        >Enable</option>
        <option value="false"
<?php selected( "false",$mpsp_slide_pagination_numbers ); ?>


        >Disable</option>

      </select>    
      <br>
      <br>
      <label for="mpsp_slide_navigation">Navigation Buttons</label>
      <select name="mpsp_slide_navigation">
        <option value="true" <?php selected( 'true', $mpsp_slide_navigation ); ?>>Enable</option>
        <option value="false" <?php selected( 'false', $mpsp_slide_navigation ); ?>>Disable</option>
      </select>
      <br>
      <br>

            <label for="mpsp_slide_nav_button_position">Navigation Buttons Position :</label>
      <select name="mpsp_slide_nav_button_position">
        <option value=""
<?php selected( "", $mpsp_slide_nav_button_position ); ?>

        >Default</option>
        <option value="<style type='text/css'>.owl-buttons{text-align:right;}</style>"    
<?php selected( "<style type='text/css'>.owl-buttons{text-align:right;}</style>", $mpsp_slide_nav_button_position ); ?>


     >Right</option>
        <option value="<style type='text/css'> .owl-buttons{ text-align:left; }</style>"
<?php selected( "<style type='text/css'> .owl-buttons{ text-align:left; }</style>", $mpsp_slide_nav_button_position ); ?>


        >Left</option>

      </select>
      <br>
      <br>
      <label for="mpsp_slide_nav_button_color">Navigation Buttons Color :</label>
      <input type="text" class='tss-color-picker' name="mpsp_slide_nav_button_color" value="<?php echo $mpsp_slide_nav_button_color; ?>">
      <br>
      <br>
      <label for="">Image Border Radius :</label>
      <select name="tss_mpsp_slider_img_border">
        <option value="100"
<?php selected( "100", $tss_mpsp_slider_img_border ); ?>


        >Round</option>
        <option value="2"
          <?php selected( "2",$tss_mpsp_slider_img_border ); ?>
        >Square</option>
        <option value="20"
          <?php selected( "20",$tss_mpsp_slider_img_border ); ?>
        >Curved Edges</option>

      </select>   
      
      <br>
      <br>
     
    <script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us8.list-manage.com","uuid":"46b196269ed011acb6bee800c","lid":"bdaca95686"}) })</script>
    </div>
</div>
<style type="text/css">
  .field_desc{
      color:#636363;
      font-style: italic;
      font-size: 14px;
      margin-left: 260px;
    }
        #post-preview,#edit-slug-box{
        display: none;
    }
</style>


<?php 
}





 ?>