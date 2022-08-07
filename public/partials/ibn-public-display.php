<?php

/**
 * Display the breaking news bar on the front-end.
 *
 * This file can be overridden by the theme.
 *
 * To override this file, copy this file to the theme's root directory/ibn-templates/ibn-public-display.php directory.
 */

$bar_options = Ibn_Settings::get_general_settings();
// check if user choose to show the bar on the front-end.
if ( isset( $bar_options['ibn-active'] ) && $bar_options['ibn-active'] !== 1 ) {
	return;
}
// check if user choose display the bar with rounded corners style.
$radius = isset( $bar_options['ibn-rounded-corners'] ) && $bar_options['ibn-rounded-corners'] === 1 ? ' radius' : '';
$title  = isset( $bar_options['ibn-title'] ) ? $bar_options['ibn-title'] : __( 'Breaking News', 'ibn' );
?>
<div class="ibn-news-ticker<?php echo esc_attr( $radius ) ?>">
    <div class="ticker-title">
        <h3><?php echo esc_html( $title ); ?></h3>
    </div>
    <div class="ticker-content animated marquee">
        <a href="#">
            FIFA president says he'll resign amid corruption scandal
            FIFA president says he'll resign amid corruption scandal
        </a>
    </div>
</div>

