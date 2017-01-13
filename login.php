<?php
session_start();
include "database.php";
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
	<!-- Custom styles for this template -->
		<link href="css/signin.css" rel="stylesheet">
		<script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
	</head>

	<body>
		<div class="container">
			<form action="login.php" method="post" class="form-signin">
						<h2 class="form-signin-heading">Effettua il Login qui</h2>
						<label for="user_email" class="sr-only">Email</label>
						<input type="text" name="user_email" class="form-control" placeholder="Inserisci la tua email" required autofocus/>
						<label for="password" class="sr-only">Password</label>
						<input type="password" name="user_pass" placeholder="Inserisci la tua password" class="form-control" required/>
						<div class="checkbox">
							<label>
							  <input type="checkbox" value="remember-me"> Remember me
							</label>
						</div>
						<button class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="Login"/>Login</button>
			</form>
			
			<center>
				<h5>
				Non ancora registrato? <a href="registration.php">Registrati qui.</a>
				</h5>
				<h5>
				Amministratore? <a href="admin_login.php">Accedi qui.</a>
				</h5>
			</center>
		</div>
		<?php

		if(isset($_POST['login']))
		{
			$user_email = mysqli_real_escape_string($con,$_POST['user_email']);
			$user_pass = mysqli_real_escape_string($con,$_POST['user_pass']);

			$sel = "select * from register_user where user_email='$user_email' AND user_pass='$user_pass'";
			$run = mysqli_query($con,$sel);
			
			$check = mysqli_num_rows($run);
			
			if($check == 0)
			{
				echo "<script>alert('e-Mail o password non valide!Prova ancora!')</script>";
				exit();
			} else
			{
				$_SESSION['user_email'] = $user_email;
				echo "<script>alert('Login effettuato con successo!')</script>";
				echo "<script>window.open('index_home.php','_self')</script>";
			}
		}
		?>	
	</body>
</html>
