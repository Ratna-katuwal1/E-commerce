<?php
session_start();

if (!isset($_SESSION['email'])){
    $_SESSION['error'] = "";
    header('Location: adminLogin.php');
    exit();
}
include ('connection.php');
  $selectCustomerDetails = mysqli_query($conn, "SELECT * FROM customer_register");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPLUXE - Ladies Shopping Store</title>
    <link rel="stylesheet" href="customer.css">
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
            <h2>Customers</h2>
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
                    <h1>Customer Details</h1>
                </div>

                <div class="cust-details">
                    <table>
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Customer Name</th>
                                <th>profile Image</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Gender</th>
                                <th>E-mail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            $sn = 1;
                            while ($customerDetails = mysqli_fetch_assoc($selectCustomerDetails)) {
                                ?>
                                <tr>
                                <td>
                                    <?php echo $sn++; ?>
                                </td>
                                <td>
                                    <?php echo $customerDetails['name']; ?>
                                </td>
                                <td><img src="<?php echo $customerDetails['profile_Image']; ?>" alt="img" height="50px" width="50px"></td>
                                <td>
                                    <?php echo $customerDetails['address']; ?>
                                </td>
                                <td>
                                    <?php echo $customerDetails['contact']; ?>
                                </td>
                                <td>
                                    <?php echo $customerDetails['gender']; ?>
                                </td>
                                <td>
                                    <?php echo $customerDetails['email']; ?>
                                </td>
                            </tr>
                            <?php
                            $counter++;
                            }  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>