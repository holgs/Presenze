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
		<title>Visualizza le gare inserite</title>
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
								<div class="col-md-12">
									<div class="card">
										<div class="card-header" data-background-color="red">
	                  	<h4 class="title">Visualizza le gare</h4>
	                  	<p class="category">Tutte le prossime gare a cui si vuole partecipare </p>
	                  </div>
	                  <div  class="card-content table-responsive">
										<table class="table table-hover " align="center"> 
											<thead class="text-danger" align="left">
												<th>Num</th>
												<th>Nome</th>
												<th>Federazione</th>
												<th>Luogo</th>
												<th>Data</th>
												<th>Termine iscrizione</th>
												<th>Azioni</th>
												<th></th>
											</thead>
											<?php
																			
												$sel = "SELECT *
																FROM gara
																ORDER BY gara_data ASC";
												
												$run = $db_pres->select_row($sel);
												$i = 0;
												while($row = $run->fetch_array())
												{
													$id = $row['gara_id'];
													$name = $row['gara_nome'];
													$luogo = $row['gara_luogo'];
													$data = date_create($row['gara_data']);
													$federazione = $row['gara_federazione'];
													$termine_iscrizione = date_create($row['gara_termine_iscrizione']);
													$i++;
									
											?>
											<tr align="left">
												<td><?php echo $i;?></td>
												<td><b><?php echo $name;?></b></td>
												<td><?php echo $federazione;?></td>
												<td><?php echo $luogo;?></td>
												<td><?php echo date_format($data,'d/m/Y');?></td>
												<td><?php echo date_format($termine_iscrizione,'d/m/Y');?></td>
												<td> 
													<a href="view_gare.php?id=<?php echo $id;?>&delete=1">
														<button type="button" class="btn btn-xs btn-warning pull-right"><i class="material-icons">delete</i></button>
													</a>
												</td>
												<td>
													<a href="detail_gara.php?id=<?php echo $id; ?>">
														<button type="button" class="btn btn-success btn-xs pull-left"><i class="material-icons">info</i></button>
													</a>
												</td>
											</tr>
											<?php } ?>
										</table>
										<a href="new_gara.php?id=<?php echo $id; ?>">
											<button type="button" class="btn btn-success btn-xs pull-left"><i class="material-icons">add</i></button>
										</a>
										</div>
									<footer class="footer">
										<div class="container-fluid">
										<p><a href="<?php echo $_SERVER["HTTP_REFERER"];?>">Indietro</a></p>
										</div>
									</footer>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>	
		</div>
	  <div class="clearfix"></div>
	
			<?php
			//DELETE GARA
			if(isset($_GET['id']) && isset($_GET['delete']))
			{
				$db_pres->gara_delete($_GET['id']);
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