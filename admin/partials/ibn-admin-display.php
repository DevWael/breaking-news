<?php
/**
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/DevWael
 * @since      1.0.0
 *
 * @package    Ibn
 * @subpackage Ibn/admin/partials
 */
?>
<div class="wrap">
    <h1><?php esc_html_e( 'Breaking News Settings', 'ibn' ); ?></h1>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e( 'Activate news bar', 'ibn' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php esc_html_e( 'Activate news bar', 'ibn' ); ?></span>
                        </legend>
                        <label for="ibn-active">
                            <input name="ibn-active" type="checkbox"
                                   id="ibn-active" <?php checked( Ibn_Settings::get_general_settings_by_key( 'ibn-active' ), 1, true ) ?>
                                   value="1">
							<?php esc_html_e( 'Show/Hide news bar', 'ibn' ); ?>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ibn-title"><?php esc_html_e( 'Breaking News Title', 'ibn' ); ?></label></th>
                <td>
                    <input name="ibn-title" type="text" id="ibn-title"
                           placeholder="<?php esc_attr_e( 'Breaking News!', 'ibn' ); ?>"
                           value="<?php echo esc_attr( Ibn_Settings::get_general_settings_by_key_default( 'ibn-title', __( 'Breaking News!' ) ) ) ?>"
                           class="regular-text">
                    <p class="description" id="new-admin-email-description">
						<?php esc_html_e( 'The title of the breaking news.', 'ibn' ); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label
                            for="ibn-title-bg"><?php esc_html_e( 'Title Background color', 'ibn' ); ?></label>
                </th>
                <td>
                    <input name="ibn-title-bg" type="text" id="ibn-title-bg"
                           value="<?php echo esc_attr( Ibn_Settings::get_general_settings_by_key_default( 'ibn-title-bg', '#000' ) ) ?>"
                           class="ibn-color-picker color-field">
                    <p class="description" id="new-admin-email-description">
						<?php esc_html_e( 'Breaking news bar background color.', 'ibn' ); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ibn-title-color"><?php esc_html_e( 'Title Text color', 'ibn' ); ?></label>
                </th>
                <td>
                    <input name="ibn-title-color" type="text" id="ibn-title-color"
                           value="<?php echo esc_attr( Ibn_Settings::get_general_settings_by_key_default( 'ibn-title-color', '#fff' ) ) ?>"
                           class="ibn-color-picker color-field">
                    <p class="description" id="new-admin-email-description">
						<?php esc_html_e( 'Breaking news title text color.', 'ibn' ); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ibn-post-bg"><?php esc_html_e( 'Post Background color', 'ibn' ); ?></label>
                </th>
                <td>
                    <input name="ibn-post-bg" type="text" id="ibn-post-bg"
                           value="<?php echo esc_attr( Ibn_Settings::get_general_settings_by_key_default( 'ibn-post-bg', '#fff' ) ) ?>"
                           class="ibn-color-picker color-field">
                    <p class="description" id="new-admin-email-description">
						<?php esc_html_e( 'Breaking news post background color.', 'ibn' ); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ibn-post-color"><?php esc_html_e( 'Post Text color', 'ibn' ); ?></label>
                </th>
                <td>
                    <input name="ibn-post-color" type="text" id="ibn-post-color"
                           value="<?php echo esc_attr( Ibn_Settings::get_general_settings_by_key_default( 'ibn-post-color', '#000' ) ) ?>"
                           class="ibn-color-picker color-field">
                    <p class="description" id="new-admin-email-description">
						<?php esc_html_e( 'Breaking news post text color.', 'ibn' ); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e( 'Rounded corners', 'ibn' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php esc_html_e( 'Rounded corners', 'ibn' ); ?></span>
                        </legend>
                        <label for="ibn-rounded-corners">
                            <input name="ibn-rounded-corners" type="checkbox"
                                   id="ibn-rounded-corners" <?php checked( Ibn_Settings::get_general_settings_by_key( 'ibn-rounded-corners' ), 1, true ) ?>
                                   value="1">
							<?php esc_html_e( 'Use rounded corners style', 'ibn' ); ?>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr class="ibn-bar-placement">
                <th scope="row"><?php esc_html_e( 'Bar placement', 'ibn' ); ?></th>
                <td>
                    <fieldset>
                        <label>
                            <input type="radio" name="ibn-bar-placement" value="automatic"
								<?php checked( Ibn_Settings::get_general_settings_by_key( 'ibn-bar-placement' ), 'automatic', true ) ?>>
							<?php esc_html_e( 'Automatic', 'ibn' ); ?>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="ibn-bar-placement"
                                   value="manual" <?php checked( Ibn_Settings::get_general_settings_by_key( 'ibn-bar-placement' ), 'manual', true ) ?>>
							<?php esc_html_e( 'Manual', 'ibn' ); ?>
                        </label>
                        <br>
                        <p class="description">
							<?php esc_html_e( 'Choose the manual option and add css selector to the header if you feel uncomfortable with the current bar placement.',
								'ibn' ); ?>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr class="ibn-css-selector">
                <th scope="row"><label for="ibn-css-selector"><?php esc_html_e( 'CSS Selector', 'ibn' ); ?></label></th>
                <td>
                    <input name="ibn-css-selector" type="text" id="ibn-css-selector"
                           placeholder="<?php esc_attr_e( 'header#masthead', 'ibn' ); ?>"
                           value="<?php echo esc_attr( Ibn_Settings::get_general_settings_by_key_default( 'ibn-css-selector', '' ) ) ?>"
                           class="regular-text">
                    <p class="description" id="new-admin-email-description">
						<?php esc_html_e( 'Write css selector here.', 'ibn' ); ?>
                        <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors" target="_blank">
							<?php esc_html_e( 'Learn more.', 'ibn' ); ?>
                        </a>
                    </p>
                </td>
            </tr>
        </table>
        <input type="hidden" name="action" value="ibn_save_settings">
		<?php wp_nonce_field( 'ibn-settings', 'ibn_nonce' ); ?>
        <button type="submit" class="button button-primary"><?php esc_html_e( 'Save Changes', 'ibn' ); ?></button>
    </form>
</div>
<?php
// display the active post
$current_news_post_id = get_option( 'ibn_breaking_news_post_id' );
if ( $current_news_post_id && is_numeric( $current_news_post_id ) ) {
	?>
    <br>
    <hr>
    <h4><?php esc_html_e( 'Current Breaking News Post:', 'ibn' ); ?></h4>
    <div class="ibn-current-active-post">
		<?php edit_post_link( get_the_title( $current_news_post_id ), '<strong>', '</strong>', $current_news_post_id ) ?>
		<?php
		$post_expiry_toggle = get_post_meta( $current_news_post_id, 'ibn_post_expiry_date_toggle', true );
		if ( $post_expiry_toggle ) {
			$post_expiry_date = get_post_meta( $current_news_post_id, 'ibn_post_expiry_date', true );
			if ( $post_expiry_date ) {
				$date_object = DateTime::createFromFormat( 'Y-m-d\TH:i', $post_expiry_date );
				if ( $date_object ) {
					//check if the date is expired.
					if ( $date_object->getTimestamp() < time() ) {
						?>
                        <strong class="ibn-expired-post">
                            - <?php esc_html_e( 'Expired', 'ibn' ); ?>
                        </strong>
						<?php
					}
				}

			}
		}
		?>
    </div>
	<?php
}