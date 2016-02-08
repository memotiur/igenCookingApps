<?php
session_start();
	include('igendb.php');
		$sql="CREATE TABLE IF NOT EXISTS item (
		itemId INT(20) AUTO_INCREMENT,
		itemName VARCHAR(100),
		pic VARCHAR(20),
		
		rate INT(200),
		PRIMARY KEY(itemId)
	)";
	if(mysqli_query($conn,$sql)){
		//echo'Yes';
	}
	else
		echo'No'.mysqli_error($conn);
?>
		
		<div class = "container">
			<div class="wrapper col-md-6">
				<form class="form-horizontal form-signin" method="POST" action="" enctype="multipart/form-data">  
					<h3 class="form-signin-heading">Add Item</h3>
					<hr class="colorgraph"><br>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Item Name</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control"  name="itemname" placeholder="Item Name" required="" autofocus="" />
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Image</label>
						<div class="col-sm-9">
						   <input type="file" name="fileToUpload" id="fileToUpload">
						</div>
					  </div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Rate</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="rate" placeholder="Rate" required="" />
						</div>
					</div>
					<button class="btn btn-lg btn-primary btn-block"  name="submit" value="Login" type="Submit">Add Item</button>  			
				</form>	
			</div>
			<?php
			if(isset($_POST['submit'])){
				$itemName=$_POST['itemname'];
				
				$rate=$_POST['rate'];
				
				//File Upload
				$target_dir = "items/";
				$bool=true;
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$filetype=pathinfo($target_file,PATHINFO_EXTENSION);
				$temp=substr($itemName, 0, 5);
				$newfilename="items/". $temp.".".$filetype;

				/*if(file_exists($newfilename)){
						$itemName=$itemName.rand();
						$newfilename="items/". $temp.rand().".".$filetype; 
					}*/
				//if($_FILES["fileToUpload"]["error"] == 4) {
					//$newfilename="items/event.jpg";
				//}
				if($filetype != "jpg" && $filetype != "png" && $filetype != "jpeg"
				&& $filetype != "gif" ) {
					$msg= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$bool=false;
				}
				if($bool==true){
					move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename);
					$msg="File uploaded";
				}
				
				
				
				
				$sql="INSERT INTO item(itemName,pic,rate)
				VALUE('$itemName','$newfilename','$rate')";
				if(mysqli_query($conn,$sql)){
					echo'<div class="alert alert-info">
  <strong>Inserted!</strong></div>';
				}
				else
					echo'Not yet';
			}

			echo'<div class="wrapper col-md-6">';
				$sql="SELECT * FROM item";
					$result=mysqli_query($conn,$sql);
					if(mysqli_num_rows($result) > 0){
						echo'<div class="table-responsive">   <table class="table table-bordered">
					<thead>
					  <tr class="info">
						<th>Item Name</th>
						<th>Pic</th>
						
						<th>Rate</th>
						<th>Delete</th>
					  </tr>
					</thead>';
						while($row=mysqli_fetch_assoc($result)){
							$pic=$row['pic'];
							echo'<tbody><tr class="danger">';
								echo'<td>';echo$row['itemName'].'</td>
								<td><img class="img-responsive" src="';echo$pic.'"alt="" max-height="50"></td>
								
								<td>';echo$row['rate'].'</td>
								<td><a href="delete_item.php?id=' . $row['itemId'] . '">Delete</a></td>
							  </tr>';
						}echo'</tbody>
						</table></div>';
					}else
						echo'<div class="alert alert-info">
  <strong>No Items</strong>Found</div>';
				?>
			</div>
		</div>
		