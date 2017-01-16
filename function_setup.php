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
	return mysqli_real_escape_string($con, $stringa);
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
//	while($row = mysqli_fetch_assoc($risultato))
	while($row = mysqli_fetch_array($risultato))
	{
		$rows[] = $row; 
	}
	//print_r($rows);
	return $rows;
}

function db_select_row($con,$select)
{
	$run = mysqli_query($con, $select);
	
	if($run === FALSE) //QUERY NON ESEGUITA
	{
		echo "Attenzione problemi con il server DB"."<br>";
		echo mysqli_sqlstate($con)."<br>";
		echo mysqli_errno($con)."<br>";
		echo mysqli_error($con);
		die;		
	}
	return $run;
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

function athlete_delete($con,$get_id,$get_ryu_id)
{
	$delete = "DELETE FROM athletes WHERE athl_id='$get_id'";
	$run_delete = mysqli_query($con,$delete);
		
	$delete_belt ="DELETE FROM athletes_ryu WHERE athl_ryu_athl_id='$get_ryu_id'";
	$run_ryu_delete = mysqli_query($con,$delete_belt);

	if($run_delete && $run_ryu_delete)
	{
		echo "<script>alert('Atleta cancellato con successo')</script>";
		echo "<script>window.open('view_athletes.php','_self')</script>";
	}
}

function athlete_presence($con,$get_id,$get_presence)
{
	$presence = "INSERT INTO athl_presence (athl_pres_athl_id,athl_pres_date,athl_pres_presence) VALUES ('$get_id',NOW(),'$get_presence')";
	$run_presence = db_insert($con,$presence);
	
	if($run_presence)
		{
			//echo "<script>alert('Presenza inserita con successo')</script>";
			//echo "<script>window.open('view_athletes.php','_self')</script>";
		}
		
}

function athlete_extract(){}

function valuta_presenza($con,$edit_id)
{
	$presence = "SELECT * FROM athl_presence WHERE athl_pres_athl_id = $edit_id ORDER BY athl_pres_date";
	$run = db_select_row($con, $presence);
	while($row = mysqli_fetch_array($run)){
	$pres_date = $row['athl_pres_date'];
	if($row['athl_pres_presence']==1)
	{
		$pres = "Presente";
	} else {
		$pres = "Assente";
	}
		echo $pres_date.": ".$pres."<br>";
	}
}

function inserisci_atleta($con)
{
	$athl_name = pulisci_stringa($con,$_POST['athl_name']);
	$athl_surname = pulisci_stringa($con,$_POST['athl_surname']);
	$athl_address = pulisci_stringa($con,$_POST['athl_address']);
	$athl_city = pulisci_stringa($con,$_POST['athl_city']);
	$athl_zip = pulisci_stringa($con,$_POST['athl_zip']);
	$athl_pr = pulisci_stringa($con,$_POST['athl_pr']);
	$athl_b_day = pulisci_stringa($con,$_POST['athl_b_day']);
	$athl_no = pulisci_stringa($con,$_POST['athl_no']);
	$athl_email = pulisci_stringa($con,$_POST['athl_email']);
	$athl_gender = pulisci_stringa($con,$_POST['athl_gender']);
	$athl_ryu_belt = pulisci_stringa($con,$_POST['athl_ryu_belt']);

	$athl_image = $_FILES['athl_image']['name'];
	$athl_tmp = $_FILES['athl_image']['tmp_name'];

	if($athl_address =='' OR $athl_image =='' OR $athl_gender='')
	{
		echo "<script>alert('Compila tutti i campi!')</script>";
		exit();
	}

	if(!filter_var($athl_email,FILTER_VALIDATE_EMAIL))
	{
		echo "<script>alert('La tua email non è valida!')</script>";
		exit();
	}
	
	move_uploaded_file($athl_tmp,"images/$athl_image");
	
	// QUERY INSERIMENTO ATLETA
	$insert = "INSERT INTO athletes 
	(athl_name,athl_surname,athl_email,athl_address,athl_zip,athl_city,athl_pr,athl_gender,athl_b_day,athl_no,athl_image,athl_register_date) 
	VALUES ('$athl_name','$athl_surname','$athl_email','$athl_address','$athl_zip','$athl_city','$athl_pr','$athl_gender','$athl_b_day','$athl_no','$athl_image',NOW())";
	$run_insert = db_insert($con,$insert);
	
	// QUERY DI OTTENIMENTO ATHL_ID APPENA INSERITO
	$get_athl_id = "SELECT athl_id FROM athletes ORDER BY athl_id DESC LIMIT 1";
	$athl_result = mysqli_query($con,$get_athl_id);
	$athl_row = mysqli_fetch_row($athl_result);
	$athl_id = $athl_row[0];
	
	// QUERY DI INSERIMENTO CINTURA
	$insert_belt = "INSERT INTO athletes_ryu (athl_ryu_athl_id,athl_ryu_belt,athl_ryu_data) VALUES ('$athl_id','$athl_ryu_belt',NOW())";
	$run_insert_belt = db_insert($con,$insert_belt);
	
	// VERIFICA CORRETTO INSERIMENTO ATLETA e CINTURA
	if($run_insert && $run_insert_belt)
	{
		echo "<script>alert('Atleta inserito con successo!')</script>";
		echo "<script>window.open('index_home.php','_self')</script>";
	}
}

function aggiorna_atleta($con,$edit_id)
{
	$athl_name = pulisci_stringa($con,$_POST['athl_name']);
	$athl_surname = pulisci_stringa($con,$_POST['athl_surname']);
	$athl_b_day =pulisci_stringa($con,$_POST['athl_b_day']);
	$athl_email = pulisci_stringa($con,$_POST['athl_email']);
	$athl_no = pulisci_stringa($con,$_POST['athl_no']);
	$athl_address = pulisci_stringa($con,$_POST['athl_address']);
	$athl_city = pulisci_stringa($con,$_POST['athl_city']);
	$athl_zip = pulisci_stringa($con,$_POST['athl_zip']);
	$athl_pr = pulisci_stringa($con,$_POST['athl_pr']);
	$athl_ryu_belt = pulisci_stringa($con,$_POST['athl_ryu_belt']);
	$athl_ryu_data = pulisci_stringa($con,$_POST['athl_ryu_data']);

	if(!filter_var($athl_email,FILTER_VALIDATE_EMAIL))
	{
		echo "<script>alert('L'indirizzo email non è valido!')</script>";
		exit();
	}
	$fmt ="'%d/%m/%Y'";
	$update = "UPDATE athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id
					SET athl_name='$athl_name',
					athl_surname='$athl_surname',
					athl_b_day=STR_TO_DATE('$athl_b_day',$fmt),
					athl_email='$athl_email',
					athl_no='$athl_no',
					athl_address='$athl_address',
					athl_city='$athl_city',
					athl_zip='$athl_zip',
					athl_pr='$athl_pr',
					athl_ryu_belt='$athl_ryu_belt',
					athl_ryu_data=STR_TO_DATE('$athl_ryu_data',$fmt)
					WHERE athl_id='$edit_id'";
	
	$run_update = mysqli_query($con,$update);
	
		if($run_update)
		{
			echo "<script>alert('Aggiornamento completato con successo')</script>";
			echo "<script>window.open('view_athletes.php','_self')</script>";

		} else {
			echo "<script>alert('Aggiornamento non effettuato')</script>";
		}
}

function aggiorna_immagine($con,$edit_id)
{
	$athl_image = $_FILES['athl_image']['name'];
	$athl_tmp = $_FILES['athl_image']['tmp_name'];
	
	move_uploaded_file($athl_tmp,"images/$athl_image");
	
	$update_image ="UPDATE athletes SET athl_image='$athl_image' WHERE athl_id='$edit_id'";
	
	$run_update_image = mysqli_query($con,$update_image);
	if($run_update_image)
	{
		echo"<script>alert('Aggiornamento immagine completato con successo')</script>";
		echo "<script>window.open('view_athletes.php','_self')</script>";

	} else {
			echo "<script>alert('Aggiornamento non effettuato')</script>";
	}
}
?>