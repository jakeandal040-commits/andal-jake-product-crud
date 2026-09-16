# Quick Start Guide - LavaLust CRUD Application

## 🚀 Get Started in 5 Steps

### Step 1: Configure Database (.env)

Edit `.env` file (in project root):

```env
DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=
DB_NAME=lavalust_crud
```

**For Aiven MySQL:**
```env
DB_HOST=your-aiven-host.aivencloud.com
DB_PORT=21345
DB_USER=avnadmin
DB_PASSWORD=your_password
DB_NAME=your_database
```

### Step 2: Setup Database

**Option A: Using PHP Script (Recommended)**
```bash
php setup_database.php
```

This will:
- Create database
- Create tables
- Insert sample data
- Create sample user

**Option B: Manual Migration**
```bash
php lava migrate
```

### Step 3: Start Development Server

```bash
php -S localhost:8000
```

Or if using XAMPP, just navigate to:
```
http://localhost/andal-product-crud
```

### Step 4: Login

**Sample Account (if created via setup script):**
- Username: `admin`
- Password: `password123`

Or register a new account

### Step 5: Start Managing Products!

- View all products
- Add new products
- Edit existing products
- Delete products

---

## 📁 Project Files Created

✅ **Controllers**
- `Products.php` - Product CRUD operations
- `Auth.php` - Login/Register/Logout

✅ **Models**
- `Product.php` - Product model
- `User.php` - User model

✅ **Views**
- `products/index.php` - Product list
- `products/create.php` - Create form
- `products/edit.php` - Edit form
- `auth/login.php` - Login page
- `auth/register.php` - Registration page

✅ **Migrations**
- `003_create_products_table.php` - Products table

✅ **Routes**
- Updated `app/config/routes.php` with all routes

---

## 🔐 Authentication Features

✅ User Registration
✅ Secure Login
✅ Session Management
✅ Password Hashing
✅ Protected Routes

All product pages require login. Unauthorized access redirects to login page.

---

## ✨ Features Implemented

### Create (C)
- Add new products with form validation
- Auto-generated timestamp

### Read (R)
- Display all products in table
- View product details

### Update (U)
- Edit product information
- Validation on all fields

### Delete (D)
- Remove products from database
- Confirmation before deletion

---

## 🛠️ Useful Commands

**Generate new key:**
```bash
php lava key:generate
```

**Run migrations:**
```bash
php lava migrate
```

**Create new controller:**
```bash
php lava make:controller YourController
```

**Create new model:**
```bash
php lava make:model YourModel
```

---

## 📝 Database Tables

### users
```
id (INT, PK)
username (VARCHAR)
email (VARCHAR)
password (VARCHAR)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### products
```
id (INT, PK)
product_name (VARCHAR)
description (TEXT)
price (DECIMAL)
quantity (INT)
created_at (TIMESTAMP)
```

---

## 🐛 Troubleshooting

**Database connection error?**
- Check .env file values
- Verify database server is running
- Ensure user has permissions

**Port 8000 already in use?**
```bash
php -S localhost:8001  # Use different port
```

**Migrations not running?**
```bash
php lava migrate --force
```

**Need to reset database?**
```bash
php setup_database.php  # Rerun setup
```

---

## 🚀 Next Steps

1. ✅ Setup & Run Application
2. ✅ Test Authentication (Login/Register)
3. ✅ Test CRUD Operations
4. ✅ Deploy to Render (Optional)

---

**Happy Coding! 🎉**

For more details, see `SETUP_GUIDE.md`
