<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$db_pres = new db($cartella_ini,$messaggi_errore,true);

if(isset($_GET['part_id']) && isset($_GET['gara_id']) && isset($_GET['esito']))
			{
				$part_id = $_GET['part_id'];
				$gara_id = $_GET['gara_id'];
				$esito = $_GET['esito'];
				$risultati = "UPDATE risultati SET risult_esito = '$esito' WHERE risult_athl_id = $part_id AND risult_gara_id=$gara_id";
				echo "<script>alert('".$risultati."')</script>";
				$db_pres->insert($risultati);
				echo "<script>window.open('esito_gara.php?gara_id=".$gara_id."&ordina=athl_name&come=ASC','_self');</script>";
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