<?php
session_start();
//include "database.php";
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Custom styles for this template -->
		<link href="css/signin.css" rel="stylesheet">
		<script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	</head>

	<body>
		<div class="container">
			<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12" >
				<img class="img-circle img-responsive center-block" src="images/K01.jpg" align="center" style="max-height:300px">
			</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<form action="elogin.php" method="post" class="form-signin">
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
				</div>
			</div>
			<center>
				<h5>
				<!-- Non ancora registrato? <a href="registration.php">Registrati qui.</a> -->
				</h5>
				<h5>
				Amministratore? <a href="admin_login.php">Accedi qui.</a>
				</h5>
			</center>
		</div>
	</body>
</html>
