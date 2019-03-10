<?php
require_once ('config/config.php');
require_once ('connector/mysql.php');

// create object to mysql connection to origin db
$mysql = new mysqlConector();
$connector = $mysql->mysqliOpen(ORIGIN_DB_HOST, ORIGIN_DB_USER, ORIGIN_DB_PASS, ORIGIN_DB_NAME);
$fromDbOrigin = 0;
$fichero = FROM_PATH_DB;
if(file_exists ( FROM_PATH_DB )){//file exist	
	// Abre el fichero para obtener el contenido existente
	$actual =  json_decode(file_get_contents($fichero));
	var_dump($actual->contenido->migrado);
	// Añade una nueva persona al fichero
	if($actual->contenido->migrado !== 0){
		$tetser = explode("-", $actual->contenido->migrado );
		$fromDbOrigin = $tetser[1];
		var_dump('en if con fichero existente');
	}
}
else{//file dont exist
	$data = [];
	$data['contenido'] = [];
	$data['contenido']['migrado'] = 0;
	$actual = 0;
	// Escribe el contenido al fichero
	file_put_contents($fichero,json_encode($data));
	var_dump('file no exist');
	$fromDbOrigin = NUMBER_ITEMS_MIGRATE;
}
//prepare the query
$sqlGetyData = "SELECT * FROM node limit ".NUMBER_ITEMS_MIGRATE. " offset ".$fromDbOrigin;
$resultoriginDb = $mysql->mysqliQuery($connector, $sqlGetyData);
var_dump($sqlGetyData);
//var_dump($resultoriginDb);
$mysql->mysqliClose($connector);

//validate the result
if($resultoriginDb && is_array ($resultoriginDb)){	
	//It grows objective with result of db origin
	//var_dump('get type');
	//var_dump(gettype($resultoriginDb));
	for ($i=0; $i < NUMBER_ITEMS_MIGRATE; $i++) { 
		// create object to mysql connection to destiny db
		$mysql = new mysqlConector();
		$connector = $mysql->mysqliOpen(DESTINY_DB_HOST, DESTINY_DB_USER, DESTINY_DB_PASS, DESTINY_DB_NAME);
		//var_dump(count($resultoriginDb));
		//var_dump('en cilco '.$i);
		//var_dump($resultoriginDb);
		//is verified if the record to be inserted exists
		$sqlSearchRecord = "SELECT * FROM node where idnode = ".$resultoriginDb[$i]['nid'];
		//var_dump($sqlSearchRecord);
		$resultSearchRecord = $mysql->mysqliQuery($connector, $sqlSearchRecord);
		if(!$resultSearchRecord){//the record dont exist in destiny db
			//insert the record
			//var_dump($resultoriginDb[$i]);
			$sqlInsert = "INSERT INTO node (idnode, title, created) VALUES (".$resultoriginDb[$i]['nid'].", '".$resultoriginDb[$i]['title']."', ".$resultoriginDb[$i]['created'].")";
			//var_dump($sqlInsert);
			//$mysql->mysqliInsert($connector, $sqlInsert);
			//var_dump('tras insertar');
			$mysql->mysqliClose($connector);
		}else{//the record exist in destiny db

		}
	}
	//update file
	$data = [];
	$data['contenido'] = [];
	$data['contenido']['migrado'] = $fromDbOrigin + NUMBER_ITEMS_MIGRATE;
	var_dump($data);
	$data['contenido']['migrado'] = "asasasasas-".$data['contenido']['migrado'];
	var_dump('aca');
	var_dump($data);
	//file_put_contents($fichero, '');
	file_put_contents($fichero, json_encode($data));
	//file_put_contents($fichero2, $test);

}else{
	
}

?>
hola