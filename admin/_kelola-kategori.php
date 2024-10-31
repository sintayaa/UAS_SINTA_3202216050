<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'uas_sinta';
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $nama = $_POST['nama'];
        $conn->query("INSERT INTO kategori (nama) VALUES ('$nama')");
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $conn->query("UPDATE kategori SET nama='$nama' WHERE id=$id");
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $conn->query("DELETE FROM kategori WHERE id=$id");
    }
}

$result = $conn->query("SELECT * FROM kategori");

?>

<h1 class="mt-4">Kelola Kategori</h1>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Kategori
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Tambah Kategori
        </button>

        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="categoryName" name="nama" placeholder="Nama Kategori" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add" class="btn btn-primary">Tambah Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <table style="" id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kategori</th>
                    <th>Edit</th>
                    <th>Hapus</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $rowNumber = 1;
                ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $rowNumber++ ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
                            Edit
                        </button>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $row['id'] ?>">Edit Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="mb-3">
                                                <label for="nama<?= $row['id'] ?>" class="form-label">Nama Kategori</label>
                                                <input type="text" class="form-control" name="nama" id="nama<?= $row['id'] ?>" value="<?= $row['nama'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form style="display:inline;" method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button class="btn btn-danger" type="submit" name="delete" onclick="return confirm('Apakah anda yakin ingin menghapus kategori ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>