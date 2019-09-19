<html>
	<body>
		<h1>Welcome Dashboard</h1>
		<h3>Settings Page</h3>
	<?php
		$all_roles = $this-> wd_get_roles();

			$templates= $this->wd_get_templates();?>

		</div>
			<div>
			<form method="post">
				<table class="dwe-settings-table wp-list-table widefat">
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
							<select value = <?php echo $roles.[];?> >
							<option value ="---select---"  >---select----</option>
							<?php foreach ($templates as $template) { ?>
							<option  name = "templateid[]" value=<?php echo $template->ID;?>> <?php echo $template->post_title;?> </option>
						<?php }?>
							</select>
		            	</th>
		            </tr>
		        <?php } ?>
				</table>
				<div>
					<?php
		 			for ($i=0; $i<2; $i++) { 
							echo  $this->wd_render_template();
					}?>
				</div>

				<input type="submit" class="button button-primary ppc-savesetting"  name="submit_radio" Value="Save Settings"/>
			</form>
			</div>
	</body>
</html>