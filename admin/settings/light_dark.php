<?php
$assets_path = plugin_dir_url( __FILE__ ).'../assets/';
$form_path = plugin_dir_url( __FILE__ ).'switch_mode.php';
$ma_settings =  plugin_dir_path( __FILE__ ).'ma_settings.json';
$jsonString = file_get_contents($ma_settings);
$jsonData = json_decode($jsonString, true);

//--- check if settings.json has writteable permissions ---
$isSettingsWritable = false;
clearstatcache();
if (is_writable($ma_settings)) {
    $isSettingsWritable = true;
} else {
    $isSettingsWritable = false;
}
//--- if not permissions to write show warning ---
if(!$isSettingsWritable){
?>
<div class="update-nag notice notice-warning inline">
    <?php _e( 'You need to give write permissions to the file', 'minimal-admin' ); ?>:<br>
    <?php echo $ma_settings ?><br>
    <?php _e( 'in order to save changes to Minimal Admin.', 'minimal-admin' ); ?>
</div>
<?php
}
?>
<div>
    <form id="ma_mode_container" method="post" action="<?php echo $form_path ?>">
        <label>
            <input type="radio" name="mode" value="light"
                <?php if($jsonData["mode"] == 'light') echo 'checked autofocus'?> />
            <img src="<?php echo $assets_path.'light-mode.svg' ?>">
            <?php _e( 'Light theme', 'minimal-admin' ); ?>
        </label>
        <label>
            <input type="radio" name="mode" value="dark"
                <?php if($jsonData["mode"] == 'dark') echo 'checked autofocus'?> />
            <img src="<?php echo $assets_path.'dark-mode.svg' ?>">
            <?php _e( 'Dark theme', 'minimal-admin' ); ?>
        </label><br>
        <input type="hidden" name="json_path" value="<?php echo $ma_settings; ?>">
        <input type="submit" value="<?php _e( 'Change theme', 'minimal-admin' ); ?>" class="button button-primary">
    </form>
</div>