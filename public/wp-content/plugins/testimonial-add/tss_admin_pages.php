<?php


add_action('admin_menu','tss_admin_menupage');
function tss_admin_menupage(){
	$menu_icon_path = plugins_url('img/icons/testimonials-icon.png',__FILE__);
	//add_menu_page( 'Testimonials', "Testimonials",'administrator', 'tss_slider','TssFrontpageUI',$menu_icon_path);
	//add_submenu_page( 'tss_slider', 'Testimonial Settings', 'Settings', 'administrator', 'administrator', 'Tss_Settings' );
	add_submenu_page( 'edit.php?post_type=tss_slider', 'Testimonials Dashboard', "Dashboard", 'administrator', 'tss_slider','TssFrontpageUI');
}