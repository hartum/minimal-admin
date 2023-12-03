<?php 
//function admin_page_html() {
  // check user capabilities
  if ( ! current_user_can( 'edit_theme_options' ) ) {
    return;
  }
  //Get the active tab from the $_GET param
  $default_tab = null;
  $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
  
  ?>
<!-- Our admin page content should all be inside .wrap -->
<div class="wrap">
    <!-- Print the page title -->
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <!-- Here are our tabs -->
    <nav class="nav-tab-wrapper">
        <a href="?page=minimal-admin-settings"
            class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>"><?php _e('Light/Dark', 'minimal-admin'); ?></a>
        <a href="?page=minimal-admin-settings&tab=menu"
            class="nav-tab <?php if($tab==='menu'):?>nav-tab-active<?php endif; ?>"><?php _e('Menu', 'minimal-admin'); ?></a>
        <a href="?page=minimal-admin-settings&tab=brand"
            class="nav-tab <?php if($tab==='brand'):?>nav-tab-active<?php endif; ?>"><?php _e('Brand', 'minimal-admin'); ?></a>
    </nav>

    <div class="tab-content">
        <?php switch($tab) :
      case 'menu':
        echo 'Under construction ;)'; //Put your HTML here
        break;
      case 'brand':
        include  plugin_dir_path( __FILE__ ).'/brand_image.php';
        break;
      default:
        include  plugin_dir_path( __FILE__ ).'/light_dark.php';
        break;
    endswitch; ?>
    </div>
</div>