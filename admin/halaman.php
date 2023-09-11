<?php
include("inc_header.php");
include("../inc/inc_koneksi.php");

// Tentukan jumlah data yang akan ditampilkan per halaman
$per_halaman = 10;

// Dapatkan halaman saat ini dari parameter URL (jika ada)
$halaman = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

// Kueri SQL untuk mengambil total jumlah data
$sql_total = "SELECT COUNT(*) AS total FROM halaman";
$result_total = mysqli_query($koneksi, $sql_total);

if (!$result_total) {
    echo "Gagal mengambil data.";
    exit;
}

$data_total = mysqli_fetch_assoc($result_total);
$total_data = $data_total['total'];

// Hitung jumlah halaman yang dibutuhkan
$total_halaman = ceil($total_data / $per_halaman);

// Hitung offset data (mulai dari data ke berapa)
$offset = ($halaman - 1) * $per_halaman;

// Kueri SQL untuk mengambil data dengan pagination
$sql = "SELECT * FROM halaman ORDER BY tahunpengesahan DESC LIMIT $offset, $per_halaman";
$result = mysqli_query($koneksi, $sql);

if (!$result) {
    echo "Gagal mengambil data.";
    exit;
}
?>

<main>
    <h1><b>Data Warga & Siswa</b></h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th class="col-3">NAMA LENGKAP</th>
                <th>JENIS KELAMIN</th>
                <th>NOMOR HP</th>
                <th class="col-2">RANTING</th>
                <th>KETERANGAN</th>
                <th class="col-2">AKSI</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = $offset + 1;

            while ($r1 = mysqli_fetch_array($result)) {
                $keterangan = $r1['keterangan'];
                $kelas_css = ($keterangan == 'WARGA') ? 'bg-warning text-dark' : 'bg-dark colour-white';
                ?>
                <tr>
                    <td>
                        <?php echo $nomor; ?>
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
                        <?php echo $r1['ranting']; ?>
                    </td>
                    <td>
                        <span class="badge <?php echo $kelas_css; ?>">
                            <?php echo $keterangan; ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success">
                            <a href="edit_data.php?id=<?php echo $r1['id']; ?>" style="text-decoration: none; color: white;"
                                onclick="return confirm('Anda yakin ingin mengedit data ini?')">Edit</a>
                        </span>
                        <a href="hapus_data.php?id=<?php echo $r1['id']; ?>" class="badge bg-danger"
                            onclick="return confirm('Anda yakin ingin menghapus data ini?')"
                            style="text-decoration: none; /* Menghilangkan garis bawah */ color: white;">Delete</a>
                    </td>
                </tr>
                <?php
                $nomor++;
            }
            ?>
        </tbody>
    </table>

    <ul class="pagination">
        <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
            <li class="page-item <?php if ($i == $halaman)
                echo 'active'; ?>">
                <a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>
    </ul>
</main>

<?php include("inc_footer.php"); ?>