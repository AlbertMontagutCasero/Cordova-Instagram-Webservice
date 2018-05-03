<?php
header("access-control-allow-origin: *");

include 'Connection.php';

$connection = new Connection();
$cnn        = $connection->getConexion();

if (isset($_POST["json"]))
{

    $sql       = "delete from note where idNota = ?;";
    $statement = $cnn->prepare($sql);
    //enlace entre los parametros de la consulta SQL con los valores obtenidos del formulario
    $statement->bindParam(1,
        $_POST["json"],
        PDO::PARAM_STR);
    echo $statement->execute() ? "Nota Borrada" : "Error";

    $statement->closeCursor();
}

$conexion = null;
