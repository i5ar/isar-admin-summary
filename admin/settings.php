<?php
/**
 * Render the Plugin options form
 * @since 2.0.0
 * @modified 2014.02.10 to fit 3.8 layout and styling
 */
 
function ias_render_form() { ?>

<div class="wrap">
		
	<!-- Display Plugin Header, and Description -->
	<h2><?php _e( 'iSar Admin Summary Settings', 'isar-admin-summary' ); ?></h2>
	
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<!-- main content -->
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<h3>
							<span><?php _e( 'Main Content Header', 'isar-admin-summary' ); ?></span>
						</h3>
						<div class="inside">
							<!-- Beginning of the Plugin Options Form -->
							<form method="post" action="options.php">
							<?php // http://codex.wordpress.org/Function_Reference/settings_fields ?>
							<?php settings_fields( 'ias_plugin_options' ); ?>
							<?php // http://codex.wordpress.org/Function_Reference/get_option ?>
							<?php $options = get_option( 'ias_options' ); ?>
					
								<div class="form-wrap">
									<p><?php _e( 'Below you can adjust the output of the Feeds. You can change the feed URLs and the amount of feed items to show.', 'isar-admin-summary' ); ?></p>
								
									<table class="form-table">
										<tbody>
																				
											<tr>
												<th scope="row">
													<label for="ias-feed-url"><?php _e( 'Main Feed URL', 'isar-admin-summary' ); ?></label>
												</th>
												<td>
													<input name="ias_options[feed_url]" type="text" id="ias-feed-url" class="regular-text code" value="<?php echo $options['feed_url']; ?>" />
													<p class="description"><?php _e( 'Change the feed-URL to a site of your choice', 'isar-admin-summary' ); ?></p>
													<input type="hidden" name="action" value="update" />
													<input type="hidden" name="page_options" value="<?php echo $options['feed_url']; ?>" />								
												</td>
											</tr>

											<tr>
												<th scope="row">
													<label for="ias-select"><?php _e( 'How many Feed Items to show in the Dashboard Feed Widget', 'isar-admin-summary' ); ?></label>
												</th>
												<td>
													<select name='ias_options[drp_select_box]'>
														<option value='1' <?php selected( '1', $options['drp_select_box'] ); ?>>1</option>
														<option value='2' <?php selected( '2', $options['drp_select_box'] ); ?>>2</option>
														<option value='3' <?php selected( '3', $options['drp_select_box'] ); ?>>3</option>
														<option value='4' <?php selected( '4', $options['drp_select_box'] ); ?>>4</option>
														<option value='5' <?php selected( '5', $options['drp_select_box'] ); ?>>5</option>
														<option value='6' <?php selected( '6', $options['drp_select_box'] ); ?>>6</option>
														<option value='7' <?php selected( '7', $options['drp_select_box'] ); ?>>7</option>
														<option value='8' <?php selected( '8', $options['drp_select_box'] ); ?>>8</option>
														<option value='9' <?php selected( '9', $options['drp_select_box'] ); ?>>9</option>
													</select>
													<p class="description"><?php _e( 'How many feed items to show in the widget?', 'isar-admin-summary' ); ?></p>
													<input type="hidden" name="action" value="update" />
													<input type="hidden" name="page_options" value="<?php echo $options['drp_select_box']; ?>" />								
												</td>
											</tr>
											
											<tr>
												<th scope="row">
													<label for="ias-select"><?php _e( 'Show images', 'isar-admin-summary' ); ?></label>
												</th>
												<td>
													<select name='ias_options[feed_images]'>
														<option value='yes' <?php selected( 'yes', $options['feed_images'] ); ?>>yes</option>
														<option value='no' <?php selected( 'no', $options['feed_images'] ); ?>>no</option>
													</select>
													<p class="description"><?php _e( 'How many feed items to show in the widget?', 'isar-admin-summary' ); ?></p>
													<input type="hidden" name="action" value="update" />
													<input type="hidden" name="page_options" value="<?php echo $options['feed_images']; ?>" />								
												</td>
											</tr>

											<tr>
												<th scope="row">
													<label for="ias-feed-url-1"><?php _e( 'Minor Feed URL 1', 'isar-admin-summary' ); ?></label>
												</th>
												<td>
													<input name="ias_options[feed_url_1]" type="text" id="ias-feed-url-1" class="regular-text code" value="<?php echo $options['feed_url_1']; ?>" />
													<p class="description"><?php _e( 'Change the Feed-URL 1 to a site of your choice', 'isar-admin-summary' ); ?></p>
													<input type="hidden" name="action" value="update" />
													<input type="hidden" name="page_options" value="<?php echo $options['feed_url_1']; ?>" />								
												</td>
											</tr>
											
											<tr>
												<th scope="row">
													<label for="ias-feed-url-2"><?php _e( 'Minor Feed URL 2', 'isar-admin-summary' ); ?></label>
												</th>
												<td>
													<input name="ias_options[feed_url_2]" type="text" id="ias-feed-url-2" class="regular-text code" value="<?php echo $options['feed_url_2']; ?>" />
													<p class="description"><?php _e( 'Change the feed-URL to a site of your choice', 'isar-admin-summary' ); ?></p>
													<input type="hidden" name="action" value="update" />
													<input type="hidden" name="page_options" value="<?php echo $options['feed_url_2']; ?>" />								
												</td>
											</tr>

											<tr>
												<th scope="row">
													<label for="ias-db-chk"><?php _e( 'Database Options', 'isar-admin-summary' ); ?></label>
												</th>
												<td>
													<input name="ias_options[chk_def_options]" type="checkbox" id="ias-db-chk" value="1" <?php if ( isset($options['chk_def_options'] ) ) { checked( '1', $options['chk_def_options'] ); } ?> />
														<?php _e( 'Restore defaults upon plugin deactivation/reactivation', 'isar-admin-summary' ); ?>
													<p class="description"><?php _e( 'Only check this if you want to reset plugin settings upon Plugin reactivation', 'isar-admin-summary' ); ?></p>
												</td>
											</tr>
										
										</tbody>
									</table> <!-- end .tbody end table -->
									
									<p class="submit">
										<input type="submit" class="button button-primary" value="<?php _e( 'Save Settings', 'isar-admin-summary' ) ?>" />
									</p>
								</div>
							</form>
							
						</div> <!-- .inside -->
					</div> <!-- .postbox -->
				</div> <!-- .meta-box-sortables .ui-sortable -->
			</div> <!-- post-body-content -->
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<div class="handlediv" title="Clicca per commutare">
							<br>
						</div>
						<h3 class="hndle">
							<span><?php _e( 'About the Author', 'isar-admin-summary' ); ?></span>
						</h3>
						<div class="inside">
							<p><strong>Lingua</strong></p>
							<div class="translations">
								<p><strong>Traduzioni </strong></p>
							
							
								<img class="author-image" src="http://www.gravatar.com/avatar/<?php echo md5( 'just@do.it' ); ?>" />
								<p>
									<?php echo __( 'I\'m an architect though I like running a blog and keeping it alive. I\'m not a constant publisher so having RSS, just a button from my post page, really helps. It also help me to stay up-to-date since I spend more time around my website than reading newspaper.<br /> I hope you like it!<br /> I\'ll do what I can to keep it stable.' ); ?>
								</p>
								<hr />
									<?php echo __( 'Thanks Pinco Pallino for his contribuition and all the supporters.' ); ?>
								</p>
								<hr />
								<ul>
									<li><a href="#" target="_blank" title="Twitter"><span class="dashicons dashicons-twitter"></span> <?php _e( 'Twitter', 'isar-admin-summary' ); ?></a></li>
									<li><a href="#" target="_blank" title="support"><span class="dashicons dashicons-heart"></span> <?php _e( 'Support', 'isar-admin-summary' ); ?></a></li>
									<li><a href="https://make.wordpress.org/polyglots/handbook/tools/poedit/" target="_blank" title="support"><span class="dashicons dashicons-star-filled"></span> <?php _e( 'Contribute', 'isar-admin-summary' ); ?></a><br /><i>Anyone can contribute with translations.</i></li>
								</ul>
							</div>
						</div>
					</div>
				</div> <!-- .meta-box-sortables -->
			</div> <!-- #postbox-container-1 .postbox-container -->
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		<br class="clear">
	</div> <!-- #poststuff -->
	
	
	
</div>
<!-- Toggle widget -->
<script type="text/javascript">
jQuery(document).ready(function() {
	//jQuery(".inside").hide();
	jQuery(".handlediv").click(function() {
		jQuery(".hndle").next(".inside").toggle();
		jQuery(".postbox","#postbox-container-1").toggleClass("closed");
	});
});
</script>

<?php }




