<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$name = $_SESSION['username'];
$db_pres = new db($cartella_ini,$messaggi_errore,true);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modifica Atleta</title>
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
		              	<h4 class="title">Inserisci un nuovo Atleta</h4>
		              </div>
									<div class="card-content">
									<form action="new_athlete.php" method="post" enctype="multipart/form-data">
										
										<div class="row">
											
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">Name</label>
													<input type="text" class="form-control" name="athl_name" placeholder="Inserisci il nome" required/>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">Cognome</label>
													<input type="text" class="form-control" name="athl_surname" placeholder="Inserisci il cognome" required/>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Sesso</label>
													<select name="athl_gender" class="form-control" placeholder="Inserisci il sesso" required>
														<option>Maschio</option>
														<option>Femmina</option>
													</select>
												</div>
											</div>
											
										</div>
										
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">Data di nascita</label>
													<input type="date" class="form-control" name="athl_b_day" placeholder="Inserisci la data di nascita" />
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">Email></label>
													<input type="text" class="form-control" name="athl_email" placeholder="Inserisci e-mail" />						
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Numero di telefono:</label>
													<input type="text" class="form-control" name="athl_no" placeholder="Inserisci il telefono" required/>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Indirizzo:</label>
													<input type="text" class="form-control" name="athl_address" placeholder="Inserisci l'indirizzo" />
												</div>
											</div>
											
											<div class="col-md-3">											
												<div class="form-group">
													<label class="control-label">Città:</label>
													<input type="text" class="form-control" name="athl_city" placeholder="Inserisci città" />
												</div>
											</div>
											
											<div class="col-md-2">
												<div class="form-group">
													<label class="control-label">Cap:</label>
													<input type="text" class="form-control" name="athl_zip" placeholder="Inserisci il CAP" />
												</div>
											</div>
											
											<div class="col-md-1">
												<div class="form-group">
													<label class="control-label">Provincia:</label>
													<input type="text" class="form-control" name="athl_pr" placeholder="Inserisci provincia" />
												</div>
											</div>
											
										</div>
										
										
										<div class="row">
											<div class="col-md-4">						
												<div class="form-group">
													<label class="control-label">Cintura:</label>
													<select name="athl_ryu_belt" class="form-control" required>
														<option>Bianca</option>
														<option>Gialla</option>
														<option>Arancione</option>
														<option>Verde</option>
														<option>Blu</option>
														<option>Marrone</option>
														<option>Nera - 1° DAN</option>
														<option>Nera - 2° DAN</option>
														<option>Nera - 3° DAN</option>
														<option>Nera - 4° DAN</option>
														<option>Nera - 5° DAN</option>
													</select>
												</div>
											</div>
												
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Data di Ottenimento Cintura</label>
												<input type="date" class="form-control" name="athl_ryu_data" />	
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group"><label class="control-label">Classe</label>
													<select name="athl_class" class="form-control" required="required">
														<option>Bambini</option>
														<option>Ragazzi</option>
														<option>Adulti</option>
													</select>
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
									
										<div class="form-group"><label>Immagine:</label>
											<input class="btn btn-danger pull-right" type="file" name="athl_image" />
										</div> -->
										<input type="file" name="athl_image" class="btn btn-warning pull-left" value="Carica Foto"/>
										<button type="submit" class="btn btn-danger pull-right" name="register" >Inserisci Atleta</button>
	                  <div class="clearfix"></div>
									</form>
									</div>
								</div>
								<!-- SEZIONE LATERALE -->
							</div>
								<div class="col-md-4">
	    						<div class="card card-profile">
	    							<div class="card-avatar">
	    								<a href="#pablo">
	    									<img class="img" src="images/foto/K01.jpg" />
	    								</a>
	    							</div>
	    						</div>
			    			</div>

						</div>
						<!-- MODAL PER CAMBIO IMMAGINE -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Cambia immagine</h4>
									</div>
									
									<div class="modal-body">
										<form action="" method="post" enctype="multipart/form-data">
											<div class="form-group">Seleziona l'immagine e clicca OK<br><br>
												<div class="col-md-6">							
													<input class="btn btn-default" type="file" name="athl_image"/>
												</div>
												<div class="col-md-3 col-md-offset-3">
													<input type="submit" class="form-control btn btn-success" name="update_image" value="OK"/>
												</div>
												<div class="row"></div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
									</div>
							  </div>
						</div>
					</div>
					<!-- FINE MODAL CAMBIO IMMAGINE -->
				</div>
			</div>
				<footer class="footer">
					<div class="container-fluid">
					<p><a href="<?php echo $_SERVER["HTTP_REFERER"];?>">Indietro</a></p>
					</div>
				</footer>
			</div>		
		</div>
		<?php

		if(isset($_POST['register']))
		{
			$db_pres->inserisci_atleta();
		}
		$db_pres->close();
		
		?>

	</body>
	<?php include 'footer.php';?>
</html>
