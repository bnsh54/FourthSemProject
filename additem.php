
<?php
/*
$name = $_POST['name'];
$image = $_POST['image'];
$price = $_POST['price'];
include 'conn.php';
$sql = "insert into tbl_product(name, image, price) values('$name','$image','$price')";
$res = mysqli_query($conn, $sql);
if (!$res) {
	die("Failed to insert " .mysqli_error($conn));
}
else{
header("location: menulist.php");
}
*/

?>


<?php
$name = $_POST['name'];
$price = $_POST['price'];
$image =$_FILES['image'];
//var_dump(($image));

// Check if file was uploaded without errors
if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $file_name = $_FILES["image"]["name"];
    $temp_name = $_FILES["image"]["tmp_name"];
    $file_size = $_FILES["image"]["size"];
    $file_type = $_FILES["image"]["type"];
    $file_error = $_FILES["image"]["error"];

    

    // Move the uploaded file to the specified folder
    $target_dir = "menuimages/";
    $target_file = $target_dir.basename($file_name);
    if(move_uploaded_file($temp_name, $target_file)) {
        // File uploaded successfully, now insert data into database
        include 'conn.php';
        $sql = "INSERT INTO tbl_product(name, image, price) VALUES ('$name', '$target_file', '$price')";
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            header("Location: menulist.php");
			die("Failed to insert: " . mysqli_error($conn));
            

        } else {
            header("Location: menulist.php");
            exit();
        }
    } else {
		header("Location: menulist.php");
        die("Error: Failed to upload file.");
    }
} else {
	header("Location: menulist.php");
    die("Error: No file uploaded or file upload error.");
}
?>