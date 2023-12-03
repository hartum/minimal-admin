<?php
//--- insert user picture and name in screen ---
add_action( 'admin_print_scripts', 'insert_user_profile' );
function insert_user_profile(){
	$user = wp_get_current_user();
	$img_url = esc_url(get_avatar_url($user->ID));
	$username = esc_html($user->user_login);
 	if ($user){
 		//-- position:relative; z-index:5;
 		$user_html = '
 		<div id="menu_user_profile_container" style="display:none;">
 			<img src="'.$img_url.'" class="picture_profile"/>
 			<div>'.$username.'</div>
 		</div>
 		';
 		echo $user_html;
 	}
}

//--- insert BRAND image and JS variables
add_action('admin_print_scripts', 'set_js_variables');
function set_js_variables() {
    //--- declare ma_settings variable, ans set available for all admin ---
    $ma_settings = plugin_dir_path( __FILE__ ).'../settings/ma_settings.json';
    $jsonString = file_get_contents($ma_settings);
	$jsonData = json_decode($jsonString, true);
    $iconsURL = plugin_dir_url( __FILE__ );
	//--- DEFINE BRAND IMAGE ---
	//--- check if image exist
	$file = $jsonData["brandImage"];
	$file_headers = @get_headers($file);
	if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
		$jsonData["brandImage"] = null;
	}
	//--- set image source
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
<script>
var ma_settings = <?php echo $jsonString; ?>;
var iconsURL = '<?php echo $iconsURL; ?>';
var brandImage = '<?php echo $image_src; ?>';
</script>
<?php
}

//--- insert logOut button --
/*
add_action('admin_print_scripts', 'insert_logout_button');
function insert_logout_button() {
	$url = site_url().'/wp-login.php?action=logout';
	$button_url = plugin_dir_url( __FILE__ ).'../assets/switch.svg';
	echo '<a href="'.wp_logout_url( home_url() ).'" class="logout-button"><img src="'.$button_url.'"/></a>';
}
*/
?>