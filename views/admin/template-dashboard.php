<?php
/**
 * Admin Dashboard template
 *
 * @package WordPressPluginBoilerplate
 */

?>
<div class="wpb-wrap">
	<h2><?php esc_html_e( 'Boilerplate Plugin Settings', 'wpb' ); ?></h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'wpb-settings-group' ); ?>
		<?php do_settings_sections( 'wpb-settings-group' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php esc_html_e( 'Activate Boilerplate Plugin', 'wpb' ); ?></th>
				<td>
					<input type="checkbox" name="_wpb_dashboard[activation]" value="1" <?php checked( $dashboard_settings['activation'] ?? '', 1 ); ?>/>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
