<?php
require 'vendor/autoload.php';
require 'includes/db.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch data
$barang = $conn->query("SELECT barang.*, sumber.nama_sumber, kode_barang.kode, lokasi.nama_lokasi 
                        FROM barang 
                        LEFT JOIN sumber ON barang.sumber_id = sumber.id 
                        LEFT JOIN kode_barang ON barang.kode_id = kode_barang.id 
                        LEFT JOIN lokasi ON barang.lokasi_id = lokasi.id");

// Create instance of FPDF
$pdf = new \FPDF();
$pdf->AddPage('L'); // Set page orientation to Landscape
$pdf->SetFont('Arial', 'B', 12);

// Add title
$pdf->Cell(0, 10, 'Data Barang', 0, 1, 'C');

// Add table headers
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(110, 10, 'Nama Barang', 1);
$pdf->Cell(20, 10, 'Jumlah', 1);
$pdf->Cell(40, 10, 'Sumber', 1);
$pdf->Cell(30, 10, 'Kode Barang', 1);
$pdf->Cell(40, 10, 'Lokasi', 1);
$pdf->Cell(30, 10, 'Tanggal', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
$counter = 1;
while ($row = $barang->fetch_assoc()) {
    $pdf->Cell(10, 10, $counter++, 1);
    $pdf->Cell(110, 10, $row['nama_barang'], 1);
    $pdf->Cell(20, 10, $row['jumlah'], 1);
    $pdf->Cell(40, 10, $row['nama_sumber'], 1);
    $pdf->Cell(30, 10, $row['kode'], 1);
    $pdf->Cell(40, 10, $row['nama_lokasi'], 1);
    $pdf->Cell(30, 10, $row['tanggal'], 1);
    $pdf->Ln();
}

$pdf->Output();
?>
