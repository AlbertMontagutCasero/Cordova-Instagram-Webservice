<?php
	header("access-control-allow-origin: *");

	include 'Connection.php';
	$connection = new Connection();
	$cnn = $connection->getConexion();

	if(isset($_POST["username"])){

		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql = "select * from usuario where email = ? and pass = ?";
		$statement = $cnn->prepare( $sql );

		//enlace entre los parametros de la consulta SQL con los valores obtenidos del formulario
		$statement->bindParam(1 , $username , PDO::PARAM_STR);
		$statement->bindParam(2 , $password , PDO::PARAM_STR);
		if($statement->execute()){
			echo $statement->rowCount();
		}else{
			echo "Error";
		}


		$statement->closeCursor();
	}

	$conexion = null;