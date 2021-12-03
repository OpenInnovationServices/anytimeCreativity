( function($) {

	'use strict';

	/* Media Uploader */
	$( document ).on( 'click', '.lswss-img-uploader', function() {

		var imgfield, showfield, file_frame;
		imgfield			= jQuery(this).prev('input').attr('id');
		showfield 			= jQuery(this).parents('td').find('.lswss-imgs-preview');
		var multiple_img	= jQuery(this).attr('data-multiple');
		multiple_img 		= (typeof(multiple_img) != 'undefined' && multiple_img == 'true') ? true : false;
			
		/* new media uploader */
		var button = jQuery(this);

		/* If the media frame already exists, reopen it. */
		if ( file_frame ) {
			file_frame.open();
		  return;
		}

		if( multiple_img == true ) {
			
			/* Create the media frame. */
			file_frame = wp.media.frames.file_frame = wp.media({
				title: button.data( 'title' ),
				button: {
					text: button.data( 'button-text' ),
				},
				multiple: true /* Set to true to allow multiple files to be selected */
			});

		} else {
			
			/* Create the media frame. */
			file_frame = wp.media.frames.file_frame = wp.media({
				frame: 'post',
				state: 'insert',
				title: button.data( 'title' ),
				button: {
					text: button.data( 'button-text' ),
				},
				multiple: false /* Set to true to allow multiple files to be selected */
			});
		}

		file_frame.on( 'menu:render:default', function(view) {
			/* Store our views in an object */
			var views = {};
			
			/* Unset default menu items */
			view.unset('library-separator');
			view.unset('gallery');
			view.unset('featured-image');
			view.unset('embed');
			
			/* Initialize the views in our view object. */
			view.set(views);
		});

		/* When an image is selected, run a callback. */
		file_frame.on( 'select', function() {
			
			/* Get selected size from media uploader */
			var selected_size = $('.attachment-display-settings .size').val();
			var selection = file_frame.state().get('selection');
			
			selection.each( function( attachment, index ) {
				
				attachment = attachment.toJSON();

				/* Selected attachment url from media uploader */
				var attachment_id = attachment.id ? attachment.id : '';
				if( attachment_id && attachment.sizes && multiple_img == true ) {
					
					var attachment_url 			= attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
					var attachment_edit_link	= attachment.editLink ? attachment.editLink : '';

					showfield.append('\
						<div class="lswss-img-wrp">\
							<div class="lswss-img-tools lswss-hide">\
								<span class="lswss-tool-icon lswss-edit-img dashicons dashicons-edit" title="'+WplswssAdmin.img_edit_popup_text+'"></span>\
								<a href="'+attachment_edit_link+'" target="_blank" title="'+WplswssAdmin.attachment_edit_text+'"><span class="lswss-tool-icon lswss-edit-attachment dashicons dashicons-visibility"></span></a>\
								<span class="lswss-tool-icon lswss-del-tool lswss-del-img dashicons dashicons-no" title="'+WplswssAdmin.img_delete_text+'"></span>\
							</div>\
							<img class="lswss-img" src="'+attachment_url+'" alt="" />\
							<input type="hidden" class="lswss-attachment-no" name="lswss_img[]" value="'+attachment_id+'" />\
						</div>\
							');
					showfield.find('.lswss-img-placeholder').hide();
				}
			});
		});
		
		/* When an image is selected, run a callback. */
		file_frame.on( 'insert', function() {
			
			/* Get selected size from media uploader */
			var selected_size = $('.attachment-display-settings .size').val();
			
			var selection = file_frame.state().get('selection');
			selection.each( function( attachment, index ) {
				attachment = attachment.toJSON();
				
				/* Selected attachment url from media uploader */
				var attachment_url = attachment.sizes[selected_size].url;
				
				/* place first attachment in field */
				$('#'+imgfield).val(attachment_url);
				showfield.html('<img src="'+attachment_url+'" />');
			});
		});
		
		/* Finally, open the modal */
		file_frame.open();
	});
	
	/* Remove Single Gallery Image */
	$(document).on('click', '.lswss-del-img', function(){
		
		$(this).closest('.lswss-img-wrp').fadeOut(300, function(){ 
			$(this).remove();
			
			if( $('.lswss-img-wrp').length == 0 ){
				$('.lswss-img-placeholder').show();
			}
		});
	});

	/* Remove All Gallery Image */
	$(document).on('click', '.lswss-del-gallery-imgs', function() {

		var ans = confirm('Are you sure to remove all logo images!');

		if( ans ) {
			$('.lswss-gallery-imgs-wrp .lswss-img-wrp').remove();
			$('.lswss-img-placeholder').fadeIn();
		}
	});

	/* Image ordering (Drag and Drop) */
	$('.lswss-gallery-imgs-wrp').sortable({
		items: '.lswss-img-wrp',
		cursor: 'move',
		scrollSensitivity:40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.8,
		placeholder: 'lswss-gallery-placeholder',
		containment: '.lswss-post-sett-table',
		start:function(event,ui){
			ui.item.css('background-color','#f6f6f6');
		},
		stop:function(event,ui){
			ui.item.removeAttr('style');
		}
	});

	/* Open Attachment Data Popup */
	$(document).on('click', '.lswss-img-wrp .lswss-edit-img', function(){
		
		$('.lswss-img-data-wrp').show();
		$('.lswss-popup-overlay').show();
		$('body').addClass('lswss-no-overflow');
		$('.lswss-img-loader').show();

		var current_obj 	= $(this);
		var attachment_id 	= current_obj.closest('.lswss-img-wrp').find('.lswss-attachment-no').val();

		var data = {
						action			: 'lswss_get_attachment_edit_form',
						attachment_id	: attachment_id
					};

		$.post(ajaxurl, data, function(result) {
			if( result.success == 1 ) {
				$('.lswss-img-data-wrp  .lswss-popup-body-wrp').html( result.data );
				$('.lswss-img-loader').hide();
			}
		});
	});

	/* Close Popup */
	$(document).on('click', '.lswss-popup-close', function(){
		lswss_hide_popup();
	});

	/* `Esc` key is pressed */
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			lswss_hide_popup();
		}
	});

	/* Save Attachment Data */
	$(document).on('click', '.lswss-save-attachment-data', function() {

		var current_obj = $(this);

		current_obj.attr('disabled','disabled');
		current_obj.parent().find('.spinner').css('visibility', 'visible');

		var data = {
						action      	: 'lswss_save_attachment_data',
						attachment_id   : current_obj.attr('data-id'),
						form_data		: current_obj.closest('form.lswss-attachment-form').serialize()
					};
		$.post( ajaxurl, data, function(result) {

			if( result.success == 1 ) {
				current_obj.closest('form').find('.lswss-success').html(result.msg).fadeIn().delay(3000).fadeOut();
			} else if( result.success == 0 ) {
				current_obj.closest('form').find('.lswss-error').html(result.msg).fadeIn().delay(3000).fadeOut();
			}
			current_obj.removeAttr('disabled','disabled');
			current_obj.parent().find('.spinner').css('visibility', '');
		});
	});
	
	/* On change of button type */
	$(document).on('change', '.lswss-sdetails-tbl .lswss-display-type', function() { 
		var selected_button = $(this).val();
		
		if(selected_button == 'slider') {
			$( ".lswss-slider-setting" ).fadeIn();
			$(".lswss-common-setting").fadeIn(); 	
			$(".lswss-grid-setting").hide();	
		}

		if(selected_button =='grid') {
			$( ".lswss-slider-setting" ).hide();
			$(".lswss-grid-setting").fadeIn();	
			$(".lswss-common-setting").fadeIn();
		}		
	});
})( jQuery );

/* Function to hide popup */
function lswss_hide_popup() {
	jQuery('.lswss-img-data-wrp').hide();
	jQuery('.lswss-popup-overlay').hide();
	jQuery('body').removeClass('lswss-no-overflow');
	jQuery('.lswss-img-data-wrp  .lswss-popup-body-wrp').html('');
}