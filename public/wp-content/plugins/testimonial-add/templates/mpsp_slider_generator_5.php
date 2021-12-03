<?php echo get_post_meta($id,'mpsp_slide_nav_button_position',true); ?>
<style>
.owl-pagination{
}
.owl-buttons{
  color:<?php echo get_post_meta($id,'mpsp_slide_nav_button_color',true);?>
}

.owl-buttons {
  margin-top: -20px !important;
}
.owl-item{
  text-align: center;
}


</style>



<div id="mpsp_wrapper" style= "padding:10px;border-radius:5px; width:<?php echo get_post_meta($id,'mpsp_slide_custom_width',true); ?>;  <?php echo $mpsp_slide_gradient; ?>    ">


<style type="text/css">
@import url(https://fonts.googleapis.com/css?family=Pacifico);


  #tss_warppper{
    background: <?php echo get_post_meta($id,'mpsp_posts_bg_color',true); ?>;
    margin: 0 auto;
    padding: 20px;
    display: inline-block;
    width: 80%;
    border-radius: 6px;
  }
  #ts_img{
    width: 90%;
    display: inline-block;
    margin-top: 10% 10% 10% 10%;
  }
  #tss_content{
    background: <?php echo get_post_meta($id,'mpsp_posts_bg_color',true); ?>;
    text-align: left;
  }

  #tss_image{
    width: 100px;
    height: 100px;
    float: right;
    text-align: left;
    border-radius:<?php echo get_post_meta($id,'tss_mpsp_slider_img_border',true); ?>px;
    
  }

  .tss_p{
    font-size: 14px;
    font-weight: 100;
    float: left;
    font-family: sans-serif,verdana,arial;
    color: <?php echo get_post_meta($id,'mpsp_posts_description_color',true); ?>;
  }
  #tss_name{
    font-weight: bold;
    font-family: 'Pacifico', cursive;
    font-size: 2.6rem;
    margin-top: 6%;
    margin-left: 4%;
  }

  #tss_occupation{
    font-style: italic;
    margin-top: -8px;
    margin-left: -15px;

  }

  #tss_testimonial span{
    font-size: 29px;
    font-weight:bold;
    color: <?php echo get_post_meta($id,'mpsp_posts_description_color',true); ?>;
  }
  #tss_testimonial{
    font-size: 15px;
  }
  </style>

  
             
              <div id="<?php echo 'tss_id'.$id; ?>" class="owl-carousel" style='text-align:center;'>
                
          <?php

$args = array (
                    'post_type'              => 'tss_data',
                    'category_name'          => get_post_meta($id,'mpsp_posts_value',true), 
                    'posts_per_page'         => get_post_meta($id,'mpsp_posts_visible',true),
                    'order'                  => get_post_meta($id,'mpsp_posts_order',true),
                    'orderby'                => get_post_meta($id,'mpsp_posts_orderby',true),

                  );



// The Query
                  $the_query = new WP_Query( $args );

          while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
          

<div id='tss_warppper'>
  <div id='tss_content'>    
    <p class='tss_p' id='tss_testimonial'><?php echo get_post_meta(get_the_ID(),'tss_testimonial',true);  ?></p>
  </div>
  <div id='ts_img'>
     <img id='tss_image' src="<?php  
            $tss_img = get_post_meta(get_the_ID(),'tss_image',true);
    
            if(!empty($tss_img)){
            echo get_post_meta(get_the_ID(),'tss_image',true);
          }else{
            echo plugins_url('user-icon.jpg',__FILE__);
          } ?>">
    <p class='tss_p' id='tss_name'><?php echo get_post_meta(get_the_ID(),'tss_name',true);  ?></p>
    </div> 
</div>


<?php endwhile;?>


               
            </div>

          </div>

<script>

jQuery(document).ready(function() {
          
 
  jQuery("<?php echo '#tss_id'.$id; ?>").owlCarousel({
    items :<?php echo  get_post_meta($id,'mpsp_slide_single',true); ?>,
    singleItem: true,
    autoPlay : <?php echo get_post_meta($id,'mpsp_slide_autoplay',true); ?>,
    stopOnHover : true,
    navigation: <?php echo  get_post_meta($id,'mpsp_slide_navigation',true); ?>,
    paginationSpeed : <?php echo  get_post_meta($id,'mpsp_slide_speed',true); ?>00,
    goToFirstSpeed : <?php echo  get_post_meta($id,'mpsp_slide_speed',true); ?>00,
    singleItem : false,
    autoHeight : true,
    slideSpeed : <?php echo  get_post_meta($id,'mpsp_slide_speed',true); ?>000,
    transitionStyle: <?php echo  get_post_meta($id,'mpsp_slide_transistion',true); ?>,
    pagination : <?php echo  get_post_meta($id,'mpsp_slide_pagination',true); ?>,
    paginationNumbers :<?php echo  get_post_meta($id,'mpsp_slide_pagination_numbers',true); ?>,
    navigationText : ["<b><</b>", "<b>></b>"],

  });
});

</script>