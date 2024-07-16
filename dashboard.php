<?php
session_start();

if (!isset($_SESSION['email'])){
    $_SESSION['error'] = "";
    header('Location: adminLogin.php');
    exit();
}

include("connection.php");

if(isset($_POST['logout'])){
    header('Location: logout.php');
    exit();
}

$totalCustomersQuery = mysqli_query($conn, "SELECT COUNT(*) AS totalCustomers FROM customer_register");
$totalCustomersData = mysqli_fetch_array($totalCustomersQuery);
$totalCustomers = $totalCustomersData['totalCustomers'];
$totalProductsResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM addproduct");
$totalProductsRow = mysqli_fetch_assoc($totalProductsResult);
$totalProducts = $totalProductsRow['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPLUXE - Ladies Shopping Store</title>
    <link rel="stylesheet" href="dashboard.css">
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
            <h2>Dashboard</h2>

            <div class="search-wrapper">
                <span class="fa-solid fa-magnifying-glass"></span>
                <input type="search" placeholder="Search Here">
            </div>

            <div class="user-wrapper">
                <img src="<?php echo isset($_SESSION['profile_Image']) ? $_SESSION['profile_Image'] : 'defaultimage.jpg'; ?>" width="50" height="50" alt="">
                <div>
                    <h4>Ratna Katuwal</h4>
                    <small>Admin</small>
                </div>
            </div>
        </header>

        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1><?php echo $totalCustomers; ?></h1>
                        <span>Customer</span>
                    </div>
                    <div>
                        <span class="fa-solid fa-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo $totalProducts; ?></h1>
                        <span>Products</span>
                    </div>
                    <div>
                        <span class="fa-solid fa-box"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>100</h1>
                        <span>Order</span>
                    </div>
                    <div>
                        <span class="fa-solid fa-bag-shopping"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1>RS: 100</h1>
                        <span>Income</span>
                    </div>
                    <div>
                        <span class="fa-solid fa-wallet"></span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>