<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<form id="custom-post-type" name="custom-post-type" method="post" action="">
 
<p><label for="title">Name</label><br />
 
<input type="text" id="title" value="" tabindex="1" size="20" name="title"  />
 
</p>

<p><label for="tss_occupation">Occupation</label><br />
 
<input type="text" id="tss_occupation" value="" tabindex="1" name="tss_occupation"  />
 
</p>

<p><label for="tss_image_input">Image URL</label><br />
 
<input type="url" id="tss_image_input" value="" tabindex="1" name="tss_image_input" />
 
</p>
 
<p><label for="tss_testimonial">Testimonial</label><br />
 
<textarea id="tss_testimonial" tabindex="3" name="tss_testimonial" cols="50" rows="6"  ></textarea>
 
</p> 

<p align="right"><input type="submit" value="Publish" tabindex="6" id="submit" name="submit" /></p>
 
<input type="hidden" name="post-type" id="post-type" value="custom_posts" />
 
<input type="hidden" name="action" value="custom_posts" />
 
 
</form>
