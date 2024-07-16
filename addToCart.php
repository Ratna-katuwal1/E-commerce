<?php
session_start();
include('connection.php');

if (!isset($_SESSION['name'])) {
    header('Location: CustomerLogin.php');
    exit();
}

if (isset($_GET['product_id']) && isset($_GET['price']) && isset($_GET['product_name']) && isset($_GET['quantity']) && isset($_GET['total'])) {
    $productId = $_GET['product_id'];
    $productPrice = $_GET['price'];
    $productName = $_GET['product_name'];
    $quantity = $_GET['quantity'];
    $total = $_GET['total'];

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = [
            'product_name' => $productName,
            'quantity' => $quantity,
            'price' => $productPrice,
            'total' => $total
        ];
    } else {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
        $_SESSION['cart'][$productId]['total'] += $total;
    }

    $response = ['success' => true, 'message' => 'Product added to cart.'];
    echo json_encode($response);
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
    echo json_encode($response);
}
?>
