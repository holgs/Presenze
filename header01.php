<?php
if(!isset($_SESSION['user_email']))
	{
		header("location: login.php");
	} else
	{
	include "login.php";
	}    
?>