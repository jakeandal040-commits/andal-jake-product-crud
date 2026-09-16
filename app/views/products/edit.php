<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">LavaLust CRUD</a>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="/products">Products</a>
                    <form method="POST" action="/auth/logout" class="d-flex">
                        <button type="submit" class="btn btn-link nav-link border-0">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Product #<?php echo (int) $product['id']; ?></h5>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="POST" action="/products/update/<?php echo (int) $product['id']; ?>">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (₱) *</label>
                        <input type="number" min="0" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity *</label>
                        <input type="number" min="0" step="1" class="form-control" id="quantity" name="quantity" value="<?php echo (int) $product['quantity']; ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="/products" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-warning">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
