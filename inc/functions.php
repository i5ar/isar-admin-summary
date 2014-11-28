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
	$select = $options['drp_select_box'];
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
function ias_widget_function_content() {
	$options = get_option( 'ias_options' ); 
	$feedurl = $options['feed_url'];
	$images = $options['feed_images'];
	$select = $options['drp_select_box'];
	// http://codex.wordpress.org/Function_Reference/fetch_feed
	$rss = fetch_feed( $feedurl );
	if ( ! is_wp_error( $rss ) ) { // Checks that the object is created correctly
		// Figure out how many total items there are.
		$maxitems = $rss->get_item_quantity( $select );
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );
	}
	if ( ! empty( $maxitems ) ) { ?>
	<p><?php echo __( 'Please, press', 'isar-admin-summary' ); ?> <code>Ctrl +</code> <?php echo __( 'one or more time to not go blind.', 'isar-admin-summary' ); ?></p>
			<ul>
				<?php
				// Loop through each feed item and display each item as a hyperlink.
				foreach ( $rss_items as $item ) { 
				?>
					<li class="ias-item">
						<a class="" href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank">
							<?php echo esc_attr( $item->get_title() ); ?></a>
						<span class=""><?php echo date_i18n('F j, Y', $item->get_date('U')); ?></span>
						<?php if ( $images == 'yes' ) { ?>
						<div><?php echo $item->get_content(); ?></div>
						<?php } else { ?>
						<div class="ias-hide"><?php echo $item->get_content(); ?></div>
						<?php }?>
					</li>
				<?php } ?>
			</ul>	
	<?php
	}
}
function ias_widget_function_col() {
	$options = get_option( 'ias_options' ); 
	$feedurl = $options['feed_url'];
	$feedurl_1 = $options['feed_url_1'];
	$feedurl_2 = $options['feed_url_2'];
	$arr = array($feedurl, $feedurl_1, $feedurl_2);
	foreach ($arr as $value) {
		if( empty($value) ){
			continue;
		}
		$select = $options['drp_select_box'];
		// http://codex.wordpress.org/Function_Reference/fetch_feed
		$rss = fetch_feed( $value );
		if ( ! is_wp_error( $rss ) ) { // Checks that the object is created correctly
			// Figure out how many total items there are.
			$maxitems = $rss->get_item_quantity( $select );
			// Build an array of all the items, starting with element 0 (first element).
			$rss_items = $rss->get_items( 0, $maxitems*2 );
		}
		if ( ! empty( $maxitems ) ) { ?>
			<h3>
				<span>
				<?php
					$array = parse_url($value);
					echo $array['host'];
				?>
				</span>
			</h3>
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
