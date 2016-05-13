<?php 
	function subscription_category_delete(){
		global $wpdb;
		$table_name = $wpdb->prefix.'subscription_category';
		$id = $_GET['id'];
		//echo $id;
		$sql = $wpdb->prepare("delete from $table_name where id=%s",$id);
		//var_dump($sql);
		$result = $wpdb->query($sql);
		if($result){
			//
			//exit();
			wp_redirect($_REQUEST['_wp_referrer']);
			exit();
			echo 'TRUE';
			if(is_admin()){
				wp_redirect(admin_url('admin.php?page=subscription-menu'));	
			}
			// $redirect_url = admin_url('admin.php?page=subscription-menu');
			// $requested_url = admin_url('admin.php?page=subscription-menu');
			// apply_filters ('redirect_canonical',$redirect_url,$requested_url );
		}
		else{
			wp_redirect(admin_url('admin.php?page=subscription-menu&message=Unable to Delete'));
			//echo 'False';
		}
	}
?>