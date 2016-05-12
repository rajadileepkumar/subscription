<?php 
	function subscription_category(){
		?>
			<div class="margin20"></div>
			<div class="container">
				<table class="table table-bordered text-center">
					<tr>
						<td>ID</td>
						<td>Category Name</td>
						<td>Edit</td>
						<td>Delete</td>
					</tr>
					<?php 
						global $wpdb;
						$table_name = $wpdb->prefix.'subscription_category';
						$sql = "select id,subscription_cat_name from $table_name";
						//echo $sql;
						$result = $wpdb->get_results($sql);
						foreach ($result as $row) {
							echo '<tr>';
								echo "<td>$row->id</td>";
								echo "<td>$row->subscription_cat_name</td>";
								echo "<td>";
									echo '<a href="">';
										echo '<i class="fa fa-pencil fa-lg"></i>';
									echo '</a>';
								echo "</td>";
								echo "<td>";
									echo '<a href="'.admin_url('admin.php?page=subscription_category_delete&id='.$row->id).'">';
										echo '<i class="fa fa-trash fa-lg"></i>';
									echo '</a>';
								echo "</td>";
							echo '</tr>';
						}
					?>
				</table>
			</div>
		<?php
	}
?>