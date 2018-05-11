<?php
header("access-control-allow-origin: *");

include 'Connection.php';

$connection = new Connection();
$cnn        = $connection->getConexion();

if (isset($_POST["id_photo"]))
{
    $idPhotoToDelete = $_POST["id_photo"];

    $sql       = "DELETE FROM `photo` WHERE id = ?;";
    $statement = $cnn->prepare($sql);
    //enlace entre los parametros de la consulta SQL con los valores obtenidos del formulario
    $statement->bindParam(1,
        $idPhotoToDelete,
        PDO::PARAM_STR);
    echo $statement->execute() ? "Foto Borrada" : "Error";

    $statement->closeCursor();
}

$conexion = null;
