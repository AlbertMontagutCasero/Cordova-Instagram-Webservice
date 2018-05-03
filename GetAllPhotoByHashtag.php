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
    photo_tiene_hashtag.id,
    photo.id as photo_id,
    photo.photo_name,
    photo.id_usuario,
    hash_tag.id as hash_tag_id,
    hash_tag.hash_tag_name,
    SUM(usuario_vota_photo.score) as total_score
FROM
    photo_tiene_hashtag
INNER JOIN photo ON photo_tiene_hashtag.id_photo = photo.id
INNER JOIN hash_tag ON hash_tag.id = photo_tiene_hashtag.id_hash_tag
INNER JOIN usuario_vota_photo on photo.id_usuario = photo.id_usuario
WHERE
    photo_tiene_hashtag.id_hash_tag = ?
    GROUP by usuario_vota_photo.id_photo";

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
        print_r($data,
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
