<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="editmenu.css">
	<title></title>
</head>
<body>


<?php 
	$id = $_GET['id'];
include 'conn.php';
	$sql = "select * from tbl_product where id= ".$id;
	$res = mysqli_query($conn, $sql);
	if(mysqli_num_rows($res)>0){
		while($row = mysqli_fetch_assoc($res)){
		//	var_dump($row);
			?>
			<div class="edit">
<form method="post" action="update.php?id=<?php echo $id;?>" enctype="multipart/form-data">
	<div class="cont">
				Name: <input type="text" name="name" value="<?php echo $row['name'];?>" required>
				<br><br>
				Current Image: <br><img src="<?php echo $row['image'];?>" alt="Product Image" height="100vh"><br>
				<br><br>

				
				Image: <input type="file" name="image" value="<?php echo $row['image'];?>" > <br><br>
								Price: <input type="number" name="price" value="<?php echo $row['price'];?>" required>
			<br>	<br>
				<input type="submit" value="Update">
	</div>
			</form>
		</div>
	<?php 
		}
	}
?>
<div class="go"><a href="admin_homepage.php">Go Home</a></div>
</body>
</html>