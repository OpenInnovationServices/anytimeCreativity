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



<style type="text/css">
  #tss_warppper{
  	min-width: 350px;
    background: <?php echo get_post_meta($id,'mpsp_posts_bg_color',true); ?>;
    margin: 0 auto;
    padding: 20px;
    display: inline-block;
  }
  #ts_img{
  	max-width: 150px;
  	width: 45%;
    float: left;
    position: absolute;
  	top: 50%;
  	transform: translate(-0%, -50%);
  	margin: 0% 7% 0% 7%;
  }
  #tss_content{
  	width: 50%;
    background: <?php echo get_post_meta($id,'mpsp_posts_bg_color',true); ?>;
    text-align: left;
    float: right;

  }

  #tss_image{
  	width: 90%;
    border-radius:<?php echo get_post_meta($id,'tss_mpsp_slider_img_border',true); ?>px;
    display: initial !important;
  }

  .tss_p{
    font-size: 16px;
    font-weight: 100;
    font-family: sans-serif,verdana,arial;
    color: <?php echo get_post_meta($id,'mpsp_posts_description_color',true); ?>;
    margin:0;
  }
  #tss_name{
    font-weight: bold;
    font-size: 16px;
    margin-top: 5px;
  }

  #tss_occupation{
    font-style: italic;
    margin-top: -5px;

  }

  #tss_testimonial span{
    font-size: 29px;
    font-weight:bold;
    color: <?php echo get_post_meta($id,'mpsp_posts_description_color',true); ?>;
  }
  #tss_testimonial{
  	display: block;
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
<div id='ts_img'>
     <img id='tss_image' src="<?php  
            $tss_img = get_post_meta(get_the_ID(),'tss_image',true);
    
            if(!empty($tss_img)){
            echo get_post_meta(get_the_ID(),'tss_image',true);
          }else{
            echo plugins_url('user-icon.jpg',__FILE__);
          } ?>">
    <p class='tss_p' id='tss_name'><?php echo get_post_meta(get_the_ID(),'tss_name',true);  ?></p>
    <p class='tss_p' id='tss_occupation'><?php echo get_post_meta(get_the_ID(),'tss_ocupation',true);  ?></p>
    </div>
  <div id='tss_content'>
    
    <p class='tss_p' id='tss_testimonial'><?php echo get_post_meta(get_the_ID(),'tss_testimonial',true);  ?></p>
  </div>  
</div>


<?php endwhile;?>


               
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