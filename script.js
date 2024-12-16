// JavaScript for handling "Add to Cart" functionality
let cart = [];

function handleAddToCart(event) {
    // Get product details
    const productId = event.target.getAttribute('data-id');
    const productName = event.target.getAttribute('data-name');
    const productPrice = event.target.getAttribute('data-price');

    // Create a product object
    const product = {
        id: productId,
        name: productName,
        price: productPrice
    };

    // Add product to cart
    cart.push(product);
    alert(`${productName} has been added to the cart!`);

    // Optionally, update cart badge or display the cart items
    console.log(cart);  // For testing purposes
}

// Example: You can add this script at the end of your HTML to run after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // You can add other functionality like loading cart items here
});
