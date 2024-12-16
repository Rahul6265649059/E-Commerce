<?php
session_start();

require('vendor/autoload.php'); 

use Razorpay\Api\Api;

$apiKey = "rzp_test_t17k7Va7z6jPwW";
$apiSecret = "7Ex5zmuyLwFyZP5ATTICO3DQ";

// Create Razorpay API instance
$api = new Api($apiKey, $apiSecret);

if (!isset($_POST['totalAmount'])) {
    die('Total amount is missing.');
}

$amount = $_POST['totalAmount'] * 100; 


$orderData = [
    'amount' => $amount, 
    'currency' => 'INR',
    'payment_capture' => 1 
];

try {
    $order = $api->order->create($orderData);
    $_SESSION['razorpay_order_id'] = $order->id;
    $_SESSION['amount'] = $amount;
    
    $checkoutScript = "
    <script>
        var options = {
            key: 'rzp_test_t17k7Va7z6jPwW', 
            amount: $amount, 
            currency: 'INR',
            name: 'Tee_Trend',
            description: 'Checkout Payment',
            image: 'https://your_logo_url', 
            order_id: '{$order->id}', 
            handler: function (response) {
                alert('Payment successful');
                
            },
            prefill: {
                name: 'John Doe', 
                email: 'johndoe@example.com', 
                contact: '9876543210' 
            },
            notes: {
                address: 'Some address'
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    </script>";

    echo $checkoutScript; 
    
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
