<?php
include "function_setup.php";
//echo $_SERVER['DOCUMENT_ROOT']."Presenze/function_setup.php";
//include $_SERVER['DOCUMENT_ROOT']."Presenze/function_setup.php";
?>

<!DOCTYPE html>
<html lang="en">
<body>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
//$con = connessione($messaggi_errore);
$db_pres = new db($cartella_ini,$messaggi_errore,true);

echo $db_pres->get_stato();

if (!$db_pres->get_stato())
{
	die;
}
	$user_email = $db_pres->pulisci_stringa($_POST['user_email']);
	$user_pass = $db_pres->pulisci_stringa($_POST['user_pass']);

	if(isset($_POST['login']))
		{

			$sel = "select * from register_user where user_email='$user_email' AND user_pass='$user_pass'";
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
				echo "<script>window.open('login.php','_self')</script>";
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
