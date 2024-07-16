<?php
session_start();
include('connection.php');

if (isset($_GET['product_id'])) {
  $productId = $_GET['product_id'];
  $select = mysqli_query($conn, "SELECT * FROM addproduct WHERE id='$productId'");
  $product = mysqli_fetch_assoc($select);
}

if (!isset($_SESSION['cart_quantity'])) {
  $_SESSION['cart_quantity'] = array();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopLuxe - Ladies Shopping Store</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #333;
      color: #fff;
      padding: 10px 0;
      text-align: center;
    }

    .title {
      background-color: #502952;
      color: #fff;
      padding: 3px;
      text-align: center;
    }

    .product-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      padding: 20px;
    }

    .product-details {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 15px;
      overflow: hidden;
      width: 85%;
      display: flex;
    }

    .product-image {
      width: 40%;
    }

    .product-image img {
      width: 100%;
      height: auto;
    }

    .product-info {
      width: 60%;
      padding: 20px;
    }

    .product-info h3 {
      color: #333;
      font-size: 1.8em;
      margin-bottom: 10px;
    }

    .product-info p {
      color: #666;
      font-size: 1.2em;
      margin-bottom: 15px;
    }

    .product-info h2 {
      color: #e44d26;
      font-size: 2.5em;
      margin-bottom: 20px;

    }

    .add-to-cart {
      background-color: #e44d26;
      color: #fff;
      border: none;
      padding: 15px;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
      display: block;
      width: 100%;
      font-size: 1.2em;
    }

    .add-to-cart:hover {
      background-color: #333;
    }

    form .inc {
      width: 300px;
      margin: 0 -50px;
      text-align: center;
      padding-top: 50px;
    }

    .input-container{
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .value-button {
      display: inline-block;
      border: 1px solid #ddd;
      width: 40px;
      height: 20px;
      text-align: center;
      vertical-align: middle;
      padding: 11px 0;
      background: #eee;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    .value-button:hover {
      cursor: pointer;
    }

    #decrease {
      margin-right: 5px;
      border-radius: 8px 0 0 8px;
    }

    #increase {
      margin-left: 5px;
      border-radius: 0 8px 8px 0;
    }

    form #input-wrap {
      display: flex;
      align-items: center;
    }

    .number {
      text-align: center;
      border: none;
      border-top: 1px solid #ddd;
      border-bottom: 1px solid #ddd;
      margin: 0px;
      width: 40px;
      height: 40px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .add-to-cart-form{
      margin-top: 20px;
    }
  </style>
  
</head>

<body>
  <div class="title">
    <h2>Product Details</h2>
  </div>

  <div class="product-container">
    <?php
    $select = mysqli_query($conn, "SELECT * FROM addproduct WHERE id='$productId'");
    while ($row = mysqli_fetch_assoc($select)) { ?>
      <div class="product-details">
        <div class="product-image">
          <img src="addProductImages/<?php echo $row['product_Image']; ?>" alt="<?php echo $row['product_name']; ?>" />
        </div>
        <div class="product-info">
          <h3 style="font-size: 50px;  text-transform: uppercase; ">
            <?php echo $row['product_name']; ?>
          </h3>
          <p><strong>Brand:</strong>
            <?php echo $row['brand']; ?>
          </p>
          <p><strong>Category:</strong>
            <?php echo $row['product_category']; ?>
          </p>
          <p><strong>Description:</strong>
            <?php echo isset($row['product_description']) ? $row['product_description'] : ''; ?>
          </p>
          <h2>Price: Rs <span>
              <?php echo $row['price']; ?>
            </span></h2>
            <div class="input-container">
          <div class="value-button" id="decrease" value="Decrease Value" data-product-id="<?php echo $row['id']; ?>">-
          </div>
          <input type="number" class="number" id="number_<?php echo $row['id']; ?>" name="quantity" value="0" />
          <input type="hidden" id="max_quantity_<?php echo $row['id']; ?>" value="<?php echo $row['quantity']; ?>">
          <div class="value-button" id="increase" value="Increase Value" data-product-id="<?php echo $row['id']; ?>">+
          </div>
            </div>
          <form class="add-to-cart-form">
            <?php if (isset($_SESSION['name'])) { ?>
              <button class="add-to-cart" data-product-id="<?php echo $row['id']; ?>"
                data-product-price="<?php echo $row['price']; ?>">Add to Cart</button>
            <?php } else { ?>
              <p>Please <a href="./CustomerLogin.php" class="hover-link"> login</a> or <a href="./CustomerRegister.php" class="hover-link">
                  register</a> to add products
                in your cart. </p>
            <?php } ?>
          </form>
        </div>
      </div>
    <?php } ?>
  </div>
</body>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const decreaseButtons = document.querySelectorAll('.value-button#decrease');
    const increaseButtons = document.querySelectorAll('.value-button#increase');

    addToCartButtons.forEach(button => {
      button.addEventListener('click', addToCart);
    });

    decreaseButtons.forEach(button => {
      button.addEventListener('click', decreaseQuantity);
    });

    increaseButtons.forEach(button => {
      button.addEventListener('click', increaseQuantity);
    });

    function addToCart(event) {
      event.preventDefault();
      const productId = event.target.getAttribute('data-product-id');
      const productPrice = event.target.getAttribute('data-product-price');
      const quantityInput = document.querySelector(`#number_${productId}`);
      const productName = event.target.closest('.product-info').querySelector('h3').textContent;
      const quantity = parseInt(quantityInput.value);
      const total = quantity * parseFloat(productPrice);

      if (quantity > 0) {
        fetch(`addToCart.php?product_id=${productId}&price=${productPrice}&product_name=${productName}&quantity=${quantity}&total=${total}`)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('product added to cart');
              quantityInput.value = 0;
            } else {
              alert('Error adding product to cart')
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      } else {
        alert('Invalid quantity. Please select a valid quantity.');
      }
    }

    function decreaseQuantity(event) {
      const productId = event.target.getAttribute('data-product-id');
      const quantityInput = document.querySelector(`#number_${productId}`);
      let currentQuantity = parseInt(quantityInput.value);
      if (currentQuantity > 0) {
        currentQuantity--;
        quantityInput.value = currentQuantity;
      }
    }

    function increaseQuantity(event) {
      const productId = event.target.getAttribute('data-product-id');
      const quantityInput = document.querySelector(`#number_${productId}`);
      let currentQuantity = parseInt(quantityInput.value);
      currentQuantity++;
      quantityInput.value = currentQuantity;
    }
  }); 
</script>

</html>