<?php
session_start();

if (!isset($_SESSION['email'])) {
  $_SESSION['error'] = "";
  header('Location: adminLogin.php');
  exit();
}

include("connection.php");

if (isset($_POST['submit'])) {
  $productCategory = isset($_POST['productCategory']) ? $_POST['productCategory'] : '';
  $productImage = isset($_FILES['productImage']['name']) ? $_FILES['productImage']['name'] : '';
  $productImageTempName = isset($_FILES['productImage']['tmp_name']) ? $_FILES['productImage']['tmp_name'] : '';
  $productImageFolder = 'addProductImages/' . $productImage;
  $productType = isset($_POST['productType']) ? $_POST['productType'] : '';
  $productName = isset($_POST['productName']) ? $_POST['productName'] : '';
  $productDescription = isset($_POST['productDescription']) ? $_POST['productDescription'] : '';
  $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
  $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
  $price = isset($_POST['price']) ? $_POST['price'] : '';

  if (empty($productCategory) || empty($productImage) || empty($productType) || empty($productName) || empty($brand) || empty($quantity) || empty($price) || empty($productDescription)) {
    $_SESSION['error'] = '';
    header('Location: dashboard.php');
    exit();
  } else {
    if (!is_dir('addProductImages')) {
      mkdir('addProductImages');
    }
    $upload = move_uploaded_file($productImageTempName, $productImageFolder);
    if ($upload) {
      $insert = "INSERT INTO addproduct (product_category, product_Image, product_type, product_name, product_description, quantity, brand, price) VALUES ('$productCategory', '$productImage', '$productType', '$productName', '$productDescription', '$quantity', '$brand', '$price')";
      if (mysqli_query($conn, $insert)) {
        echo "Product Inserted Successfully";
      } else {
        $_SESSION['error'] = 'Failed to add product' . mysqli_error($conn);
      }
    } else {
      $_SESSION['error'] = 'Failed to uploaded File';
    }

    if ($productCategory === 'lehenga') {
      header("Location: lehenga.php");
      exit();

    } elseif ($productCategory === 'suit') {
      header("Location: suit.php");
      exit();

    } elseif ($productCategory === 'saree') {
      header("Location: saree.php");
      exit();

    }  else {
      header("Location: shop.php?newCategory=$productType");
      exit();
    }
  }
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM addproduct WHERE id = $id");
  header('location:dashboard.php');
}
;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SHOPLUXE - Ladies Shopping Store</title>
  <link rel="stylesheet" href="addProduct.css">
  <link rel="icon" href="./Images/logo1.png" type="image/x-icon">
  <script src="https://kit.fontawesome.com/9a11afd28c.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="sidebar">
    <div class="sidebar-logo">
      <img src="./images/logo.png" alt="logo">
    </div>

    <div class="sidebar-menu">
      <ul>
        <li><a href="dashboard.php" class="active">Dashboard</a></li>
        <li><a href="customer.php" class="active">Customers</a></li>
        <li><a href="addProduct.php" class="active">Add Products</a></li>
        <li><a href="productList.php" class="active">Product Lists</a></li>
        <li><a href="order.php" class="active">Orders</a></li>
        <li><a href="account.php" class="active">Account</a></li>
        <li><a href="logout.php" class="active">Logout</a></li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <header>
      <h2>Add Products</h2>
      <div class="search-wrapper">
        <span class="fa-solid fa-magnifying-glass"></span>
        <input type="search" placeholder="Search Here">
      </div>

      <div class="user-wrapper">
        <img src="<?php echo isset($_SESSION['profile_Image']) ? $_SESSION['profile_Image'] : 'defaultimage.jpg'; ?>" width="50px" height="50px" alt="">
        <div>
          <h4>Ratna Katuwal</h4>
          <small>Admin</small>
        </div>
      </div>
    </header>

    <main>
      <div class="admin-product-form">
        <div class="heading">
          <h1>Add a Product</h1>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data"
          id="addProductForm">
          <div class="inputbox">
            <label for="productCategory">Product Category:</label>
            <select name="productCategory" id="productCategory">
              <option value="">Select Product Category</option>
              <option value="lehenga">Lehengas</option>
              <option value="suit">Suits</option>
              <option value="saree">Sarees</option>
            </select>
            <span id="productCategoryError" class="error"></span>
          </div>

          <div class="inputbox">
            <label for="productImage">Product Image:</label>
            <input type="file" name="productImage" id="productImage">
          </div>

          <div class="inputbox">
            <label for="productType">Product Type:</label>
            <input type="text" id="productType" name="productType" value="" autocomplete="off" />
            <span id="productTypeError" class="error"></span>
          </div>

          <div class="inputbox">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" value="" autocomplete="off" />
            <span id="productNameError" class="error"></span>
          </div>

          <div class="inputbox">
            <label for="productDescription">Product Description:</label>
            <textarea id="productDescription" name="productDescription" rows="6" cols="110"
              autocomplete="off"></textarea>
            <span id="productDescriptionError" class="error"></span>
          </div>

          <div class="inputbox">
            <label for="quantity">Quantity:</label>
            <input type="text" id="quantity" name="quantity" value="" autocomplete="off" />
            <span id="quantityError" class="error"></span>
          </div>

          <div class="inputbox">
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" value="" autocomplete="off" />
            <span id="brandError" class="error"></span>
          </div>

          <div class="inputbox">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" value="" autocomplete="off" />
            <span id="priceError" class="error"></span>
          </div>

          <button type="submit" name="submit">Add Product</button>
        </form>
      </div>
    </main>
  </div>
  <script>
    document.getElementById('addProductForm').onsubmit =function (){
      return validateAddProductForm();
    };

    function validateAddProductForm(){
      var productCategory =document.getElementById('productCategory').value;
      var productImage =document.getElementById('productImage').value;
      var productType = document.getElementById('productType').value;
      var productName = document.getElementById('productName').value;
      var productDescription =document.getElementById('productDescription').value;
      var quantity = document.getElementById('quantity').value;
      var brand = document.getElementById('brand').value;
      var price = document.getElementById('price').value;

      if(productCategory === '' || productImage === '' || productType === '' || productName === '' || productDescription === '' || quantity === '' || brand === '' || price === ''){
        alert('please fill out all the field for adding the product.');
        return false;
      }
      return true;
    }
  </script>
</body>

</html>