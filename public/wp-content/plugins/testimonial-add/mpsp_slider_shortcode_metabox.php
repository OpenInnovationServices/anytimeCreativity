<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function tss_mpsp_tslider_posts_shortcode($post){
    // $post is already set, and contains an object: the WordPress post
    global $post;
 //////////////////////////////////////////////////////////////////////////
                                                                        //  
                               //START                                 //
                                                                      //  
                                                                     //
    ///////  MAIN SETTINGS var assign BOX Starts HERE!!! /////////////

    $postid = $post->ID;

    ?>
    <style type="text/css">
      #mpsp_slider_posts_shortcode{
      border-top: 5px solid #A7D476;
    }
    </style>
    <p>For Testimonial slider use following shortcode :</p>
    <p style='font-weight:bold; font-size:20px;'>[tss_slider id='<?php echo $postid; ?>']</p>
    <p>For Testimonial list use following shortcode : <b>(Only Available for premium version users)</b></p>
    <p style='font-weight:bold; font-size:20px;'>[tss_list id='<?php echo $postid; ?>']</p>

    <a href="http://web-settler.com/testimonials-plugin/" target="_blank" style="font-size:17px;" id="pr_msg_link"><i>To unlock list showcase Click Here</i></a>
    
    <script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us8.list-manage.com","uuid":"46b196269ed011acb6bee800c","lid":"bdaca95686"}) })</script>

    <?php


 }


 ?>