<?php
	$all_roles = $this-> wd_get_roles();
	$templates= $this->wd_get_templates();
	wp_enqueue_style( 'wd_css' );
	wp_enqueue_script('wd_js');
 	$wd_post = get_option('wd_settings_data');		
?>
		<h1>Welcome Dashboard</h1>
		<h3>Settings Page</h3>
			<form method="post">
				<table class="wd-table wp-list-table widefat fixed striped ">
					<tr valign="top">
		                <th scope="row" valign="top">
		                    <strong><?php esc_html_e('User Roles', 'welcome-dashboard'); ?></strong>
		                </th>
		                <th scope="row" valign="top">
		                    <strong><?php esc_html_e('Show Template', 'welcome-dashboard'); ?></strong>
		                </th>
		                <th scope="row" valign="top">
		                    <strong><?php esc_html_e('Is Dismissible?', 'welcome-dashboard'); ?></strong>
		                </th>
		                <th scope="row" valign="top">
		                    <strong><?php esc_html_e('Clear dashboard?', 'welcome-dashboard'); ?></strong>
		                </th>
		            </tr>
		            <?php foreach ($all_roles as $roles) {?>
		            <tr>
		            	<th>
		            	<?php echo $roles;?>
		            	</th>
		            	<th>
							<select name= <?php echo $roles;?>[template-id]>
							<option>---select----</option>
							<?php foreach ($templates as $template) { ?>
							<option name = <?php echo $roles;?> value = <?php echo $template->ID;?>>  <?php echo $template->post_title;?> </option>
						<?php }?>
							</select>
		            	</th>
		            	<th>
		            	<input type="checkbox" value = 1 name = <?php echo $roles;?>[dissmissable]> 
		            	</th>
		            	<th>
		            	<input type="checkbox" value = 1 name = <?php echo $roles;?>[clear-dasboard]>
		            	</th>
		            </tr>
		        <?php } ?>
				</table>
 				<input type="submit" class="button button-primary wd-savesetting"  name="submit_radio" Value="Save Settings"/>
 				<br>
			</form>
			</div>