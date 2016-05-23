<?php 
	function add_subscriber(){
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$mobile = $_POST['mobile'];
		$categoryList = $_POST['categoryList'];
		//$categoryList1 = implode(',',$categoryList);
		foreach ($categoryList as $key) {
			$key;
		}
		if(isset($_POST['add'])){
			global $wpdb;
			$table_name = $wpdb->prefix.'subscriber';
			$table_name1 = $wpdb->prefix.'subscription';
			$sql = $wpdb->prepare("insert into $table_name (firstname,lastname,mobile) values(%s,%s,%s)",$firstName,$lastName,$mobile);
			$wpdb->query($sql);
			$lasid = $wpdb->insert_id;
			foreach ($categoryList as $key) {
				$sql1 = $wpdb->prepare("insert into $table_name1 (sname,aid) values(%s,%s)",$key,$lasid);
				$wpdb->query($sql1);
			}
			$message.="Subscriber Added Sucessfully";
		}
	
		?>
			<div class="wrap">
			    <h1><?php _e( 'Add New Subscriber', 'sample' ); ?></h1>
				<?php if (isset($message)): ?><div class="updated"><p><?php echo $message;?></p></div><?php endif;?>
			    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" id="newSubscriber">

			        <table class="form-table">
			            <tbody>
			                <tr class="row-category">
			                    <th scope="row">
			                        <label for="FirstName"><?php _e( 'First Name', 'sample' ); ?></label>
			                    </th>
			                    <td>
			                        <input type="text" name="firstName" id="firstName1" class="regular-text form-group" placeholder="<?php echo esc_attr( 'First Name', 'sample' ); ?>" value="" required="required" />
			                    </td>
			                </tr>
			                <tr class="row-id">
			                    <th scope="row">
			                        <label for="LastName"><?php _e( 'Last Name', 'sample' ); ?></label>
			                    </th>
			                    <td>
			                        <input type="text" name="lastName" id="lastName1" class="regular-text form-group" placeholder="<?php echo esc_attr( 'Last Name', 'sample' ); ?>" value="" required="required" />
			                    </td>
			                </tr>
			                <tr class="row-id">
			                    <th scope="row">
			                        <label for="MobileNumber"><?php _e( 'Mobile', 'sample' ); ?></label>
			                    </th>
			                    <td>
			                        <input type="text" name="mobile" id="mobile" class="regular-text form-group" placeholder="<?php echo esc_attr( 'Mobile', 'sample' ); ?>" value="" required="required" />
			                    </td>
			                </tr>
			                <tr class="row-id">
			                    <th scope="row">
			                        <label for="Subscription List"><?php _e( 'Subscription List', 'sample' ); ?></label>
			                    </th>
			                    <td>
			                        <select name="categoryList[]" multiple="multiple" name="multiselect" id="multiSelect">
			                        	<?php 
			                        		global $wpdb;
			                        		$table_name = $wpdb->prefix.'subscription_category';
			                        		echo $table_name;
			                        		$sql = "select id,subscription_cat_name from $table_name";
			                     			$data = $wpdb->get_results($sql);
			                     			foreach ($data as $key) {
	                     						echo "<option value='".$key->subscription_cat_name."'>".$key->subscription_cat_name."</option>";
	                     					}		
			                        	?>
			                        </select>
			                    </td>
			                </tr>
			                <tr class="row-id">
			                	<td>
			                		<input type="submit" value="Add Subscriber" class="btn btn-primary" name="add">
			                	</td>
			                </tr>
			             </tbody>
			        </table>
			    </form>
			</div>
		<?php
	}
?>