<?php
	header("access-control-allow-origin: *");

	include 'Connection.php';

	$connection = new Conexion();
	$cnn = $connection->getConexion();

	if(isset($_POST["username"])){

		$username = $_POST["username"];
		$password = $_POST["password"];
		$repeatPassword = $_POST["repeatPassword"];


		$sql = "INSERT INTO user(username, password) VALUES (?,?);";
		$statement = $cnn->prepare( $sql );

		//enlace entre los parametros de la consulta SQL con los valores obtenidos del formulario
		$statement->bindParam(1 , $username , PDO::PARAM_STR);
		$statement->bindParam(2 , $password , PDO::PARAM_STR);
		echo $statement->execute() ? "Registrado" : "Error";
		
		$statement->closeCursor();
	}

	$conexion = null
/*
echo "server: Datos obtenidos del formulario<br>";
echo "Username: $username <br>";
echo "Password: $password<br>";
echo "Cantidad: $repeatPassword <br>";
*/

//// Associative array
/*
if (isset($_GET['showNotes'])) {

	$con = mysqli_connect("localhost", "root", "", "ajaxcristian");
	// Check connection
	if (mysqli_connect_errno()) {
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$sql = "SELECT note.texto, user.name FROM ajaxcristian.note inner join user on note.idUser = user.idUser";
	$result = mysqli_query($con, $sql);
	$json = json_encode($result->fetch_all(MYSQLI_ASSOC)); 
   	echo $_GET['showNotes'] . '(' . $json . ')';
	mysqli_close($con);
}



if(isset($_GET['register'])){
	
	$con = mysqli_connect("localhost", "root", "", "ajaxcristian");
	// Check connection
	if (mysqli_connect_errno()) {
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$obj = json_decode($_GET['register']);
	mysqli_query($con,'INSERT INTO user(username, password) 
       VALUES ("'.$obj[0]->name.'", "'.$obj[0]->password.'")');
	echo $_GET['register'] . '(' . "aaa" . ')';

	mysqli_close($con);
}

if(isset($_GET['getResponseMessage'])){
	echo $_GET['getResponseMessage'] . '(' . "aaa" . ')';
}



/*
$array = array(1,2,3,4,5,6);
$resposta= json_encode($array);

if(isset($_GET['callback'])){
 echo $_GET['callback'].'('. $resposta.')';
}
else {
 echo ($resposta);
}
*/
?>

