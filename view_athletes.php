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
		<title>Visualizza tutti gli atleti</title>
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
									<th>Data di nascita</th>
									<th>E-mail</th>
									<th>Telefono</th>
									<th>Classe</th>
									<th>Cintura</th>
									<th></th>
								</tr>
								<?php
									$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id";
									$run = $db_pres->select_row($sel);
									$i = 0;
									while($row = $run->fetch_array())
									{
										$id = $row['athl_id'];
										$name = $row['athl_name'];
										$surname = $row['athl_surname'];
										$email = $row['athl_email'];
										$b_day = date_create($row['athl_b_day']);
										$image = $row['athl_image'];
										$phone = $row['athl_no'];
										$class = $row['athl_class'];
										$belt = $row['athl_ryu_belt'];
										$ryu_id = $row['athl_ryu_athl_id'];
										$i++;
						
								?>
								<tr align="left">
									<td><?php echo $i;?></td>
									<td><img src="images/foto/<?php echo $image;?>" class="img-thumbnail center-block" style="max-width:140px;max-height:70px;"/></td>
									<td><?php echo $name;?></td>
									<td><?php echo $surname;?></td>
									<td><?php echo date_format($b_day,'d/m/Y');?></td>
									<td><?php echo $email;?></td>
									<td><?php echo $phone;?></td>
									<td><?php echo $class;?></td>
									<td><?php echo $belt;?></td>
									<td>
										<div class="btn-group btn-group-xs" role="group">
											<a href="view_athletes.php?id=<?php echo $id;?>&ryu_id=<?php echo $ryu_id?>">
											<button type="button" class="btn btn-default">Cancella</button>
											</a>
											<a href="edit_athlete.php?id=<?php echo $id; ?>">
											<button type="button" class="btn btn-default">Modifca</button>
											</a>
											<a href="detail_athlete.php?id=<?php echo $id; ?>">
											<button type="button" class="btn btn-default">Dettagli</button>
											</a>
										</div>
									</td>
								</tr>
								<?php } ?>
							</table>
							<div class="page-header text-center">
								<p><a href="index_home.php">Indietro</a></p>
							</div>
						<div class="page-header text-right">Benvenuto: <?php echo $_SESSION['user_email']." - ".$_SESSION['username'];?> - 
							<a href="index_home.php">Home</a> - <a href="logout.php">Logout</a>
						</div>
					</div>
				</div>
			</div>		
		</div>
	  <div class="clearfix"></div>
	
			
			<?php
			//DELETE USER
			if(isset($_GET['id']) && isset($_GET['ryu_id']))
			{
				$db_pres->athlete_delete($_GET['id'],$_GET['ryu_id']);
			}		
			?>
			
			<?php
			//INSERISCI PRESENZA
			if(isset($_GET['id']) && isset($_GET['presence']))
			{
				$get_id = $_GET['id'];
				$run_presence = $db_pres->athlete_presence($_GET['id']);
			}
			$db_pres->close();
			
			?>
	
	</body>
</html>