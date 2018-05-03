<?php
header("access-control-allow-origin: *");
include 'Connection.php';

$conexion = new Connection();
$cnn      = $conexion->getConexion();

if (
    isset($_POST["id_photo"])
    && isset($_POST["id_user"])
)
{

    $idPhoto = $_POST["id_photo"];
    $idUser  = $_POST["id_user"];
    $sql
             = "SELECT
                    *
                FROM
                    usuario_vota_photo
                WHERE
                    id_usuario = ? AND id_photo = ?";

    $statement = $cnn->prepare($sql);
    $statement->bindParam(
        1,
        $idUser,
        PDO::PARAM_STR);
    $statement->bindParam(
        2,
        $idPhoto,
        PDO::PARAM_STR);

    if ($statement->execute())
    {

        while (
        $resultado = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $data["data"][] = $resultado;
        }
        print_r(
            $data,
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
