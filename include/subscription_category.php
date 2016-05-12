<?php 
	function subscription_category_add(){
		$subscriptionCategory = $_POST['subscriptionCategory'];
		//insert
		if(isset($_POST['save'])){
			global $wpdb;
			$table_name = $wpdb->prefix.'subscription_category';
			$sql = $wpdb->prepare("insert into $table_name (subscription_cat_name) values(%s)",$subscriptionCategory);
			$wpdb->query($sql);
			$message.="Subscription Category inserted";
		}		
		?>
			<h2>Add New Subscription Category</h2>
			<?php if (isset($message)): ?><div class="updated"><p><?php echo $message;?></p></div><?php endif;?>
			<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
				<label>Enter Subscription Plan</label>
				<input type="text" name="subscriptionCategory" placeholder="Subscription Plan Name">
				<input type="submit" value="Add" name="save">
			</form>
		<?php 
	}
?>