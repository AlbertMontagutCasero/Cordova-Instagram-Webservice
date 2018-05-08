<?php
header("access-control-allow-origin: *");

include 'Connection.php';

$connection = new Connection();
$cnn = $connection->getConexion();

if (!isset($_FILES["file"]["type"]))
{
    return;
}
$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if (
    !(
        ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/jpeg")
    ) && !($_FILES["file"]["size"] < 100000)
    && !(in_array($file_extension, $validextensions))
) //Approx. 100kb files can be uploaded.
{
    echo "Invalid file Size or Type";
    return;
}

if (
    !isset($_POST["hashtags"])
    && !isset($_POST["id_user"])
)
{
    echo "ERROR";
    return;
}

$hashtags = json_decode($_POST['hashtags']);
$idUser = $_POST["id_user"];
$idPhoto;
print_r($hashtags);
echo $idUser;

if ($_FILES["file"]["error"] > 0)
{
    echo "Return Code: " . $_FILES["file"]["error"];
    return;
}

$fileName = generateRandomString(30);
echo "destination filename".$fileName;
$destinationPhotoPaht = "uploads/$fileName.jpg";
echo "destination photo path".$destinationPhotoPaht;
$serverHost = "https://ajaxinstaalbert.000webhostapp.com/";
$sql
    = " INSERT INTO photo
            (`photo_name`, `id_usuario`) 
            VALUES 
            (?,?);";
$statement = $cnn->prepare($sql);

$urlPhoto = $serverHost . $destinationPhotoPaht;
echo "urlPhoto".$urlPhoto;
$statement->bindParam(
    1,
    $urlPhoto,
    PDO::PARAM_STR);

$statement->bindParam(
    2,
    $idUser,
    PDO::PARAM_STR);
if ($statement->execute())
{
    $idPhoto = $cnn->lastInsertId();
    echo "New record created successfully. Last inserted ID is: " . $idPhoto;
}

foreach ($hashtags as $hashtag)
{
    try
    {
        $sql
            = " INSERT INTO hash_tag
                (`hash_tag_name`)
                 VALUES 
                 (?)";
        $statement = $cnn->prepare($sql);

        $statement->bindParam(
            1,
            $hashtag,
            PDO::PARAM_STR);
        if ($statement->execute())
        {
            echo "Hashtag dado de alta <br>";
        }

        $idHashtag = $cnn->lastInsertId();

    } catch (PDOException $e)
    {
        $sql
            = " SELECT 
                `id` 
                FROM 
                `hash_tag` 
                WHERE 
                hash_tag_name = ?";
        $statement = $cnn->prepare($sql);

        $statement->bindParam(
            1,
            $hashtag,
            PDO::PARAM_STR);
        if ($statement->execute())
        {
            $result = $statement->fetch();
            $idHashtag = $result["id"];
        }
    }

    $sql
        = " INSERT INTO photo_tiene_hashtag
                    (`id_photo`, `id_hash_tag`) 
                    VALUES 
                    (?,?)";
    $statement = $cnn->prepare($sql);

    $statement->bindParam(
        1,
        $idPhoto,
        PDO::PARAM_STR);
    $statement->bindParam(
        2,
        $idHashtag,
        PDO::PARAM_STR);
    if ($statement->execute())
    {
        echo "owner setted <br>";
    }
}

move_uploaded_file($_FILES['file']['tmp_name'], $destinationPhotoPaht);

echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}