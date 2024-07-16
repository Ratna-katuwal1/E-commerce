<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the grandTotal from POST parameters
    $grandTotal = $_POST['grandTotal'];

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
//     $totalItems = $_GET['totalItems'] ?? 0;
//     $subTotal = $_GET['subTotal'] ?? 0;
//     $shippingCharge = $_GET['shippingCharge'] ?? 0;
//     $total = $_GET['total'] ?? 0;
//     $tax = $_GET['tax'] ?? 0;
//     $grandTotal = $_GET['grandTotal'] ?? 0;

$customerName = $_GET['name'];
    $customerEmail = $_GET['email'];
    $customerPhone = $_GET['phone'];
    $grandTotal = $_GET['grandTotal'];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "return_url": "http://localhost/mis_project/Project-1/projectCode/thankyou.php",
            "website_url": "http://localhost/mis_project/Project-1/projectCode/",
            "amount": "' . $grandTotal . '",
            "purchase_order_id": "Order01",
            "purchase_order_name": "test",
            "customer_info": {
                "name": "' . $customerName . '",
                "email": "' . $customerEmail . '",
                "phone": "' . $customerPhone . '"
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
            'Content-Type: application/json',
        ),
    ));

//     // Customer information
//     $customerName = $_SESSION['orderDetails']['customer_name'] ?? '';
//     $customerEmail = $_POST['email'] ?? '';
//     $customerPhone = $_POST['phone'] ?? '';
    
    
// Check if form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "GET") {
// $curl = curl_init();
//     curl_setopt_array($curl, array(
//     CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_POSTFIELDS =>'{
//     "return_url": "http://localhost/mis_project/Project-1/projectCode/thankyou.php",
//     "website_url": "http://localhost/mis_project/Project-1/projectCode/",
//     "amount": "1000",
//     "purchase_order_id": "Order01",
//         "purchase_order_name": "test",

//     "customer_info": {
//         "name": "Test Bahadur",
//         "email": "test@khalti.com",
//         "phone": "9800000001"
//     }
//     }

//     ',
//     CURLOPT_HTTPHEADER => array(
//         'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
//         'Content-Type: application/json',
//     ),
//     ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response_array = json_decode($response, true);

    if ($response_array && isset($response_array['pidx'])) {
        return header("Location: $response_array[payment_url]");
    } else {
        // Display error message
        echo "Payment initiation failed. Please try again later.";
    }
}
?>
