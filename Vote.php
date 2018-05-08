<?php
header("access-control-allow-origin: *");
include 'Connection.php';

$conexion = new Connection();
$cnn = $conexion->getConexion();

if (
    isset($_POST["id_photo"])
    && isset($_POST["id_user"])
    && isset($_POST["score"])
)
{
    $idPhoto = $_POST["id_photo"];
    $idUser = $_POST["id_user"];
    $score = $_POST["score"];

    //TODO REFACTOR! This will generate a technical debt over 9000

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

    // si se puede ejecutar sin errores
    if ($statement->execute())
    {
        //si ya hay un registro
        if (
            $statement->rowCount()
            > 0
        )
        {
            while ($resultado = $statement->fetch(PDO::FETCH_ASSOC))
            {
                if ($resultado["score"] == $score)
                {
                    echo "-1";
                    return;
                }
            }

            $sql
                = "UPDATE 
               `usuario_vota_photo` 
               SET
               `score`= ? 
               WHERE 
               id_usuario = ? and id_photo = ?";

            $statement = $cnn->prepare($sql);
            $statement->bindParam(
                1,
                $score,
                PDO::PARAM_STR);
            $statement->bindParam(
                2,
                $idUser,
                PDO::PARAM_STR);
            $statement->bindParam(
                3,
                $idPhoto,
                PDO::PARAM_STR);
            if ($statement->execute())
            {
                echo "Update: ok";
            }

        } else
        {
            $sql
                = "INSERT INTO 
                `usuario_vota_photo`
                (`id_usuario`, `id_photo`, `score`)
                VALUES
                (?, ?, ?)";

            $statement = $cnn->prepare($sql);
            $statement->bindParam(
                1,
                $idUser,
                PDO::PARAM_STR);
            $statement->bindParam(
                2,
                $idPhoto,
                PDO::PARAM_STR);
            $statement->bindParam(
                3,
                $score,
                PDO::PARAM_STR);
            if ($statement->execute())
            {
                echo "Insert: ok";
            }
        }
    } else
    {
        echo "Error";
    }
    $statement->closeCursor();
}

$conexion = null;

