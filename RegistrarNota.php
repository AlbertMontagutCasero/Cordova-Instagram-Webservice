<?php
header("access-control-allow-origin: *");

include 'Connection.php';

$connection = new Connection();
$cnn        = $connection->getConexion();

if (isset($_POST["json"]))
{
    $notas = json_decode($_POST["json"]);
    //var_dump($notas);
    //var_dump($notas->{"data"}[1]);

    //foreach ($notas->{"data"} as $nota) {
    //echo print_r($nota[0], true);
    //echo $nota->{"idUser"}."<br>";
    //echo $nota->{"texto"}."<br>";
    //}


    //$userName = $_POST["userName"];
    //$nota = $_POST["nota"];


    $sql       = "INSERT INTO note(idUser, texto) VALUES (?,?);";
    $statement = $cnn->prepare($sql);
    //enlace entre los parametros de la consulta SQL con los valores obtenidos del formulario
    $statement->bindParam(1,
        $notas->data[1]->idUser,
        PDO::PARAM_STR);
    $statement->bindParam(2,
        $notas->data[2]->texto,
        PDO::PARAM_STR);
    echo $statement->execute() ? "Nota Registrada" : "Error";

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

