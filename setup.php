<?php
@session_start();
$cartella_ini = $_SERVER['DOCUMENT_ROOT']."/ini";
$br = "<br>";
$messaggi_errore = parse_ini_file("ini/msg_errore.ini");
?>