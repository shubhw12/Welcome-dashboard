
<?php
function wd_get_roles() {
	
	global $wp_roles;
	
	$roles = $wp_roles->get_names();
	
	return $roles;
}

		$args = array(
			'fields'          => 'ids', 
            'post_type'         => 'elementor_library',
			'posts_per_page'    => '-1',
			'post_status'		=> 'publish'
		);

		$templates = get_posts( $args );
?>

<html>
<body>
	<h1>Welcome Dashboard</h1>
	<h3>Settings Page</h3>
<?php
	$all_roles = wd_get_roles();
	foreach( $all_roles as $roles ){ 
	?>

	<div>
		<?php echo $roles; ?>
	</div>
<?php	
	}
?>
<?php
	foreach( $templates as $template ){ 
	?>

	<div>
		<?php print_r($templates['fields']); ?>
	</div>
<?php	
	}
?>

</body>
</html>