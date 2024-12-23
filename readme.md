//install dependencies
npm install
npm install nodemon

//starting point
index.html - run on live server

//run server
nodemon register.js
nodemon login.js
nodemon server.js

//Database - MySql
database name = teetrens_db

Tables:
1. users
create table users(
    id int primary key auto_increment,
    email varchar(255),
    password vaarchar(255),
    createdAt timestamp
)

2.cart
create table cart(
    id int primart key auto_increment,
    product_id varchar(255),
    product_name varchar(255),
    product_price varchar(255),
    quantity int
)
