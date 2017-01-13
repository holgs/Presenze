<?php
include "setup.php";
//include($_SERVER['DOCUMENT_ROOT']."/setup.php");

//FUNZIONE DI CONNESSIONE A DB mySQL
function connessione($messaggi_errore)
{
	global $cartella_ini;

	//RECUPERO CREDENZIALI DA FILE ESTERNO DB.INI
	$access_data = parse_ini_file("ini/db.ini");
	
	//CONNESSIONE AL SERVER
	$con = mysqli_connect($access_data['server'],$access_data['username'],$access_data['password']);
	
	//GESTIONE ERRORI
	if(!$con)
	{
		echo $messaggi_errore['connessione_fallita'];
		die;
	}
	
	//SELEZIONE DB CON CUI LAVORARE E GESTIONE EVENTUALI ERRORI
	if(!@mysqli_select_db($con,$access_data['db']))
	{
		echo $messaggi_errore['db_non_trovato']."<br>";
		echo mysqli_sqlstate($con)."<br>";
		echo mysqli_errno($con)."<br>";
		echo mysqli_error($con)."<br>";
		die;
	}
	return $con;
}

//FUNZIONE DI PULIZIA CARATTERI NON DESIDERATI
function pulisci_stringa($con,$stringa)
{
	return mysqli_escape_string($con, $stringa);
}

//FUNZIONE DI ESECUZIONE SELECT E GESTIONE ERRORE
function db_select($con,$select)
{
	$risultato = mysqli_query($con, $select);
	
	if($risultato === FALSE) //QUERY NON ESEGUITA
	{
		echo "Attenzione problemi con il server DB"."<br>";
		echo mysqli_sqlstate($con)."<br>";
		echo mysqli_errno($con)."<br>";
		echo mysqli_error($con);
		die;		
	}
	$rows = array();
	while($row = mysqli_fetch_assoc($risultato))
	{
		$rows[] = $row; 
	}
	return $rows;
}

function db_insert($con,$comandoSQL)
{
	$esito = mysqli_query($con, $comandoSQL);
	if($esito)
	{
		return mysqli_insert_id($con);
	} else 
	{
			return FALSE;
	}
}

function db_close($con)
{
	mysqli_close($con);
}
?>