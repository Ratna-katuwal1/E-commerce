<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION['error'] = "";
    header('Location: adminLogin.php');
    exit();
}

include("connection.php");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM addproduct WHERE id = $id");
    header('location: productList.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPLUXE - Ladies Clothing Shop</title>
    <link rel="stylesheet" href="productList.css">
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
            <h2>Product List</h2>
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
            <div class="cust">
                <div class="heading">
                    <h1>Product List</h1>
                </div>

                <?php
                $select = mysqli_query($conn, "SELECT * FROM addproduct");
                ?>
                <div class="cust-details">
                    <table>
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Product Category</th>
                                <th>Product Image</th>
                                <th>Product Type</th>
                                <th>Product Name</th>
                                <th>Product Description</th>
                                <th>Quantity</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        $sno = 1;
                        while ($row = mysqli_fetch_assoc($select)) {
                            $productId = $row['id'];
                            $updateQuantity = isset($_SESSION['cart_quantity'][$productId]) ? ($_SESSION['cart_quantity'][$productId]) : 0;
                            ?>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo $sno++; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['product_category']; ?>
                                    </td>
                                    <td><img src="addProductImages/<?php echo $row['product_Image']; ?>" alt="img"
                                            height="200px" width="200px"></td>
                                    <td>
                                        <?php echo $row['product_type']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['product_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['product_description']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['quantity']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['brand']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['price']; ?>
                                    </td>
                                    <td><a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn">
                                             edit</a>
                                        <a href="productList.php?delete=<?php echo $row['id']; ?>" class="btn">
                                             delete</a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                        } ?>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>