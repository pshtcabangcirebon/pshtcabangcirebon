<?php
include("inc_header.php");
include("../inc/inc_koneksi.php");

$nama = $kelamin = $tempatlahir = $tanggallahir = $alamat = $nomorhp = $pekerjaan = $keterangan = $sabuk = $rayon = $ranting = $tahunpengesahan = $tempatpengesahan = "";
$error = $sukses = "";

// Cek apakah parameter id tersedia
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data berdasarkan ID
    $sql = "SELECT * FROM halaman WHERE id = $id";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $nama = $data['nama'];
        $kelamin = $data['kelamin'];
        $tempatlahir = $data['tempatlahir'];
        $tanggallahir = $data['tanggallahir'];
        $alamat = $data['alamat'];
        $nomorhp = $data['nomorhp'];
        $pekerjaan = $data['pekerjaan'];
        $keterangan = $data['keterangan'];
        $sabuk = $data['sabuk'];
        $rayon = $data['rayon'];
        $ranting = $data['ranting'];
        $tahunpengesahan = $data['tahunpengesahan'];
        $tempatpengesahan = $data['tempatpengesahan'];
    } else {
        echo "Gagal mengambil data.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}

// Logika untuk menyimpan perubahan data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = strtoupper($_POST['nama']);
    $kelamin = strtoupper($_POST['kelamin']);
    $tempatlahir = strtoupper($_POST['tempatlahir']);
    $tanggallahir = $_POST['tanggallahir'];
    $alamat = strtoupper($_POST['alamat']);
    $nomorhp = strtoupper($_POST['nomorhp']);
    $pekerjaan = strtoupper($_POST['pekerjaan']);
    $keterangan = strtoupper($_POST['keterangan']);
    $sabuk = strtoupper($_POST['sabuk']);
    $rayon = strtoupper($_POST['rayon']);
    $ranting = strtoupper($_POST['ranting']);
    $tahunpengesahan = strtoupper($_POST['tahunpengesahan']);
    $tempatpengesahan = strtoupper($_POST['tempatpengesahan']);

    // Validasi input (sesuai kebutuhan Anda)

    // Proses update foto
    $uploadDirectory = '../uploads/'; // Direktori tempat menyimpan file
    $foto = $data['foto']; // Foto saat ini di database

    // Hapus foto lama jika checkbox "Hapus Foto" dicentang
    if (isset($_POST['hapus_foto']) && $_POST['hapus_foto'] == 1) {
        if (!empty($foto)) {
            $currentFilePath = $uploadDirectory . $foto;
            if (file_exists($currentFilePath)) {
                unlink($currentFilePath);
            }
            $foto = ""; // Kosongkan nama foto dalam database
        }
    }


    if ($_FILES["file_foto"]["name"]) {
        // Handle file upload jika ada foto baru yang diunggah
        $targetFile = $uploadDirectory . basename($_FILES["file_foto"]["name"]);

        // Cek apakah file yang diunggah adalah gambar
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            echo "Hanya file gambar JPG, JPEG, atau PNG yang diperbolehkan.";
            exit;
        }

        // Hapus foto saat ini dari direktori jika ada
        if (!empty($foto)) {
            $currentFilePath = $uploadDirectory . $foto;
            if (file_exists($currentFilePath)) {
                unlink($currentFilePath);
            }
        }

        // Pindahkan foto baru ke direktori upload
        if (move_uploaded_file($_FILES["file_foto"]["tmp_name"], $targetFile)) {
            $foto = basename($_FILES["file_foto"]["name"]); // Simpan nama file di database
        } else {
            echo "Gagal mengunggah file.";
            exit;
        }
    }

    // Query untuk mengupdate data
    $sql_update = "UPDATE halaman SET nama = ?, kelamin = ?, tempatlahir = ?, tanggallahir = ?, alamat = ?, nomorhp = ?, pekerjaan = ?, keterangan = ?, sabuk = ?, rayon = ?, ranting = ?, tahunpengesahan = ?, tempatpengesahan = ?, foto = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql_update);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssssssssi", $nama, $kelamin, $tempatlahir, $tanggallahir, $alamat, $nomorhp, $pekerjaan, $keterangan, $sabuk, $rayon, $ranting, $tahunpengesahan, $tempatpengesahan, $foto, $id);
        $result_update = mysqli_stmt_execute($stmt);

        if ($result_update) {
            echo "Data berhasil diupdate.";

        } else {
            echo "Gagal mengupdate data: " . mysqli_error($koneksi);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal mempersiapkan pernyataan SQL: " . mysqli_error($koneksi);
    }
}
?>

<main>
    <h1><b>Edit Data Warga & Siswa</b></h1>

    <p>
        <a href="halaman.php" class="btn btn-danger" style="font-size: 12px;">Kembali Ke Halaman Utama</a>
    </p>

    <?php if ($error) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php } ?>
    <?php if ($sukses) { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $sukses; ?>
        </div>
    <?php } ?>


    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3 row">
            <label for="keterangan" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select class="form-select" id="keterangan" name="keterangan">
                    <option value="WARGA" <?php if ($keterangan == "WARGA")
                        echo "selected"; ?>>WARGA</option>
                    <option value="SISWA" <?php if ($keterangan == "SISWA")
                        echo "selected"; ?>>SISWA</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="sabuk" class="col-sm-2 col-form-label">Sabuk</label>
            <div class="col-sm-10">
                <select class="form-select" id="sabuk" name="sabuk">
                    <option value="PRAPOLOS" <?php if ($sabuk == "PRAPOLOS")
                        echo "selected"; ?>>PRA POLOS</option>
                    <option value="POLOS" <?php if ($sabuk == "POLOS")
                        echo "selected"; ?>>POLOS</option>
                    <option value="JAMBON" <?php if ($sabuk == "JAMBON")
                        echo "selected"; ?>>JAMBON</option>
                    <option value="HIJAU" <?php if ($sabuk == "HIJAU")
                        echo "selected"; ?>>HIJAU</option>
                    <option value="PUTIH" <?php if ($sabuk == "PUTIH")
                        echo "selected"; ?>>PUTIH</option>
                    <option value="MORI" <?php if ($sabuk == "MORI")
                        echo "selected"; ?>>MORI</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="namalengkap" value="<?php echo $nama ?>" name="nama"
                    oninput="toUpperCase(this)">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
                <select class="form-select" id="kelamin" name="kelamin">
                    <option value="PRIA" <?php if ($kelamin == "PRIA")
                        echo "selected"; ?>>PRIA</option>
                    <option value="WANITA" <?php if ($kelamin == "WANITA")
                        echo "selected"; ?>>WANITA</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tempatlahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tempatlahir" value="<?php echo $tempatlahir ?>"
                    name="tempatlahir" oninput="toUpperCase(this)">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tanggallahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="tanggallahir" value="<?php echo $tanggallahir ?>"
                    name="tanggallahir">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="alamat" class="col-sm-2 col-form-label">Alamat Lengkap</label>
            <div class="col-sm-10">
                <textarea name="alamat" class="form-control"
                    oninput="toUpperCase(this)"><?php echo $alamat ?></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nomorhp" class="col-sm-2 col-form-label">Nomor HP</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="nomorhp" value="<?php echo $nomorhp ?>" name="nomorhp">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="pekerjaan" value="<?php echo $pekerjaan ?>" name="pekerjaan"
                    oninput="toUpperCase(this)">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rayon" class="col-sm-2 col-form-label">Rayon</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rayon" value="<?php echo $rayon ?>" name="rayon"
                    oninput="toUpperCase(this)">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="ranting" class="col-sm-2 col-form-label">Ranting</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="ranting" value="<?php echo $ranting ?>" name="ranting"
                    oninput="toUpperCase(this)">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tahunpengesahan" class="col-sm-2 col-form-label">Tahun Pengesahan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tahunpengesahan" value="<?php echo $tahunpengesahan ?>"
                    name="tahunpengesahan" oninput="toUpperCase(this)" pattern="\d{4}" placeholder="Masukkan Tahun">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tempatpengesahan" class="col-sm-2 col-form-label">Tempat Pengesahan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tempatpengesahan" value="<?php echo $tempatpengesahan ?>"
                    name="tempatpengesahan" oninput="toUpperCase(this)">
            </div>
        </div>
        <!-- Tampilkan foto yang sudah diunggah -->
        <div class="mb-3 row">
            <label for="foto_lama" class="col-sm-2 col-form-label">Foto Lama</label>
            <div class="col-sm-10">
                <?php if (!empty($foto)) { ?>
                    <img src="../uploads/<?php echo $foto; ?>" alt="Foto Lama" width="200">
                    <input type="hidden" name="foto_lama" value="<?php echo $foto; ?>">
                <?php } else { ?>
                    <p>Tidak ada foto tersedia.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Input untuk mengunggah foto baru -->
        <div class="mb-3 row">
            <label for="file_foto" class="col-sm-2 col-form-label">Unggah Foto Baru</label>
            <div class="col-sm-10">
                <input type="file" name="file_foto" id="file_foto">
            </div>
        </div>

        <!-- Tambahkan checkbox untuk menghapus foto -->
        <div class="mb-3 row">
            <label for="hapus_foto" class="col-sm-2 col-form-label">Hapus Foto</label>
            <div class="col-sm-10">
                <input type="checkbox" name="hapus_foto" id="hapus_foto" value="1"> Hapus foto lama
            </div>
        </div>


        <div class="mb-3 row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <input type="submit" class="btn btn-primary" value="Simpan Perubahan" name="Simpan">
            </div>
        </div>
    </form>
</main>

<script>
    function toUpperCase(input) {
        input.value = input.value.toUpperCase();
    }
</script>

<?php include("inc_footer.php"); ?>