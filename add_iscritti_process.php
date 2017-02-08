<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$db_pres = new db($cartella_ini,$messaggi_errore,true);

if(isset($_GET['part_id']) && isset($_GET['gara_id']) && isset($_GET['aggiungi']))
			{
				$part_id = $_GET['part_id'];
				$gara_id = $_GET['gara_id'];
				$add = "UPDATE partecipanti SET part_status='ISCRITTO' WHERE part_athl_id = $part_id AND part_gara_id = $gara_id";
				$db_pres->insert($add);
				
				$partecipanti_esito = "INSERT INTO risultati (risult_athl_id,risult_gara_id)
											SELECT part_athl_id,$gara_id
											FROM partecipanti
											WHERE part_status = 'ISCRITTO' AND part_athl_id = $part_id
											";		
				$run_insert = $db_pres->insert($partecipanti_esito);
				
				echo "<script>window.open('add_iscritti.php?gara_id=".$gara_id."&ordina=athl_name&come=ASC','_self');</script>";
			}	
				
if(isset($_GET['part_id']) && isset($_GET['gara_id']) && isset($_GET['rimuovi']))
			{
				$part_id = $_GET['part_id'];
				$gara_id = $_GET['gara_id'];
				$remove = "UPDATE partecipanti SET part_status='' WHERE part_athl_id = $part_id AND part_gara_id = $gara_id";
				$db_pres->delete($remove);
				echo "<script>window.open('add_iscritti.php?gara_id=".$gara_id."&ordina=athl_name&come=ASC','_self');</script>";
			}		
//				$add = "INSERT INTO partecipanti (part_gara_id,part_athl_id,part_status) VALUES ('".$gara_id."','".$part_id."','ISCRITTO')";
//				echo "<script>alert('Atleta inserito');</script>";
//				echo "<script>alert('Gara : ".$gara_id."');</script>";
//				echo "<script>alert('Partecipante : ".$part_id."');</script>";
//				$remove = "DELETE FROM `partecipanti` WHERE `part_gara_id` = $gara_id AND `part_athl_id` = $part_id";
//				echo "<script>alert('Atleta rimosso');</script>";

?>