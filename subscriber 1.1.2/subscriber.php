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
global $sms_options;
$sms_options = array('sms_api' => 'http://bhashsms.com/api/sendmsg.php?user=success&pass=654321&sender=bshsms&phone=[Mobile]&text=[TextMessage]&priority=ndnd&stype=normal');
define('WP_DEBUG', TRUE);
register_activation_hook( __FILE__, 'subscription_create_db');
function subscription_create_db(){
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'subscription_category';
	$table_name1 = $wpdb->prefix.'subscriber';
	$sql = "create table $table_name(id int auto_increment primary key,subscription_cat_name varchar(20))$charset_collate";
	//require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$results = $wpdb->query($sql);
	$sql1 = "create table $table_name1(id int auto_increment primary key,firstname varchar(50),lastname varchar(50),mobile varchar(13))$charset_collate"; 
	$results1 = $wpdb->query($sql1);


	$wpsms_options=array(
		'sms_api1'=>'http://bhashsms.com/api/sendmsg.php?user=success&pass=654321&sender=bshsms&phone=[Mobile]&text=[TextMessage]&priority=ndnd&stype=normal',
		'remove_bad_words'=>'1',
		'captcha'=>'1',
		'captcha_width'=>'70',
		'captcha_height'=>'25',
		'captcha_characters'=>'4',
		'maximum_characters'=>'140',
		'confirm_page'=>'1',
		'sender_id'=>'',
		'allow_without_login'=>'0');
	foreach($wpsms_options as $option=>$value)
	{
		add_option($option,$value);
	}
	
	// Create Database Tables 
	$sql3='CREATE TABLE '.$wpdb->prefix.'sent_sms (
		`id` INT NOT NULL AUTO_INCREMENT,
		`user_id` INT NOT NULL ,
		`mobile` VARCHAR(15) NOT NULL ,
		`message` TEXT NOT NULL ,
		`response` TEXT NULL ,
		`ip` VARCHAR(20) NOT NULL ,
		`sent_time` DATETIME NOT NULL,
		 PRIMARY KEY  (`id`)
		) $charset_collate';
	$result2 = $wpdb->query($sql3);
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
	
	$menu = add_submenu_page('subscription-menu','Subscribers Lists','Subscribers','manage_options','subscribe_list','subscribe_list');

	$menu3 = add_submenu_page('subscription-menu','Send Sms','Send Sms','manage_options','send_sms','subscriber_send_sms'); 
	
	add_action('admin_print_styles-'.$menu,'admin_custom_css');
	add_action('admin_print_scripts-'.$menu,'admin_custom_js');
	add_action('admin_print_styles-'.$menu2,'admin_custom_css');
	add_action('admin_print_scripts-'.$menu2,'admin_custom_js');
	add_action('admin_print_styles-'.$menu3,'admin_custom_css');
	add_action('admin_print_scripts-'.$menu3,'admin_custom_js');
}

define('PATH',plugin_dir_path(__FILE__ ));
include_once PATH .'include/subscription_category.php';
include_once PATH .'include/subscription_category.list.php';
include_once PATH .'include/subscriber_list.php';
include_once PATH .'include/subscription_category_delete.php';
include_once PATH .'include/add_subscriber.php';
include_once PATH .'include/send_sms.php';

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


function subscribe_list(){
	?>
		<a href="<?php echo admin_url('admin.php?page=new_subscriber');?>" class="btn btn-primary btn-large">Add New</a>
	<?php

	if( isset( $_GET['edit'] ) ) :
	  // Show my edit hotel form
		echo 'Hello World';
	else :
	$subscribe = new Subscriber_List_Table();
	$subscribe->prepare_items();
	
	?>
		<form id="sent-sms-filter" method="post">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<!-- Now we can render the completed list table -->
			<?php 
				//$myListTable->search_box( 'search', 'search_id' );
				$subscribe->display();
			?>
			<?php  ?>
		</form>
	<?php
	endif;
}


add_action('init', 'adminsms_send');

?>