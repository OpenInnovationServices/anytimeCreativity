<?php 
	/**
	* Plugin Main Class
	*/
	class LA_Words_Rotator
	{
		
		function __construct()
		{
			add_action( "admin_menu", array($this,'rotating_words_admin_options'));
			add_action( 'admin_enqueue_scripts', array($this,'admin_enqueuing_scripts'));
			add_action('wp_ajax_la_save_words_rotator', array($this, 'save_admin_options'));
			add_shortcode( 'animated-words-rotator', array($this, 'render_words_rotator') );
		}
	

		function rotating_words_admin_options(){
			add_menu_page( 'CSS3 Rotating Words', 'CSS3 Rotating Words', 'manage_options', 'word_rotator', array($this,'rotating_wordpress_admin_menu'), 'dashicons-update-alt');
		}

		function admin_enqueuing_scripts($slug){
		if ($slug == 'toplevel_page_word_rotator') {
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'rw-fontselector-js', plugins_url( 'admin/jquery.fontselect.min.js' , __FILE__ ), array('jquery') );
			wp_enqueue_script( 'wdo-rotator-admin-js', plugins_url( 'admin/admin.js' , __FILE__ ), array('jquery', 'jquery-ui-accordion', 'wp-color-picker','rw-fontselector-js') );
			wp_enqueue_style( 'rotator-ui-css', plugins_url( 'admin/jquery-ui.min.css' , __FILE__ ));
			wp_enqueue_style( 'rotator-admin-css', plugins_url( 'admin/style.css' , __FILE__ ));
			wp_enqueue_style( 'rotator-bootstrap-css', plugins_url( 'admin/bootstrap-min.css' , __FILE__ ));

			wp_enqueue_style( 'rw-fontselector-css', plugins_url( 'admin/fontselect-default.css' , __FILE__ ));

			wp_localize_script( 'wdo-rotator-admin-js', 'laAjax', array( 'url' => admin_url( 'admin-ajax.php' ),'path' => plugin_dir_url( __FILE__ )));
			}
		}
		function get_google_web_fonts(){
			$google_api_key = "AIzaSyAcxFoKHAm9soFUWfJ0nvWXAckAqDmEoQk";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/webfonts/v1/webfonts?key=" . $google_api_key);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    "Content-Type: application/json"
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
			$fonts_list = json_decode(curl_exec($ch), true);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if($http_code != 200) 
			    exit('Error : Failed to get Google Fonts list');

			return $fonts_list;
		}

		function rotating_wordpress_admin_menu(){
			$savedmeta = get_option('la_words_rotator');
			?>
			<div class="rotaing-words-wrap" id="compactviewer"> 
				<div class="se-pre-con"></div>
				<div class="se-saved-con"></div>
				<div class="overlay-message">
				    <p>Changes Saved..!</p>
				</div>
				<div class="plugin-title">
					<h2 class="wdo-main-heading">CSS3 Rotating Words - WordPress Plugin <img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/rotating-icon.png"></h2>
					<h3 class="wdo-sub-heading">Welcome! You are going to create something awesome with this plugin. Add multiple words in sentence with animations which changes after intervals.</h3>
				</div>
				 
				<div id="accordion">
				<?php if (isset($savedmeta['rotwords'])) {?>
					<?php foreach ($savedmeta['rotwords'] as $key => $data) {?>

					<h3 class="tab-head"> 
						<?php echo ( $data['rw_group_name'] != "" ) ? $data['rw_group_name'] : 'Rotating Words' ; ?>
						<button title="Click To Get Shortcode" class="button-primary fullshortcode" id="<?php echo $data['counter']; ?>"><span title="Get Shortcode" class="dashicons dashicons-shortcode"></span>   <?php _e( 'Get Shortcode', 'la-wordsrotator' ); ?></button>
						<button class="button btnadd"><span title="Add New Words" class="dashicons dashicons-plus-alt"></span></button>&nbsp;
						<button class="button btndelete"><span class="dashicons dashicons-dismiss" title="Delete Words"></span></button>
					</h3>
					<div class="tab-content">
						<h2><?php _e( 'General Settings', 'la-wordsrotator' ); ?></h2>
						<table class="form-table">
							<hr>

							<tr>
								<td style="width:30%">
									<strong><?php _e( 'Group Name', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td style="width:30%"> 
									
									<input class="rw-group-name widefat form-control" type="text" value="<?php echo $data['rw_group_name']; ?>">	
								</td>

								<td style="width:40%">
									<p class="description"><?php _e( 'Name this group. This would be for your reference which would be shown on red tab. Default: Rotating Words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

							<tr>
								<td style="width:30%">
									<strong><?php _e( 'Give Start Sentence', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td class="get-terms" style="width:30%">
									
									<textarea cols="10" rows="5" class="static-sen form-control" placeholder="Sentence before rotating words"><?php echo stripslashes($data['stat_sent']); ?></textarea>		
								</td>

								<td style="width:40%">
									<p class="description"><?php _e( 'Write starting sentence.Leave empty if have no starting words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

			  				<tr>
			  					<td> <strong> <?php _e( 'Add Words(these will be rotating)', 'la-wordsrotator' ); ?> </strong></td>
			  					<td>
			  						<textarea cols="10" rows="5" class="rotating-words form-control" placeholder="first,second,third"><?php echo stripslashes($data['rot_words']); ?></textarea> 
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Comma separated list of words', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
							<tr>
								<td>
									<strong><?php _e( 'Give Ending Sentence', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td class="get-terms">
									
									<textarea cols="10" rows="5" class="end-sen form-control" placeholder="Sentence after rotating words"><?php echo stripslashes($data['end_sent']); ?></textarea>		
								</td>

								<td>
									<p class="description"><?php _e( 'Write a ending sentence.Leave empty if have no ending words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

							<tr>
								<td>
									<strong ><?php _e( 'Animation Effect', 'la-wordsrotator' ); ?></strong>
								</td>
								<td>
									<select class="animate form-control">
										<option value="fade" <?php if ( $data['animation_effect'] == 'fade' ) echo 'selected="selected"'; ?>>Fade</option>
										<option value="flip" <?php if ( $data['animation_effect'] == 'flip' ) echo 'selected="selected"'; ?>>Flip</option>
										<option value="flipCube" <?php if ( $data['animation_effect'] == 'flipCube' ) echo 'selected="selected"'; ?>>Flip Cube</option>
										<option value="flipUp" <?php if ( $data['animation_effect'] == 'flipUp' ) echo 'selected="selected"'; ?>>Flip Up</option>
										<option value="zoomIn" <?php if ( $data['animation_effect'] == 'zoomIn' ) echo 'selected="selected"'; ?>>Zoom In</option>
										<option value="fade">Rotate 1 (PRO Version)</option>
										<option value="fade">Typing (PRO Version)</option>
										<option value="fade">Rotate 2 (PRO Version)</option>
										<option value="fade">Loading Bar (PRO Version)</option>
										<option value="fade">Loading Bar (PRO Version)</option>
										<option value="fade">Slide (PRO Version)</option>
										<option value="fade">Clip (PRO Version)</option>
										<option value="fade">Zoom (PRO Version)</option>
										<option value="fade">Rotate 3 (PRO Version)</option>
										<option value="fade">Scale (PRO Version)</option>
										<option value="fade">Push (PRO Version)</option>
									</select>
								</td>
								<td>
									<p class="description"><?php _e( 'Select Animation effect for words', 'la-wordsrotator' ); ?>.</p>
									<a style="color:#428bca;font-weight: bold;" href="http://demo.webdevocean.com/css3-rotating-words-demo/" target="_blank">All Animation Effects</a>
								</td>
							</tr>
							<tr>
								<td style="width:30%">
									<strong ><?php _e( 'Animation Speed', 'la-wordsrotator' ); ?></strong>
								</td>
								<td style="width:30%">
									<input type="number" class="animate-speed form-control" value="<?php echo $data['animation_speed']; ?>">
								</td>	
								<td style="width:40%">
									<p class="description"><?php _e( 'Select animation speed for words.Large value would slower animation.Default 1250', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>
						</table>
						<button title="Click To Get Shortcode" class="button-primary bottom-shortcode" id="<?php echo $data['counter']; ?>"><?php _e( 'Get Shortcode', 'la-wordsrotator' ); ?></button>
						<h3 class="pro-heading"><?php _e( 'Pro Features', 'la-wordsrotator' ); ?></h3>
						<table class="form-table">	
						    <tr>
						        <td>
						            <strong>
						            	<?php _e( 'Select Font Style ', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a>
						            		
						            </strong>
						        </td>
						        <td>
						            <select class="rw-fontstyle form-control">
						              <option value="italic"><?php _e( 'Italic', 'la-wordsrotator' ); ?></option>
						              <option value="normal"><?php _e( 'Normal', 'la-wordsrotator' ); ?></option>
						            </select>
						        </td>
						        <td>
						            <p class="description"><?php _e( 'Select font style for sentence and words.', 'la-wordsrotator' ); ?></p>
						        </td>
						    </tr>

						    <tr>
						        <td>
						            <strong>
						            	<?php _e( 'Sentence Alignment', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a>
						            </strong>
						        </td>
						        <td>
						            <select class="rw-textalign form-control">
						              <option value="left"><?php _e( 'Left', 'la-wordsrotator' ); ?></option>
						              <option value="center"><?php _e( 'Center', 'la-wordsrotator' ); ?></option>
						              <option value="right"><?php _e( 'Right', 'la-wordsrotator' ); ?></option>
						            </select>
						        </td>
						        <td>
						            <p class="description"><?php _e( 'Select in which direction sentence should be align.', 'la-wordsrotator' ); ?></p>
						        </td>
						    </tr>
							<tr>
								<td>
									<strong><?php _e( 'Sentence and Words Font Size', 'la-wordsrotator' ); ?> <a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
								</td>
								<td class="get-terms">
									<input type="number" class="font form-control" value=""> 		
								</td>

								<td>
									<p class="description"><?php _e( 'Set font size for words and sentence.Default 45px' ); ?>.</p>
								</td>
							</tr>

							<tr>
								<td>
									<strong><?php _e( 'Words Font Size On Small Screen', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
								</td>
								<td class="get-terms">
									<input type="number" class="form-control" value="">
								</td>

								<td>
									<p class="description"><?php _e( 'Set font size for words and sentence for mobile and tablets' ); ?>.</p>
								</td>
							</tr>

							<tr>
			  					<td> 
			  						<strong ><?php _e( 'Sentence Color', 'la-wordsrotator' ); ?> <a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="my-colorpicker" value="">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose color for the sentence.Default #000', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<td> 
			  						<strong ><?php _e( 'Rotating Words Color', 'la-wordsrotator' ); ?> <a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="wordscolor" value="">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose color for rotating words.Default #000', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>

			  				<tr>
			  					<td> 
			  						<strong ><?php _e( 'Rotating Words Background Color', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="wordsbgcolor" value="">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose background color for rotating words', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<td>
			  						<strong ><?php _e( 'Stop Rotation On Last Word', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
			  					</td>
			  					<td>
			  						<select class="loop-words form-control">
			  							<option value="true">No</option>
			  							<option value="false">Yes</option>
			  						</select>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Select want to stop word rotation on last word on not. ', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
						</table>

						<div class="clearfix"></div>
						
						<hr style="margin-bottom: 10px;">

					</div>
						<?php } ?>
					<?php } else { ?>
					<h3 class="tab-head">
						<button title="Click To Get Shortcode" class="button-primary fullshortcode" id="1"><span title="Get Shortcode" class="dashicons dashicons-shortcode"></span>   <?php _e( 'Get Shortcode', 'la-wordsrotator' ); ?></button>
						<button class="button btnadd"><span title="Add New Words" class="dashicons dashicons-plus-alt"></span></button>&nbsp;
						<button class="button btndelete"><span class="dashicons dashicons-dismiss" title="Delete Words"></span></button>
						Rotating Words
					</h3>
					<div class="tab-content">
						<h2>General Settings</h2>
						<table class="form-table">
							<hr>

							<tr>
								<td style="width:30%">
									<strong><?php _e( 'Group Name', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td style="width:30%">
									
									<input class="rw-group-name widefat form-control" type="text">	
								</td>

								<td style="width:40%">
									<p class="description"><?php _e( 'Name this group. This would be for your reference which would be shown on red tab. Default: Rotating Words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

							<tr>
								<td>
									<strong><?php _e( 'Give Start Sentence', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td class="get-terms">
									
									<textarea cols="10" rows="5" class="static-sen form-control" placeholder="Sentence before rotating words"></textarea>		
								</td>

								<td>
									<p class="description"><?php _e( 'Write a starting sentence.Leave empty if have no starting words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>



			  				<tr>
			  					<td> <strong> <?php _e( 'Add Words(these will be rotating)', 'la-wordsrotator' ); ?> </strong></td>
			  					<td>
			  						<textarea cols="10" rows="5" class="rotating-words form-control" placeholder="first,second,third"></textarea> 
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Comma separated list of words', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>

			  				<tr>
								<td>
									<strong><?php _e( 'Give Ending Sentence', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td class="get-terms">
									
									<textarea cols="10" rows="5" class="end-sen form-control" placeholder="Sentence after rotating words"></textarea>		
								</td>

								<td>
									<p class="description"><?php _e( 'Write a ending sentence.Leave empty if have no ending words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

							<tr>
								<td>
									<strong ><?php _e( 'Animation Effect', 'la-wordsrotator' ); ?></strong>
								</td>
								<td>
									<select class="animate form-control">
										<option value="fade">Fade</option>
										<option value="flip">Flip</option>
										<option value="flipCube">Flip Cube</option>
										<option value="flipUp">Flip Up</option>
										<option value="zoomIn">Zoom In</option>
										<option value="fade">Rotate 1 (PRO Version)</option>
										<option value="fade">Typing (PRO Version)</option>
										<option value="fade">Rotate 2 (PRO Version)</option>
										<option value="fade">Loading Bar (PRO Version)</option>
										<option value="fade">Loading Bar (PRO Version)</option>
										<option value="fade">Slide (PRO Version)</option>
										<option value="fade">Clip (PRO Version)</option>
										<option value="fade">Zoom (PRO Version)</option>
										<option value="fade">Rotate 3 (PRO Version)</option>
										<option value="fade">Scale (PRO Version)</option>
										<option value="fade">Push (PRO Version)</option>
									</select>
								</td>
								<td>
									<p class="description"><?php _e( 'Select Animation effect for words', 'la-wordsrotator' ); ?>.</p>
									<a style="color:#428bca;font-weight: bold;" href="http://demo.webdevocean.com/css3-rotating-words-demo/" target="_blank">All Animation Effects</a>
								</td>
							</tr>

							<tr>
								<td>
									<strong ><?php _e( 'Animation Speed', 'la-wordsrotator' ); ?></strong>
								</td>
								<td>
									<input type="number" class="animate-speed form-control">
								</td>
								<td>
									<p class="description"><?php _e( 'Select animation speed for words.Large value would slower animation.Default 1250.', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

						</table>
						<button title="Click To Get Shortcode" class="button-primary bottom-shortcode" id="1"><?php _e( 'Get Shortcode', 'la-wordsrotator' ); ?></button>
						<h3 class="pro-heading"><?php _e( 'Pro Features', 'la-wordsrotator' ); ?></h3>
						<table class="form-table">

						    <tr>
						        <td>
						            <strong>
						            	<?php _e( 'Select Font Style ', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a>
						            		
						            </strong>
						        </td>
						        <td>
						            <select class="rw-fontstyle form-control">
						              <option value="italic"><?php _e( 'Italic', 'la-wordsrotator' ); ?></option>
						              <option value="normal"><?php _e( 'Normal', 'la-wordsrotator' ); ?></option>
						            </select>
						        </td>
						        <td>
						            <p class="description"><?php _e( 'Select font style for sentence and words.', 'la-wordsrotator' ); ?></p>
						        </td>
						    </tr>

						    <tr>
						        <td>
						            <strong>
						            	<?php _e( 'Sentence Alignment', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a>
						            </strong>
						        </td>
						        <td>
						            <select class="rw-textalign form-control">
						              <option value="left"><?php _e( 'Left', 'la-wordsrotator' ); ?></option>
						              <option value="center"><?php _e( 'Center', 'la-wordsrotator' ); ?></option>
						              <option value="right"><?php _e( 'Right', 'la-wordsrotator' ); ?></option>
						            </select>
						        </td>
						        <td>
						            <p class="description"><?php _e( 'Select in which direction sentence should be align.', 'la-wordsrotator' ); ?></p>
						        </td>
						    </tr>

							<tr>
								<td>
									<strong><?php _e( 'Sentence and Words Font Size', 'la-wordsrotator' ); ?> <a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
								</td>
								<td class="get-terms">
									<input type="number" class="font form-control" value=""> 		
								</td>

								<td>
									<p class="description"><?php _e( 'Set font size for words and sentence.Default 45px', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

							<tr>
								<td>
									<strong><?php _e( 'Words Font Size On Small Screen', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
								</td>
								<td class="get-terms">
									<input type="number" class="form-control" value="">
								</td>

								<td>
									<p class="description"><?php _e( 'Set font size for words and sentence for mobile and tablets' ); ?>.</p>
								</td>
							</tr>

							<tr>
			  					<td>
			  						<strong ><?php _e( 'Sentence Color', 'la-wordsrotator' ); ?> <a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="my-colorpicker" value="#000">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose color for the sentence.Default #000', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<td> 
			  						<strong ><?php _e( 'Rotating Words Color', 'la-wordsrotator' ); ?> <a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="wordscolor" value="#000">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose color for the rotating words.Default #000', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>

			  				<tr>
			  					<td> 
			  						<strong ><?php _e( 'Rotating Words Background Color', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="wordsbgcolor" value="">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose background color for rotating words', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<td>
			  						<strong ><?php _e( 'Stop Rotation On Last Word', 'la-wordsrotator' ); ?><a href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"> (Pro Feature)</a></strong>
			  					</td>
			  					<td>
			  						<select class="loop-words form-control">
			  							<option value="true">No</option>
			  							<option value="false">Yes</option>
			  						</select>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Select want to stop word rotation on last word on not. ', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>	
						</table>

						<div class="clearfix"></div>
						
						<hr style="margin-bottom: 10px;">
						
					</div>
					<?php } ?>
				</div>
					<hr style="margin-top: 20px;">
					<button class="btn btn-success position-fixed save-meta" ><?php _e( 'Save Changes', 'la-wordsrotator' ); ?></button>
					<a style="text-decoration:none;"  href="https://webdevocean.com/product/css3-rotating-words-wordpress-plugin/" target="_blank"><h4 style="padding: 10px;background: #860c4adb;color: #fff;margin-top: 50px;text-align:center;font-size:24px;">Buy Pro Version To Unlock More Features</h4></a><br>
				</div>
				
	<?php	
	}

	function save_admin_options(){
		if (isset($_REQUEST)) {
			update_option( 'la_words_rotator', $_REQUEST );
			
		}
	}
 
	function render_words_rotator($atts, $content, $the_shortcode){
		$savedmeta = get_option( 'la_words_rotator' );
		$postContents = '';
		if (isset($savedmeta['rotwords'])) {
			foreach ($savedmeta['rotwords'] as $key => $data) {
				if ($atts['id']== $data['counter']) {
					wp_enqueue_script( 'rw-text-rotator-js', plugins_url( 'js/jquery.simple-text-rotator.min.js', __FILE__ ),array('jquery'));
					wp_enqueue_script( 'rw-animate-js', plugins_url( 'js/jquery.simple-text-rotator.min.js', __FILE__ ),array('jquery'));
					wp_enqueue_script( 'rw-script-js', plugins_url( 'js/script.js', __FILE__ ),array('jquery'));
					wp_enqueue_style( 'rw-text-rotator-css', plugins_url( 'js/simpletextrotator.css', __FILE__ ));
					wp_enqueue_style( 'rw-animate-css', plugins_url( 'js/animate.min.css', __FILE__ ));
					wp_localize_script( 'rw-script-js', 'words', array(
										'animation' => $data["animation_effect"],
										'speed' => $data['animation_speed'],
									));

					$rotate_words = $data['rot_words'];
					$rotate_words_arr = explode(",",$rotate_words);

		            $postContents.='<h3 class="demo" style="font-size:'.$data['font_size'].'px;color:'.$data['font_color'].';">';  
		            $postContents.=stripslashes($data["stat_sent"]);  
		            $postContents.=' <span class="rotate" style="font-size:'.$data['font_size'].'px;color:'.$data['words_color'].';">'.stripslashes($rotate_words).'';   
		            $postContents.='</span> ' .stripslashes($data['end_sent']).'</h3>'; 
					return $postContents;

				}	
			}
		}
	}
}
 ?>