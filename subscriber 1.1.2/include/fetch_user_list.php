<?php
	require_once('../../../../wp-load.php'); 
	$cat_id = ($_REQUEST["cat_id"] <> "") ? trim($_REQUEST["cat_id"]) : "";
	//echo $cat_id;
	if ($cat_id <> "") {
		global $wpdb;
		$table_name = $wpdb->prefix.'wp_subscriber';
		$sql = "select * from wp_subscriber inner join wp_subscription on wp_subscriber.id = wp_subscription.aid where sname='$cat_id'";
		//var_dump($sql);
		//$wpdb->flush();
		$data = $wpdb->get_results($sql);
		//print_r($data);
		//var_dump($result);
		?>
			
		<?php
		if(count($data) > 0){
			?>
				
				<label>Select Subscribers</label>
				<select name="multiMobileSelection" id="multiMobileSelection" multiple="multiple" class="selectpicker">
						<?php foreach($data as $key){?>
							<option value="<?php echo $key->id; ?>"><?php echo $key->mobile ?></option>
						<?php }?>
				</select>
				<label>Send Message</label>
				<textarea rows="3" cols="30" class="form-control"></textarea>
				<input type="submit" value="Send Sms" class="btn btn-primary">
				<script type="text/javascript">

				$(function () {
				            $('#multiMobileSelection').multiselect({
				                includeSelectAllOption: true
				            });
				            // $('.btn-primary').click(function () {
				            //     var selected = $("#multiSelect option:selected");
				            //     var message = "";
				            //     selected.each(function () {
				            //         message += $(this).text() + " " + $(this).val() + "\n";
				            //     });
				            //     alert(message);
				            // });
				        });
				</script>
				
			<?php	
		}	
		
	}
	
?>