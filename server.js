const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const cors = require('cors'); // If your frontend is running on a different domain/port

const app = express();
const port = 5000; // Make sure to use the correct port

// Middleware setup
app.use(cors()); // Allow cross-origin requests
app.use(bodyParser.json()); // Parse JSON bodies

// Set up MySQL connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root', // Your MySQL username
    password: 'Admin@2004', // Your MySQL password
    database: 'teetrend_db' // Your MySQL database name
});

db.connect(err => {
    if (err) {
        console.error('Error connecting to MySQL:', err);
        return;
    }
    console.log('Connected to MySQL');
});

// Route to handle adding products to the cart in the database
app.post('/add-to-cart', (req, res) => {
    const { id, name, price, quantity } = req.body; // Get product data from the request body

    // Check if the product already exists in the cart (cart table in DB)
    const checkQuery = 'SELECT * FROM cart WHERE product_id = ?';
    db.query(checkQuery, [id], (err, results) => {
        if (err) {
            return res.status(500).json({ success: false, message: 'Database error' });
        }

        if (results.length > 0) {
            // If the product already exists, update the quantity
            const updateQuery = 'UPDATE cart SET quantity = quantity + ? WHERE product_id = ?';
            db.query(updateQuery, [quantity, id], (err, results) => {
                if (err) {
                    return res.status(500).json({ success: false, message: 'Failed to update product' });
                }
                return res.json({ success: true, message: 'Product quantity updated' });
            });
        } else {
            // If the product doesn't exist, insert it into the cart table
            const insertQuery = 'INSERT INTO cart (product_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?)';
            db.query(insertQuery, [id, name, price, quantity], (err, results) => {
                if (err) {
                    return res.status(500).json({ success: false, message: 'Failed to insert product' });
                }
                return res.json({ success: true, message: 'Product added to cart' });
            });
        }
    });
});

// Start the server
app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
