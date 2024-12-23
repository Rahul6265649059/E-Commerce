const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const bcrypt = require('bcrypt');

// Initialize Express app
const app = express();
const PORT = 3002;

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

// Handle POST request for user registration (from earlier code)
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

// Handle POST request for user login
app.post('/login', (req, res) => {
    const { email, password } = req.body;

    // Input validation
    if (!email || !password) {
        return res.status(400).send('Email and password are required.');
    }

    // Check if the user exists
    const sql = 'SELECT * FROM users WHERE email = ?';
    db.query(sql, [email], (err, result) => {
        if (err) {
            console.error('Error querying database:', err);
            return res.status(500).send('An error occurred while logging in.');
        }

        if (result.length === 0) {
            return res.status(401).send('Invalid email or password.');
        }

        // Compare the entered password with the stored hashed password
        bcrypt.compare(password, result[0].password, (err, match) => {
            if (err) {
                console.error('Error comparing passwords:', err);
                return res.status(500).send('An error occurred while logging in.');
            }

            if (match) {
                res.status(200).send('Login successful!');
                localStorage.setItem("email",email)
            } else {
                res.status(401).send('Invalid email or password.');
            }
        });
    });
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
