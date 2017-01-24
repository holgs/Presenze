<?php
header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=export-'.date('Y-m-d-').'.xls');  
include "function_setup.php";
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$db_pres = new db($cartella_ini,$messaggi_errore,true);
$fname = "export-".date("Y-m-d").".csv";
$query = "SELECT 
					    athl_id,
					    athl_name,
					    athl_surname,
					    athl_address,
					    athl_city,
					    athl_pr,
					    athl_no,
					    athl_email,
					    athl_class,
					    athl_belt,
					    athl_b_day
					FROM
					    athletes
					        LEFT JOIN
					    athletes_ryu ON athl_id = athl_ryu_athl_id
					ORDER BY athl_ryu_nbelt ASC";  
$db_pres->esporta_csv($fname,$query);
?>
