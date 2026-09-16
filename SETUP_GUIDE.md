# LavaLust CRUD Application with Authentication

A complete CRUD web application built with the **LavaLust** PHP MVC framework with user authentication and product management.

## Features

✅ **User Authentication**
- User registration with password hashing
- Session-based login system
- Secure logout functionality

✅ **Product Management (CRUD)**
- Create new products
- Read/View all products
- Update existing products
- Delete products

✅ **Database Features**
- MySQL integration via Aiven
- Database migrations
- Eloquent-style ORM models

✅ **Security**
- Protected routes (authentication required)
- Password hashing with bcrypt
- Form validation
- HTML entity escaping

## Requirements

- PHP 7.4+
- MySQL 5.7+
- Composer
- LavaLust Framework

## Installation

### 1. Clone/Setup the Project

```bash
cd c:\xampp\htdocs\andal-product-crud
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Generate Application Key

```bash
php lava key:generate
```

### 4. Configure Environment Variables

Create a `.env` file in the root directory (copy from `.env.example` if exists):

```env
APP_NAME=Lavalust
APP_KEY=your_generated_key
APP_ENV=development

# Database Configuration (for Aiven MySQL)
DB_DRIVER=mysql
DB_HOST=your-aiven-host.aivencloud.com
DB_PORT=21345
DB_USER=avnadmin
DB_PASSWORD=your_password
DB_NAME=your_database
DB_CHARSET=utf8mb4
DB_PREFIX=
```

**Note:** For local development with XAMPP:
```env
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=
DB_NAME=lavalust_crud
```

### 5. Run Database Migrations

```bash
php lava migrate
```

This will create:
- `users` table (for authentication)
- `products` table (for product management)

### 6. Start the Application

**Using PHP Built-in Server:**
```bash
php -S localhost:8000
```

**Using XAMPP:**
1. Place project in `htdocs` folder
2. Access `http://localhost/andal-product-crud`

## Project Structure

```
app/
├── controllers/
│   ├── Auth.php           # Authentication controller (login, register, logout)
│   ├── Products.php       # Product CRUD operations
│   └── Welcome.php        # Homepage controller
├── models/
│   ├── User.php          # User model
│   └── Product.php       # Product model
├── views/
│   ├── auth/
│   │   ├── login.php     # Login page
│   │   └── register.php  # Registration page
│   ├── products/
│   │   ├── index.php     # Product list
│   │   ├── create.php    # Create product form
│   │   └── edit.php      # Edit product form
│   └── welcome_page.php
├── config/
│   ├── routes.php        # Route definitions
│   ├── database.php      # Database configuration
│   └── ...
└── migrations/
    ├── 000_initial_setup.php
    ├── 001_create_users_table.php
    ├── 002_create_refresh_tokens_table.php
    └── 003_create_products_table.php
```

## Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Products Table
```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Usage

### 1. Access the Application

Navigate to `http://localhost:8000` or `http://localhost/andal-product-crud`

### 2. Register a New Account

- Click "Register here" on the login page
- Fill in username, email, and password
- Submit to create account

### 3. Login

- Enter your username and password
- Click "Login" button
- You'll be redirected to the products page

### 4. Manage Products

**View Products:**
- See all products in a table format
- View product details (name, description, price, quantity)

**Create Product:**
- Click "Add New Product" button
- Fill in product details
- Click "Create Product"

**Edit Product:**
- Click "Edit" button on product row
- Update product information
- Click "Update Product"

**Delete Product:**
- Click "Delete" button on product row
- Confirm deletion

## API Routes

| Method | Route | Controller | Description |
|--------|-------|-----------|-------------|
| GET | / | Welcome::index | Redirect to login/products |
| GET | /auth/login | Auth::login | Show login form |
| POST | /auth/authenticate | Auth::authenticate | Process login |
| GET | /auth/register | Auth::register | Show registration form |
| POST | /auth/store_user | Auth::store_user | Process registration |
| GET | /auth/logout | Auth::logout | Logout user |
| GET | /products | Products::index | List all products |
| GET | /products/create | Products::create | Show create form |
| POST | /products/store | Products::store | Store new product |
| GET | /products/edit/:id | Products::edit | Show edit form |
| POST | /products/update/:id | Products::update | Update product |
| GET | /products/delete/:id | Products::delete | Delete product |

## Security Features

✅ **Authentication**
- Session-based user authentication
- Password hashing with PHP's password_hash()
- Protection checks on all product routes

✅ **Validation**
- Form validation for all inputs
- Required field validation
- Email validation
- Password confirmation matching

✅ **Prevention**
- HTML escaping with htmlspecialchars()
- SQL injection prevention via ORM
- CSRF token support (via LavaLust middleware)

## Deployment to Render

### 1. Push to GitHub

```bash
git add .
git commit -m "Initial commit: LavaLust CRUD application"
git push origin main
```

### 2. Create Render Service

1. Go to [Render.com](https://render.com)
2. Click "New" → "Web Service"
3. Connect GitHub repository
4. Configure:
   - **Build Command:** `composer install`
   - **Start Command:** `php -S 0.0.0.0:$PORT`

### 3. Set Environment Variables

In Render dashboard, add:
```
DB_DRIVER=mysql
DB_HOST=your-aiven-host.aivencloud.com
DB_PORT=21345
DB_USER=avnadmin
DB_PASSWORD=your_password
DB_NAME=your_database
DB_CHARSET=utf8mb4
```

### 4. Run Migrations on Render

After deployment, run:
```bash
php lava migrate
```

## Troubleshooting

### Database Connection Error
- Verify `.env` file has correct database credentials
- Check database host is accessible
- Ensure database user has proper permissions

### Migration Error
- Run `php lava migrate` to create tables
- Check migrations folder for syntax errors

### Login Not Working
- Verify `users` table exists
- Check password hashing is working
- Review session configuration

### Products Not Showing
- Ensure you're logged in
- Check `products` migration was run
- Verify database connection

## Testing Checklist

- [ ] Registration works
- [ ] Login works
- [ ] Logout works
- [ ] Create product works
- [ ] Read/List products works
- [ ] Update product works
- [ ] Delete product works
- [ ] Unauthenticated access redirects to login
- [ ] Data persists in database

## Technologies Used

- **Framework:** LavaLust PHP MVC
- **Database:** MySQL 5.7+
- **Frontend:** Bootstrap 5
- **Authentication:** PHP Sessions
- **Password Hashing:** bcrypt (password_hash)

## License

This project is part of the Web Systems and Technologies 2 course laboratory exercise.

## Support

For issues or questions about LavaLust framework:
- GitHub: https://github.com/ronmarasigan/LavaLust
- Documentation: Check the framework's README

---

**Created for:** Laboratory Exercise No. 5  
**Course:** Web Systems and Technologies 2  
**Framework:** LavaLust  
**Database:** Aiven MySQL  
**Deployment:** Render
