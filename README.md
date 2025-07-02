# 🛠 FixerUpper Secure Shopping Website

This project is a secure prototype e-commerce website developed for **FixerUpper**, a hardware supply company transitioning from traditional retail to an online model. It was built as part of a Level 5 Computing coursework and demonstrates core dynamic web development and web security practices.

**Author:** Ion Cojocaru  
**Student ID:** 2261534

---

## 📦 Features

- 🔐 Secure user registration and login system (with password hashing and verification)
- 🛒 Product listing with images, description and prices
- 🧺 Shopping cart (add, update quantity, remove items)
- ✅ Checkout process with authentication
- 📦 Order confirmation and user order history
- 🚪 Logout with session cleanup
- 🎨 Dark modern UI design
- ⚙️ Backend powered by PHP and MySQL
- 💾 Data persisted using `shoppingcart.sql`

---

## 🔐 Security Measures

| Threat               | Mitigation Strategy                                       |
|----------------------|-----------------------------------------------------------|
| Password Theft       | PHP `password_hash()` and `password_verify()`             |
| SQL Injection        | Prepared statements via PDO                               |
| Session Hijacking    | `session_regenerate_id()`, secure session cookies         |
| Cross-Site Scripting | Output sanitization using `htmlspecialchars()`            |

---

## 📁 Folder Structure

```
FixerUpperShop/
├── index.php               # Homepage – product listings
├── cart.php                # Shopping cart view
├── checkout.php            # Order summary before confirmation
├── confirm_order.php       # Places order in DB
├── login.php / register.php
├── logout.php              # Secure logout
├── order_history.php       # View past orders
│
├── css/
│   └── style.css           # Dark-themed styling
│
├── includes/
│   ├── db.php              # Secure DB connection (PDO)
│   ├── functions.php       # Sanitization, helpers
│   └── auth.php            # Session management
│
├── img/                    # Product images + logo
└── sql/
    └── shoppingcart.sql    # Database structure and seed data
```

---

## ⚙️ Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/FixerUpperShop.git
   ```

2. **Import Database**
   - Open **phpMyAdmin**
   - Create a new database: `shoppingcart`
   - Import the file: `/sql/shoppingcart.sql`

3. **Configure Apache & PHP**
   - Place the folder inside your web root (`htdocs/` or `www/`)
   - Make sure PHP 7.4+ is enabled
   - Start **Apache** and **MySQL**

4. **Check Port in XAMPP**
   - XAMPP may assign a non-standard port (e.g. `localhost:8080`)
   - To find the port:
     - Open XAMPP Control Panel
     - Click **Config > Apache (httpd.conf)**
     - Search for `Listen` and check if it's `80`, `8080`, or another
   - Access your site using:
     ```
     http://localhost:[your-port]/FixerUpperShop/index.php
     ```

#### ✅ MySQL Port (Database Connection)

XAMPP may also assign a **non-default MySQL port** (e.g., `3306`, `3308`, etc.), which must match the settings in your project.

To check and configure this:
1. Open **XAMPP Control Panel**
2. Check the port listed next to **MySQL** (e.g., 3306 or 3308)
3. Open the project file `/includes/db.php`
4. Find the database connection string:
   ```php
   $pdo = new PDO("mysql:host=localhost;port=3308;dbname=shoppingcart", ...);
   ```
5. Change `port=3308` to match your XAMPP MySQL port

⚠️ If the port is incorrect, you may see connection errors like:
`SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it`

---

## 🔐 Demo Users

- 👤 **User:** John | 🔑 **Password:** john01  
- 👤 **User:** Leo  | 🔑 **Password:** leo01

---

## 📸 Screenshots

Example UI screenshots included:

- ✅ Homepage with products  
- 🛒 Cart with update/remove  
- 🧾 Checkout summary  
- 📦 Order history  
- 🔐 Login and Register pages  
- 🚪 Logout confirmation


Screenshots located in /img folder of the repository

---

## 👨‍💻 Author

Developed by: **Ion Cojocaru**  
Student ID: **2261534**  
Course: Level 5 Computing – Secure Web Development

---

## 📃 License

This project is for academic use only. © 2025 FixerUpper Prototype
