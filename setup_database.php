#!/usr/bin/env php
<?php
/**
 * Database Setup Script
 * This script helps set up your local database for development
 */

echo "================================\n";
echo "LavaLust CRUD - Database Setup\n";
echo "================================\n\n";

// Check if .env file exists
if (!file_exists(__DIR__ . '/.env')) {
    echo "Error: .env file not found!\n";
    echo "Please create .env file with your database configuration.\n";
    exit(1);
}

// Load environment variables
$env = parse_ini_file(__DIR__ . '/.env');

$host = $env['DB_HOST'] ?? 'localhost';
$user = $env['DB_USER'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';
$database = $env['DB_NAME'] ?? 'lavalust_crud';

echo "Database Configuration:\n";
echo "Host: $host\n";
echo "User: $user\n";
echo "Database: $database\n";
echo "\n";

try {
    // Connect to MySQL
    $conn = new mysqli($host, $user, $password);
    
    if ($conn->connect_error) {
        echo "Error: Failed to connect to database server\n";
        echo "Reason: " . $conn->connect_error . "\n";
        exit(1);
    }
    
    echo "✓ Connected to MySQL server\n";
    
    // Create database if not exists
    $create_db = "CREATE DATABASE IF NOT EXISTS `$database`";
    
    if ($conn->query($create_db) === TRUE) {
        echo "✓ Database '$database' created/verified\n";
    } else {
        echo "Error creating database: " . $conn->error . "\n";
        exit(1);
    }
    
    // Select database
    $conn->select_db($database);
    
    // Run migrations
    echo "\nRunning migrations...\n\n";
    
    // Users table
    $users_table = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($users_table) === TRUE) {
        echo "✓ Created 'users' table\n";
    } else {
        echo "✗ Error creating users table: " . $conn->error . "\n";
    }
    
    // Products table
    $products_table = "
    CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_name VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        quantity INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($products_table) === TRUE) {
        echo "✓ Created 'products' table\n";
    } else {
        echo "✗ Error creating products table: " . $conn->error . "\n";
    }
    
    echo "\n================================\n";
    echo "✓ Database setup completed!\n";
    echo "================================\n\n";
    
    // Insert sample data
    echo "Would you like to insert sample data? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));
    
    if (strtolower($line) === 'y') {
        echo "\nInserting sample products...\n";
        
        $sample_products = [
            ['Laptop', 'High-performance laptop with 16GB RAM', 45000.00, 5],
            ['Mouse', 'Wireless optical mouse', 450.00, 25],
            ['Keyboard', 'Mechanical keyboard with RGB lighting', 2500.00, 10],
            ['Monitor', '27-inch 4K monitor', 15000.00, 8],
            ['Headphones', 'Noise-cancelling wireless headphones', 8000.00, 15],
        ];
        
        foreach ($sample_products as $product) {
            $stmt = $conn->prepare("INSERT INTO products (product_name, description, price, quantity) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssdi", $product[0], $product[1], $product[2], $product[3]);
            
            if ($stmt->execute()) {
                echo "  ✓ Added: " . $product[0] . "\n";
            } else {
                echo "  ✗ Error adding product: " . $stmt->error . "\n";
            }
            $stmt->close();
        }
        
        echo "\n✓ Sample data inserted successfully!\n";
    }
    
    // Insert sample user
    echo "\nWould you like to insert a sample user? (y/n): ";
    $line = trim(fgets($handle));
    
    if (strtolower($line) === 'y') {
        $username = 'admin';
        $email = 'admin@example.com';
        $password = password_hash('password123', PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            echo "\n✓ Sample user created!\n";
            echo "  Username: admin\n";
            echo "  Password: password123\n";
        } else {
            if (strpos($stmt->error, 'Duplicate') !== false) {
                echo "\n✓ Sample user already exists\n";
                echo "  Username: admin\n";
                echo "  Password: password123\n";
            } else {
                echo "\n✗ Error creating user: " . $stmt->error . "\n";
            }
        }
        $stmt->close();
    }
    
    fclose($handle);
    
    echo "\n================================\n";
    echo "Setup Complete!\n";
    echo "================================\n";
    echo "You can now start your application:\n";
    echo "  php -S localhost:8000\n";
    echo "\nAccess it at: http://localhost:8000\n";
    echo "\n";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
