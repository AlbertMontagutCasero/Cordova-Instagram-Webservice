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
var_dump($hashtags);
echo $idUser;

if ($_FILES["file"]["error"] > 0)
{
    echo "Return Code: " . $_FILES["file"]["error"];
    return;
}

if (file_exists("uploads/" . $_FILES["file"]["name"]))
{
    echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
} else
{
    $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
    $targetPath = "uploads/" . $_FILES['file']['name']; // Target path where file is to be stored
    move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
    echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
    echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
    echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
    echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
}
