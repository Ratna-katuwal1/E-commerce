<?php
session_start();
include('connection.php');

if (!isset($_SESSION['email'])){
    $_SESSION['error'] = "";
    header('Location: adminLogin.php');
    exit();
}

$orderDetails = isset($_SESSION['orderDetails']) ? $_SESSION['orderDetails'] : null;

unset($_SESSION['orderDetails']);

$orderQuery = "SELECT * FROM checkout";
$result = mysqli_query($conn, $orderQuery);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPLUXE - Ladies Clothing Shop</title>
    <link rel="stylesheet" href="order.css">
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
            <h2>Orders</h2>
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
                    <h1>Customer Order List</h1>
                </div>

                <div class="cust-details">
                    <table>
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) : ?>
                            <tr>
                                <td>1.</td>
                                <td><?php echo $order['customer_name']; ?></td>
                                <td><?php echo $order['contact']; ?></td>
                                <td><?php echo $order['quantity']; ?></td>
                                <td><?php echo number_format($order['price'], 2); ?></td>
                                <td><?php echo number_format($order['grandTotal'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>