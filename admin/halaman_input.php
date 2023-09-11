<?php
include("inc_header.php");
include("../inc/inc_koneksi.php");

$nama = $kelamin = $tempatlahir = $tanggallahir = $alamat = $nomorhp = $pekerjaan = $keterangan = $sabuk = $rayon = $ranting = $tahunpengesahan = $tempatpengesahan = $foto = "";
$error = $sukses = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    $uploadDirectory = '../uploads/'; // Direktori tempat menyimpan file
    $targetFile = $uploadDirectory . basename($_FILES["file_foto"]["name"]);
    $uploadOk = 1;

    // Cek apakah file yang diunggah adalah gambar
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        $error = "Hanya file gambar JPG, JPEG, atau PNG yang diperbolehkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file_foto"]["tmp_name"], $targetFile)) {
            $foto = basename($_FILES["file_foto"]["name"]); // Simpan nama file di database
        } else {
            $error = "Gagal mengunggah file.";
        }
    }

    // Ambil nilai-nilai dari form
    $nama = strtoupper($_POST['nama']);
    $kelamin = strtoupper($_POST['kelamin']);
    $tempatlahir = strtoupper($_POST['tempatlahir']);
    $tanggallahir = $_POST['tanggallahir']; // Tidak perlu strtoupper karena format tanggal tidak case-sensitive
    $alamat = strtoupper($_POST['alamat']);
    $nomorhp = strtoupper($_POST['nomorhp']);
    $pekerjaan = strtoupper($_POST['pekerjaan']);
    $keterangan = strtoupper($_POST['keterangan']);
    $sabuk = strtoupper($_POST['sabuk']);
    $rayon = strtoupper($_POST['rayon']);
    $ranting = strtoupper($_POST['ranting']);
    $tahunpengesahan = strtoupper($_POST['tahunpengesahan']);
    $tempatpengesahan = strtoupper($_POST['tempatpengesahan']);
    $foto = strtoupper($_POST['foto']);

    // Validasi input
    if (empty($nama) || empty($kelamin) || empty($tempatlahir) || empty($alamat) || empty($nomorhp) || empty($pekerjaan) || empty($keterangan) || empty($rayon) || empty($ranting)) {
        $error = "Silahkan isi semua data";
    }

    if (empty($error)) {
        // Siapkan query SQL dan eksekusi
        $sql1 = "INSERT INTO halaman (nama, kelamin, tempatlahir, tanggallahir, alamat, nomorhp, pekerjaan, keterangan, sabuk, rayon, ranting, tahunpengesahan, tempatpengesahan, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql1);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssssssssss", $nama, $kelamin, $tempatlahir, $tanggallahir, $alamat, $nomorhp, $pekerjaan, $keterangan, $sabuk, $rayon, $ranting, $tahunpengesahan, $tempatpengesahan, $foto);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $sukses = "Sukses Memasukkan Data";
                header("Location: halaman.php");
                exit();
            } else {
                $error = "Gagal Memasukkan Data: " . mysqli_error($koneksi);
            }

            mysqli_stmt_close($stmt);
        } else {
            $error = "Gagal mempersiapkan pernyataan SQL: " . mysqli_error($koneksi);
        }
    }
}
?>

<h1>Halaman Input Data</h1>
<p>
    <a href="halaman.php" class="btn btn-danger" style="font-size: 12px;">Kembali</a>
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
                <option value="PRAPOLOS" <?php if ($keterangan == "PRAPOLOS")
                    echo "selected"; ?>>PRA POLOS</option>
                <option value="POLOS" <?php if ($keterangan == "POLOS")
                    echo "selected"; ?>>POLOS</option>
                <option value="JAMBON" <?php if ($keterangan == "JAMBON")
                    echo "selected"; ?>>JAMBON</option>
                <option value="HIJAU" <?php if ($keterangan == "HIJAU")
                    echo "selected"; ?>>HIJAU</option>
                <option value="PUTIH" <?php if ($keterangan == "PUTIH")
                    echo "selected"; ?>>PUTIH</option>
                <option value="MORI" <?php if ($keterangan == "MORI")
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
                <option value="pria" <?php if ($kelamin == "pria")
                    echo "selected"; ?>>PRIA</option>
                <option value="wanita" <?php if ($kelamin == "wanita")
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
                name="tanggallahir" oninput="toUpperCase(this)">
        </div>
    </div>
    </div>

    </div>
    <div class="mb-3 row">
        <label for="alamat" class="col-sm-2 col-form-label">Alamat Lengkap</label>
        <div class="col-sm-10">
            <textarea name="alamat" class="form-control" oninput="toUpperCase(this)"><?php echo $alamat ?></textarea>
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
    <div class="mb-3 row">
        <label for="foto" class="col-sm-2 col-form-label">Unggah Foto</label>
        <div class="col-sm-10">
            <input type="file" name="file_foto" id="file_foto">
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" class="btn btn-primary" value="Simpan Data" name="Simpan">
        </div>
    </div>
</form>

<script>
    function toUpperCase(input) {
        input.value = input.value.toUpperCase();
    }
</script>

<?php include("inc_footer.php"); ?>