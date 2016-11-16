<?php
	session_start();

	if($_SESSION["connected"] == 0){
		header("Location:../index.php");
	}
	
	
	if(isset($_GET["zone"]) && isset($_GET["litres"])){
		/* add a new sprinkler programmation*/
		if($_GET["action"] == "add"){
			$dataen = file_get_contents("../io/output.json");
			$data = json_decode($dataen, true);
			
			array_push($data["programmation"], ["zone" => $_GET["zone"], "nbLitres" => $_GET["litres"]]);
			
			$file = fopen("../io/output.json", 'w');
			fwrite($file, json_encode($data));
			fclose($file);
		}
		
		/* edit an existing sprinkler programmation */
		if($_GET["action"] == "edit"){
			$dataen = file_get_contents("../io/output.json");
			$data = json_decode($dataen, true);

			/* Finding an existing programmation with same zone number and liter count */
			$found = false;
			for($i=0; $i<count($data["programmation"]); $i++){
				if(!$found && $data["programmation"][$i]["zone"] == strval($_GET["oldzone"]) && $data["programmation"][$i]["nbLitres"] == strval($_GET["oldlitres"])){
					$data["programmation"][$i]["zone"] = $_GET["zone"];
					$data["programmation"][$i]["nbLitres"] = $_GET["litres"];
					$found = true;
					
				}
			}
			
			$file = fopen("../io/output.json", 'w');
			fwrite($file, json_encode($data));
			fclose($file);
		}
		
		/* delete an existing programmation*/
		if($_GET["action"] == "delete"){
			$dataen = file_get_contents("../io/output.json");
			$data = json_decode($dataen, true);

			/* Finding an existing programmation with same zone number and liter count */
			$found = -1;
			for($i=0; $i<count($data["programmation"]); $i++){
				if($found == -1 && $data["programmation"][$i]["zone"] == strval($_GET["zone"]) && $data["programmation"][$i]["nbLitres"] == strval($_GET["litres"])){
					$found = $i;
				}
			}

			if($found != -1){
				array_splice($data["programmation"], $found, 1);
			}
			
			$file = fopen("../io/output.json", 'w');
			fwrite($file, json_encode($data));
			fclose($file);
		}
		
		/* move an existing programmation down in the list*/
		if($_GET["action"] == "down"){
			$dataen = file_get_contents("../io/output.json");
			$data = json_decode($dataen, true);

			$found = -1;
			for($i=0; $i<count($data["programmation"]); $i++){
				if($found == -1 && $data["programmation"][$i]["zone"] == strval($_GET["zone"]) && $data["programmation"][$i]["nbLitres"] == strval($_GET["litres"])){
					$found = $i;
				}
			}

			if($found != -1 && $found < count($data["programmation"]) - 1){
				$temp = $data["programmation"][$found+1];
				$data["programmation"][$found+1] = $data["programmation"][$found];
				$data["programmation"][$found] = $temp;
			}
			
			$file = fopen("../io/output.json", 'w');
			fwrite($file, json_encode($data));
			fclose($file);
		}
		
		/* move an existing programmation up in the list*/
		if($_GET["action"] == "up"){
			$dataen = file_get_contents("../io/output.json");
			$data = json_decode($dataen, true);

			$found = -1;
			for($i=0; $i<count($data["programmation"]); $i++){
				if($found == -1 && $data["programmation"][$i]["zone"] == strval($_GET["zone"]) && $data["programmation"][$i]["nbLitres"] == strval($_GET["litres"])){
					$found = $i;
				}
			}

			if($found != -1 && $found > 0){
				$temp = $data["programmation"][$found-1];
				$data["programmation"][$found-1] = $data["programmation"][$found];
				$data["programmation"][$found] = $temp;
			}
			
			$file = fopen("../io/output.json", 'w');
			fwrite($file, json_encode($data));
			fclose($file);
		}
	}
	
header("Location:../dashboard.php");