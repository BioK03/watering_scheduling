<?php
	session_start();

	if($_SESSION["connected"] == 0){
		header("Location:../index.php");
	}
	
	/* Put the ecl (light) in the output.json file*/
	if(isset($_GET["zone"]) && isset($_GET["ecl"])){
		$dataen = file_get_contents("../io/output.json");
		$data = json_decode($dataen, true);
		
		$data["eclairage"][strval($_GET["zone"])] = $_GET["ecl"];
		
		
		$file = fopen("../io/output.json", 'w');
		fwrite($file, json_encode($data));
		fclose($file);
	}
	
	
	
	header("Location:../dashboard.php");