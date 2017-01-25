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
	<?php include 'header_head.php';?>
	</head>
	<body>
		<div class="wrapper">
		<?php include 'sidebar.php';?>  
			<div class="main-panel">
				<?php include 'header.php';?>
				<div class="content">
					<div class="container-fluid">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<h2>Visualizza le presenze di tutti gli atleti</h2>
										<table class="table table-hover " align="center"> 
											<tr align="left">
												<th>Num</th>
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
				<footer class="footer">
					<div class="container-fluid">
					<p><a href="index_home.php">Indietro</a></p>
					</div>
				</footer>
								</div>
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
	<?php include 'footer.php';?>
</html>