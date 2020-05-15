<?php
include_once 'Conexion.php';

session_start();
$user = $_SESSION['user'];

$nombre = "foto_avatar_" . $user . ".jpg";

$directorio = getcwd(); //obtenemos el directorio Actual
$directorio  = str_replace("modelo", "Download/fotos_Avatar/", $directorio);
if (is_array($_FILES) && count($_FILES) > 0) {
    if (($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/gif")
    ) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $directorio . $nombre)) {
            //more code here...
            echo "../Download/fotos_Avatar/" . $nombre;
            actualizarFotoAvatar($user, $nombre);
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}


function actualizarFotoAvatar($nick, $foto)
{

    $conexion = Conexion::conectar();
    $conexion->beginTransaction();

    $insert = $conexion->prepare("UPDATE users  SET foto_avatar=? WHERE nick = ?");

    $insert->bindParam(1, $foto);
    $insert->bindParam(2, $nick);

    $todobien = $insert->execute();

    if ($todobien == TRUE) {
        $conexion->commit();
    } else {
        $conexion->rollback();
    }

    unset($conexion);
}
