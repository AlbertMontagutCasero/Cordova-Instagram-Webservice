<?php
header("access-control-allow-origin: *");
include 'Connection.php';

$conexion = new Connection();
$cnn      = $conexion->getConexion();

if (isset($_POST["id_user"]))
{
    $id = $_POST["id_user"];
    $sql
        = "SELECT
                photo_tiene_hashtag.id,
                photo.id AS photo_id,
                photo.photo_name,
                photo.id_usuario,
                hash_tag.id AS hash_tag_id,
                hash_tag.hash_tag_name,
                SUM(usuario_vota_photo.score) AS total_score
            FROM
                photo_tiene_hashtag
            INNER JOIN photo ON photo_tiene_hashtag.id_photo = photo.id
            INNER JOIN hash_tag ON hash_tag.id = photo_tiene_hashtag.id_hash_tag
            LEFT JOIN usuario_vota_photo ON usuario_vota_photo.id_photo = photo.id
            WHERE
                photo.id_usuario = ?
            GROUP BY
                photo.id";

    $statement = $cnn->prepare($sql);
    $statement->bindParam(
        1,
        $id,
        PDO::PARAM_STR);

    if ($statement->execute())
    {
        if($statement->rowCount() <= 0){
            echo "-1";
            return;
        }

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
