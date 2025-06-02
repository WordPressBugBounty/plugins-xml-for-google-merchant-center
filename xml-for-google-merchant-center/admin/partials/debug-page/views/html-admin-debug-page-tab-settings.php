<?php
/**
 * Display the Settings tab.
 * 
 * @version    4.0.0 (02-06-2025)
 * @package    XFGMC
 * @subpackage XFGMC/admin/partials/debug_page/
 * 
 * @param $view_arr['keeplogs']
 * @param $view_arr['plugin_notifications']
 */
defined( 'ABSPATH' ) || exit; ?>
<div class="xfgmc-postbox postbox">

	<table class="form-table">
		<tbody>
			<tr>
				<th class="xfgmc_th" scope="row"><?php esc_html_e( 'Keep logs', 'xml-for-google-merchatnt-center' ); ?></th>
				<td class="xfgmc_td overalldesc">
					<select id="xfgmc_keeplogs" class="xfgmc_select" name="xfgmc_keeplogs">
						<option value="disabled" <?php selected( $view_arr['keeplogs'], 'disabled' ); ?>>
							<?php esc_html_e( 'Disabled', 'xml-for-google-merchatnt-center' ); ?>
						</option>
						<option value="enabled" <?php selected( $view_arr['keeplogs'], 'enabled' ); ?>>
							<?php esc_html_e( 'Enabled', 'xml-for-google-merchatnt-center' ); ?>
						</option>
					</select>
				</td>
			</tr>
			<?php if ( $view_arr['keeplogs'] === 'enabled' ) : ?>
				<tr>
					<th class="xfgmc_th" scope="row"><?php esc_html_e( 'Link to the log file', 'xml-for-google-merchatnt-center' ); ?>
					</th>
					<td class="xfgmc_td overalldesc">
						<?php
						printf( '<p><a href="%1$s%2$s">%1$s%2$s</a><br/><strong>%4$s:</strong> %3$s%2$s (<a href="%1$s%2$s" download>%5$s</a>).</p>',
							esc_attr( XFGMC_PLUGIN_UPLOADS_DIR_URL ),
							'/xml-for-google-merchatnt-center.log',
							esc_html( XFGMC_PLUGIN_UPLOADS_DIR_PATH ),
							esc_html__( 'Location on your server', 'xml-for-google-merchatnt-center' ),
							esc_html__( 'Download', 'xml-for-google-merchatnt-center' )
						);
						?>
					</td>
				</tr>
			<?php endif; ?>

			<tr>
				<th class="xfgmc_th" scope="row"><?php esc_html_e( 'Plugin notifications', 'xml-for-google-merchatnt-center' ); ?>
				</th>
				<td class="xfgmc_td overalldesc">
					<select id="xfgmc_plugin_notifications" class="xfgmc_select" name="xfgmc_plugin_notifications">
						<option value="enabled" <?php selected( $view_arr['plugin_notifications'], 'enabled' ); ?>>
							<?php esc_html_e( 'Enabled', 'xml-for-google-merchatnt-center' ); ?>
						</option>
						<option value="disabled" <?php selected( $view_arr['plugin_notifications'], 'disabled' ); ?>>
							<?php esc_html_e( 'Disabled', 'xml-for-google-merchatnt-center' ); ?>
						</option>
					</select>
					<p><?php esc_html_e( 'Disables most of the plugin notifications', 'xml-for-google-merchatnt-center' ); ?>.</p>
				</td>
			</tr>
		</tbody>
	</table>

</div>