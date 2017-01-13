<?php
//echo $_SERVER['DOCUMENT_ROOT']."Presenze/function_setup.php";
//include $_SERVER['DOCUMENT_ROOT']."Presenze/function_setup.php";
include "function_setup.php";
?>

<!DOCTYPE html>
<html lang="en">
<body>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$con = connessione($messaggi_errore);
	
	$user_email = pulisci_stringa($con,$_POST['user_email']);
	$user_pass = pulisci_stringa($con,$_POST['user_pass']);
	
	if(isset($_POST['login']))
		{

			$sel = "select * from register_user where user_email='$user_email' AND user_pass='$user_pass'";
			$rows = db_select($con,$sel);
			
			if(count($rows) == 0)
			{
				echo "<script>alert('e-Mail o password non valide!Prova ancora!')</script>";
				db_close();
				exit();
			} else
			{
				$_SESSION['user_email'] = $user_email;
				echo "<script>alert('Login effettuato con successo!')</script>";
				echo "<script>window.open('index_home.php','_self')</script>";
			}
		}
}
?>	
</body>
</html>
