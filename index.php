<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
require 'includes/header.php';
?>

<div class="container">
    <h1 class="text-center my-4">Selamat Datang</h1>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-home fa-3x mb-3"></i>
                    <h5 class="card-title">Halaman Utama</h5>
                    <p class="card-text">Lihat halaman utama aplikasi.</p>
                    <a href="index.php" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user fa-3x mb-3"></i>
                    <h5 class="card-title">Data Admin</h5>
                    <p class="card-text">Kelola data admin.</p>
                    <a href="admin.php" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-database fa-3x mb-3"></i>
                    <h5 class="card-title">Data Sumber</h5>
                    <p class="card-text">Kelola data sumber barang.</p>
                    <a href="sumber.php" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-barcode fa-3x mb-3"></i>
                    <h5 class="card-title">Kode Barang</h5>
                    <p class="card-text">Kelola kode barang.</p>
                    <a href="kode_barang.php" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                    <h5 class="card-title">Data Lokasi</h5>
                    <p class="card-text">Kelola data lokasi barang.</p>
                    <a href="lokasi.php" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-3x mb-3"></i>
                    <h5 class="card-title">Data Barang</h5>
                    <p class="card-text">Kelola data barang.</p>
                    <a href="barang.php" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
