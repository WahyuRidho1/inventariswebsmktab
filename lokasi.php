<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle add lokasi
    if (isset($_POST['nama_lokasi'])) {
        $nama_lokasi = $_POST['nama_lokasi'];
        $stmt = $conn->prepare("INSERT INTO lokasi (nama_lokasi) VALUES (?)");
        $stmt->bind_param("s", $nama_lokasi);
        $stmt->execute();
    }

    // Handle edit lokasi
    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $nama_lokasi = $_POST['edit_nama_lokasi'];

        $stmt = $conn->prepare("UPDATE lokasi SET nama_lokasi = ? WHERE id = ?");
        $stmt->bind_param("si", $nama_lokasi, $id);
        $stmt->execute();
    }

    // Handle delete lokasi
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];

        $stmt = $conn->prepare("DELETE FROM lokasi WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$lokasi = $conn->query("SELECT * FROM lokasi");

require 'includes/header.php';
?>

<div class="container">
    <h2>Data Lokasi</h2>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addLokasiModal">Tambah Lokasi</button>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lokasi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $counter = 1;
            while ($row = $lokasi->fetch_assoc()): ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= $row['nama_lokasi'] ?></td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editLokasiModal" 
                                data-id="<?= $row['id'] ?>" data-nama_lokasi="<?= $row['nama_lokasi'] ?>">
                            Edit
                        </button>
                        <form method="POST" action="lokasi.php" style="display:inline-block;">
                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus lokasi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addLokasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="lokasi.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Lokasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_lokasi">Nama Lokasi</label>
                        <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" required>
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

<div class="modal fade" id="editLokasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="lokasi.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Lokasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_nama_lokasi">Nama Lokasi</label>
                        <input type="text" class="form-control" id="edit_nama_lokasi" name="edit_nama_lokasi" required>
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
    $('#editLokasiModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nama_lokasi = button.data('nama_lokasi');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_nama_lokasi').val(nama_lokasi);
    });
</script>

<?php require 'includes/footer.php'; ?>
