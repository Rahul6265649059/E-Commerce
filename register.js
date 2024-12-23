// Import required modules
const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const bcrypt = require('bcrypt');

// Initialize Express app
const app = express();
const PORT = 3001;

// Middleware for parsing JSON and form data
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// MySQL Database connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'Admin@2004', // Update with your MySQL password
    database: 'teetrend_db', // Update with your database name
});

// Connect to the database
db.connect((err) => {
    if (err) {
        console.error('Error connecting to the database:', err);
        return;
    }
    console.log('Connected to the MySQL database.');
});

// Handle POST request for user registration
app.post('/register', async (req, res) => {
    const { email, password } = req.body;

    // Input validation
    if (!email || !password) {
        return res.status(400).send('Email and password are required.');
    }

    try {
        // Hash the password
        const hashedPassword = await bcrypt.hash(password, 10);

        // Insert user data into the database
        const sql = 'INSERT INTO users (email, password) VALUES (?, ?)';
        db.query(sql, [email, hashedPassword], (err, result) => {
            if (err) {
                console.error('Error inserting data:', err);
                return res.status(500).send('An error occurred while registering.');
            }
            res.status(200).send('Registration successful!');
        });
    } catch (error) {
        console.error('Error hashing password:', error);
        res.status(500).send('An error occurred while processing your request.');
    }
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
