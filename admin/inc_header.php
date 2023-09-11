<?php include("../inc/inc_koneksi.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSHT CABANG CIREBON</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <style>
        .gambar-dengan-jarak {
            margin: 15px;
        }
    </style>
</head>

<body class="container">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <img src="psht.png" alt="Logo PSHT" width="50" height="65" class="gambar-dengan-jarak">
                <a class="navbar-brand" href="halaman.php">PSHT CABANG CIREBON</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="data_warga.php" style="color:#C69749;">Data Warga</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_siswa.php"style="color:#C69749;">Data Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="struktur_organisasi.php"style="color:#C69749;">Struktur Organisasi Cabang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="jadwal.php"style="color:#C69749;">Jadwal Latihan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="galery.php"style="color:#C69749;">Galleries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="halaman_input.php"style="color:#C69749;">Input Data</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>

</html>