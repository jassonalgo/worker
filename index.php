<?php
require_once ('config/config.php');
require_once ('connector/mysql.php');

// create object to mysql connection to origin db
$mysql = new mysqlConector();
$connector = $mysql->mysqliOpen(ORIGIN_DB_HOST, ORIGIN_DB_USER, ORIGIN_DB_PASS, ORIGIN_DB_NAME);
$fromDbOrigin = 0;
//prepare the query
$sqlGetyData = "SELECT * FROM node limit ".NUMBER_ITEMS_MIGRATE. " offset ".$fromDbOrigin;
$resultoriginDb = $mysql->mysqliQuery($connector, $sqlGetyData);
//var_dump($sqlGetyData);
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
			$mysql->mysqliInsert($connector, $sqlInsert);
			//var_dump('tras insertar');
			$mysql->mysqliClose($connector);
		}else{//the record exist in destiny db

		}
	}
	

}else{
	
}

?>
hola