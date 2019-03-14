<?php
require_once ('config/config.php');
require_once ('connector/mysql.php');

// create object to mysql connection to origin db
$mysql = new mysqlConector();
$connector = $mysql->mysqliOpen(ORIGIN_DB_HOST, ORIGIN_DB_USER, ORIGIN_DB_PASS, ORIGIN_DB_NAME);
$fromDbOrigin = 0;
$fichero = FROM_PATH_DB;
$successInsert = 0;
$failnsert = 0;

//se consulta el punto de partida para la migracion
$sqlStartPoint = "SELECT * FROM worker";
$resultStartPoint = $mysql->mysqliQuery($connector, $sqlStartPoint);
//var_dump('aca');
if(is_array($resultStartPoint) && array_key_exists('migrado', $resultStartPoint[0])){
	$fromDbOrigin = $resultStartPoint[0]['migrado'];
}

//prepare the query
$sqlGetyData = "SELECT * FROM node limit ".NUMBER_ITEMS_MIGRATE. " offset ".$fromDbOrigin;
$resultoriginDb = $mysql->mysqliQuery($connector, $sqlGetyData);
var_dump($sqlGetyData);
//var_dump($resultoriginDb);

//validate the result
if($resultoriginDb && is_array ($resultoriginDb)){	
	//It grows objective with result of db origin
	//var_dump('get type');
	//var_dump(gettype($resultoriginDb));
	for ($i=0; $i < NUMBER_ITEMS_MIGRATE; $i++) { 
		var_dump('en ciclo '.$i);
		// create object to mysql connection to destiny db
		$mysql2 = new mysqlConector();
		$connector2 = $mysql2->mysqliOpen(DESTINY_DB_HOST, DESTINY_DB_USER, DESTINY_DB_PASS, DESTINY_DB_NAME);
		//var_dump(count($resultoriginDb));
		//var_dump('en cilco '.$i);
		//var_dump($resultoriginDb);
		//is verified if the record to be inserted exists
		$sqlSearchRecord = "SELECT * FROM node where idnode = ".$resultoriginDb[$i]['nid'];
		//var_dump($sqlSearchRecord);
		$resultSearchRecord = $mysql2->mysqliQuery($connector2, $sqlSearchRecord);
		if(!$resultSearchRecord){//the record dont exist in destiny db
			//insert the record
			//var_dump($resultoriginDb[$i]);
			$sqlInsert = "INSERT INTO node (idnode, title, created) VALUES (".$resultoriginDb[$i]['nid'].", '".$resultoriginDb[$i]['title']."', ".$resultoriginDb[$i]['created'].")";
			var_dump($sqlInsert);
			//$mysql->mysqliInsert($connector, $sqlInsert);
			if($mysql2->mysqliInsert($connector2, $sqlInsert) === true){//insercion exitosa
				var_dump('registro insertado');
				$successInsert++;
			}else{//no se pudo insertar
				var_dump('registro no insertado');
				$failnsert++;
			}
			//var_dump('tras insertar');
			
		}else{//the record exist in destiny db

		}
		$mysql2->mysqliClose($connector2);

	}
	
	//$updateStartPoint = $successInsert + $failnsert;
	$updateStartPoint = $fromDbOrigin + NUMBER_ITEMS_MIGRATE;
	$sqlUpdateStartPoint = "UPDATE worker SET migrado = ".$updateStartPoint. " WHERE id=1";
	var_dump('valor a actualizar '.$sqlUpdateStartPoint);
	$mysql->mysqliQuery($connector, $sqlUpdateStartPoint);
	$mysql->mysqliClose($connector);

}else{
	
}

?>
hola