<?php

/**
 * Display the breaking news bar on the front-end.
 *
 * This file can be overridden by the theme.
 *
 * To override this file, copy this file to the active theme's root directory /ibn-templates/ibn-public-display.php directory.
 */

$bar_options = Ibn_Settings::get_general_settings();
// check if user choose to show the bar on the front-end.
if ( isset( $bar_options['ibn-active'] ) && $bar_options['ibn-active'] !== 1 ) {
	return; // exit if the bar is not active.
}
$post_id = get_option( 'ibn_breaking_news_post_id' );
if ( ! $post_id ) {
	return; // no breaking news post id found, don't show the bar.
}
// check if user choose display the bar with rounded corners style.
$radius       = isset( $bar_options['ibn-rounded-corners'] ) && $bar_options['ibn-rounded-corners'] === 1 ? ' radius' : '';
$bar_title    = isset( $bar_options['ibn-title'] ) ? $bar_options['ibn-title'] : __( 'Breaking News', 'ibn' ); // get the news bar title.
$permalink    = get_permalink( $post_id ); // get the post permalink.
$title        = get_the_title( $post_id ); // get the post title.
$custom_title = get_post_meta( $post_id, 'ibn_post_custom_title', true ); // get the custom title.
?>
<div class="ibn-news-ticker<?php echo esc_attr( $radius ) ?>">
    <div class="ticker-title">
        <h3><?php echo esc_html( $bar_title ); ?></h3>
    </div>
    <div class="ticker-content animated">
        <a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_html( $title ) ?>">
			<?php echo esc_html( $custom_title ? $custom_title : $title ) ?>
        </a>
    </div>
</div>

