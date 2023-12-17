<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "kepegawaian";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$id             = "";
$nama           = "";
$jabatan        = "";
$golongan      = "";
$nama           = "";
$alamat         = "";
$tempatlahir    = "";
$tglahir        = "";
$status         = "";
$agama          = "";
$telepon        = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id         = $_GET['id'];
    $sql1       = "delete from pegawai where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id            = $_GET['id'];
    $sql1           = "select * from pegawai where id = '$id'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $jabatan        = $r1['jabatan'];
    $golongan      = $r1['golongan'];
    $nama           = $r1['nama'];
    $alamat         = $r1['alamat'];
    $tempatlahir    = $r1['tempatlahir'];
    $tglahir        = $r1['tglahir'];
    $status         = $r1['status'];
    $agama          = $r1['agama'];
    $telepon        = $r1['telepon'];

    if ($id == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $id             = $_POST['id'];
    $jabatan        = $_POST['jabatan'];
    $golongan       = $_POST['golongan'];
    $nama           = $_POST['nama'];
    $alamat         = $_POST['alamat'];
    $tempatlahir    = $_POST['tempatlahir'];
    $tglahir        = $_POST['tglahir'];
    $status         = $_POST['status'];
    $agama          = $_POST['agama'];
    $telepon        = $_POST['telepon'];




    if ($id && $jabatan && $golongan &&$nama && $alamat && $tempatlahir &&$tglahir && $status && $agama &&$telepon) {
        if ($op == 'edit') 
        { //untuk update
            $sql1       = "UPDATE `pegawai` SET id = '$id', golongan = '$golongan', jabatan = '$jabatan', nama = '$nama', alamat = '$alamat', tempatlahir = '$tempatlahir',
            tglahir = '$tglahir', status = '$status', agama = '$agama', telepon = '$telepon' WHERE pegawai.id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "INSERT INTO pegawai (`id`, `jabatan`, `golongan`, `nama`, `alamat`, `tempatlahir`, `tglahir`, `status`, `agama`, `telepon`) VALUES ('$id', '$jabatan', '$golongan', '$nama', '$alamat', '$tempatlahir', '$tglahir', '$status', '$agama', '$telepon')";
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
                    header("refresh:5;url=pegawai.php"); //5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=pegawai.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="id" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id" name="id" value="<?php echo $id ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ids" class="col-sm-2 col-form-label">JABATAN</label>
                        <div class="col-sm-10">
                            <select name="jabatan" id="jabatan">
                                <option disabled selected> Pilih </option>
                                <?php
                                $sql2 = "SELECT * FROM jabatan";
                                $q1 = mysqli_query($koneksi, $sql2);
                                while ($data = mysqli_fetch_array($q1)) {
                                ?>
                                    <option value="<?= $data['id'] ?>"><?= $data['namajabatan'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ids" class="col-sm-2 col-form-label">GOLONGAN</label>
                        <div class="col-sm-10">
                            <select name="golongan" id="golongan">
                                <option disabled selected> Pilih </option>
                                <?php
                                $sql2 = "SELECT * FROM golongan";
                                $q1 = mysqli_query($koneksi, $sql2);
                                while ($data = mysqli_fetch_array($q1)) {
                                ?>
                                    <option value="<?= $data['id'] ?>"><?= $data['id'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tempatlahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="<?php echo $tempatlahir ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tggllahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tglahir" name="tglahir" value="<?php echo $tglahir ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="status" name="status" value="<?php echo $status ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="agama" class="col-sm-2 col-form-label">Agama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="agama" name="agama" value="<?php echo $agama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $telepon ?>">
                        </div>
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
            Data Pegawai Satker
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">NIP</th>
                        <th scope="col">ID Jabatan</th>
                        <th scope="col">ID Golongan</th>
                        <th scope="col">Nama Pegawai</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Tempat Lahir</th>
                        <th scope="col">Tggl Lahir</th>
                        <th scope="col">Status</th>
                        <th scope="col">Agama</th>
                        <th scope="col">Telepon</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2   = "select * from pegawai order by id DESC";
                    $q2     = mysqli_query($koneksi, $sql2);
                    $nip    = 1;
                    while ($r2 = mysqli_fetch_array($q2)) {
                        $id             = $r2['id'];
                        $jabatan        = $r2['jabatan'];
                        $golongan       = $r2['golongan'];
                        $nama           = $r2['nama'];
                        $alamat         = $r2['alamat'];
                        $tempatlahir    = $r2['tempatlahir'];
                        $tglahir       = $r2['tglahir'];
                        $status         = $r2['status'];
                        $agama          = $r2['agama'];
                        $telepon        = $r2['telepon'];
                        ?>
                        <tr>
                            <!-- <th scope="row"><?php echo $urut++ ?></th> -->
                            <th scope="row"> <?php echo $id ?></th>
                            <td scope="row"><?php echo $jabatan ?></td>
                            <td scope="row"><?php echo $golongan ?></td>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $alamat ?></td>
                            <td scope="row"><?php echo $tempatlahir ?></td>
                            <td scope="row"><?php echo $tglahir ?></td>
                            <td scope="row"><?php echo $status ?></td>
                            <td scope="row"><?php echo $agama ?></td>
                            <td scope="row"><?php echo $telepon ?></td>

                            <td scope="row">
                                <a href="pegawai.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                <a href="pegawai.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
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