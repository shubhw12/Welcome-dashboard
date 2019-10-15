<?php
/**
 * Welcome Dashboard settings page
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Welcome Dashboard
 * @author   Display Name <username@BrainstormForce.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 *
 * @since  1.0.0
 * @return void
 */

	$all_roles = $this->wd_get_roles();
	$templates = $this->wd_get_templates();
	wp_enqueue_style( 'wd_css' );
	wp_enqueue_script( 'wd_js' );
	$wd_post              = get_option( 'wd_settings_data' );
	$wd_current_user_role = $this->wd_get_current_user_role();
	$wd_role              = ucfirst( $wd_current_user_role );
	$ppc_screen           = get_current_screen();
?>
		<h1>Welcome Dashboard</h1>
		<h3>Settings Page</h3>
			<form method="post">
				<table class="wd-table wp-list-table widefat fixed striped ">
					<tr valign="top">
						<th scope="row" valign="top">
							<strong><?php esc_html_e( 'User Roles', 'welcome-dashboard' ); ?></strong>
						</th>
						<th scope="row" valign="top">
							<strong><?php esc_html_e( 'Show Template', 'welcome-dashboard' ); ?></strong>
						</th>
						<th scope="row" valign="top">
							<strong><?php esc_html_e( 'Is Dismissible?', 'welcome-dashboard' ); ?></strong>
						</th>
						<th scope="row" valign="top">
							<strong><?php esc_html_e( 'Clear dashboard?', 'welcome-dashboard' ); ?></strong>
						</th>
					</tr>
					<?php foreach ( $all_roles as $roles ) { ?>
					<tr>
						<th>
						<?php echo esc_attr( $roles ); ?>
						</th>
						<th>
							<select name= <?php echo esc_attr( ( str_replace( ' ', '', $roles ) ) ); ?>[template-id]>
							<option>---select---</option>
							<?php foreach ( $templates as $template ) { ?>
							<option name = <?php echo esc_attr( ( str_replace( ' ', '', $roles ) ) ); ?> value = <?php echo esc_attr( $template->ID ); ?> 
								<?php
								if ( ! empty( $wd_post ) ) {
									selected( true, in_array( $template->ID, $wd_post[ ( str_replace( ' ', '', $roles ) ) ] ) );
								}
								?>
							> 
								<?php
								echo esc_attr( $template->post_title );
								?>
							</option>
						<?php } ?>
							</select>
						</th>
						<th>
						<input type="checkbox" value = 1 name = <?php echo esc_attr( ( str_replace( ' ', '', $roles ) ) ); ?>[dissmissable] 
						<?php
						if ( ! empty( $wd_post ) ) {
							checked( isset( $wd_post[ ( str_replace( ' ', '', $roles ) ) ]['dissmissable'] ) );
						}
						?>
						> 
						</th>
						<th>
						<input type="checkbox" value = 1 name = <?php echo esc_attr( ( str_replace( ' ', '', $roles ) ) ); ?>[clear-dasboard]
						<?php
						if ( ! empty( $wd_post ) ) {
							checked( isset( $wd_post[ ( str_replace( ' ', '', $roles ) ) ]['clear-dasboard'] ) );
						}
						?>
						>
						</th>
					</tr>
				<?php } ?>
				</table>
				<br>
				<?php if ( is_multisite() && get_current_blog_id() === 1 ) { ?>
				<div class="wd-hide-settings">Hide settings from other subsites
				<label class="switch">
								<input type="checkbox" value="yes" name="wd_hide_settings" 
								<?php
								if ( ! empty( $wd_post ) ) {
									checked( isset( $wd_post['wd_hide_settings'] ) );
								}
								?>
								>
								<span class="slider round"></span>
								</label>
				</div>
				<?php } ?>
				<br>
				<?php wp_nonce_field( 'wd-form-nonce', 'wd-form' ); ?>
				<input type="submit" class="button button-primary wd-savesetting"  name="submit_radio" Value="Save Settings"/>
			</form>
			</div>
