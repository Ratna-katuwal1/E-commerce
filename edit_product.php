<?php
include("connection.php");

if(isset($_POST['submit'])){
  $id = $_POST['id'];
  $productCategory = $_POST['productCategory'];
  $productType = $_POST['productType'];
  $productName = $_POST['productName'];
  $productDescription = $_POST['productDescription'];
  $quantity = $_POST['quantity'];
  $brand = $_POST['brand'];
  $price = $_POST['price'];

  $update = $conn->prepare("UPDATE addproduct SET product_category=?, product_type=?, product_name=?, product_description=?, quantity=?, brand=?, price=? WHERE id=?");
$update->bind_param("ssssdssi", $productCategory, $productType, $productName, $productDescription, $quantity, $brand, $price, $id);

$result = $update->execute();
    if($result){
      header('location: productList.php');
      exit;
    } else {
      $message[] = 'Error: Product cannot be updated.' . $conn-> error;;
    }
  }

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $select = mysqli_query($conn, "SELECT * FROM addproduct WHERE id = $id");
  $row = mysqli_fetch_assoc($select);

  if(!$row){
    header('location: dashboard.php');
  }
} else {
  header('location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f1f1f1;
        margin: 0;
        padding: 0;
      }

      .admin-product-form {
        max-width: 700px;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 5px;
        margin-top: 60px;
        padding-left: 30px;
        padding-right: 50px;
      }

      .admin-product-form h3 {
        font-size: 32px;
        margin-bottom: 40px;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
        text-decoration: underline;
        padding-top: 20px;
      }

      .admin-product-form .inputbox {
        margin-bottom: 15px;
      }

      .admin-product-form label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
      }

      .admin-product-form input,
      .admin-product-form select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border-radius: 4px;
        border: 1px solid #ccc;
      }
      .admin-product-form select{
        width: 103%
      }

      .admin-product-form button {
        background-color: #4caf50;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 280px;
        margin-bottom: 20px;
      }

      .admin-product-form button:hover {
        background-color: #869b87;
        color: black;
      }

      .admin-product-form .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
      }
    </style>
  </head>
  <body>
    <div id="editProduct" class="title hidden">
      <div class="cont">
        <div class="admin-product-form">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h3>Edit Product Details</h3>

            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="inputbox">
              <label for="productCategory">Product Category</label>
              <select name="productCategory" id="productCategory">
              <option value="">Select Product Category</option>
              <option value="lehenga">Lehengas</option>
              <option value="suit">Suits</option>
              <option value="saree">Sarees</option>
              </select>
            </div>

            <div class="inputbox">
                <label for="productImage">Product Image</label>
                <input type="file" name="productImage" id="productImage" value="<?php echo $row['product_category']; ?>" autocomplete="off"/>
              </div>

            <div class="inputbox">
              <label for="productType">Product Type</label>
              <input type="text" id="productType" name="productType" value="<?php echo $row['product_category']; ?>" autocomplete="off"/>
            </div>

            <div class="inputbox">
              <label for="productName">Product Name</label>
              <input type="text" id="productName" name="productName" value="<?php echo $row['product_name']; ?>" autocomplete="off"/>
            </div>

            <div class="inputbox">
            <label for="productDescription">Product Description</label>
            <textarea id="productDescription" name="productDescription" rows="6" cols="70" autocomplete="off"><?php echo $row['product_description']; ?></textarea>
          </div>

            <div class="inputbox">
              <label for="quantity">Quantity</label>
              <input type="text" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" autocomplete="off"/>
            </div>

            <div class="inputbox">
              <label for="brand">Brand</label>
              <input type="text" id="brand" name="brand" value="<?php echo $row['brand']; ?>" autocomplete="off"/>
            </div>

            <div class="inputbox">
              <label for="price">Price</label>
              <input type="text" id="price" name="price" value="<?php echo $row['price']; ?>" autocomplete="off"/>
            </div>

            <button type="submit" name="submit">Update Product</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
