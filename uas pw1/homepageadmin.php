<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "uas pw1";

$conn    = mysqli_connect($host, $user, $pass, $db);
if (!$conn) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$username   = "";
$password   = "";
$email      = "";
$domisili   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from user where id = '$id'";
    $q1         = mysqli_query($conn,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id             = $_GET['id'];
    $sql1           = "select * from user where id = '$id'";
    $q1             = mysqli_query($conn, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $username       = $r1['username'];
    $password       = $r1['password'];
    $email          = $r1['email'];
    $domisili       = $r1['domisili'];

    if ($username == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $email      = $_POST['email'];
    $domisili   = $_POST['domisili'];

    if ($username && $password && $email && $domisili) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update user set username = '$username',password='$password',email = '$email',domisili='$domisili' where id = '$id'";
            $q1         = mysqli_query($conn, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into user(username,password,email,domisili) values ('$username','$password','$email','$domisili')";
            $q1     = mysqli_query($conn, $sql1);
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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Grayscale -Endangered Animal</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
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
    
    
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#page-top">Home</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#keloladata">Kelola Data</a></li>
                        
                        <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
                        
                    </ul>
                </div>
            </div>
        </nav>
        
        
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h1 class="mx-auto my-0 text-uppercase">Endangered Animal</h1>
                        <h2 class="text-white-50 mx-auto mt-2 mb-5"><div style="color: white"><?php echo "<h2>Selamat Datang Kembali " . $_SESSION['username'] . ", di Database ini</h2>"; ?></div></h2>
                        <a class="btn btn-primary" href="#keloladata">Get Started</a>
                        
                    </div>
                </div>
            </div>
        </header>
        
        
        <div class="mx-auto" id="keloladata"> 
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
                    header("refresh:5;url=homepageadmin.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=homepageadmin.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="password" value="<?php echo $password ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="domisili" class="col-sm-2 col-form-label">Domisili</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="domisili" id="domisili">
                                <option value="">- Pilih Domisili -</option>
                                <option value="Banda Aceh" <?php if ($domisili == "1") echo "selected" ?>>Banda Aceh</option>
                                <option value="Sumatera Utara" <?php if ($domisili == "2") echo "selected" ?>>Sumatera Utara</option>
                                <option value="Sumatera Barat" <?php if ($domisili == "3") echo "selected" ?>>Sumatera Barat</option>
                                <option value="Riau" <?php if ($domisili == "4") echo "selected" ?>>Riau</option>
                                <option value="Kepulauan Riau" <?php if ($domisili == "5") echo "selected" ?>>Kepulauan Riau</option>
                                <option value="Jambi " <?php if ($domisili == "6") echo "selected" ?>>Jambi</option>
                                <option value="Sumatera Selatan" <?php if ($domisili == "7") echo "selected" ?>>Sumatera Selatan</option>
                                <option value="Kepulauan Bangka Belitung" <?php if ($domisili == "8") echo "selected" ?>>Kepulauan Bangka Belitung</option>
                                <option value="Bengkulu" <?php if ($domisili == "8") echo "selected" ?>>Bengkulu</option>
                                <option value="Lampung" <?php if ($domisili == "10") echo "selected" ?>>Lampung</option>
                                <option value="DKI Jakarta" <?php if ($domisili == "11") echo "selected" ?>>DKI Jakarta</option>
                                <option value="Banten" <?php if ($domisili == "12") echo "selected" ?>>Banten</option>
                                <option value="Jawa Barat" <?php if ($domisili == "13") echo "selected" ?>>Jawa Barat</option>
                                <option value="Jawa Tengah" <?php if ($domisili == "14") echo "selected" ?>>Jawa Tengah</option>
                                <option value="DI Yogyakarta" <?php if ($domisili == "15") echo "selected" ?>>DI Yogyakarta</option>
                                <option value="Jawa Timur" <?php if ($domisili == "16") echo "selected" ?>>Jawa Timur </option>
                                <option value="Bali" <?php if ($domisili == "17") echo "selected" ?>>Bali</option>
                                <option value="Nusa Tenggara Barat" <?php if ($domisili == "18") echo "selected" ?>>Nusa Tenggara Barat</option>
                                <option value="Nusa Tenggara Timur" <?php if ($domisili == "19") echo "selected" ?>>Nusa Tenggara Timur</option>
                                <option value="Kalimantan Barat" <?php if ($domisili == "20") echo "selected" ?>>Kalimantan Barat</option>
                                <option value="Kalimantan Tengah" <?php if ($domisili == "21") echo "selected" ?>>Kalimantan Tengah</option>
                                <option value="Kalimantan Selatan" <?php if ($domisili == "22") echo "selected" ?>>Kalimantan Selatan</option>
                                <option value="Kalimantan Timur" <?php if ($domisili == "23") echo "selected" ?>>Kalimantan Timur</option>
                                <option value="Kalimantan Utara" <?php if ($domisili == "24") echo "selected" ?>>Kalimantan Utara</option>
                                <option value="Sulawesi Utara" <?php if ($domisili == "25") echo "selected" ?>>Sulawesi Utara</option>
                                <option value="Gorontalo" <?php if ($domisili == "26") echo "selected" ?>>Gorontalo</option>
                                <option value="Sulawesi Tengah" <?php if ($domisili == "27") echo "selected" ?>>Sulawesi Tengah</option>
                                <option value="Sulawesi Barat" <?php if ($domisili == "28") echo "selected" ?>>Sulawesi Barat</option>
                                <option value="Sulawesi Selatan" <?php if ($domisili == "29") echo "selected" ?>>Sulawesi Selatan</option>
                                <option value="Sulawesi Tenggara" <?php if ($domisili == "30") echo "selected" ?>>Sulawesi Tenggara</option>
                                <option value="Maluku" <?php if ($domisili == "31") echo "selected" ?>>Maluku</option>
                                <option value="Maluku Utara" <?php if ($domisili == "32") echo "selected" ?>>Maluku Utara</option>
                                <option value="Papua Barat" <?php if ($domisili == "33") echo "selected" ?>>Papua Barat</option>
                                <option value="Papua" <?php if ($domisili == "34") echo "selected" ?>>Papua</option>
                            </select>
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
                    Data Pengunjung
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Email</th>
                                <th scope="col">Domisili</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql2   = "select * from user order by id desc";
                            $q2     = mysqli_query($conn, $sql2);
                            $urut   = 1;
                            while ($r2 = mysqli_fetch_array($q2)) {
                                $id         = $r2['id'];
                                $username   = $r2['username'];
                                $password   = $r2['password'];
                                $email      = $r2['email'];
                                $domisili   = $r2['domisili'];

                            ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $username ?></td>
                                    <td scope="row"><?php echo $password ?></td>
                                    <td scope="row"><?php echo $email ?></td>
                                    <td scope="row"><?php echo $domisili ?></td>
                                    <td scope="row">
                                        <a href="homepageadmin.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="homepageadmin.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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
        
        
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container px-4 px-lg-5">Copyright &copy; Habib 2021</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>