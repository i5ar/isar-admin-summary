<?php
/**
 * Render the Plugin options form
 * @modified 2014.12.13 to fit 4.0.1 layout and styling
 */
 
function ias_render_form() { ?>

<div class="wrap">

	<h2><?php _e( 'iSar Admin Summary Settings', 'isar-admin-summary' ); ?></h2>
	
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<form method="post" action="options.php">
						<?php // @link	http://codex.wordpress.org/Function_Reference/settings_fields ?>
						<?php settings_fields( 'ias_general_tab' ); ?>
						<?php // @link	http://codex.wordpress.org/Function_Reference/get_option ?>
						<?php $options = get_option( 'ias_options' ); ?>
						
							<p><?php _e('Below you can adjust the output of the Feeds','isar-admin-summary') ?>. <?php _e('You can change the feed','isar-admin-summary')?> <abbr title="Uniform Resource Locator">URL</abbr>s <?php _e( 'and the amount of feed items to show', 'isar-admin-summary'); ?>.</p>
							<table class="form-table">
								<tbody>
									<tr>
										<th scope="row">
											<label for="ias-feed-url"><?php _e('Main Feed URL General Tab','isar-admin-summary'); ?>:</label>
										</th>
										<td>
											<input name="ias_options[feed_url]" type="text" id="ias-feed-url" class="regular-text code" value="<?php echo $options['feed_url']; ?>" />
											<a href="<?php echo admin_url('/admin.php?page=ias_general_tab'); ?>"><span alt="f135" class="dashicons dashicons-align-left"></span></a>
											<p class="description">
											<?php _e( 'Choose your favorite website','isar-admin-summary') ?>: <?php _e('These feed items will be displayed in the left column of the iSummary') ?>
											<a href="<?php echo admin_url('/admin.php?page=ias_general_tab'); ?>"><span alt="f135" class="dashicons dashicons-rss"></span></a>
											<?php _e('General Tab and in the Dashboard','isar-admin-summary') ?>
											<a href="<?php echo admin_url(); ?>"><span alt="f226" class="dashicons dashicons-dashboard"></span></a>
											<?php _e('page','isar-admin-summary') ?>.
											</p>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['feed_url']; ?>" />								
										</td>
									</tr>
									
									<tr>
										<th scope="row">
											<label for="ias-select"><?php _e( 'Show images in General Tab', 'isar-admin-summary' ); ?>?</label>
										</th>
										<td>
											<select name='ias_options[feed_images]'>
												<option value='yes' <?php selected( 'yes', $options['feed_images'] ); ?>>yes</option>
												<option value='no' <?php selected( 'no', $options['feed_images'] ); ?>>no</option>
											</select>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['feed_images']; ?>" />				
										</td>
									</tr>                                            
									<tr>
										<th scope="row">
											<label for="ias-feed-url-1"><?php _e( 'Minor Feed URL 1', 'isar-admin-summary' ); ?>:</label>
										</th>
										<td>
											<input name="ias_options[feed_url_1]" type="text" id="ias-feed-url-1" class="regular-text code" value="<?php echo $options['feed_url_1']; ?>" />
											<a href="<?php echo admin_url('/admin.php?page=ias_general_tab'); ?>"><span alt="f136" class="dashicons dashicons-align-right"></span></a>
											<p class="description">
											<?php _e( 'Change to a website of your choice', 'isar-admin-summary' ); ?>: <?php _e( 'These feed items will be displayed in the right column of the iSummary General Tab', 'isar-admin-summary' ); ?>.
											</p>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['feed_url_1']; ?>" />
										</td>
									</tr>
									
									<tr>
										<th scope="row">
											<label for="ias-feed-url-2"><?php _e( 'Minor Feed URL 2', 'isar-admin-summary' ); ?>:</label>
										</th>
										<td>
											<input name="ias_options[feed_url_2]" type="text" id="ias-feed-url-2" class="regular-text code" value="<?php echo $options['feed_url_2']; ?>" />
											<a href="<?php echo admin_url('/admin.php?page=ias_general_tab'); ?>"><span alt="f136" class="dashicons dashicons-align-right"></span></a>													
											<p class="description"><?php _e( 'Change to a website of your choice', 'isar-admin-summary' ); ?>: <?php _e( 'This feed will be displayed in the right column of the iSummary General Tab', 'isar-admin-summary' ); ?>.</p>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['feed_url_2']; ?>" />				
										</td>
									</tr>
									
									<tr>
										<th scope="row">
											<label for="ias-feed-url-3"><?php _e( 'Minor Feed URL 3', 'isar-admin-summary' ); ?>:</label>
										</th>
										<td>
											<input name="ias_options[feed_url_3]" type="text" id="ias-feed-url-3" class="regular-text code" value="<?php echo $options['feed_url_3']; ?>" />
											<a href="<?php echo admin_url('/admin.php?page=ias_general_tab'); ?>"><span alt="f136" class="dashicons dashicons-align-right"></span></a>
											<p class="description"><?php _e( 'Change to a website of your choice', 'isar-admin-summary' ); ?>: <?php _e( 'These feed items will be displayed in the right column of the iSummary General Tab', 'isar-admin-summary' ); ?>.</p>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['feed_url_3']; ?>" />
										</td>
									</tr>
									
									<tr>
										<th scope="row">
											<label for="ias-select"><?php _e( 'Number of Feed Headlines', 'isar-admin-summary' ); ?>:</label>
										</th>
										<td>
											<select name='ias_options[num_content_items]'>
												<option value='1' <?php selected( '1', $options['num_content_items'] ); ?>>1</option>
												<option value='2' <?php selected( '2', $options['num_content_items'] ); ?>>2</option>
												<option value='3' <?php selected( '3', $options['num_content_items'] ); ?>>3</option>
												<option value='4' <?php selected( '4', $options['num_content_items'] ); ?>>4</option>
												<option value='5' <?php selected( '5', $options['num_content_items'] ); ?>>5</option>
												<option value='6' <?php selected( '6', $options['num_content_items'] ); ?>>6</option>
												<option value='7' <?php selected( '7', $options['num_content_items'] ); ?>>7</option>
												<option value='8' <?php selected( '8', $options['num_content_items'] ); ?>>8</option>
												<option value='9' <?php selected( '9', $options['num_content_items'] ); ?>>9</option>
											</select>
											<p class="description"><?php _e( 'Choose the number of Feed Headlines to show in the Dashboard Feed Widget', 'isar-admin-summary' ); ?>.</p>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['num_content_items']; ?>" />								
										</td>
									</tr>
									
									<tr>
										<th scope="row">
											<label for="ias-feed-url-images"><?php _e( 'Images Feed URL', 'isar-admin-summary' ); ?>:</label>
										</th>
										<td>
											<input name="ias_options[feed_url_images]" type="text" id="ias-feed-url-images" class="regular-text code" value="<?php echo $options['feed_url_images']; ?>" />
											<a href="<?php echo admin_url('/admin.php?page=ias_general_tab&tab=ias_images_tab'); ?>"><span alt="f489" class="dashicons dashicons-schedule"></span></a>													
											<p class="description"><?php _e( 'Change to a website of your choice', 'isar-admin-summary' ); ?>: <?php _e( 'This feed will be displayed in the iSummary Images Tab', 'isar-admin-summary' ); ?>.</p>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['feed_url_images']; ?>" />								
										</td>
									</tr>
									
									<tr>
										<th scope="row">
											<label for="ias-select"><?php _e( 'Number of Feed Images' ); ?>:</label>
										</th>
										<td>
										<?php
											$options = get_option( 'ias_options' ); 
											$select = $options['num_content_items'];
										?>
											<select disabled>
												<option value='<?php echo $select*3; ?>'><?php echo $select*3; ?></option>
											</select>
											<p class="description"><?php _e( 'The amount of feed items in the Images Tab is set to be three times the number of Feed Headlines', 'isar-admin-summary' ); ?>.</p>
										</td>
									</tr>
									
									<tr>
										<th scope="row">
											<label for="ias-select"><?php _e( 'Enable Feeds Menu', 'isar-admin-summary' ); ?>?</label>
										</th>
										<td>
											<select name='ias_options[feed_menu]'>
												<option value='yes' <?php selected( 'yes', $options['feed_menu'] ); ?>>yes</option>
												<option value='no' <?php selected( 'no', $options['feed_menu'] ); ?>>no</option>
											</select>
											<p class="description"><?php _e( 'Enable the Feed Menu in the admin bar', 'isar-admin-summary' ); ?>.</p>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['feed_menu']; ?>" />								
										</td>
									</tr>
									
									<?php 
										global $_wp_admin_css_colors;
										$user_admin_color = get_user_meta(get_current_user_id(), 'admin_color', True);
										$color = $_wp_admin_css_colors[$user_admin_color]->colors;
									?>
									
									<tr>
										<th scope="row">
											<label for="feed-menu-colour"><?php _e( 'Feed Menu Colour', 'isar-admin-summary' ); ?>:</label>
										</th>
										<td>												
											<input name="ias_options[feed_menu_colour]" type="text" id='color-picker' class="code" placeholder="<?php echo $color[3] ?>" value="<?php echo $options['feed_menu_colour']; ?>" />
											<p class="description"><?php _e( 'Change the background colour of the Feed Menu', 'isar-admin-summary' ); ?>.</p>
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="<?php echo $options['feed_menu_colour']; ?>" />								
										</td>
									</tr>
									
									<tr>
										<th scope="row">
											<label for="ias-db-chk"><?php _e( 'Database Options', 'isar-admin-summary' ); ?>:</label>
										</th>
										<td>
											<input name="ias_options[chk_def_options]" type="checkbox" id="ias-db-chk" value="1" <?php if ( isset($options['chk_def_options'] )) { checked( '1', $options['chk_def_options'] ); } ?> />
												<?php _e( 'Restore defaults upon plugin deactivation/reactivation', 'isar-admin-summary' ); ?>
											<p class="description"><?php _e( 'Only check this if you want to reset plugin settings upon Plugin reactivation', 'isar-admin-summary' ); ?>.</p>
										</td>
									</tr>
									
								</tbody>
							</table>
							
							<p class="submit">
								<input type="submit" class="button button-primary" value="<?php _e( 'Save Settings', 'isar-admin-summary' ) ?>" />
							</p>
							
						</form>
					</div><!-- .postbox -->
				</div><!-- .meta-box-sortables.ui-sortable -->
			</div><!-- post-body-content -->
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
							<p>Arch. <strong>Pierpaolo Rasicci</strong> aka <strong>iSar</strong> </p>
							<p>
								<?php echo __( 'I like running my blog and keeping it alive. I\'m not a constant publisher but having <abbr title="Rich Site Summary">RSS</abbr>, just a button from my post page, really helps as far as I\'ve got something to say.
                                It also helps me to stay up-to-date since I spend more time around my website than reading newspaper.<br />
                                I hope you like it!<br /> I\'ll do what I can to keep it updated and lovely styled.' ); ?>
							</p>
                            <blockquote>
								<?php echo __( 'Thanks to Piet Bos for his huge contribuition and all the supporters.' ); ?>
                            </blockquote>
                            </p>
							<hr />
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
								<ul>
									<li><a href="https://twitter.com/i5ar" target="_blank" title="Twitter"><span class="dashicons dashicons-twitter"></span> <?php _e( 'Twitter', 'isar-admin-summary' ); ?></a></li>
									<input type="hidden" name="cmd" value="_s-xclick">
									<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
									<li><a id="isanchor" style="cursor:pointer" href="#" target="_blank" title="support"><span class="dashicons dashicons-heart"></span> <?php _e( 'Support', 'isar-admin-summary' ); ?></a></li>
									<input id="isinput" style="display:none" type="image" target="_blank" value="support" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare.">
									<img style="display:none" alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
									<li><a href="https://make.wordpress.org/polyglots/handbook/tools/poedit/" target="_blank" title="support"><span class="dashicons dashicons-star-filled"></span> <?php _e( 'Contribute', 'isar-admin-summary' ); ?></a><br />Anyone can contribute with translations.</li>
								</ul>
							</form>
						</div>
					</div>
				</div><!-- .meta-box-sortables.ui-sortable -->
			</div><!-- #postbox-container-1.postbox-container -->
		</div><!-- .metabox-holder.columns-2 -->
		<br class="clear">
	</div><!-- #poststuff -->
</div>

<script type="text/javascript">
// Replace ugly Paypal Donate button with simple anchor
jQuery("#isanchor").removeAttr("href");
jQuery('#isanchor ').click( function() {
	jQuery("#isinput").trigger("click");
});
// Toggle postbox container
jQuery(document).ready(function() {
	jQuery(".handlediv").click(function() {
		jQuery(".hndle").next(".inside").toggle();
		jQuery(".postbox","#postbox-container-1").toggleClass("closed");
	});
});
// Iris Color Picker
jQuery(document).ready(function($){
    $('#color-picker').iris({
		palettes: true,
		width: 255
	});
});
</script>
<?php }
