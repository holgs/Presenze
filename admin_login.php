<?php
include "function_setup.php";
//echo $_SERVER['DOCUMENT_ROOT']."Presenze/function_setup.php";
//include $_SERVER['DOCUMENT_ROOT']."Presenze/function_setup.php";
?>

<!DOCTYPE html>


<html lang="en">
	<head>
		<title>Pannello di controllo Admin</title>
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
			<form action="admin_login.php" method="POST" class="form-signin">
				<h2 class="form-signin-heading">Admin Login </h2>
				<label for="admin_email" class="sr-only">Email</label>
				<input type="text" name="admin_email" class="form-control" placeholder="Inserisci la tua email" required autofocus/>
				<label for="admin_pass" class="sr-only">Password</label>
				<input type="password" name="admin_pass" class="form-control" placeholder="Inserisci la tua password" required="required"/>
				<div class="checkbox">
					<label>
					  <input type="checkbox" value="remember-me"> Remember me
					</label>
				</div>
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="admin_login" value="Admin Login"/>Login</button>
			</form>
			<center>
				<h5>
				Non ancora registrato? <a href="registration.php">Registrati qui.</a>
				</h5>
				<h5>
				Utente? <a href="login.php">Accedi qui.</a>
				</h5>
			</center>

		</div>
		
		<?php
		if(isset($_POST['admin_login']))
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			$db_pres = new db($cartella_ini,$messaggi_errore,true);
			
			echo $db_pres->get_stato();
			
			if (!$db_pres->get_stato())
			{
				die;
			}
			$admin_email = $db_pres->pulisci_stringa($_POST['admin_email']);
			$admin_pass = $db_pres->pulisci_stringa($_POST['admin_pass']);
			
			if(isset($_POST['admin_login']))
			{
	
				$sel = "select * from admin where admin_email='$admin_email' AND admin_pass='$admin_pass'";
				$rows = $db_pres->select($sel);
				//$rows = db_select($con,$sel);
				
				if($rows === FALSE)
				{
					echo $db_pres->get_descrizione_stato()."<br>";
					echo "...mentre stavo eseguendo: ".$sel."<br>";
					die;
				}
				
				if(count($rows) == 0)
				{
					echo "<script>alert('e-Mail o password non valide!Prova ancora!')</script>";
					$db_pres->close();
					echo "<script>window.open('admin_login.php','_self')</script>";
					exit();
				} else
				{
					$_SESSION['user_email'] = $admin_email;
					echo "<script>alert('Login effettuato con successo!')</script>";
					echo "<script>window.open('view_users.php','_self')</script>";
				}
			}
		}

/*		if(isset($_POST['admin_login']))
		{
			$admin_email = mysqli_real_escape_string($con,$_POST['admin_email']);
			$admin_pass = mysqli_real_escape_string($con,$_POST['admin_pass']);

			$sel = "select * from admin where admin_email='$admin_email' AND admin_pass='$admin_pass'";
			$run = mysqli_query($con,$sel);
			
			$check = mysqli_num_rows($run);
		
			if($check == 0)
			{
				echo "<script>alert('e-Mail o password non valide! Prova ancora!')</script>";
				exit();
			} else
			{
				$_SESSION['admin_email'] = $admin_email;
				echo "<script>alert('Login effettuato con successo!')</script>";
				echo "<script>window.open('view_users.php','_self')</script>";
			}
		}*/
		?>	
	</body>
</html>
