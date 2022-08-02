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
                    <input name="ibn-title" type="text" id="ibn-title" placeholder="<?php esc_attr_e( 'Breaking News!', 'ibn' ); ?>"
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
        </table>
        <input type="hidden" name="action" value="ibn_save_settings">
		<?php wp_nonce_field( 'ibn-settings', 'ibn_nonce' ); ?>
        <button type="submit" class="button button-primary"><?php esc_html_e( 'Save Changes', 'ibn' ); ?></button>
    </form>
</div>