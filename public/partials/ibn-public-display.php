<?php

/**
 * Display the breaking news bar on the front-end.
 *
 * This file can be overridden by the theme.
 *
 * To override this file, copy this file to the active theme's root directory /ibn-templates/ibn-public-display.php directory.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$bar_options = Ibn_Settings::get_general_settings();
// check if user choose to show the bar on the front-end.
if ( isset( $bar_options['ibn-active'] ) && $bar_options['ibn-active'] !== 1 ) {
	return; // exit if the bar is not active.
}
$active_breaking_post_id = get_option( 'ibn_breaking_news_post_id' );
if ( ! $active_breaking_post_id ) {
	return; // no breaking news post id found, don't show the bar.
}
// check if user choose display the bar with rounded corners style.
$radius              = isset( $bar_options['ibn-rounded-corners'] ) && $bar_options['ibn-rounded-corners'] === 1 ? ' radius' : '';
$bar_title           = isset( $bar_options['ibn-title'] ) ? $bar_options['ibn-title'] : __( 'Breaking News', 'ibn' ); // get the news bar title.
$permalink           = get_permalink( $active_breaking_post_id ); // get the post permalink.
$breaking_post_title = get_the_title( $active_breaking_post_id ); // get the post title.
$custom_title        = get_post_meta( $active_breaking_post_id, 'ibn_post_custom_title', true ); // get the custom title.
do_action( 'ibn_before_breaking_news_bar' ); // hook before the breaking news bar.
?>
	<div class="ibn-news-ticker<?php echo esc_attr( $radius ); ?>">
		<div class="ticker-title">
			<h3><?php echo esc_html( $bar_title ); ?></h3>
		</div>
		<div class="ticker-content animated">
			<a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_html( $breaking_post_title ); ?>">
				<?php
				echo esc_html( $breaking_post_title );
				echo ( $custom_title && $breaking_post_title ) ? ' | ' : '';
				echo $custom_title ? esc_html( $custom_title ) : '';
				?>
			</a>
		</div>
	</div>
<?php
do_action( 'ibn_after_breaking_news_bar' ); // hook after the breaking news bar.
