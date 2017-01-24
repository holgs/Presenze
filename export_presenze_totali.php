<?php
header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=export-presenze-totali-'.date('Y-m-d').'.xls');  
include "function_setup.php";
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$db_pres = new db($cartella_ini,$messaggi_errore,true);
$fname = "export-presenze-totali".date("Y-m-d").".csv";
$query = "SELECT 
					    athl_id,
					    athl_name,
					    athl_surname,
					    DATE_FORMAT(athl_pres_date,'%d %b %Y'),
					    if(athl_pres_presence = 1,'presente','assente') as stato
					FROM
					    athletes
					        LEFT JOIN
					    athl_presence ON athl_id = athl_pres_athl_id
					ORDER BY athl_id,athl_pres_date ASC";  
$db_pres->esporta_presenze_csv($fname,$query);
?>