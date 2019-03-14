<?php
require_once ('config/config.php');
require_once ('connector/mysql.php');

$fromDbOrigin = 0;
$fichero = FROM_PATH_DB;
$successInsert = 0;
$failnsert = 0;
$failRecordPth = FAIL_ITEM_LOG_PATH."/".FAIL_ITEM_LOG_FILE;//ruta del archivo con id,s fallidos
// conexion con la base de datos origen
$mysql = new mysqlConector();
$connector = $mysql->mysqliOpen(ORIGIN_DB_HOST, ORIGIN_DB_USER, ORIGIN_DB_PASS, ORIGIN_DB_NAME);
// conexion con la base de datos destino
$mysql2 = new mysqlConector();
$connector2 = $mysql2->mysqliOpen(DESTINY_DB_HOST, DESTINY_DB_USER, DESTINY_DB_PASS, DESTINY_DB_NAME);

//se consulta archivo con ids fallidos
$testFail = file_get_contents($failRecordPth);
$arrayFail = array_unique(explode(",", $testFail));
$arrayFailInsert = [];
//var_dump($arrayFail);
foreach ($arrayFail as $key => $value) {
	//se valida si es un entero
	if(is_int((int)$value) && !empty($value)){
		//consulta para obtener la informacion dle registro fallido
		$sqlGetyParticularData = "SELECT * FROM node WHERE nid = ".$value;
		$resultGetyParticularData = $mysql->mysqliQuery($connector, $sqlGetyParticularData);
		//var_dump($sqlGetyParticularData);
		//var_dump($resultGetyParticularData);
		//se prepara insersion de datos
		$sqlInsert = "INSERT INTO node (idnode, title, created) VALUES (".$resultGetyParticularData[0]['nid'].", '".$resultGetyParticularData[0]['title']."', ".$resultGetyParticularData[0]['created'].")";
		var_dump($sqlInsert);
		//se valdia la insercion de datos
		if($mysql2->mysqliInsert($connector2, $sqlInsert) === true){//insercion exitosa
		//if(false){
			var_dump('registro insertado');
			//se agrega id de registro original como fallido, ahora exitodso, para remover del archivo de registros fallidos
			array_push($arrayFailInsert, $value.",");
		}
	}
}
//del contenido del  archivo de registros fallidos, se elimina los registros insertados pro el paso anterior
$updateFailFile = str_replace($arrayFailInsert, "", $testFail);
//var_dump($arrayFailInsert);
//var_dump($updateFailFile);
//se actualiza el archivo con ids fallidos
file_put_contents($failRecordPth, $updateFailFile);
//var_dump('----------------------------------');

//se consulta el punto de partida para la migracion
$sqlStartPoint = "SELECT * FROM worker";
$resultStartPoint = $mysql->mysqliQuery($connector, $sqlStartPoint);
//var_dump('aca');
if(is_array($resultStartPoint) && array_key_exists('migrado', $resultStartPoint[0])){
	$fromDbOrigin = $resultStartPoint[0]['migrado'];
}

//preparacion del query con lso datos a migrar
$sqlGetyData = "SELECT * FROM node limit ".NUMBER_ITEMS_MIGRATE. " offset ".$fromDbOrigin;
$resultoriginDb = $mysql->mysqliQuery($connector, $sqlGetyData);
//var_dump($sqlGetyData);
//var_dump($resultoriginDb);

//se valdia el resultado de la consulta
if($resultoriginDb && is_array ($resultoriginDb)){	
	//se itera los resultados obtenidos para preparar la oinsercion
	//var_dump('get type');
	//var_dump(gettype($resultoriginDb));
	for ($i=0; $i < NUMBER_ITEMS_MIGRATE; $i++) { 
		//var_dump('en ciclo '.$i);
		//var_dump(count($resultoriginDb));
		//var_dump('en cilco '.$i);
		//var_dump($resultoriginDb);
		//se verifica que el registro iterado no exista en la base de datos destino
		$sqlSearchRecord = "SELECT * FROM node where idnode = ".$resultoriginDb[$i]['nid'];
		//var_dump($sqlSearchRecord);
		$resultSearchRecord = $mysql2->mysqliQuery($connector2, $sqlSearchRecord);
		if(!$resultSearchRecord){//si el registro no existe en la base de datos destino
			//se inserta el registro
			//var_dump($resultoriginDb[$i]);
			$sqlInsert = "INSERT INTO node (idnode, title, created) VALUES (".$resultoriginDb[$i]['nid'].", '".$resultoriginDb[$i]['title']."', ".$resultoriginDb[$i]['created'].")";
			//var_dump($sqlInsert);
			$mysql->mysqliInsert($connector, $sqlInsert);
			if($mysql2->mysqliInsert($connector2, $sqlInsert) === true){//insercion exitosa
			//if(false){//prueba para valdiar archvio con id's de registros faliidos al insertar
				//var_dump('registro insertado');
				$successInsert++;//variable que lleva la suma de registros exitosos
			}else{//no se pudo insertar
				//var_dump('registro no insertado');
				$failnsert++;//variable que lleva la suma de registros fallidos
				//var_dump($failRecordPth);
				//var_dump($testFail);
				//se verifica si el archivo con registros fallios existe
				if(!file_exists($failRecordPth)){//si no existe el archivo
					file_put_contents($failRecordPth, '');//se crea el archivo sin contenidop
					//var_dump('archivo no existe');
				}else{
					var_dump('archivo existe');
					//se agrega id a archivo de registros fallidos para posterior insercion
					file_put_contents($failRecordPth, $resultoriginDb[$i]['nid'].",", FILE_APPEND);
				}				
			}
			//var_dump('tras insertar');
			
		}else{//el registro existe en la base de datos

		}
		$mysql2->mysqliClose($connector2);

	}
	
	//$updateStartPoint = $successInsert + $failnsert;//original para determinar el punto de partida del siguiente lote de migracion
	$updateStartPoint = $fromDbOrigin + NUMBER_ITEMS_MIGRATE;//prueba
	$sqlUpdateStartPoint = "UPDATE worker SET migrado = ".$updateStartPoint. " WHERE id=1";
	//var_dump('valor a actualizar '.$sqlUpdateStartPoint);
	$mysql->mysqliQuery($connector, $sqlUpdateStartPoint);
	$mysql->mysqliClose($connector);

}else{
	
}

?>
hola