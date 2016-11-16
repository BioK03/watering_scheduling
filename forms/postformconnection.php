<?php
	session_start();

if($_GET["login"]=="root" && $_GET["password"]=="pass"){
	$_SESSION["connected"] = 1;
	header("Location:../dashboard.php");
}else{
	$_SESSION["connected"] = 0;
	header("Location:../index.php");
}
