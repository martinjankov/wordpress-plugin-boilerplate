<div class="wpb-wrap">
	<h2><?php _e( 'WPB Settings', 'wpb' ); ?></h2>

	<form method="post" action="options.php">
	    <?php settings_fields( 'wpb-settings-group' ); ?>
	    <?php do_settings_sections( 'wpb-settings-group' ); ?>
	    <table class="form-table">
	    	<tr valign="top">
                <th scope="row"><?php _e( 'Activate WPB', 'wpb' ); ?></th>
                <td>
                    <input type="checkbox" name="wpb_activation" value="1" <?php checked( get_option( 'wpb_activation' ), 1 ); ?>/>
                </td>
	        </tr>
	    </table>
	    <?php submit_button(); ?>
	</form>
</div>
