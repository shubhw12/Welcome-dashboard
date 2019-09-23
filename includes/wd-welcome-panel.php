
<?php
wp_enqueue_script('wd_js');
wp_enqueue_style( 'wd_css' );

?>

<div class="wd-welcome-panel-content">		
	<?php echo $this->wd_render_template();	 ?>
</div>

<?php if ( ! current_user_can( 'edit_theme_options' ) ) { ?>
<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $('<div id="welcome-panel" class="welcome-panel wd-welcome-panel-content"></div>').insertBefore('#dashboard-widgets-wrap').append( '<div id="welcome-panel" class="welcome-panel wd-welcome-panel-content" >' + <?php echo $this->wd_render_template();?> +'</div>');
        });
    })(jQuery);
</script>
<?php } ?>





