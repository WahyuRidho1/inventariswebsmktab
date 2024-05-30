<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Menangani pencarian
$search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';
$search_query = $search_keyword ? " WHERE nama_barang LIKE '%$search_keyword%'" : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nama_barang'])) {
        $nama_barang = $_POST['nama_barang'];
        $jumlah = $_POST['jumlah'];
        $sumber_id = $_POST['sumber_id'];
        $kode_id = $_POST['kode_id'];
        $lokasi_id = $_POST['lokasi_id'];
        $tanggal = $_POST['tanggal'];

        $stmt = $conn->prepare("INSERT INTO barang (nama_barang, jumlah, sumber_id, kode_id, lokasi_id, tanggal) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiss", $nama_barang, $jumlah, $sumber_id, $kode_id, $lokasi_id, $tanggal);
        $stmt->execute();
    }

    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $nama_barang = $_POST['edit_nama_barang'];
        $jumlah = $_POST['edit_jumlah'];
        $sumber_id = $_POST['edit_sumber_id'];
        $kode_id = $_POST['edit_kode_id'];
        $lokasi_id = $_POST['edit_lokasi_id'];
        $tanggal = $_POST['edit_tanggal'];

        $stmt = $conn->prepare("UPDATE barang SET nama_barang = ?, jumlah = ?, sumber_id = ?, kode_id = ?, lokasi_id = ?, tanggal = ? WHERE id = ?");
        $stmt->bind_param("siiiisi", $nama_barang, $jumlah, $sumber_id, $kode_id, $lokasi_id, $tanggal, $id);
        $stmt->execute();
    }

    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$result = $conn->query("SELECT COUNT(id) AS id FROM barang $search_query");
$row = $result->fetch_assoc();
$total = $row['id'];
$pages = ceil($total / $limit);

$query = "SELECT barang.*, sumber.nama_sumber, kode_barang.kode, lokasi.nama_lokasi 
          FROM barang 
          LEFT JOIN sumber ON barang.sumber_id = sumber.id 
          LEFT JOIN kode_barang ON barang.kode_id = kode_barang.id 
          LEFT JOIN lokasi ON barang.lokasi_id = lokasi.id 
          $search_query
          LIMIT $start, $limit";
$barang = $conn->query($query);

$sumber = $conn->query("SELECT * FROM sumber");
$kode_barang = $conn->query("SELECT * FROM kode_barang");
$lokasi = $conn->query("SELECT * FROM lokasi");

require 'includes/header.php';
?>

<div class="container">
    <h2>Data Barang</h2>
    <form method="GET" action="barang.php" class="form-inline mb-3">
        <div class="input-group">
            <input type="text" class="form-control me-1" name="search_keyword" placeholder="Cari Barang" value="<?= htmlspecialchars($search_keyword) ?>">
            <div class="input-group-append">
                <button type="submit" class="btn btn-success">Cari</button>
            </div>
        </div>
    </form>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addBarangModal">Tambah Barang</button>
    <a href="export_pdf.php" class="btn btn-danger">Cetak ke PDF</a>
    <table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Sumber</th>
            <th>Kode Barang</th>
            <th>Lokasi</th>
            <th>Tanggal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $counter = $start + 1;
        while ($row = $barang->fetch_assoc()): ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['nama_sumber'] ?></td>
                <td><?= $row['kode'] ?></td>
                <td><?= $row['nama_lokasi'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#editBarangModal" 
                            data-id="<?= $row['id'] ?>" data-nama_barang="<?= $row['nama_barang'] ?>" 
                            data-jumlah="<?= $row['jumlah'] ?>" data-sumber_id="<?= $row['sumber_id'] ?>" 
                            data-kode_id="<?= $row['kode_id'] ?>" data-lokasi_id="<?= $row['lokasi_id'] ?>" 
                            data-tanggal="<?= $row['tanggal'] ?>">
                        Edit
                    </button>
                    <form method="POST" action="barang.php" style="display:inline-block;">
                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="barang.php?page=<?= $page - 1 ?>">Sebelumnya</a>
            </li>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="barang.php?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page == $pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="barang.php?page=<?= $page + 1 ?>">Berikutnya</a>
            </li>
        </ul>
    </nav>
</div>

<div class="modal fade" id="addBarangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="barang.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="sumber_id">Sumber</label>
                        <select class="form-control" id="sumber_id" name="sumber_id" required>
                            <?php while ($row = $sumber->fetch_assoc()): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama_sumber'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kode_id">Kode Barang</label>
                        <select class="form-control" id="kode_id" name="kode_id" required>
                            <?php while ($row = $kode_barang->fetch_assoc()): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['kode'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_id">Lokasi</label>
                        <select class="form-control" id="lokasi_id" name="lokasi_id" required>
                            <?php while ($row = $lokasi->fetch_assoc()): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama_lokasi'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBarangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="barang.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="edit_nama_barang" name="edit_nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="edit_jumlah" name="edit_jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_sumber_id">Sumber</label>
                        <select class="form-control" id="edit_sumber_id" name="edit_sumber_id" required>
                            <?php while ($row = $sumber->fetch_assoc()): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama_sumber'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_kode_id">Kode Barang</label>
                        <select class="form-control" id="edit_kode_id" name="edit_kode_id" required>
                            <?php while ($row = $kode_barang->fetch_assoc()): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['kode'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_lokasi_id">Lokasi</label>
                        <select class="form-control" id="edit_lokasi_id" name="edit_lokasi_id" required>
                            <?php while ($row = $lokasi->fetch_assoc()): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama_lokasi'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="edit_tanggal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
   $('#editBarangModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nama_barang = button.data('nama_barang');
    var jumlah = button.data('jumlah');
    var sumber_id = button.data('sumber_id');
    var kode_id = button.data('kode_id');
    var lokasi_id = button.data('lokasi_id');
    var tanggal = button.data('tanggal'); // Tambahkan tanggal

    var modal = $(this);
    modal.find('#edit_id').val(id);
    modal.find('#edit_nama_barang').val(nama_barang);
    modal.find('#edit_jumlah').val(jumlah);
    modal.find('#edit_sumber_id').val(sumber_id);
    modal.find('#edit_kode_id').val(kode_id);
    modal.find('#edit_lokasi_id').val(lokasi_id);
    modal.find('#edit_tanggal').val(tanggal); // Tambahkan tanggal
});
</script>

<?php require 'includes/footer.php'; ?>
