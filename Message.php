<?php
	header("access-control-allow-origin: *");
	include 'Connection.php';
	
	$conexion = new Conexion();
	$cnn = $conexion->getConexion();
	$sql = "SELECT * FROM note where idUser = ?;";
	$statement = $cnn->prepare( $sql );
	$statement->bindParam(1 , $_POST["username"] , PDO::PARAM_STR);
	$valor = $statement->execute();

	//si al ejecutar la consulta todo va bien
	if( $valor ){
		while ($resultado = $statement->fetch(PDO::FETCH_ASSOC)) {
			$data["data"][] = $resultado;
		}
		print_r($data, true);
		echo json_encode( $data );
	}else{
		echo "error";
	}

	$statement->closeCursor();
	$conexion = null;
