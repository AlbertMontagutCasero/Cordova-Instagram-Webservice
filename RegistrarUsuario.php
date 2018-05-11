<?php
header("access-control-allow-origin: *");

include 'Connection.php';

$connection = new Connection();
$cnn        = $connection->getConexion();

if (isset($_POST["email"]) && isset($_POST["password"]))
{

    $email    = $_POST["email"];
    $password = $_POST["password"];

    $sql       = "INSERT INTO usuario(email, pass) VALUES (?,?);";
    $statement = $cnn->prepare($sql);

    //enlace entre los parametros de la consulta SQL con los valores obtenidos del formulario
    $statement->bindParam(1,
        $email,
        PDO::PARAM_STR);
    $statement->bindParam(2,
        $password,
        PDO::PARAM_STR);
    echo $statement->execute() ? "Registrado" : "Error";

    $statement->closeCursor();
}

$conexion = null;