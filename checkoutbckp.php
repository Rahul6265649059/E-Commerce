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
    <form action="payment_gateway.php" method="POST">
      <input type="hidden" id="totalHiddenAmount" name="totalAmount" value="">
      <button type="submit" class="payment-button">Pay Now</button>
    </form>
  </div>

  <script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalAmount = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
    document.getElementById('totalHiddenAmount').value = totalAmount.toFixed(2);
  </script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

</body>
</html>
