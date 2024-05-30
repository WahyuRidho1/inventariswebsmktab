<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['kode'])) {
        $kode = $_POST['kode'];
        $stmt = $conn->prepare("INSERT INTO kode_barang (kode) VALUES (?)");
        $stmt->bind_param("s", $kode);
        $stmt->execute();
    }

    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $kode = $_POST['edit_kode'];
        $stmt = $conn->prepare("UPDATE kode_barang SET kode = ? WHERE id = ?");
        $stmt->bind_param("si", $kode, $id);
        $stmt->execute();
    }

    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt = $conn->prepare("DELETE FROM kode_barang WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$kode_barang = $conn->query("SELECT * FROM kode_barang");

require 'includes/header.php';
?>

<div class="container">
    <h2>Data Kode Barang</h2>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addKodeModal">Tambah Kode</button>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $counter = 1;
            while ($row = $kode_barang->fetch_assoc()): ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= $row['kode'] ?></td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editKodeModal" 
                                data-id="<?= $row['id'] ?>" data-kode="<?= $row['kode'] ?>">
                            Edit
                        </button>
                        <form method="POST" action="kode_barang.php" style="display:inline-block;">
                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kode ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addKodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="kode_barang.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kode Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode">Kode Barang</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
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

<div class="modal fade" id="editKodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="kode_barang.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kode Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_kode">Kode Barang</label>
                        <input type="text" class="form-control" id="edit_kode" name="edit_kode" required>
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
    $('#editKodeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var kode = button.data('kode');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_kode').val(kode);
    });
</script>

<?php require 'includes/footer.php'; ?>
