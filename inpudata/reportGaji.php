<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "kepegawaian";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Gaji</title>
    <a href="index.php" class="btn btn-success btn-md" style="margin-right:1pc;"><span class="fa fa-home"></span> Kembali</a>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- untuk mengeluarkan data -->
    <div class="card">
        <div class="card-header text-white bg-secondary">
            Data Pegawai
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">NIP</th>
                        <th scope="col">Nama Pegawai</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Golongan</th>
                        <th scope="col">Gaji Pokok</th>
                        <th scope="col">Tunjangan</th>
                        <th scope="col">Gaji Bersih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2   = "SELECT peg.id, peg.nama,
                        jab.namajabatan as jabatan,
                        
                        gol.id as golongan, gol.gajipokok,
                        jab.tunjanganjabatan as tunjangan,
                        
                        (gol.gajipokok+jab.tunjanganjabatan) as GajiBersih

                        FROM pegawai peg left join jabatan jab on 
                        peg.jabatan=jab.id left join golongan gol on 
                        peg.golongan=gol.id";

                    $q2     = mysqli_query($koneksi, $sql2);
                    $id   = 1;
                    while ($r2 = mysqli_fetch_array($q2)) {
                        $id         = $r2['id'];
                        $nama       = $r2['nama'];
                        $jabatan    = $r2['jabatan'];
                        $golongan   = $r2['golongan'];
                        $gajipokok  = $r2['gajipokok'];
                        $tunjangan  = $r2['tunjangan'];
                        $gajibersih = $r2['GajiBersih'];



                    ?>
                        <tr>
                            
                            <td scope="row"><?php echo $id ?></td>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $jabatan ?></td>
                            <td scope="row"><?php echo $golongan ?></td>
                            <td scope="row"><?php echo $gajipokok ?></td>
                            <td scope="row"><?php echo $tunjangan ?></td>
                            <td scope="row"><?php echo $gajibersih ?></td>



                        </tr>
                    <?php
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
    </div>
</body>

</html>