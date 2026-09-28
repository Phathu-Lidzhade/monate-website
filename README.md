# monate-website
# 🍗 Monate Chicken N Steak

A full-stack restaurant ordering website developed for **Monate Chicken N Steak**, a restaurant based in Thohoyandou, Limpopo, South Africa.

The website provides customers with an online platform to explore the restaurant's menu, create an account, manage their cart, and place orders for **delivery or collection**.

The project was developed using **HTML, CSS, JavaScript, PHP, and MySQL**, with XAMPP used as the local development environment.

---

## 📌 About the Project

Monate Chicken N Steak was developed to provide a digital ordering experience for a local restaurant.

The system focuses on the customer's ordering journey, from browsing the menu to adding items to a cart and submitting an order. It also includes account management and an administrative section for managing the restaurant's system.

---

## ✨ Features

### 👤 Customer Features

* Create a customer account
* Sign in and sign out
* Forgot password functionality
* Browse the restaurant menu
* Add products to the shopping cart
* Update cart items
* Remove items from the cart
* View the total order amount
* Place orders
* Choose between delivery and collection
* Access restaurant information through the About Us page

### 🛒 Shopping Cart

The website includes a shopping cart system that allows customers to:

* Add menu items
* Increase or decrease quantities
* Remove items
* Review selected items
* Calculate the order total before placing an order

### 🔐 Authentication

The system includes:

* Customer registration
* Customer login
* Logout functionality
* Forgot password functionality
* Session-based user management

### 👨‍💼 Admin

The project includes a dedicated admin section for managing the restaurant's system.

### 🍽️ Menu

Customers can browse the restaurant's available food items and select products to add to their order.

---

## 🛠️ Technologies Used

### Frontend

* HTML5
* CSS3
* JavaScript

### Backend

* PHP

### Database

* MySQL

### Development Tools

* XAMPP
* Apache
* phpMyAdmin
* MySQL

---

## 📂 Project Structure

The project is organized into different directories based on the functionality of the website.

```text
monate-website/
│
├── API/
│   └── API-related functionality
│
├── HOME/
│   └── Home page
│
├── Logout/
│   └── Logout functionality
│
├── about us/
│   └── Restaurant information
│
├── admin/
│   └── Administrative functionality
│
├── create account/
│   └── Customer registration
│
├── forgot password/
│   └── Password recovery functionality
│
├── menu/
│   └── Restaurant menu and ordering functionality
│
├── sign in/
│   └── Customer authentication
│
├── LICENSE
│
├── README.md
│
├── monate_website (1).sql
│
└── monate_website (3).sql
```

The project is structured around the main functionality of the restaurant website rather than using a single centralized MVC directory structure.

---

## 🗄️ Database

The application uses **MySQL** for storing and managing the data required by the restaurant ordering system.

SQL database files are included in the repository:

```text
monate_website (1).sql
monate_website (3).sql
```

These files can be imported into **phpMyAdmin** to set up the database in a local XAMPP environment.

---

## 🚀 Getting Started

### Prerequisites

Before running the project, make sure you have:

* [XAMPP](https://www.apachefriends.org/) installed
* Apache
* MySQL
* phpMyAdmin
* A modern web browser
* Git

### 1. Clone the Repository

```bash
git clone https://github.com/Phathu-Lidzhade/monate-website.git
```

### 2. Move the Project

Move the project folder into the XAMPP `htdocs` directory.

```text
C:\xampp\htdocs\monate-website
```

### 3. Start XAMPP

Open the XAMPP Control Panel and start:

* Apache
* MySQL

### 4. Set Up the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create the required database and import the appropriate SQL file from the repository.

### 5. Run the Website

Open the website in your browser:

```text
http://localhost/monate-website/
```

---

## 🔄 Ordering Workflow

The basic customer workflow is:

```text
Create Account / Sign In
          ↓
      Browse Menu
          ↓
      Select Items
          ↓
       Add to Cart
          ↓
      Review Cart
          ↓
 Delivery or Collection
          ↓
      Place Order
```

---

## 🧠 What I Learned

This project gave me practical experience in building a full-stack web application and connecting a frontend to a relational database.

Some of the key areas I worked with include:

* PHP backend development
* MySQL database integration
* User authentication
* Session management
* Form handling
* Shopping cart functionality
* CRUD operations
* JavaScript DOM manipulation
* Database-driven web pages
* Debugging frontend and backend issues
* Working with XAMPP and phpMyAdmin
* Structuring a multi-page web application

---

## 🔧 Challenges and Development

One of the areas that required debugging during development was the shopping cart functionality.

The project went through several iterations to fix cart-related issues and improve the interaction between the menu, cart, and ordering functionality.

This provided practical experience in tracing problems across the frontend, backend, and database layers rather than treating each part of the application separately.

---

## 📸 Screenshots

### Home Page

<img width="1920" height="1020" alt="landing page" src="https://github.com/user-attachments/assets/5fe198c8-e802-4e97-9c78-5b724f23a461" />


### Menu

<img width="1920" height="1020" alt="menu" src="https://github.com/user-attachments/assets/24c021dc-52dd-4a2f-8c5e-1edb36ad75d2" />


### Shopping Cart

<img width="1920" height="1020" alt="cart page" src="https://github.com/user-attachments/assets/eec4d849-6382-44ba-ae9f-de7641b1bc14" />


### About

<img width="1920" height="1020" alt="about page" src="https://github.com/user-attachments/assets/64b6fc93-ac3d-4f9b-aecc-a702e1058e23" />


### Checkout page

<img width="1920" height="1020" alt="checkout page" src="https://github.com/user-attachments/assets/bbafa933-8d59-4320-9e87-6fcae9e80bdb" />


### Order summary page

<img width="1920" height="1020" alt="order summary page" src="https://github.com/user-attachments/assets/3011e507-2b02-456d-ac88-034f2a2a8ff5" />

### Orders page

<img width="1920" height="1020" alt="orders page" src="https://github.com/user-attachments/assets/0d8c7951-0236-49cb-94e9-8d5e1df8b47b" />


---

## 🔮 Future Improvements

Possible improvements for the project include:

* Online payment integration
* Real-time order status tracking
* Improved admin dashboard
* Automated order notifications
* Customer order history
* More detailed order management
* Improved security and input validation
* Production deployment
* Improved mobile responsiveness

---

## 📚 Project Status

**Completed**

This project was developed as a practical full-stack web development project for a restaurant ordering system.

---

## 👨‍💻 Authors

**Phathutshedzo Lidzhade**
**Akonaho Mbedzi and other students**

Computer Science Graduate

South Africa

* GitHub: [Phathu-Lidzhade](https://github.com/Phathu-Lidzhade)
* LinkedIn: [Phathutshedzo Lidzhade](https://www.linkedin.com/in/phathutshedzo-lidzhade-a502a238/)

