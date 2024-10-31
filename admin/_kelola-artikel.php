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
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $penulis = $_POST['penulis'];
        $tanggal = date('Y-m-d');
        $read = 0;
        $kategori_id = $_POST['kategori_id'];
        // Handle file upload
        $targetDir = "uploads/"; // Define the upload directory
        $fileName = basename($_FILES["foto"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allow only certain file formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileType, $allowedTypes)) {
            // Check if file uploaded successfully
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
                // Insert into database
                $conn->query("INSERT INTO artikel (judul,deskripsi,penulis,tanggal,foto,read_count,kategori_id) VALUES ('$judul', '$deskripsi', '$penulis', '$tanggal', '$fileName', '$read', '$kategori_id')");
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $penulis = $_POST['penulis'];
        $tanggal = date('Y-m-d');
        $kategori_id = $_POST['kategori_id'] ?? null;
        
        if ($kategori_id) {
            $id = $_POST['id'];
            $updateQuery = "UPDATE artikel SET judul='$judul', deskripsi='$deskripsi', penulis='$penulis', tanggal='$tanggal', kategori_id='$kategori_id'";

            // Check if a new file was uploaded
            if (!empty($_FILES["foto"]["name"])) {
                $fileName = basename($_FILES["foto"]["name"]);
                $targetFilePath = "uploads/" . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

                if (in_array($fileType, $allowedTypes) && move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
                    $updateQuery .= ", foto='$fileName'";
                } else {
                    echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            }
            $updateQuery .= " WHERE id=$id";
            $conn->query($updateQuery);
        } else {
            echo "Please select a category.";
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $conn->query("DELETE FROM artikel WHERE id=$id");
    }
}

$result = $conn->query("SELECT artikel.*, kategori.nama AS kategori_nama FROM artikel 
                        LEFT JOIN kategori ON artikel.kategori_id = kategori.id");

$categoryResult = $conn->query("SELECT id, nama FROM kategori");

?>

<h1 class="mt-4">Kelola Artikel</h1>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Artikel
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Tambah Artikel
        </button>

        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Tambah Artikel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" placeholder="Judul" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="kategori_id" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <?php while ($category = $categoryResult->fetch_assoc()): ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['nama'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" placeholder="Deskripsi" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penulis</label>
                                <input type="text" class="form-control" name="penulis" placeholder="Nama Penulis" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" class="form-control" name="foto" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add" class="btn btn-primary">Tambah Artikel</button>
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
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th>Foto</th>
                    <th>Dilihat</th>
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
                        <td><?= $row['judul'] ?></td>
                        <td><?= $row['kategori_nama'] ?></td>
                        <td><?= $row['deskripsi'] ?></td>
                        <td><?= $row['penulis'] ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                        <td><img src="uploads/<?= $row['foto'] ?>" alt="Foto Artikel" style="width: 100px; height: 100px;"></td>
                        <td><?= $row['read_count'] ?>x</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
                                Edit
                            </button>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $row['id'] ?>">Edit Artikel</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Judul</label>
                                                    <input type="text" class="form-control" name="judul" value="<?= $row['judul'] ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Kategori</label>
                                                    <select class="form-select" name="kategori_id" required>
                                                        <option value="" disabled>Pilih Kategori</option>
                                                        <?php
                                                        // Re-fetch categories for the dropdown
                                                        $categoryResultEdit = $conn->query("SELECT id, nama FROM kategori");
                                                        while ($category = $categoryResultEdit->fetch_assoc()):
                                                            $selected = $category['id'] == $row['kategori_id'] ? 'selected' : '';
                                                        ?>
                                                            <option value="<?= $category['id'] ?>" <?= $selected ?>>
                                                                <?= $category['nama'] ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <input type="text" class="form-control" name="deskripsi" value="<?= $row['deskripsi'] ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Penulis</label>
                                                    <input type="text" class="form-control" name="penulis" value="<?= $row['penulis'] ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Foto</label>
                                                    <img src="uploads/<?= $row['foto'] ?>" alt="Foto Artikel" style="width: 100px; height: 100px;">
                                                    <br>
                                                    <input type="file" class="form-control" name="foto">
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
                                <button class="btn btn-danger" type="submit" name="delete" onclick="return confirm('Apakah anda yakin ingin menghapus artikel ini?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>
    </div>
</div>