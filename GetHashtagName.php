<?php
header("access-control-allow-origin: *");
include 'Connection.php';

$conexion = new Connection();
$cnn      = $conexion->getConexion();

if (isset($_POST["id"]))
{
    $id = $_POST["id"];
    $sql
        = "SELECT
                hash_tag.hash_tag_name
            FROM
                hash_tag
            WHERE
                id = ?";

    $statement = $cnn->prepare($sql);
    $statement->bindParam(
        1,
        $id,
        PDO::PARAM_STR);

    if ($statement->execute())
    {

        while (
        $resultado = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $data["data"][] = $resultado;
        }
        print_r(
            $statement->fetch(PDO::FETCH_ASSOC),
            true);
        echo json_encode($data);
    }
    else
    {
        echo "error";
    }
    $statement->closeCursor();
}


$conexion = null;
