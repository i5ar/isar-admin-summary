<?php
/**
 * Add a drop-down menu & link that opens in a new window 
 */
add_action( 'admin_bar_menu', 'rss_toolbar_items', 15);												
function rss_toolbar_items($admin_bar){
	$options = get_option( 'ias_options' );
	$feed_menu = $options['feed_menu'];
	if ($feed_menu == 'yes'):
		$options = get_option( 'ias_options' ); 
		$feedurl = $options['feed_url'];
		$feedurl_1 = $options['feed_url_1'];
		$feedurl_2 = $options['feed_url_2'];
		$feedurl_3 = $options['feed_url_3'];
		$feedurl_images = $options['feed_url_images'];
		$admin_bar->add_menu(
		array(
			'id'    => 'feeds-item',
			'title' => 'Feeds',
			'meta'  => array(
				'title' => __('Feeds')
			),
		)
	);
	$arr = array($feedurl, $feedurl_1, $feedurl_2, $feedurl_3, $feedurl_images);
	foreach ($arr as $key => $value) {
		if( empty($value) ){ continue; }
		// Get the previous value of the array
		$previous_value = $arr[$key-1];
		$array = parse_url($value);
		$array_previous = parse_url($previous_value);
		$host =  $array['host'];
		$host_previous =  $array_previous['host'];
		// Exclude the current value of the array if equal the previous value
		if ($host !== $host_previous){
			$admin_bar->add_menu(
				array(
					'id'    => 'feed-sub-item-'.$i++,
					'parent' => 'feeds-item',
					'title' => $host,
					'href'  => $value,
					'meta'  => array(
						'title' => $host,
						'target' => '_blank'
					),
				)
			);
		}
	}
	endif;
}

/**
 * Add Feed loops
 */ 
function ias_setup_function() {
	// @link	http://codex.wordpress.org/Function_Reference/add_meta_box
	add_meta_box(
		'ias_widget',					// $id
		'iSummary Main Feed Headlines',	// $title
		'ias_widget_function',			// $callback
		'dashboard',					// $post_type
		'normal', 						// $context
		'high'							// $priority
	);	
}
function ias_widget_function() {
	$options = get_option( 'ias_options' ); 
	$feedurl = $options['feed_url'];
	$select = $options['num_content_items'];
	// @link	http://codex.wordpress.org/Function_Reference/fetch_feed
	$rss = fetch_feed( $feedurl );
	if ( ! is_wp_error( $rss ) ) { // Checks that the object is created correctly
		// Figure out how many total items there are.
		$maxitems = $rss->get_item_quantity( $select );
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );
	}
	if ( ! empty( $maxitems ) ) { ?>
	<div class="rss-widget">
		<ul>
			<?php
			// Loop through each feed item and display each item as a hyperlink.
			foreach ( $rss_items as $item ) { 
			?>
				<li>
					<a class="rsswidget" href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank">
						<?php echo esc_attr( $item->get_title() ); ?></a>
					<span class="rss-date"><?php echo date_i18n('F j, Y', $item->get_date('U')); ?></span>
				</li>
			<?php } ?>
		</ul>
	</div>			
<?php }
}
function ias_panel_function( $feed, $host, $content, $images, $column ) {
	foreach ( (array) $feed as $value ) {	
		if( empty( $value ) ){
			return;
		}
		$options = get_option( 'ias_options' );
		$select = $options['num_content_items'];
		// @link	http://codex.wordpress.org/Function_Reference/fetch_feed
		$rss = fetch_feed( $value );
		// Checks that the object is created correctly
		if ( ! is_wp_error( $rss ) ) {
			// Figure out how many total items there are
			$maxitems = $rss->get_item_quantity( $select );
			// Calculating the start and the extreme utmost value for each column
			if ( $column == 'second' ) {
				//$maxitems = 3;
				$startitems = $maxitems+1;		// 4
			} elseif ( $column == 'third' ) {
				//$maxitems = 3;
				$startitems = $maxitems*2+1;	// 7
			} elseif ($column == 'first') { ?>
				<h3 class="">
					<span>
					<?php _e( 'Images Feed Contents', 'isar-admin-summary' );
						echo ' - ';
						$parse_url = parse_url($value);
						echo $parse_url['host']; ?>
					</span>
				</h3>
			<?php			
				//$startitems = 0;
				//$maxitems = 3;
			}
			// Build an array of all the items, starting with element 0
			$rss_items = $rss->get_items( $startitems, $maxitems );
			}
			if ( ! empty( $maxitems ) ) { ?>
			<?php if ( $host == True ) { ?>
				<h3>
					<span>
					<?php
						$parse_url = parse_url($value);
						echo $parse_url['host']; ?>
					</span>
				</h3>
			<?php } ?>
				<ul>
					<?php
					// Loop through each feed item and display each item as a hyperlink.
					foreach ( $rss_items as $item ) { ?>
						<li class="ias-item">
							<a class="ias-title" href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank"><?php echo esc_attr( $item->get_title() ); ?></a>
							<span class="ias-date"><?php echo date_i18n('F j, Y', $item->get_date('U')); ?></span>
							<?php if ( $content == True && $images == True ) { ?>
								<div><?php echo $item->get_content(); ?></div>
							<?php } elseif ( $content == True && $images !== True ) { ?>
								<div class="ias-hide"><?php echo $item->get_content(); ?></div>
							<?php }
							?>
						</li>
						<hr />
					<?php } ?>
				</ul>
		<?php
		}
	}
}
/**
 * Add Styles
 */
function ias_style_function() {
	global $_wp_admin_css_colors;
	$user_admin_color = get_user_meta(get_current_user_id(), 'admin_color', True);
	$color = $_wp_admin_css_colors[$user_admin_color]->colors;
	$options = get_option( 'ias_options' );
	$colour = isset( $options['feed_menu_colour'] ) ? $options['feed_menu_colour'] : $color[3];
	// @link	http://codex.wordpress.org/Function_Reference/is_rtl
	$x = is_rtl() ? 'right' : 'left';
	echo '
	<style type="text/css">
		#ias_widget .rss-widget span.rss-date{margin-left:12px}
		#ias_widget a.rsswidget{font-weight:400;}
		#wp-admin-bar-feeds-item .ab-item.ab-empty-item{background:' . $colour . ';}
		#ias_widget.postbox h3,#ias_widget.postbox .rss-widget{text-align:'.$x.';}
		#col-container.ias-container .form-wrap{text-align:'.$x.';}
		#dashboard-widgets.ias-container .meta-box-sortables.ui-sortable{text-align:'.$x.';}
	</style>';
}
add_action( 'admin_head', 'ias_style_function' );
