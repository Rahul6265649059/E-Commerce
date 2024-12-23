from flask import Flask, render_template, request, flash, redirect
import mysql.connector

app = Flask(__name__)
app.secret_key = 'your_secret_key'

# Database configuration
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': 'Admin@2004',
    'database': 'teetrend_db'
}

# Route to serve the registration form
@app.route('/')
def registration_form():
    return render_template('./register.html')

# Route to handle registration form submission
@app.route('/register', methods=['POST'])
def register():
    try:
        # Get form data
        email = request.form['email']
        password = request.form['password']

        # Input validation
        if not email or not password:
            flash('Email and password are required!')
            return redirect('/')

        # Save to database
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        cursor.execute("INSERT INTO users (email, password) VALUES (%s, %s)", (email, password))
        conn.commit()
        cursor.close()
        conn.close()

        flash('Registration successful!')
        return redirect('/')
    except Exception as e:
        flash(f"An error occurred: {e}")
        return redirect('/')

if __name__ == '__main__':
    app.run(debug=True)
