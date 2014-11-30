<?php
/**
 * Add a drop-down menu & link that opens in a new window 
 */
add_action( 'admin_bar_menu', 'rss_toolbar_items', 15);												
function rss_toolbar_items($admin_bar){
	$options = get_option( 'ias_options' ); 
	$feedurl = $options['feed_url'];
	$feedurl_1 = $options['feed_url_1'];
	$feedurl_2 = $options['feed_url_2'];
	$admin_bar->add_menu(
		array(
			'id'    => 'feeds-item',
			'title' => 'Feeds',
			'meta'  => array(
				'title' => __('Feeds')
			),
		)
	);
	$arr = array($feedurl, $feedurl_1, $feedurl_2);
	foreach ($arr as $value) {
		if( empty($value) ){
			continue;
		}
		$array = parse_url($value);
		$host =  $array['host'];
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

/**
 * Add Feed loops
 */ 
// http://codex.wordpress.org/Function_Reference/add_meta_box
function ias_setup_function() {
	add_meta_box(
		'ias_widget',			// $id
		'iSummary Main Feeds',	// $title
		'ias_widget_function',	// $callback
		'dashboard',			// $post_type
		'normal', 				// $context
		'high'					// $priority
	);	
}
function ias_widget_function() {
	$options = get_option( 'ias_options' ); 
	$feedurl = $options['feed_url'];
	$select = $options['num_content_items'];
	// http://codex.wordpress.org/Function_Reference/fetch_feed
	$rss = fetch_feed( $feedurl );
	if ( ! is_wp_error( $rss ) ) { // Checks that the object is created correctly
		// Figure out how many total items there are.
		$maxitems = $rss->get_item_quantity( $select );
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );
	}
	if ( ! empty( $maxitems ) ) { ?>
			<ul>
				<?php
				// Loop through each feed item and display each item as a hyperlink.
				foreach ( $rss_items as $item ) { 
				?>
					<li>
						<a class="" href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank">
							<?php echo esc_attr( $item->get_title() ); ?></a>
						<span class=""><?php echo date_i18n('F j, Y', $item->get_date('U')); ?></span>
					</li>
				<?php } ?>
			</ul>	
	<?php }
}

function ias_widget_function_bis( $feed, $host, $content, $images, $column ) {
	foreach ( (array) $feed as $value ) {	
		if( empty( $value ) ){
			return;
		}
		$options = get_option( 'ias_options' ); 
		$select = $options['num_content_items'];
		// http://codex.wordpress.org/Function_Reference/fetch_feed
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
			<h3 class="mytest">
				<span><?php _e( 'Images Feed Contents', 'isar-admin-summary' );
					echo ' - ';
					echo parse_url($value)['host']; ?>
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
						$array = parse_url($value);
						echo $array['host']; ?>
					</span>
				</h3>
			<?php } ?>
				<ul>
					<?php
					// Loop through each feed item and display each item as a hyperlink.
					foreach ( $rss_items as $item ) {
					?>
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
					<?php } ?>
				</ul>
		<?php	
		}
	}
}
/**
 * Add right-to-left languages style
 */ 
function ias_style_function() {
	// http://codex.wordpress.org/Function_Reference/is_rtl
	$x = is_rtl() ? 'right' : 'left';
	echo '<style type="text/css"> #ias_widget.postbox h3, #ias_widget.postbox .rss-widget { text-align: ' . $x . '; } </style>';
}
add_action( 'admin_head', 'ias_style_function' );
