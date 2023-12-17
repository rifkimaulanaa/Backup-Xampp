<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "kepegawaian";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$id                 = "";
$ids                = "";
$nama               = "";
$tunjangan          = "";
$sukses             = "";
$error              = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id         = $_GET["id"];
    $sql1       = "delete from jabatan where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from jabatan where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $ids        = $r1['idsatker'];
    $nama       = $r1['namajabatan'];
    $tunjangan  = $r1['tunjanganjabatan'];
    if ($id == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { //untuk create
    $ids                = $_POST['idsatker'];
    $nama               = $_POST['namajabatan'];
    $tunjangan          = $_POST['tunjanganjabatan'];


    if ($ids && $nama && $tunjangan) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update jabatan set id='$id',namajabatan= '$nama',tunjanganjabatan= '$tunjangan' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "INSERT INTO jabatan (`idsatker`, `namajabatan`, `tunjanganjabatan`) values ('$ids','$nama', '$tunjangan')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
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
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;url=jabatan.php"); //5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:3;url=jabatan.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="ids" class="col-sm-2 col-form-label">SATUAN KERJA</label>
                        <div class="col-sm-10">
                            <select name="idsatker" id="satker">
                                <option disabled selected> Pilih </option>
                                <?php
                                $sql2 = "SELECT * FROM satker";
                                $q1 = mysqli_query($koneksi, $sql2);
                                while ($data = mysqli_fetch_array($q1)) {
                                ?>
                                    <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
                                <?php
                                }
                                ?>4
                                
                            </select>
                        </div>
                    </div>
                        <div class="mb-3 row">
                            <label for="namajabatan" class="col-sm-2 col-form-label text-1xl">NAMA JABATAN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="namajabatan" name="namajabatan" value="<?php echo $nama ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tunjanganjabatan" class="col-sm-2 col-form-label">TUNJANGAN JABATAN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tunjanganjabatan" name="tunjanganjabatan" value="<?php echo $tunjangan ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Pegawai Jabatan
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">SATUAN KERJA</th>
                            <th scope="col">NAMA JABATAN</th>
                            <th scope="col">TUNJANGAN JABATAN</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "SELECT jbtn.id, jbtn.idsatker, jbtn.namajabatan, jbtn.tunjanganjabatan, 
                        sat.nama
                        FROM 
                        jabatan 
                        jbtn left join satker sat on jbtn.idsatker=sat.id";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id          = $r2['id'];
                            $ids         = $r2['nama'];
                            $nama        = $r2['namajabatan'];
                            $tunjangan   = $r2['tunjanganjabatan'];



                        ?>
                            <tr>
                                <td scope="row"><?php echo $ids ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $tunjangan ?></td>

                                <td scope="row">
                                    <a href="jabatan.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="jabatan.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
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