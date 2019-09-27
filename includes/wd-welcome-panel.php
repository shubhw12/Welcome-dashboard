
<?php
	wp_enqueue_style( 'wd_css' );
	wp_enqueue_script('wd_js');	
?>


<div class="welcome-panel-content wd-panel-content">
	<?php $this->wd_render_template(); ?>
</div>

<?php if ( ! current_user_can( 'edit_theme_options' ) ) { ?>
<script type="text/javascript">
    ;(function($) {
        $(document).ready(function() {
            $('<div id="welcome-panel" class="welcome-panel welcome-panel-content notice is-dismissible"></div>').insertBefore('#dashboard-widgets-wrap').append($('.wd-panel-content'));
        });
    })(jQuery);
</script>
<?php } ?>




