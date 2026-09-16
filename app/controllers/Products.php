<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Products extends Controller
{
    public function before_action()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_save_path(ROOT_DIR . 'runtime/sessions');
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            header('Location: /auth/login?error=' . rawurlencode('Please log in first.'));
            exit;
        }
    }

    public function index()
    {
        $products = $this->call->database()
            ->table('products')
            ->order_by('id', 'DESC')
            ->get_all();
        include __DIR__ . '/../views/products/index.php';
    }

    public function create()
    {
        $this->requireAdmin();
        $formData = [];
        $errors = [];
        include __DIR__ . '/../views/products/create.php';
    }

    public function store()
    {
        $this->requireAdmin();
        $formData = [
            'product_name' => trim((string) ($_POST['product_name'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'price' => trim((string) ($_POST['price'] ?? '')),
            'quantity' => trim((string) ($_POST['quantity'] ?? '')),
        ];
        $errors = [];

        if ($formData['product_name'] === '' || strlen($formData['product_name']) > 100) {
            $errors[] = 'Product name is required and must not exceed 100 characters.';
        }
        if ($formData['description'] === '') {
            $errors[] = 'Description is required.';
        }
        if (!is_numeric($formData['price']) || (float) $formData['price'] < 0) {
            $errors[] = 'Price must be a valid non-negative number.';
        }
        if (filter_var($formData['quantity'], FILTER_VALIDATE_INT) === false || (int) $formData['quantity'] < 0) {
            $errors[] = 'Quantity must be a non-negative whole number.';
        }

        if ($errors) {
            include __DIR__ . '/../views/products/create.php';
            return;
        }

        try {
            $this->call->database()->table('products')->insert([
                'product_name' => $formData['product_name'],
                'description' => $formData['description'],
                'price' => number_format((float) $formData['price'], 2, '.', ''),
                'quantity' => (int) $formData['quantity'],
            ]);
        } catch (Throwable $exception) {
            $errors[] = 'Unable to save the product. Please make sure MySQL is running and the products table has been created.';
            include __DIR__ . '/../views/products/create.php';
            return;
        }

        header('Location: /products?success=' . rawurlencode('Product added successfully.'));
        exit;
    }

    public function edit($id)
    {
        $this->requireAdmin();
        $id = (int) $id;
        $product = $this->call->database()->table('products')->where('id', $id)->get();
        if (!$product) {
            header('Location: /products?error=' . rawurlencode('Product not found.'));
            exit;
        }

        $errors = [];
        include __DIR__ . '/../views/products/edit.php';
    }

    public function update($id)
    {
        $this->requireAdmin();
        $id = (int) $id;
        $product = $this->call->database()->table('products')->where('id', $id)->get();
        if (!$product) {
            header('Location: /products?error=' . rawurlencode('Product not found.'));
            exit;
        }

        $product = [
            'id' => $id,
            'product_name' => trim((string) ($_POST['product_name'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'price' => trim((string) ($_POST['price'] ?? '')),
            'quantity' => trim((string) ($_POST['quantity'] ?? '')),
        ];
        $errors = $this->validateProduct($product);
        if ($errors) {
            include __DIR__ . '/../views/products/edit.php';
            return;
        }

        $this->call->database()->table('products')->where('id', $id)->update([
            'product_name' => $product['product_name'],
            'description' => $product['description'],
            'price' => number_format((float) $product['price'], 2, '.', ''),
            'quantity' => (int) $product['quantity'],
        ]);

        header('Location: /products?success=' . rawurlencode('Product updated successfully.'));
        exit;
    }

    public function delete($id)
    {
        $this->requireAdmin();
        $id = (int) $id;
        $deleted = $this->call->database()->table('products')->where('id', $id)->delete();
        $message = $deleted ? 'Product deleted successfully.' : 'Product not found.';
        header('Location: /products?success=' . rawurlencode($message));
        exit;
    }

    private function validateProduct(array $product): array
    {
        $errors = [];
        if ($product['product_name'] === '' || strlen($product['product_name']) > 100) {
            $errors[] = 'Product name is required and must not exceed 100 characters.';
        }
        if ($product['description'] === '') {
            $errors[] = 'Description is required.';
        }
        if (!is_numeric($product['price']) || (float) $product['price'] < 0) {
            $errors[] = 'Price must be a valid non-negative number.';
        }
        if (filter_var($product['quantity'], FILTER_VALIDATE_INT) === false || (int) $product['quantity'] < 0) {
            $errors[] = 'Quantity must be a non-negative whole number.';
        }

        return $errors;
    }

    private function requireAdmin(): void
    {
        if (($_SESSION['user_role'] ?? 'user') !== 'admin') {
            header('Location: /products?error=' . rawurlencode('Only admin accounts can modify products.'));
            exit;
        }
    }
}
