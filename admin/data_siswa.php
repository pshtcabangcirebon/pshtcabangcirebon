<?php
include("inc_header.php");
include("../inc/inc_koneksi.php");

// Jumlah data yang akan ditampilkan per halaman
$jumlah_per_halaman_siswa = 10;

// Halaman saat ini (jika tidak diset, maka halaman pertama)
$data_siswa = (isset($_GET['data_siswa'])) ? $_GET['data_siswa'] : 1;
$mulai = ($data_siswa >1) ? ($data_siswa * $jumlah_per_halaman_siswa) - $jumlah_per_halaman_siswa : 0;
$nomor = $mulai + 1;

// Hitung offset untuk mengambil data mulai dari baris berapa
$offset = ($data_siswa - 1) * $jumlah_per_halaman_siswa;

$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";

// Query data dengan batasan jumlah per halaman
$sqltambahan = "";
if ($katakunci != '') {
    $array_katakunci = explode(" ", $katakunci);
    $sqlcari = [];
    for ($x = 0; $x < count($array_katakunci); $x++) {
        $sqlcari[] = "(nama LIKE '%" . $array_katakunci[$x] . "%' OR tempatlahir LIKE '%" . $array_katakunci[$x] . "%' OR tanggallahir LIKE '%" . $array_katakunci[$x] . "%' OR ranting LIKE '%" . $array_katakunci[$x] . "%')";
    }
    $sqltambahan = "WHERE (" . implode(" OR ", $sqlcari) . ") AND keterangan = 'SISWA'";
} else {
    $sqltambahan = "WHERE keterangan = 'SISWA'";
}

$sql1 = "SELECT COUNT(*) as total FROM halaman $sqltambahan";
$q_total = mysqli_query($koneksi, $sql1);
$total_data = mysqli_fetch_assoc($q_total)['total'];

// Jumlah halaman yang tersedia
$total_halaman = ceil($total_data / $jumlah_per_halaman_siswa);

// Query data dengan pagination
$sql2 = "SELECT * FROM halaman $sqltambahan ORDER BY id DESC LIMIT $offset, $jumlah_per_halaman_siswa";
$q2 = mysqli_query($koneksi, $sql2);
?>

<main>
    <h1><b>Data Siswa</b></h1>
    <?php
    // Menampilkan total data siswa di bawah header
    echo "<p>Total Siswa: " . $total_data . "</p>";
    ?>
    <form class="row g-3" method="get">
        <div class="row justify-content-end">
            <div class="col-auto">
                <input type="text" class="form-control" placeholder="Masukkan Kata Kunci" name="katakunci"
                    value="<?php echo $katakunci ?>" />
            </div>
            <div class="col-auto">
                <input type="submit" name="Cari" value="Cari Tulisan" class="btn btn-secondary" />
            </div>
        </div>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th class="col-2">NAMA LENGKAP</th>
                <th>JENIS KELAMIN</th>
                <th>NOMOR HP</th>
                <th>RAYON</th>
                <th>RANTING</th>
                <th>SABUK</th>
                <th class="col-3">ALAMAT</th>

            </tr>
        </thead>
        <tbody>
    <?php
    while ($r1 = mysqli_fetch_array($q2)) {
        // Anda tidak perlu lagi melakukan pemeriksaan keterangan di sini,
        // karena query hanya akan mengambil data dengan keterangan 'SISWA'
        $sabuk = $r1['sabuk'];
        $background_color = '';

        // Tentukan warna latar belakang berdasarkan kategori sabuk
        switch ($sabuk) {
            case 'PRAPOLOS':
                $background_color = ''; // Pra Polos tanpa warna
                break;
            case 'POLOS':
                $background_color = 'bg-dark text-white'; // Polos warna hitam
                break;
            case 'JAMBON':
                $background_color = 'bg-danger'; // Jambon berwarna merah muda
                break;
            case 'HIJAU':
                $background_color = 'bg-success text-white'; // Hijau berwarna hijau
                break;
            case 'PUTIH':
                $background_color = 'bg-white'; // Putih berwarna putih
                break;
            // Tambahkan kategori sabuk lainnya sesuai kebutuhan
        }
    ?>
            <tr class="<?php echo $background_color; ?>">
                <td>
                    <?php echo $nomor++; ?>
                </td>
                <td>
                    <?php echo $r1['nama']; ?>
                </td>
                <td>
                    <?php echo $r1['kelamin']; ?>
                </td>
                <td>
                    <?php echo $r1['nomorhp']; ?>
                </td>
                <td>
                    <?php echo $r1['rayon']; ?>
                </td>
                <td>
                    <?php echo $r1['ranting']; ?>
                </td>
                <td>
                    <?php echo $r1['sabuk']; ?>
                </td>
                <td>
                    <?php echo $r1['alamat']; ?>
                </td>
            </tr>
    <?php
    }
    ?>
</tbody>


    </table>

    <!-- Tampilkan pagination -->
    <ul class="pagination">
        <?php
        for ($i = 1; $i <= $total_halaman; $i++) {
            $active = ($i == $data_siswa) ? 'active' : '';
            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?data_siswa=' . $i . '&katakunci=' . $katakunci . '">' . $i . '</a></li>';
        }
        ?>
    </ul>
</main>

<?php include("inc_footer.php"); ?>
