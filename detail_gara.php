<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
} else if(isset($_GET['id']))
	{
		$db_pres = new db($cartella_ini,$messaggi_errore,true);
		
		$edit_id = $_GET['id'];
		$sel = "SELECT * FROM gara WHERE gara_id='$edit_id'";
		//DATE_FORMAT(athl_b_day, '%d/%m/%Y')as athl_b_day 
		$run = $db_pres->select_row($sel);
		$row = $run->fetch_array();
				
		$id = $row['gara_id'];
		$nome = $row['gara_nome'];
		$federazione = $row['gara_federazione'];
		$data = date_create($row['gara_data']);
		$luogo = $row['gara_luogo'];
		$termine_iscrizione = date_create($row['gara_termine_iscrizione']);	
		$referente = $row['gara_referente'];
		$email = $row['gara_email'];
		$telefono = $row['gara_telefono'];
		$indirizzo = $row['gara_indirizzo'];
		$cap = $row['gara_cap'];
		$pr = $row['gara_pr'];
		$orario = $row['gara_orario'];	
		$quota = $row['gara_quota'];

	}
?>
<!DOCTYPE html>

<html>
	<head>
		<title>Dettagli della gara</title>
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
	             <div class="col-md-8">
	             	<div class="card">
					        <div class="card-header" data-background-color="red">
		              	<h4 class="title">Dettagli Gara: <b><?php echo $nome.' '.$federazione ;?></b></h4>
		              </div>
									<div class="card-content">
									<form action="#" method="post" enctype="multipart/form-data">
										<!-- RIGA 1 -->
										<div class="row">	
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Name Evento</label>
													<input type="text" class="form-control" name="gara_nome" value="<?php echo $nome ;?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-2">
												<div class="form-group">
													<label class="control-label">Data della Gara</label>
													<input type="text" class="form-control" name="gara_data" value="<?php echo date_format($data,'d/m/Y') ;?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Federazione</label>
													<input type="text" class="form-control" name="gara_federazione" value="<?php echo $federazione ;?>" disabled/>
												</div>
											</div>
										</div>
										<!-- RIGA 2 -->
										<div class="row">
											<div class="col-md-4">						
												<div class="form-group">
													<label class="control-label">Referente:</label>
													<input type="text" class="form-control" name="gara_referente" value="<?php echo $referente; ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Numero di telefono:</label>
													<input type="text" class="form-control" name="gara_telefono" value="<?php echo $telefono; ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Email</label>
													<input type="text" class="form-control" name="gara_email" value="<?php echo $email ;?>" disabled/>						
												</div>
											</div>

										</div>
										
										<!-- RIGA 3 -->
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">Indirizzo:</label>
													<input type="text" class="form-control" name="gara_indirizzo" value="<?php echo $indirizzo; ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-4">											
												<div class="form-group">
													<label class="control-label">Città:</label>
													<input type="text" class="form-control" name="gara_luogo" value="<?php echo $luogo; ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-2">
												<div class="form-group">
													<label class="control-label">Cap:</label>
													<input type="text" class="form-control" name="gara_cap" value="<?php echo $cap; ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-1">
												<div class="form-group">
													<label class="control-label">Pr:</label>
													<input type="text" class="form-control" name="gara_pr" value="<?php echo $pr; ?>" disabled/>
												</div>
											</div>
											
										</div>
										
										<!-- RIGA 4 -->
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Data di Termine Iscrizione</label>
												<input type="text" class="form-control" name="gara_termine_iscrizione" value="<?php echo date_format($termine_iscrizione,'d/m/Y') ;?>" disabled/>	
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group"><label class="control-label">Orario inizio gara</label>
													<input type="time" class="form-control" name="gara_orario" value="<?php echo $orario ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group"><label class="control-label">Quota di iscrizione</label>
													<input type="text" class="form-control" name="gara_quota" value="<?php echo $quota." euro" ?>" disabled/>
												</div>
											</div>
											
										</div>
										
									<!--		<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<label class="control-label">Cambia immagine</label>
												<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Cambia immagine</button>
												</div>
											</div>
										</div>
							
										<div class="row">
										<div class="form-group col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-sx-8 ">
											<input type="submit" class=" btn btn-danger btn-block" name="update" value="Aggiorna!"/>
										</div>
									</div>
								
										<button type="submit" class="btn btn-danger pull-right" name="update" >Aggiorna Profilo</button>
	                  <button type="submit" class="btn btn-danger pull-left" data-toggle="modal" data-target="#myModal">Aggiorna Immagine</button>
	                  <div class="clearfix"></div>
	                  	-->
									</form>
									</div>
								</div>
								<!-- SEZIONE LATERALE -->
							</div>
								<div class="col-md-4">
									<div class="row">
		    						<div class="card card-profile">
		    							<div class="card-avatar">
		    								<a href="#pablo">
		    									<img class="img" src="images/foto/K01.jpg" />
		    								</a>
		    							</div>
		
		    							<div class="content">
		    								<h6 class="category text-gray"><?php echo $federazione;?></h6>
		    								<h4 class="card-title"><?php echo $nome;?></h4>
		    								<p class="card-content">
													Qualcosa sulla gara</p>
		    							</div>
	    							</div>
	    						</div>
	    						
	    						<div class="row">
	    							<div class="card">
	    								<div class="card-header" data-background-color="red">
												<h4 class="title">Iscritti</h4>
												<p class="category">Sono iscritti alla gara
													<?php
													$iscritti = "SELECT COUNT(part_athl_id) AS iscritti FROM partecipanti WHERE part_gara_id = $id AND part_status = 'ISCRITTO'";
													$run = $db_pres->select_row($iscritti);
													while($row = $run->fetch_array())
													{
														$atleti_iscritti = $row['iscritti'];
													}
													echo $atleti_iscritti;
													?> atleti
													</p>
											</div>
		    							<div class="card-content table-responsive">
		    									<table class="table table-hover">
		    										<thead class="text-danger">
		    											<th>Medaglie</th>
		    											<th>Numeri</th>
		    										</thead>
		    										<tbody>
		    											<?php 
		    												$totale = 0;
		    												$sel = "SELECT risult_esito, count(risult_esito) AS risultato 
		    																FROM risultati risult_esito 
		    																WHERE risult_gara_id = $id
		    																GROUP BY risult_esito  
																				ORDER BY risult_esito ASC";
																$run = $db_pres->select_row($sel);
																while($row = $run->fetch_array())
																{
																	$classifica = $row['risult_esito'];
																	$conteggio = $row['risultato'];
																	if($classifica !="nc")
																	{
																		$totale +=$conteggio;
					    											echo "<tr>
					    													<td> $classifica</td>
					    													<td> $conteggio</td>
					    												</tr>";
					    											 }
																} ?>
		    										</tbody>
		    									</table>
		    							</div>
		    							<div class="card-footer">
												<div class="stats">
													<i class="material-icons text-danger">add</i> <a href="add_iscritti.php?ordina=athl_name&come=ASC&gara_id=<?php echo $id;?>">Aggiungi iscritti</a>
												</div>
												<div class="stats">
													<i class="material-icons text-danger">print</i> <a href="export_iscritti.php?ordina=athl_name&come=ASC&gara_id=<?php echo $id;?>">Esporta iscritti</a>
												</div>
												<div class="stats">
													<i class="material-icons text-danger">add_box</i> <a href="esito_gara.php?ordina=athl_name&come=ASC&gara_id=<?php echo $id;?>">Inserisci risultati</a>
												</div>
		    						</div>
		    					</div>
			    			</div>

						</div>
				</div>
			</div>
				<footer class="footer">
					<div class="container-fluid">
					<p><a href="<?php echo $_SERVER["HTTP_REFERER"];?>">Indietro</a></p>
					</div>
				</footer>
			</div>		
		</div>

	</body>
	<?php include 'footer.php';?>
</html>
