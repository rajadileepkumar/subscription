<?php 
	function subscription_category_delete(){
		global $wpdb;
		$table_name = $wpdb->prefix.'subscription_category';
		$id = $_GET['id'];
		//echo $id;
		$sql = $wpdb->prepare("delete from $table_name where id=%s",$id);
		//var_dump($sql);
		$result = $wpdb->query($sql);
		if($result >= 0){
			wp_redirect(admin_url('admin.php?page=subscription-menu'));
			exit();
		}
		else{
			wp_redirect(admin_url('admin.php?page=subscription-menu&message=Unable to Delete'));
			//echo 'False';
		}
	}
?>