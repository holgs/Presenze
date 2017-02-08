<?php
include "setup.php";
//include($_SERVER['DOCUMENT_ROOT']."/setup.php");
//include '../php/ext/SimpleImage.php';

//CLASSE DB
class db
{
	private
	$db,								// oggetto database che verrà istanziato a partire dalla classe mysqli.
	$con,								//riferimento alla connessione
	$cartella_ini,			//posizione file ini
	$messaggi_errore,		//array associativo con i messaggi di errore
	$access_data,				//credenziali lette da .ini
	$stato,							//esito (true o false) dopo creazione oggetto o dopo aver tentato invio comando a mySQL
	$descrizione_stato,	//il messaggio di errore eventualmente da stampare
	$stampa_errori,			//true o false
	$br ="<br>";
	
	public function get_stato()
	{
		return $this->stato;
	}
	
	public function get_descrizione_stato()
	{
		return $this->descrizione_stato;
	}
	
	public function __construct($cartella_ini,$messaggi_errore,$stampa_errori=TRUE)
	{
		//recupero credenziali da file ESTERNO alla cartella pubblica del sito
		$this->access_data = parse_ini_file($cartella_ini.'/db.ini');
		
		//copio riferimento all'array con i messaggi di errore
		$this->messaggi_errore = $messaggi_errore;
		
		//devono essere stampati gli errori o solo memorizzati nella descrizione stato?
		$this->stampa_errori = $stampa_errori;
		
		$this->connessione();
		if($this->stato)
		{
			$this->scelta_data_base();
			if(!$this->stato)
			{
				$this->close();
			}
		}
	}
	
	private function connessione()
	{
		$this->db = @new mysqli($this->access_data['server'],
														$this->access_data['username'],
														$this->access_data['password']);
		//$this->db = @new mysqli(localhost,j420jvmc_shotoka,nsVBnhoWdB8mLa);
		//DEBUG
		if($this->db->connect_error)
		{
			$this->stato = FALSE;
			$this->descrizione_stato = $this->messaggi_errore['connessione_fallita'];
			
			if($this->stampa_errori)
			{
				echo $this->messaggi_errore['connessione_fallita'].$this->br;
			}
		}
		else 
		{
			$this->stato = TRUE;
		}
	}
	
	private function scelta_data_base()
	{
		if(!@$this->db->select_db($this->access_data['db']))
		{
			$this->stato = FALSE;
			$this->descrizione_stato = $this->messaggi_errore['db_non_trovato'];
			if($this->stampa_errori)
			{
				echo $this->messaggi_errore['db_non_trovato'].$this->br;
			}
		}
		else
		{
			$this->stato = TRUE;
		}
	}
	
	public function pulisci_stringa($stringa)
	{
			return $this->db->real_escape_string($stringa);
	}

	public function delete($sql)
	{
		$risultato_query = $this->db->query($sql);
		
		if($risultato_query === FALSE)
		{
			$this->stato = FALSE;
			$this->descrizione_stato = $this->messaggi_errore['problema_con_server'];
			if($this->stampa_errori)
			{
				echo $this->messaggi_errore['problame_con_server'].$this->br;
			}
			return FALSE;
		}
		else 
		{
			$this->stato = TRUE;
		}
	}

	
	public function select($sql)
	{
		$risultato_query = $this->db->query($sql);
		
		if($risultato_query === FALSE)
		{
			$this->stato = FALSE;
			$this->descrizione_stato = $this->messaggi_errore['problema_con_server'];
			if($this->stampa_errori)
			{
				echo $this->messaggi_errore['problame_con_server'].$this->br;
			}
			return FALSE;
		}
		else 
		{
			$this->stato = TRUE;
			
			$righe_estratte = array();
			while($riga = $risultato_query->fetch_assoc())
			{
				$righe_estratte[] = $riga;
			}
			return $righe_estratte;
		}
	}
	
	public function close()
	{
		$this->db->close();
	}
	
	public function insert($sql)
	{
		$esito = $this->db->query($sql);
		if($esito)
		{
			$this->stato = TRUE;
			return $this->db->insert_id;
		}
		else 
		{
			$this->stato = FALSE;
			$this->descrizione_stato = $this->messaggi_errore['problema_con_server'];
			if($this->stampa_errori)
			{
				echo $this->messaggi_errore['problema_con_server']." :<br> ".$sql.$this->br;
			}
			return FALSE;
		}
	}

	public function athlete_delete($get_id,$get_ryu_id)
	{
		$get_image_name_sql = "SELECT * FROM athletes WHERE athl_id='$get_id'";
		$risultato = $this->select_row($get_image_name_sql);
		$row = $risultato->fetch_array();
		
		$get_image_name = $row['athl_image'];
		echo "<script>alert('File da cancellare ".$get_image_name."')</script>";
		
		unlink('images/foto/'.$get_image_name);
		
		$delete = "DELETE FROM athletes WHERE athl_id='$get_id'";
		$run_delete = $this->db->query($delete);
			
		$delete_belt ="DELETE FROM athletes_ryu WHERE athl_ryu_athl_id='$get_ryu_id'";
		$run_ryu_delete = $this->db->query($delete_belt);
	
		if($run_delete && $run_ryu_delete)
		{
			$this->stato = TRUE;
			echo "<script>alert('Atleta cancellato con successo')</script>";
			echo "<script>window.open('view_athletes.php','_self')</script>";
			return $this->db->insert_id;
		}
	}

	public function user_delete($get_id)
	{
		$delete = "DELETE FROM register_user WHERE user_id='$get_id'";
		$run_delete = $this->db->query($delete);
	
		if($run_delete)
		{
			$this->stato = TRUE;
			echo "<script>alert('Utente cancellato con successo')</script>";
			echo "<script>window.open('view_users.php','_self')</script>";
			return $this->db->insert_id;
		}
	}

	public function athlete_presence($get_id,$get_presence)
	{
		$presence = "INSERT INTO athl_presence (athl_pres_athl_id,athl_pres_date,athl_pres_presence) VALUES ('$get_id',NOW(),'$get_presence')";
		$run_presence = $this->insert($presence);
		
		//$esito = $this->db->query($sql);
		//if($esito)
		if($run_presence)
		{
			$this->stato = TRUE;
			return $this->db->insert_id;
		}
	}
	
	public function assegna_cintura($belt)
	{
		$n_cintura = 0;
		switch ($belt) {
			case 'Bianca':
				$n_cintura = 1;
				break;
			case 'Gialla':
				$n_cintura = 2;
				break;
			case 'Arancione':
				$n_cintura = 3;
				break;
			case 'Verde':
				$n_cintura = 4;
				break;
			case 'Blu':
				$n_cintura = 5;
				break;
			case 'Marrone':
				$n_cintura = 6;
				break;
			case 'Nera - 1° DAN':
				$n_cintura = 7;
				break;
			case 'Nera - 2° DAN':
				$n_cintura = 8;
				break;
			case 'Nera - 3° DAN':
				$n_cintura = 9;
				break;
			case 'Nera - 4° DAN':
				$n_cintura = 10;
				break;
			case 'Nera - 5° DAN':
				$n_cintura = 11;
				break;							
			default:
				echo "<script>alert('CINTURA NON CONVERTITA')</script>";
				break;
		}
	return $n_cintura;
	}

	
	
	public function inserisci_atleta()
	{
		$athl_name = $this->pulisci_stringa($_POST['athl_name']);
		$athl_surname = $this->pulisci_stringa($_POST['athl_surname']);
		$athl_address = $this->pulisci_stringa($_POST['athl_address']);
		$athl_city = $this->pulisci_stringa($_POST['athl_city']);
		$athl_zip = $this->pulisci_stringa($_POST['athl_zip']);
		$athl_pr = $this->pulisci_stringa($_POST['athl_pr']);
		$athl_b_day = $this->pulisci_stringa($_POST['athl_b_day']);
		$athl_no = $this->pulisci_stringa($_POST['athl_no']);
		$athl_email = $this->pulisci_stringa($_POST['athl_email']);
		$athl_gender = $this->pulisci_stringa($_POST['athl_gender']);
		$athl_class = $this->pulisci_stringa($_POST['athl_class']);
		$athl_ryu_belt = $this->pulisci_stringa($_POST['athl_ryu_belt']);
		$athl_ryu_nbelt = $this->assegna_cintura($athl_ryu_belt);
		
		$athl_image = $_FILES['athl_image']['name'];
		$athl_tmp = $_FILES['athl_image']['tmp_name'];
		$athl_image = $this->inserisci_img($_FILES['athl_image']['name'],$_FILES['athl_image']['tmp_name'],$_FILES['athl_image']['size']);
	
		/*if($athl_address =='' OR $athl_image =='' OR $athl_gender='')
		{
			echo "<script>alert('Compila tutti i campi!')</script>";
			exit();
		}*/

		/*if(!filter_var($athl_email,FILTER_VALIDATE_EMAIL))
		{
			echo "<script>alert('La tua email non è valida!')</script>";
			exit();
		}*/
		
		//move_uploaded_file($athl_tmp,"images/$athl_image");
		
		// QUERY INSERIMENTO ATLETA
		$insert = "INSERT INTO athletes 
		(athl_name,athl_surname,athl_email,athl_address,athl_zip,athl_city,athl_pr,athl_gender,athl_b_day,athl_class,athl_no,athl_image,athl_register_date) 
		VALUES ('$athl_name','$athl_surname','$athl_email','$athl_address','$athl_zip','$athl_city','$athl_pr','$athl_gender','$athl_b_day','$athl_class','$athl_no','$athl_image',NOW())";
		echo "<script>alert('QUERY: <br>".$insert."')</script>";
		$run_insert = $this->insert($insert);
		
		// OTTENIMENTO ATHL_ID APPENA INSERITO
		$athl_id = $run_insert;
		//$athl_id = $this->db->insert_id;
		//$get_athl_id = "SELECT athl_id FROM athletes ORDER BY athl_id DESC LIMIT 1";
		//$athl_result = $this->query($get_athl_id);
		//$athl_row = $this->fetch_row($athl_result);
		//$athl_id = $athl_row[0];
		
		// QUERY DI INSERIMENTO CINTURA
		$insert_belt = "INSERT INTO athletes_ryu (athl_ryu_athl_id,athl_ryu_belt,athl_ryu_nbelt,athl_ryu_data) VALUES ('$athl_id','$athl_ryu_belt','$athl_ryu_nbelt',NOW())";
		$run_insert_belt = $this->insert($insert_belt);
		
		// VERIFICA CORRETTO INSERIMENTO ATLETA e CINTURA
		if($run_insert && $run_insert_belt)
		{
			echo "<script>alert('Atleta inserito con successo!')</script>";
			echo "<script>window.open('index_home.php','_self')</script>";
		}
	}

	public function inserisci_utente()
	{
		$user_name = $this->pulisci_stringa($_POST['user_name']);
		$user_surname = $this->pulisci_stringa($_POST['user_surname']);
		$user_no = $this->pulisci_stringa($_POST['user_no']);
		$user_email = $this->pulisci_stringa($_POST['user_email']);
		$user_pass = $this->pulisci_stringa($_POST['user_pass']);
	
		$user_image = $_FILES['user_image']['name'];
		$user_tmp = $_FILES['user_image']['tmp_name'];
	
		if($user_image =='')
		{
			echo "<script>alert('Inserisci l'immagine!')</script>";
			exit();
		}
	
		if(!filter_var($user_email,FILTER_VALIDATE_EMAIL))
		{
			echo "<script>alert('La tua email non è valida!')</script>";
			exit();
		}
		
		move_uploaded_file($user_tmp,"images/foto/$user_image");
		
		// QUERY INSERIMENTO UTENTE
		$insert_user = "INSERT INTO register_user 
		(user_name,user_surname,user_email,user_no,user_pass,user_image,register_date) 
		VALUES ('$user_name','$user_surname','$user_email','$user_no','$user_pwd','$user_image',NOW())";
		$run_insert_user = $this->insert($insert_user);
		echo $run_insert_user;
		
		// OTTENIMENTO ATHL_ID APPENA INSERITO
		$user_id = $run_insert_user;
		echo $user_id;
		
		// VERIFICA CORRETTO INSERIMENTO ATLETA e CINTURA
		if($run_insert_user)
		{
			echo "<script>alert('Utente inserito con successo!')</script>";
			echo "<script>window.open('view_users.php','_self')</script>";
		}
	}
	
	
			
	public function valuta_presenza($edit_id)
	{
		$presence = "SELECT * FROM athl_presence WHERE athl_pres_athl_id = $edit_id ORDER BY athl_pres_date";
		$run = $this->select_row($presence);
		$tpa = array(0,0,0);
		while($row = $run->fetch_array())
		{
			$pres_date = $row['athl_pres_date'];
			$array_date = explode("-",$pres_date);
			if($row['athl_pres_presence']==1)
			{
				$pres = "Presente";
				$tpa[1]++;
			} else {
				$pres = "Assente";
				$tpa[2]++;
			}
			echo strftime("%a %e",mktime(0,0,0,$array_date[1],$array_date[2],$array_date[0])).": ".$pres."<br>";
			$tpa[0]++;
		}
		return $tpa;
	}

	public function aggiorna_atleta($edit_id)
	{
		$athl_name = $this->pulisci_stringa($_POST['athl_name']);
		$athl_surname = $this->pulisci_stringa($_POST['athl_surname']);
		$athl_b_day = $this->pulisci_stringa($_POST['athl_b_day']);
		$athl_email = $this->pulisci_stringa($_POST['athl_email']);
		$athl_no = $this->pulisci_stringa($_POST['athl_no']);
		$athl_address = $this->pulisci_stringa($_POST['athl_address']);
		$athl_city = $this->pulisci_stringa($_POST['athl_city']);
		$athl_zip = $this->pulisci_stringa($_POST['athl_zip']);
		$athl_pr = $this->pulisci_stringa($_POST['athl_pr']);
		$athl_class = $this->pulisci_stringa($_POST['athl_class']);
		$athl_ryu_belt = $this->pulisci_stringa($_POST['athl_ryu_belt']);
		$athl_ryu_data = $this->pulisci_stringa($_POST['athl_ryu_data']);
		$athl_ryn_nbelt = $this->assegna_cintura($athl_ryu_belt);
	
		if(!filter_var($athl_email,FILTER_VALIDATE_EMAIL))
		{
			echo "<script>alert('L'indirizzo email non è valido!')</script>";
			exit();
		}
		$fmt ="'%d/%m/%Y'";
		$update = "UPDATE athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id
						SET athl_name='$athl_name',
						athl_surname='$athl_surname',
						athl_b_day = STR_TO_DATE('$athl_b_day',$fmt),
						athl_email='$athl_email',
						athl_no='$athl_no',
						athl_address='$athl_address',
						athl_city='$athl_city',
						athl_zip='$athl_zip',
						athl_pr='$athl_pr',
						athl_class='$athl_class',						
						athl_ryu_belt='$athl_ryu_belt',
						athl_ryu_nbelt='$athl_ryu_nbelt',
						athl_ryu_data=STR_TO_DATE('$athl_ryu_data',$fmt)
						WHERE athl_id='$edit_id'";

		$run_update = $this->db->query($update);
		//$run_update = $this->insert($update);
			if($run_update)
			{
				echo "<script>alert('Aggiornamento completato con successo')</script>";
				echo "<script>window.open('view_athletes.php?ordina=athl_name&come=ASC','_self')</script>";
	
			} else {
				echo "<script>alert('Aggiornamento non effettuato')</script>";
			}
	}

	public function aggiorna_utente($edit_id)
	{
		$user_name = $this->pulisci_stringa($_POST['user_name']);
		$user_surname = $this->pulisci_stringa($_POST['user_surname']);
		$user_email = $this->pulisci_stringa($_POST['user_email']);
		$user_no = $this->pulisci_stringa($_POST['user_no']);
		$user_pass = $this->pulisci_stringa($_POST['user_pass']);
	
		if(!filter_var($user_email,FILTER_VALIDATE_EMAIL))
		{
			echo "<script>alert('L'indirizzo email non è valido!')</script>";
			exit();
		}
		$update = "UPDATE register_user
						SET user_name='$user_name',
						user_surname='$user_surname',
						user_email='$user_email',
						user_no='$user_no',
						user_pass='$user_pass'
						WHERE user_id='$edit_id'";
		
		$run_update = $this->db->query($update);
		//$run_update = $this->insert($update);
		
			if($run_update)
			{
				echo "<script>alert('Aggiornamento completato con successo')</script>";
				echo "<script>window.open('view_users.php','_self')</script>";
	
			} else {
				echo "<script>alert('Aggiornamento non effettuato verifica la query: $update')</script>";
			}
	}


	public function inserisci_img($athl_image,$athl_tmp,$athl_img_size)
	{
		//echo "<script>alert('File Caricato ".$athl_image." - ".$athl_img_size."')</script>";
		move_uploaded_file($athl_tmp,"images/foto/$athl_image");	
		
		// OGGETTO SIMPLE IMAGE - INIZIO		
		error_reporting(E_ALL & ~E_NOTICE);
		try {
		  // Create a new SimpleImage object
		  $image = new \claviska\SimpleImage();
			//echo "<script>alert('File In elaborazione ".$athl_image." -')</script>";
		
		  // Manipulate it
		  $image
		    ->fromFile("images/foto/$athl_image")      // load file
		    ->autoOrient()                        // adjust orientation based on exif data
		    ->bestFit(300, 400)                   // proportinoally resize to fit inside a 300x400 box
		    ->border('white', 5)                  // add a 5 pixel black border
		    ->toFile("images/foto/$athl_image");

		} 
		catch(Exception $err) {
		  // Handle errors
		  echo $err->getMessage();
		}
		// OGGETTO SIMPLE IMAGE - FINE		
		
		$ext = substr($athl_image,-3);
		//echo "<script>alert('Estensione ".$ext."')</script>";
		
		$file_name = substr($this->pulisci_stringa($_POST['athl_name']),0,3).substr($this->pulisci_stringa($_POST['athl_surname']),0,3).rand(1,5000).".".$ext;
		//$file_name = "PIPPO.jpg";
		//echo "<script>alert('File Caricato ".$file_name."')</script>";
		
		rename("images/foto/$athl_image","images/foto/$file_name");
		//echo "<script>alert('IMMAGINE ELABORATA)</script>";	
		return $file_name;
	}
	

	public function aggiorna_immagine($edit_id,$name,$surname)
	{
		//ELIMINAZIONE VECCHIO FILE
		$get_image_name_sql = "SELECT * FROM athletes WHERE athl_id='$edit_id'";
		$risultato = $this->select_row($get_image_name_sql);
		$row = $risultato->fetch_array();
		
		$get_image_name = $row['athl_image'];
		//echo "<script>alert('File da cancellare ".$get_image_name."')</script>";
		
		unlink('images/foto/'.$get_image_name);
		
		//INSERIMENTO NUOVO FILE	
		$athl_image = $_FILES['athl_image']['name'];
		$athl_tmp = $_FILES['athl_image']['tmp_name'];
		
		$_POST['athl_name'] = $name;
		$_POST['athl_surname'] = $surname;
		
		$athl_image = $this->inserisci_img($athl_image,$athl_tmp,$_FILES['athl_image']['size']);
		
		//move_uploaded_file($athl_tmp,"images/foto/$athl_image");
		
		$update_image ="UPDATE athletes SET athl_image='$athl_image' WHERE athl_id='$edit_id'";
		//echo "<script>alert('File Caricato ".$update_image."')</script>";
		
		$run_update_image = $this->db->query($update_image);
		if($run_update_image)
		{
			echo"<script>alert('Aggiornamento immagine completato con successo')</script>";
			echo "<script>window.open('view_athletes.php','_self')</script>";
	
		} else {
				echo "<script>alert('Aggiornamento non effettuato')</script>";
		}
	}

	public function select_row($select)
	{
		$risultato_query = $this->db->query($select);
		
		if($risultato_query === FALSE) //QUERY NON ESEGUITA
		{
			$this->stato = FALSE;
			$this->descrizione_stato = $this->messaggi_errore['problema_con_server'];
			if($this->stampa_errori)
			{
				echo $this->messaggi_errore['problema_con_server'].$this->br.$select;
			}
			return FALSE;	
		} 
		else 
		{
			$this->stato = TRUE;
			return $risultato_query;	
		}
		
	}

	public function esporta_csv($fname,$query)
	{
	      $output = fopen("php://output", "w");  
	      fputcsv($output, array('ID','Nome','Cognome','Indirizzo','Citta','Provincia','Telefono','Email','Classe','Cintura','Compleanno'));  
							
	      $result = $this->db->query($query);  
	      while($row = $result->fetch_assoc())  
	      {  
	           fputcsv($output, $row);
	      }  
	      fclose($output);  
	}
	public function esporta_presenze_csv($fname,$query)
	{
	      $output = fopen("php://output", "w");  
	      fputcsv($output, array('ID','Nome','Cognome','Data','Stato'));  
				
	      $result = $this->db->query($query);  
	      while($row = $result->fetch_assoc())  
	      {  
	           fputcsv($output, $row);
	      }  
	      fclose($output);  
	}
	


	public function inserisci_gara()
	{		
		$gara_nome = $this->pulisci_stringa($_POST['gara_nome']);
		$gara_federazione = $this->pulisci_stringa($_POST['gara_federazione']);
		$gara_data = $this->pulisci_stringa($_POST['gara_data']);
		$gara_luogo = $this->pulisci_stringa($_POST['gara_luogo']);
		$gara_termine_iscrizione = $this->pulisci_stringa($_POST['gara_termine_iscrizione']);
		$gara_referente = $this->pulisci_stringa($_POST['gara_referente']);
		$gara_email = $this->pulisci_stringa($_POST['gara_email']);
		$gara_telefono = $this->pulisci_stringa($_POST['gara_telefono']);
		$gara_indirizzo = $this->pulisci_stringa($_POST['gara_indirizzo']);
		$gara_cap = $this->pulisci_stringa($_POST['gara_cap']);
		$gara_pr = $this->pulisci_stringa($_POST['gara_pr']);
		$gara_orario = $this->pulisci_stringa($_POST['gara_orario']);
		$gara_quota = $this->pulisci_stringa($_POST['gara_quota']);
		
		// QUERY INSERIMENTO GARA
		$insert = "INSERT INTO gara 
										(
											gara_nome,
											gara_federazione,
											gara_data,
											gara_luogo,
											gara_termine_iscrizione,
											gara_referente,
											gara_email,
											gara_telefono,
											gara_indirizzo,
											gara_cap,
											gara_pr,
											gara_orario,
											gara_quota
										) 
										VALUES 
										(
											'$gara_nome',
											'$gara_federazione',
											'$gara_data',
											'$gara_luogo',
											'$gara_termine_iscrizione',
											'$gara_referente',
											'$gara_email',
											'$gara_telefono',
											'$gara_indirizzo',
											'$gara_cap',
											'$gara_pr',
											'$gara_orario',
											'$gara_quota'
											)";
										
		//echo "<script>alert('QUERY: <br>".$insert."')</script>";
		$run_insert = $this->insert($insert);
		
		// OTTENIMENTO gara_id APPENA INSERITO
		$gara_id = $run_insert;
				
		// VERIFICA CORRETTO INSERIMENTO GARA
		if($run_insert)
		{
			echo "<script>alert('Gara inserita con successo!')</script>";
			echo "<script>window.open('view_gare.php','_self')</script>";
		}
		
		// CREA ELENCO ATLETI CHE POSSONO PARTECIPARE ALLA GARA APPENA CREATA
		$partecipanti = "INSERT INTO partecipanti (part_athl_id,part_gara_id)
											Select athl_id,$gara_id
											from athletes
											where athl_status = 1";		
		$run_insert = $this->insert($partecipanti);
		
		// CREA ELENCO ATLETI PER I RISULTATI
/*		$partecipanti_esito = "INSERT INTO risultati (risult_athl_id,risult_gara_id)
											SELECT part_athl_id,$gara_id
											FROM partecipanti
											WHERE part_status = 'ISCRITTO'";		
		$run_insert = $this->insert($partecipanti_esito);*/
	}

		public function gara_delete($get_id)
	{
		
		$delete = "DELETE FROM gara WHERE gara_id='$get_id'";
		$run_delete = $this->db->query($delete);
		$delete = "DELETE FROM partecipanti WHERE gara_id='$get_id'";
		$run_delete = $this->db->query($delete);
		echo "<script>window.open('view_gare.php','_self')</script>";
								
		if($run_delete)
		{
			$this->stato = TRUE;
			echo "<script>alert('Gara cancellata con successo')</script>";
			echo "<script>window.open('".$_SERVER["HTTP_REFERER"]."','_self')</script>";
			return $this->db->insert_id;
		}
	}
	
	
// FINE CLASSE
}

?>