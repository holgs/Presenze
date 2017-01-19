<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$db_pres = new db($cartella_ini,$messaggi_errore,true);
?>
<!DOCTYPE html>


<html lang="en">
	<head>
		<title>Visualizza tutti gli utenti</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
 		<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	</head>
	<body>
		<div class="jumbotron col-md-12 col-sm-12">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<h2>Visualizza tutti gli utenti</h2>
							<table class="table table-hover col-md-12 col-sm-8" align="center">
								<tr align="left">
									<th>Num</th>
									<th>Foto</th>
									<th>Nome</th>
									<th>Cognome</th>
									<th>Telefono</th>
									<th>E-mail</th>
									<th>Password</th>
									<th></th>
								</tr>
								<?php
									$sel = "SELECT * FROM register_user";
									$run = $db_pres->select_row($sel);
									$i = 0;
									while($row = $run->fetch_array())
									{
										$id = $row['user_id'];
										$name = $row['user_name'];
										$surname = $row['user_surname'];
										$email = $row['user_email'];
										$image = $row['user_image'];
										$phone = $row['user_no'];
										$pwd = $row['user_pass'];
										$i++;
						
								?>
								<tr align="left">
									<td><?php echo $i;?></td>
									<td><img src="images/<?php echo $image;?>" class="img-thumbnail center-block" style="max-width:140px;max-height:70px;"/></td>
									<td><?php echo $name;?></td>
									<td><?php echo $surname;?></td>
									<td><?php echo $phone;?></td>
									<td><?php echo $email;?></td>
									<td><?php echo $pwd;?></td>
									<td>
										<div class="btn-group btn-group-xs" role="group">
											<a href="view_users.php?id=<?php echo $id;?>">
											<button type="button" class="btn btn-default">Cancella</button>
											</a>
											<a href="edit_user.php?id=<?php echo $id; ?>">
											<button type="button" class="btn btn-default">Modifca </button>
											</a>
										</div>
									</td>
								</tr>
								<?php } ?>
							</table>
							<div class="page-header text-center">
								<p><a href="new_user.php">Nuovo Utente</a></p>
								<p><a href="logout.php">Logout</a></p>
							</div>
						<div class="page-header text-right">Benvenuto: <?php echo $_SESSION['user_email'];?> - 
							<a href="logout.php">Logout</a>
						</div>
					</div>
				</div>
			</div>		
		</div>
	  <div class="clearfix"></div>
	
			
			<?php
			//DELETE USER
			if(isset($_GET['id']))
			{
				$db_pres->user_delete($_GET['id']);
			}		
			?>
	
	</body>
</html>