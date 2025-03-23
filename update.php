<?php
$id = $_GET['id'];
$name = $_POST['name'];
$price = $_POST['price'];

// Check if the "image" file has been uploaded
if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $image = $_FILES['image'];

    // Get file details
    $file_name = $image['name'];
    $temp_name = $image['tmp_name'];
    $file_size = $image['size'];
    $file_type = $image['type'];
    $file_error = $image['error'];

    // Move the uploaded file to the specified folder
    $target_dir = "menuimages/";
    $target_file = $target_dir . basename($file_name);

    if(move_uploaded_file($temp_name, $target_file)) {
        // File uploaded successfully, now update data in the database
        include 'conn.php';

        // Update the product information with the new image path
        $sql = "UPDATE tbl_product SET name='$name', image='$target_file', price='$price' WHERE id=$id";
        $res = mysqli_query($conn, $sql);
        if(!$res) {
            // Failed to update
            header("Location: menulist.php");
            die("Failed to update: " . mysqli_error($conn));
        } else {
            // Success, redirect to product list page
            header("Location: menulist.php");
            exit();
        }
    } else {
        // Error moving uploaded file
        header("Location: menulist.php");
        die("Error moving uploaded file.");
    }
} else {
    // If no new image uploaded, update product information without updating the image
    include 'conn.php';
    $sql = "UPDATE tbl_product SET name='$name', price='$price' WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    if(!$res) {
        // Failed to update
        header("Location: menulist.php");
        die("Failed to update: " . mysqli_error($conn));
    } else {
        // Success, redirect to product list page
        header("Location: menulist.php");
        exit();
    }
}
?>
