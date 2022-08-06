<?php do_action( 'ibn_before_custom_editor_metabox' ); ?>
    <div class="ibn-post-fields">
        <div class="ibn-post-field">
            <input type="checkbox" name="ibn_breaking_news_post_id" class="post-format" id="ibn-mark-breaking-news"
                   value="<?php echo esc_attr( $post->ID ); ?>" <?php checked( get_option( 'ibn_breaking_news_post_id' ), esc_attr( $post->ID ) ) ?>>
            <label for="ibn-mark-breaking-news">
				<?php esc_html_e( 'Mark as breaking news', 'ibn' ); ?>
            </label>
        </div>

        <div class="ibn-post-field">
            <label for="ibn_post_custom_title">
				<?php esc_html_e( 'Custom Title:', 'ibn' ); ?>
            </label>
            <input type="text" name="ibn_post_custom_title" id="ibn_post_custom_title" class="code"
                   value="<?php echo esc_attr( get_post_meta( $post->ID, 'ibn_post_custom_title', true ) ); ?>"/>
        </div>

        <div class="ibn-post-field">
            <input type="checkbox" name="ibn_post_expiry_date_toggle" class="post-format" id="ibn-post-expiry-date-toggle"
                   value="1" <?php checked( get_post_meta( $post->ID, 'ibn_post_expiry_date_toggle', true ), 1 ) ?>>
            <label for="ibn-post-expiry-date-toggle">
				<?php esc_html_e( 'Set breaking news expiry date', 'ibn' ); ?>
            </label>
        </div>

        <div class="ibn-post-field date-field">
            <label for="ibn-post-expiry-date">
			    <?php esc_html_e( 'Expiry Date:', 'ibn' ); ?>
            </label>
            <input type="datetime-local" name="ibn_post_expiry_date" id="ibn-post-expiry-date"
                   value="<?php echo esc_attr( get_post_meta( $post->ID, 'ibn_post_expiry_date', true ) ); ?>"/>
        </div>
    </div>
<?php do_action( 'ibn_after_custom_editor_metabox' );
wp_nonce_field( 'ibn_breaking_news_post', 'ibn_nonce' );