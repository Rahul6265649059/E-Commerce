<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Tee_Trend</title>
  <link rel="stylesheet" href="checkout.css"> 
</head>
<body>
  <h1>Checkout</h1>
  <div class="checkout-summary">
    <?php
    echo '<script>
            const cart = JSON.parse(localStorage.getItem("cart"));
            document.write("<h2>Your Cart:</h2>");
            if (cart && cart.length > 0) {
                cart.forEach(item => {
                    document.write(`<p>${item.name} - Rs. ${item.price} x ${item.quantity}</p>`);
                });
            } else {
                document.write("<p>Your cart is empty.</p>");
            }
          </script>';
    ?>
    <p><strong>Total Amount: Rs. <span id="totalAmount"></span></strong></p>
  </div>

  <div class="payment">
    <button class="payment-button" action="payment_gateway.php">Pay Now</button>
  </div>

  <script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalAmount = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);

    fetch('payment_gateway.php', {
      method: 'POST',
      body: new URLSearchParams({ 'totalAmount': totalAmount })
    })
    .then(response => response.json())
    .then(data => {
      const razorpayOptions = {
        "key": "rzp_test_t17k7Va7z6jPwW	",  
        "amount": totalAmount * 100,    
        "currency": "INR",
        "name": "Tee Trend",
        "description": "Purchase items from your cart",
        "order_id": data.order_id,      
        "handler": function (response) {
          alert("Payment Successful!");
        },
        "prefill": {
          "name": "Your Name",
          "email": "your_email@example.com",
          "contact": "9999999999"
        },
        "theme": {
          "color": "#F37254"
        }
      };

      document.querySelector('.payment-button').onclick = function(e) {
    e.preventDefault();  
    const rzp1 = new Razorpay(razorpayOptions); 
    rzp1.open();  
};
    })
    .catch(error => console.error('Error creating order:', error));
  </script>

  
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</body>
</html>
