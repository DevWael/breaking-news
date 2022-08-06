(function ($) {
    'use strict';

    /**
     * Add event listener to check if the expiry date toggle is checked
     * and hide the date picker if the toggle is not checked.
     */
    $(document).on('ibn_date_toggle_check', function (e) {
        if ($('.ibn-post-field #ibn-post-expiry-date-toggle').is(':checked')) {
            $('.ibn-post-field.date-field').show();
        } else {
            $('.ibn-post-field.date-field').hide();
        }
    });

    /**
     * Add event listener to check if the expiry date toggle is checked on every change to the toggle.
     */
    $(document).on('change', '#ibn-post-expiry-date-toggle', function (e) {
        $(document).trigger('ibn_date_toggle_check');
    });

    /**
     * Add event listener to check if the expiry date toggle is checked on document load.
     */
    $(document).trigger('ibn_date_toggle_check');
})(jQuery);