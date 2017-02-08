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
		<title>Inserisci una nuova gara</title>
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
		              	<h4 class="title">Inserisci una nuova gara</h4>
		              </div>
									<div class="card-content">
									<form action="new_gara.php" method="post" enctype="multipart/form-data">
									<!-- RIGA 1 -->	
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Nome Evento</label>
													<input type="text" class="form-control" name="gara_nome" placeholder="Inserisci il nome dell'evento" required/>
												</div>
											</div>
											
											<div class="col-md-2">
												<div class="form-group">
													<label class="control-label">Data della gara</label>
													<input type="date" class="form-control" name="gara_data" placeholder="Inserisci il nome dell'evento" required/>
												</div>
											</div>
																						
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Federazione</label>
													<select name="gara_federazione" class="form-control" placeholder="Inserisci la Federazione" required>
														<option>FESIK</option>
														<option>FIKTA</option>
													</select>
												</div>
											</div>
										</div>
									<!-- RIGA 2 -->											
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Referente</label>
													<input type="text" class="form-control" name="gara_referente" placeholder="Inserisci il referente" />						
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Numero di telefono:</label>
													<input type="text" class="form-control" name="gara_telefono" placeholder="Inserisci il telefono" required/>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">e-Mail:</label>
													<input type="text" class="form-control" name="gara_email" placeholder="Inserisci e-mail" required/>
												</div>
											</div>
										</div>
										<!-- RIGA 3 -->	
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">Indirizzo:</label>
													<input type="text" class="form-control" name="gara_indirizzo" placeholder="Inserisci l'indirizzo" />
												</div>
											</div>
											
											<div class="col-md-4">											
												<div class="form-group">
													<label class="control-label">Città:</label>
													<input type="text" class="form-control" name="gara_luogo" placeholder="Inserisci città" />
												</div>
											</div>
											
											<div class="col-md-2">
												<div class="form-group">
													<label class="control-label">Cap:</label>
													<input type="text" class="form-control" name="gara_cap" placeholder="Inserisci il CAP" />
												</div>
											</div>
											
											<div class="col-md-1">
												<div class="form-group">
													<label class="control-label">PR:</label>
													<input type="text" class="form-control" name="gara_pr" placeholder="..." />
												</div>
											</div>
										</div>
										<!-- RIGA 4 -->		
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Date termine di iscrizione alla gara</label>
													<input type="date" class="form-control" name="gara_termine_iscrizione" placeholder="Inserisci la data dell'evento" />
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Ora di inizio gara</label>
													<input type="time" class="form-control" name="gara_orario" placeholder="Inserisci l'orario di inzio gara" />
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Quota di iscrizione alla gara</label>
													<input type="text" class="form-control" name="gara_quota" placeholder="Inserisci il costo di partecipazione" />
												</div>
											</div>
											
										</div>
										

										<button type="submit" class="btn btn-danger pull-right" name="register" >Inserisci Gara</button>
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
			$db_pres->inserisci_gara();
		}
		$db_pres->close();
		
		?>

	</body>
	<?php include 'footer.php';?>
</html>
