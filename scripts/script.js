
/* requesting server resource*/
function xhr(file, id, content, callback){
	var req = new XMLHttpRequest();
	req.open("GET", "http://192.168.20.109/io/"+file+".json?data="+ new Date().getTime(), false);
	req.send(null);
	if(req.status == 200){
		callback(id, content, JSON.parse(req.responseText));
	}
}

function consoleData(id, content, data){
	console.log(data);
}


/* print the sprinkler list */
function printArrosages(id, content, data){
	var div = document.getElementById(id);
	var sum = 0;
	data[content].forEach(function(value, index){
		div.innerHTML = div.innerHTML
			+"<tr>"
				+"<td><img class='img1em' src='images/sprinkler.png'/></td>"
				+"<td>Arrosage de la zone "+value.zone+" avec "+value.nbLitres+" litres.</td>"
				+((id == "courant")?
					"<td><nobr><span class='span1em'>"
						+((index == 0)?"":"<a href='forms/getformwater.php?action=up&zone="+value.zone+"&litres="+value.nbLitres+"'><i class='fa fa-angle-up'></i></a>")
					+"</span>"
					+" <span class='span1em'>"
						+((index == data[content].length-1)?"":"<a href='forms/getformwater.php?action=down&zone="+value.zone+"&litres="+value.nbLitres+"'><i class='fa fa-angle-down'></i></a>")
					+"</span>"
					+" <a href='addform.php?zone="+value.zone+"&litres="+value.nbLitres+"'><i class='fa fa-edit'></i></a>"
					+" <a href='forms/getformwater.php?action=delete&zone="+value.zone+"&litres="+value.nbLitres+"'><i class='fa fa-remove'></i></a></nobr></td>"
				:"")
			+"</tr>";
		sum += value.nbLitres;
	});

	if(data[content].length == 0){
		div.innerHTML = div.innerHTML + "Aucun arrosage dans cette section !";
	}else{
		/* print the current sprinkler programmation */
		if(id == "courant"){
			var div = document.getElementById("containerDash");
			div.innerHTML = "<div id='encours' class='card hoverable'>"
				+"<span>Arrosage en cours <br/><span class='fa-stack fa-lg'><i class='fa fa-certificate fa-stack-2x fa-lg fa-spin'></i><i class='fa fa-tint fa-stack-1x fa-inverse'></i></span></span>"
				+"<span>Zone<br/><i>"+data[content][0].zone+"</i></span>"
				+"<span>Litres<br/><i>"+data[content][0].nbLitres+"</i></span></div>"
				+div.innerHTML;
		}
	}
	
	/* calculating the water counter*/
	if(id == "histoContainer"){
		var div = document.getElementById("litrecounter");
		div.innerHTML = sum+" litres";
		div = document.getElementById("arrosagecounter");
		div.innerHTML = data[content].length+" arrosages";
	}
}

/* print the light comand panel*/
function printEclairage(id, content, data){
	var div = document.getElementById(id);
	for(var index in data[content]){
		div.innerHTML = div.innerHTML
			+"<span>"
				+"<i class='fa fa-lightbulb-o'></i> "
				+"Zone "+index+" : "
				+((data[content][index] == 0)?
					"<a href='forms/getformlight.php?zone="+index+"&ecl=1'><i class='fa fa-toggle-off'></i></a>"
					:"<a href='forms/getformlight.php?zone="+index+"&ecl=0'><i class='fa fa-toggle-on'></i></a>")
			+"</span>";
	}
}

xhr("history", "histoContainer", "historique", printArrosages);
xhr("output", "courant", "programmation", printArrosages);
xhr("output", "eclairage", "eclairage", printEclairage);