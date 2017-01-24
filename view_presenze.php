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
		<title>Visualizza le presenze degli atleti</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
 		<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	</head>
	<body>
		<div class="jumbotron">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<h2>Visualizza le presenze di tutti gli atleti</h2>
							<table class="table table-hover " align="center"> <!--col-md-12 col-sm-8-->
								<tr align="left">
									<th>Num</th>
									<!--<th>Foto</th>-->
									<th>Nome</th>
									<th>Cognome</th>
									<th>Classe</th>
									<th>Presenze</th>
									<th>Percentuale</th>
								</tr>
								<?php
																
									$sel = "SELECT 
													    athletes.athl_id,
													    athletes.athl_name,
													    athletes.athl_surname,
													    athletes.athl_class,
													    athletes.athl_image,
													    SUM(athl_presence.athl_pres_presence) AS presenze,
													    SUM(IF(athl_pres_presence = 0
													            OR athl_pres_presence = 1,
													        1,
													        1)) AS totali
													FROM
													    athletes
													        LEFT JOIN
													  	athl_presence ON athl_id = athl_pres_athl_id
													WHERE
													    MONTH(athl_pres_date) = MONTH(CURDATE())
													GROUP BY athletes.athl_surname
													ORDER BY presenze DESC";
													//`j420jvmc_ad-iuva01`.athletes
													//`j420jvmc_ad-iuva01`.athl_presence ON athl_id = athl_pres_athl_id
									
//echo "<script>alert(".$sel.")</script>";
									$run = $db_pres->select_row($sel);
									$i = 0;
									while($row = $run->fetch_array())
									{
										$id = $row['athl_id'];
										$name = $row['athl_name'];
										$surname = $row['athl_surname'];
										$image = $row['athl_image'];
										$class = $row['athl_class'];
										$presenze = $row['presenze'];
										$percentuale = (round(($presenze/$row['totali']),2)*100);
										$i++;
						
								?>
								<tr align="left">
									<td><?php echo $i;?></td>
									<!--<td><img src="images/foto/<?php echo $image;?>" class="img-thumbnail center-block" style="max-width:140px;max-height:70px;"/></td> -->
									<td><?php echo $name;?></td>
									<td><?php echo $surname;?></td>
									<td><?php echo $class;?></td>
									<td><?php echo $presenze;?></td>
									<td>
										<div class="progress">
										  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percentuale;?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;width: <?php echo $percentuale.'%';?>;">
										    <?php echo $percentuale." %";?>
										  </div>
										</div>
									</td>
									<td>
										<div class="btn-group btn-group-xs" role="group">
											<a href="detail_athlete.php?id=<?php echo $id; ?>">
											<button type="button" class="btn btn-default">Dettagli</button>
											</a>
										</div>
										<div class="btn-group btn-group-xs" role="group">
											<a href="export_presenze.php?id=<?php echo $id; ?>">
											<button type="button" class="btn btn-default">Scarica presenze</button>
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