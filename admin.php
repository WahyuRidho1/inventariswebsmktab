<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$admins = $conn->query("SELECT * FROM admins");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle edit admin
    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $username = $_POST['edit_username'];
        $password = password_hash($_POST['edit_password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE admins SET username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $password, $id);
        $stmt->execute();
    }

    // Handle delete admin
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];

        $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

require 'includes/header.php';
?>

<div class="container">
    <h2>Data Admin</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            while ($row = $admins->fetch_assoc()): ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= $row['username'] ?></td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editAdminModal" 
                                data-id="<?= $row['id'] ?>" data-username="<?= $row['username'] ?>">
                            Edit
                        </button>
                        <form method="POST" action="admin.php" style="display:inline-block;">
                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus admin ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="admin.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="edit_username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Password</label>
                        <input type="password" class="form-control" id="edit_password" name="edit_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#editAdminModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var username = button.data('username');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_username').val(username);
    });
</script>

<?php require 'includes/footer.php'; ?>
