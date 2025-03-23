 <?php 
session_start();
include "conn.php";
if(isset($_SESSION["username"])){
  $uname =$_SESSION["username"];

$query = $conn->prepare("SELECT * FROM takeorder WHERE username = ? order by order_date DESC");
$query->bind_param('s',$uname);
$query-> execute();
$fetchedresult = $query-> get_result();
$fetchedresult =$fetchedresult->fetch_all(MYSQLI_ASSOC);
//print_r($fetchedresult);




// $uid = $result3 ["id"];
if(isset($_POST["add_to_cart"]))
{
  if(isset($_SESSION["shopping_cart"]))
  {
    $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
    if(!in_array($_GET["id"], $item_array_id))
    {
      $count = count($_SESSION["shopping_cart"]);
      $item_array = array(
        'item_id'     =>  $_GET["id"],
        'item_name'     =>  $_POST["hidden_name"],
        'item_price'    =>  $_POST["hidden_price"],
        'item_quantity'   =>  $_POST["quantity"]
      );
      $_SESSION["shopping_cart"][$count] = $item_array;
   
      $username = $uname;
      $item_name = $_POST['hidden_name'];
      $quantity = $_POST['quantity'];
      $price = $_POST['hidden_price'];
      $price1 = $price*$quantity;
      $sql = "insert into takeorder(id,username,item_name,quantity,price) values ('$id','$uname','$item_name','$quantity','$price1')";
      $res = mysqli_query($conn,$sql);
      echo '<script>alert("Item Added")</script>';
       echo '<script>window.location="menu.php"</script>';
    }
    else
    {
      echo '<script>alert("Item Already Added")</script>';
    }
  }

  else
  {
    $item_array = array(
      'item_id'     =>  $_GET["id"],
      'item_name'     =>  $_POST["hidden_name"],
      'item_price'    =>  $_POST["hidden_price"],
      'item_quantity'   =>  $_POST["quantity"]
    );
     $_SESSION["shopping_cart"][0] = $item_array;

      $username = $uname;
      $item_name = $_POST['hidden_name'];
      $quantity = $_POST['quantity'];
      $price = $_POST['hidden_price'];
      $price1 = $price*$quantity;
      $sql = "insert into takeorder(id,username,item_name,quantity,price) values ('$id','$uname','$item_name','$quantity','$price1')";
      $res = mysqli_query($conn,$sql);
      echo '<script>alert("Item Added")</script>';
       echo '<script>window.location="menu.php"</script>';
  }
}

if(isset($_GET["action"]))
{
  if($_GET["action"] == "delete")
  {
    foreach($_SESSION["shopping_cart"] as $keys => $values)
    {
      if($values["item_id"] == $_GET["id"])
      {
        unset($_SESSION["shopping_cart"][$keys]);
        echo '<script>alert("Item Removed")</script>';
        echo '<script>window.location="cart1.php"</script>';
      }
    }
  }
}

}
else{
  header("Location: login.php");
    exit();

}

?>
<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="menu.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  <body>
    <br />
    <div class="container">
      <br />
      <br />
      <br />
      <h1 align="center">Order Details</h1> 
      <?php
        $query = "SELECT * FROM tbl_product ORDER BY id ASC";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
     
      <?php
          }
        }
      ?>
      <div style="clear:both"></div>
      <br>
  
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th width="40%">Item Name</th>
            <th width="10%">Quantity</th>
            <th width="20%">Price</th>
            <th width="15%">Total</th>
            <th width="5%">Action</th>
          </tr>
         
         
          <?php
          if (!empty($fetchedresult)) {
            $totalPrice=0;
                foreach ($fetchedresult as $row) {
                    ?>
                    <tr>
                       <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>Rs <?php echo $row['price']; ?></td>
                        <td><?php echo $row['quantity']*$row['price']; ?></td>
                        <td><a href="cart1.php?action=delete&id=<?php echo $row["id"]; ?>"><span
                                    class="text-danger">Remove</span></a></td>
                    </tr>
                    <?php
              $totalPrice = $totalPrice + ($row['quantity'] * $row['price']);
            }
          ?>
          
          <tr>
            <td colspan="3" align="right">Total</td>
            <td align="right">Rs <?php echo number_format($totalPrice, 2); ?></td>
            <td></td>
          </tr>
                    <?php
                
            } else {
            }
                ?>

        </table>
      </div>
    </div>
  </div>
    <div class= "men"> <a href="canteen.php">Go Home</a></div>
        <div class= "car"> <a href="menu.php">Menu</a></div>
  </body>
</html>
 