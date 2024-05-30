<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventarisasi Barang</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,121,113,1) 35%, rgba(0,212,255,1) 100%);
        }
        .navbar-brand img {
            border-radius: 50%;
            transition: transform 0.3s;
        }
        .navbar-brand img:hover {
            transform: scale(1.1);
        }
        .nav-link {
            color: #fff !important;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #ddd !important;
        }
        .nav-item .active {
            font-weight: bold;
        }
        .card {
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-body i {
            color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .logout-icon {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light mb-3">
    <a class="navbar-brand ms-3" href="#">
        <img src="assets/img/logo-smk.png" alt="Logo" style="width: 50px; height: 50px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Halaman Utama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Data Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sumber.php">Data Sumber</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kode_barang.php">Kode Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="lokasi.php">Data Lokasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="barang.php">Data Barang</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt logout-icon"></i>Keluar
                </a>
            </li>
        </ul>
    </div>
</nav>
