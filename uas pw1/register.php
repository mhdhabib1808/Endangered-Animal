<?php 

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: login.php");
}

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
    $domisili = $_POST['domisili'];

	if ($password == $cpassword) {
		$sql = "SELECT * FROM user WHERE email='$email'";
		$result = mysqli_query($conn, $sql);
		if (!$result->num_rows > 0) {
			$sql = "INSERT INTO user (username, email, password, domisili)
					VALUES ('$username', '$email', '$password', '$domisili')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				echo "<script>alert('Selamat! Pendaftaran telah berhasil.'); location = 'login.php';</script>";
				$username = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
			} else {
				echo "<script>alert('Ada yang salah, silahkan diulang.')</script>";
			}
		} else {
			echo "<script>alert('Maaf, Email telah digunakan.')</script>";
		}
		
	} else {
		echo "<script>alert('Password tidak cocok!')</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="YPI.png">
    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="gaya.css">

	<title>Register</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Konfirmasi Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
            <div class="input-group">
				<input type="text" placeholder="Provinsi Anda" name="domisili" value="<?php echo $domisili; ?>" required>
                
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Sudah punya akun? <a href="login.php">Login Disini</a>.</p>
		</form>
	</div>
</body>
</html>