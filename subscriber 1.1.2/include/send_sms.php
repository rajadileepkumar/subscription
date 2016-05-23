<?php
	ob_start();
	
	function subscriber_send_sms(){
		//echo 'Send Sms';
		?>
			<div class="wrap">
			    <h1><?php _e( 'Send Sms', 'sample' ); ?></h1>
				<form action="#" method="post">
				<label>Select Subscription List</label>
				<select name="multiSelectSubscription" id="multiSelectSubscription" onchange="print_name(this)" class="selectpicker">
					<option value="">Select Category List</option>
					<?php
	            		global $wpdb;
	            		$table_name = $wpdb->prefix.'subscription_category';
	            		echo $table_name;
	            		$sql = "select subscription_cat_name from $table_name";
	         			$data = $wpdb->get_results($sql);
	         			foreach ($data as $key) {
	 						echo "<option value='".$key->subscription_cat_name."'>".$key->subscription_cat_name."</option>";
	 					}		
					?>
				</select>
				
				<!-- <select name="categoryList[]" multiple="multiple" name="multiselect" id="multiSelect">
					
				</select>  -->
				<div id="output1"></div>
				</form>
			</div>
			<script type="text/javascript">
				function print_name(sel){
					//var ajaxurl = <?php plugin_dir_url(__FILE__ ).'include/fetch_user_list.php';?>
					//console.log(ajaxurl);
					$("#output1").html("");
					var cat_id = sel.options[sel.selectedIndex].value;
					console.log(cat_id);
					var url="<?php echo plugin_dir_url(__FILE__).'fetch_user_list.php'?>";
					//alert(url);
					if(cat_id.length>0){
						$.ajax({
							type:"POST",
							url:url,
							data:"cat_id="+cat_id,
							cache:false,
							success:function(html){
								$("#output1").html(html);
							}

						});
					}
				}
			</script>
		<?php
		wp_die();
	}


?>