<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .register-card {
            width: 100%;
            max-width: 450px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .register-card .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            text-align: center;
            padding: 2rem;
            border-radius: 10px 10px 0 0;
        }
        .register-card .card-header h4 {
            color: white;
            margin: 0;
            font-weight: 600;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px 15px;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px;
            font-weight: 600;
            border-radius: 5px;
            color: white;
        }
        .btn-register:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="card-header">
            <h4>LavaLust CRUD</h4>
            <small class="text-light">Create your account</small>
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
            <form method="POST" action="/auth/store_user">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($formData['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($formData['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <small class="text-muted">Minimum 6 characters</small>
                </div>

                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Account Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user" <?php echo ($formData['role'] ?? 'user') === 'user' ? 'selected' : ''; ?>>User (view products only)</option>
                        <option value="admin" <?php echo ($formData['role'] ?? '') === 'admin' ? 'selected' : ''; ?>>Admin (manage products)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-register w-100">Register</button>
            </form>

            <div class="text-center mt-3">
                Already have an account? <a href="/auth/login">Login here</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
