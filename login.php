<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin'] = $user['id'];
        header("Location: index.php");
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <title>Halaman Masuk</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f7fa;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .login-container {
            display: flex;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .login-form {
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .login-form h2 {
            margin-bottom: 30px;
            color: #333;
        }

        .form-group label {
            color: #333;
        }

        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #5a54d7;
            border-color: #5a54d7;
        }

        .side-image {
            background: url('assets/img/halaman.jpg') no-repeat center center;
            background-size: cover;
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="side-image"></div>
        <div class="login-form">
            <h2 class="text-center">Masuk</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group mb-2">
                    <label for="username">Nama Pengguna</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
