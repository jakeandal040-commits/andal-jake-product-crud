<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">LavaLust CRUD</a>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="/products">Products</a>
                    <span class="navbar-text text-light me-2">
                        <?php echo htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($_SESSION['user_role'] ?? 'user', ENT_QUOTES, 'UTF-8'); ?>)
                    </span>
                    <form method="POST" action="/auth/logout" class="d-flex">
                        <button type="submit" class="btn btn-link nav-link border-0">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="row mb-4">
            <div class="col-md-8">
                <h1>Product Management</h1>
            </div>
            <?php if (($_SESSION['user_role'] ?? 'user') === 'admin'): ?>
                <div class="col-md-4 text-end">
                    <a href="/products/create" class="btn btn-primary">+ Add New Product</a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($products) && count($products) > 0): ?>
                            <?php foreach($products as $product): ?>
                                <tr>
                                    <td><?php echo (int) $product['id']; ?></td>
                                    <td><?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars(mb_strimwidth($product['description'], 0, 40, '...'), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>₱<?php echo number_format($product['price'], 2); ?></td>
                                    <td><?php echo (int) $product['quantity']; ?></td>
                                    <td>
                                        <?php if (($_SESSION['user_role'] ?? 'user') === 'admin'): ?>
                                            <a href="/products/edit/<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <form method="POST" action="/products/delete/<?php echo (int) $product['id']; ?>" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted">View only</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No products found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
