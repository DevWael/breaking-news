(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $('.ibn-color-picker').wpColorPicker();


    /**
     * Add event listener to check if the manual placement toggle is checked
     * and hide the css selector text field if the toggle is not checked.
     */
    $(document).on('ibn_placement_toggle_check', function (e) {
        if ($('.ibn-bar-placement input[type=radio]:checked').val() === 'manual') {
            $('.ibn-css-selector').show();
        } else {
            $('.ibn-css-selector').hide();
        }
    });

    /**
     * Add event listener to check if the manual placement toggle is checked on every change to the toggle.
     */
    $(document).on('change', '.ibn-bar-placement input[type=radio]', function (e) {
        $(document).trigger('ibn_placement_toggle_check');
    });

    /**
     * Add event listener to check if the manual placement toggle is checked on document load.
     */
    $(document).trigger('ibn_placement_toggle_check');
})(jQuery);
