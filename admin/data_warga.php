<?php
include("inc_header.php");
include("../inc/inc_koneksi.php");

// Jumlah data yang akan ditampilkan per halaman
$jumlah_per_halaman_warga = 10;

// Halaman saat ini (jika tidak diset, maka halaman pertama)
$data_warga = (isset($_GET['data_warga'])) ? $_GET['data_warga'] : 1;
$mulai = ($data_warga >1) ? ($data_warga * $jumlah_per_halaman_warga) - $jumlah_per_halaman_warga : 0;
$nomor = $mulai + 1;

// Hitung offset untuk mengambil data mulai dari baris berapa
$offset = ($data_warga - 1) * $jumlah_per_halaman_warga;

$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";

// Query data dengan batasan jumlah per halaman
$sqltambahan = "";
if ($katakunci != '') {
    $array_katakunci = explode(" ", $katakunci);
    $sqlcari = [];
    for ($x = 0; $x < count($array_katakunci); $x++) {
        $sqlcari[] = "(nama LIKE '%" . $array_katakunci[$x] . "%' OR tempatlahir LIKE '%" . $array_katakunci[$x] . "%' OR tanggallahir LIKE '%" . $array_katakunci[$x] . "%' OR ranting LIKE '%" . $array_katakunci[$x] . "%')";
    }
    $sqltambahan = "WHERE (" . implode(" OR ", $sqlcari) . ") AND keterangan = 'WARGA'";
} else {
    $sqltambahan = "WHERE keterangan = 'WARGA'";
}

$sql1 = "SELECT COUNT(*) as total FROM halaman $sqltambahan";
$q_total = mysqli_query($koneksi, $sql1);
$total_data = mysqli_fetch_assoc($q_total)['total'];

// Jumlah halaman yang tersedia
$total_halaman = ceil($total_data / $jumlah_per_halaman_warga);

// Query data dengan pagination
$sql2 = "SELECT * FROM halaman $sqltambahan ORDER BY tahunpengesahan DESC LIMIT $offset, $jumlah_per_halaman_warga";
$q2 = mysqli_query($koneksi, $sql2);

?>

<main>
    <h1><b>Data Warga</b></h1>
    <?php
    // Menampilkan total data warga di bawah header
    echo "<p>Total Warga: " . $total_data . "</p>";
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
                <th>RANTING</th>
                <th>PENGESAHAN</th>
                <th class="col-4">ALAMAT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($r1 = mysqli_fetch_array($q2)) {
                $keterangan = $r1['keterangan'];
                // Tampilkan hanya jika keterangan adalah "WARGA"
                if ($keterangan == 'WARGA') {
                    ?>
                    <tr>
                        <td>
                            <?php echo $nomor++; ?>
                        </td>
                        <td>
                            <?php echo $r1['nama']; ?>
                        </td>
                        <td>
                            <?php echo $r1['kelamin']; ?>
                        <td>
                            <?php echo $r1['nomorhp']; ?>
                        </td>
                        <td>
                            <?php echo $r1['ranting']; ?>
                        </td>
                        <td>
                            <?php echo $r1['tahunpengesahan']; ?>
                        </td>
                        <td>
                            <?php echo $r1['alamat']; ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Tampilkan pagination -->
    <ul class="pagination">
        <?php
        $page_range = 3; // Jumlah halaman yang akan ditampilkan sebelum dan sesudah halaman saat ini
        
        // Hitung halaman pertama dan terakhir yang akan ditampilkan
        $start_page = max($data_warga - $page_range, 1);
        $end_page = min($data_warga + $page_range, $total_halaman);

        // Tampilkan halaman pertama
        if ($start_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?data_warga=1&katakunci=' . $katakunci . '">1</a></li>';
            if ($start_page > 2) {
                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Tampilkan halaman-halaman di antara
        for ($i = $start_page; $i <= $end_page; $i++) {
            $active = ($i == $data_warga) ? 'active' : '';
            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?data_warga=' . $i . '&katakunci=' . $katakunci . '">' . $i . '</a></li>';
        }

        // Tampilkan halaman terakhir
        if ($end_page < $total_halaman) {
            if ($end_page < $total_halaman - 1) {
                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            echo '<li class="page-item"><a class="page-link" href="?data_warga=' . $total_halaman . '&katakunci=' . $katakunci . '">' . $total_halaman . '</a></li>';
        }
        ?>
    </ul>
</main>

<?php include("inc_footer.php"); ?>