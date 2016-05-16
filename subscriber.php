<?php
/**
 * Plugin Name: Subscription
 * Plugin URI: https://github.com/rajadileepkumar
 * Description: This plugin adds Subscribes to get the updates of application.
 * Version: 1.0.0
 * Author: Raja Dileep Kumar
 * Author URI: https://github.com/rajadileepkumar
 * License: GPL2
 */

define('WP_DEBUG', TRUE);
register_activation_hook( __FILE__, 'subscription_create_db');
function subscription_create_db(){
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'subscription_category';
	$sql = "create table $table_name(id int auto_increment primary key,subscription_cat_name varchar(20))$charset_collate";
	//require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$results = $wpdb->query($sql);
}
register_deactivation_hook(__FILE__,'subscription_drop_db');

function subscription_drop_db(){
	global $wpdb;
	$table_name = $wpdb->prefix .'subscription_category';
	$sql = "drop table if exists $table_name";
	$wpdb->query($sql);
}

add_action('admin_menu','subscription_menu');

function subscription_menu(){
	$menu = add_menu_page('Subscription','Subscription', 'manage_options', 'subscription-menu','subscription_category','dashicons-admin-users',90);

	$submenu = add_submenu_page('subscription-menu', 'subscription_category_page', 'Add Category', 'manage_options','subscription_category_page','subscription_category_add');

	add_submenu_page(null,'Update Category','Update','manage_options','subscription_category_delete','subscription_category_delete');

	$menu2 = add_submenu_page('subscription-menu','Add Subscriber','Add Subscriber','manage_options','new_subscriber','add_subscriber');
	
	add_action('admin_print_styles-'.$menu,'admin_custom_css');
	add_action('admin_print_scripts-'.$menu,'admin_custom_js');
	add_action('admin_print_styles-'.$menu2,'admin_custom_css');
	add_action('admin_print_scripts-'.$menu2,'admin_custom_js');
}

define('PATH',plugin_dir_path(__FILE__ ));
include_once PATH .'include/subscription_category.php';
include_once PATH .'include/subscription_category.list.php';
include_once PATH .'include/subscription_category_delete.php';
include_once PATH .'include/add_subscriber.php';

function admin_custom_css(){
	wp_enqueue_style('bootstrap',plugin_dir_url(__FILE__ ).'css/bootstrap.css');
    wp_enqueue_style('font-awesome',plugin_dir_url(__FILE__ ).'css/font-awesome.css' );
    wp_enqueue_style('style',plugin_dir_url(__FILE__ ).'css/style.css');
    wp_enqueue_style('bootstrap-select',plugin_dir_url(__FILE__ ).'css/bootstrap-select.min.css');
    wp_enqueue_style('bootstrap-multi-select',plugin_dir_url(__FILE__ ).'css/bootstrap-multiselect.css');
}

function admin_custom_js(){
	wp_enqueue_script('jQuery');
    wp_enqueue_script('bootstrap-js',plugin_dir_url(__FILE__ ).'js/bootstrap.min.js');
    wp_enqueue_script('bootstrap-select-js',plugin_dir_url(__FILE__ ).'js/bootstrap-select.min.js');
    wp_enqueue_script('bootstrap-multiselect-js',plugin_dir_url(__FILE__ ).'js/bootstrap-multiselect.min.js');
    wp_enqueue_script('custom-js',plugin_dir_url(__FILE__ ).'js/custom.js');	
}

function subscription_category(){
	$myListTable = new Subscription_List_Table();
	$myListTable->prepare_items(); 

	 ?>
	 <div class="wrap">	
		<div id="icon-users" class="icon32"><br/></div>
		<h2>Subscription Categories</h2>
		<?php if(!empty($myListTable->notify)) { ?>
		<div id="message" class="updated below-h2">
				<?php 
						if( isset($_POST['s']) ){
			                $myListTable->prepare_items($_POST['s']);
			        } else {
			                $myListTable->prepare_items();
			        }
		        ?>
		</div>
		<?php } ?>
		<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
		<form id="sent-sms-filter" method="post">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<!-- Now we can render the completed list table -->
			<?php 
				//$myListTable->search_box( 'search', 'search_id' );
				$myListTable->display()
			?>
			<?php  ?>
		</form>
		
	</div>
	<?php
}


?>