<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle add sumber
    if (isset($_POST['nama_sumber'])) {
        $nama_sumber = $_POST['nama_sumber'];
        $stmt = $conn->prepare("INSERT INTO sumber (nama_sumber) VALUES (?)");
        $stmt->bind_param("s", $nama_sumber);
        $stmt->execute();
    }

    // Handle edit sumber
    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $nama_sumber = $_POST['edit_nama_sumber'];

        $stmt = $conn->prepare("UPDATE sumber SET nama_sumber = ? WHERE id = ?");
        $stmt->bind_param("si", $nama_sumber, $id);
        $stmt->execute();
    }

    // Handle delete sumber
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];

        $stmt = $conn->prepare("DELETE FROM sumber WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$sumber = $conn->query("SELECT * FROM sumber");

require 'includes/header.php';
?>

<div class="container">
    <h2>Data Sumber</h2>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addSumberModal">Tambah Sumber</button>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sumber</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $counter = 1;
            while ($row = $sumber->fetch_assoc()): ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= $row['nama_sumber'] ?></td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editSumberModal" 
                                data-id="<?= $row['id'] ?>" data-nama_sumber="<?= $row['nama_sumber'] ?>">
                            Edit
                        </button>
                        <form method="POST" action="sumber.php" style="display:inline-block;">
                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus sumber ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addSumberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="sumber.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Sumber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_sumber">Nama Sumber</label>
                        <input type="text" class="form-control" id="nama_sumber" name="nama_sumber" required>
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

<div class="modal fade" id="editSumberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="sumber.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sumber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_nama_sumber">Nama Sumber</label>
                        <input type="text" class="form-control" id="edit_nama_sumber" name="edit_nama_sumber" required>
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
    $('#editSumberModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nama_sumber = button.data('nama_sumber');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_nama_sumber').val(nama_sumber);
    });
</script>

<?php require 'includes/footer.php'; ?>
