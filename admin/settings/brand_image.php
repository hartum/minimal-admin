<?php
$assets_path = plugin_dir_url( __FILE__ ).'../assets/';
$form_path = plugin_dir_url( __FILE__ ).'switch_brand.php';
$ma_settings =  plugin_dir_path( __FILE__ ).'ma_settings.json';
$jsonString = file_get_contents($ma_settings);
$jsonData = json_decode($jsonString, true);
wp_enqueue_media();
$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

//--- check if settings.json has writteable permissions ---
$isSettingsWritable = false;
clearstatcache();
if (is_writable($ma_settings)) {
    $isSettingsWritable = true;
} else {
    $isSettingsWritable = false;
}

//--- if not permissions to write file, show warning ---
if(!$isSettingsWritable){
?>
<div class="update-nag notice notice-warning inline">
    <?php _e( 'You need to give write permissions to the file', 'minimal-admin' ); ?>:<br>
    <?php echo $ma_settings ?><br>
    <?php _e( 'in order to save changes to Minimal Admin.', 'minimal-admin' ); ?>
</div>
<?php
}
//--- DEFINE BRAND IMAGE ---
if($jsonData["brandImage"] == null){
    if($jsonData["mode"] == 'light'){
        $image_src = plugin_dir_url( __FILE__ ).'../menu/brand/ma_logo_light.png';
    } else {
        $image_src = plugin_dir_url( __FILE__ ).'../menu/brand/ma_logo_dark.png';
    }
} else {
    $image_src = $jsonData["brandImage"];
}


?>
<form id="ma_brand_container" method="post" action="<?php echo $form_path ?>">
    <div class='image-preview-wrapper'>
        <img id='image-preview' src="<?php echo $image_src; ?>">
    </div>
    <input id="upload_image_button" type="button" class="button"
        value="<?php _e( 'Change image', 'minimal-admin' ); ?>" />
    <input type='hidden' name='image_attachment_url' id='image_attachment_url' value=''>
    <input type="hidden" name="json_path" value="<?php echo $ma_settings; ?>">
    <input type="submit" value="<?php _e( 'Save image', 'minimal-admin' ); ?>" class="button button-primary"
        <?php if(!$isSettingsWritable) echo "disabled"; ?>>
</form>

<script type='text/javascript'>
jQuery(document).ready(function($) {

    // Uploading files
    var file_frame;
    var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
    var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

    jQuery('#upload_image_button').on('click', function(event) {
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (file_frame) {
            // Set the post ID to what we want
            file_frame.uploader.uploader.param('post_id', set_to_post_id);
            // Open frame
            file_frame.open();
            return;
        } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
            wp.media.model.settings.post.id = set_to_post_id;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        file_frame.on('select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();

            // Do something with attachment.id and/or attachment.url here
            $('#image-preview').attr('src', attachment.url).css('width', 'auto');
            $('#image_attachment_url').val(attachment.url);

            // Restore the main post ID
            wp.media.model.settings.post.id = wp_media_post_id;
        });

        // Finally, open the modal
        file_frame.open();
    });
});
</script>