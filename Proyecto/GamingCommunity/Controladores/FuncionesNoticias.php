<?php

include_once '../Modelo/Conexion.php';

function ver_Noticias_Carrousel()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM noticias ORDER BY fecha_creacion DESC LIMIT 5");

    $noticias = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $noticia = array();
            $noticia["id"] = $row["id"];
            $noticia["titulo"] = $row["titulo"];
            $noticia["subtitulo"] = $row["subtitulo"];
            $noticia["contenido"] = $row["contenido"];
            $noticia["img"] = $row["img"];
            $noticia["fecha_creacion"] = $row["fecha_creacion"];

            array_push($noticias, $noticia);
        }
    }

    unset($conexion);

    return $noticias;
}

function ver_Noticias()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM noticias ORDER BY fecha_creacion DESC LIMIT 6");

    $noticias = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $noticia = array();
            $noticia["id"] = $row["id"];
            $noticia["titulo"] = $row["titulo"];
            $noticia["subtitulo"] = $row["subtitulo"];
            $noticia["contenido"] = $row["contenido"];
            $noticia["img"] = $row["img"];
            $noticia["fecha_creacion"] = $row["fecha_creacion"];

            array_push($noticias, $noticia);
        }
    }

    unset($conexion);

    return $noticias;
}

function ver_Noticias_id($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM noticias WHERE id = " . $id);


    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $noticia = array();
            $noticia["id"] = $row["id"];
            $noticia["titulo"] = $row["titulo"];
            $noticia["subtitulo"] = $row["subtitulo"];
            $noticia["contenido"] = $row["contenido"];
            $noticia["img"] = $row["img"];
            $noticia["fecha_creacion"] = $row["fecha_creacion"];
        }
    }

    unset($conexion);

    return $noticia;
}


function existe_Avatar($nick)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM users WHERE nick = '" . $nick . "'");

    $foto_Avatar = "";

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $foto_Avatar = $row["foto_Avatar"];
        }
    }

    unset($conexion);

    return $foto_Avatar;
}

function insetarNoticia($titulo, $subtitulo, $contenido, $img, $fecha_craecion)
{
    $conexion = Conexion::conectar();
    $respuesta = "";
    $insert = $conexion->prepare("INSERT INTO noticias (titulo, subtitulo, contenido, img, fecha_creacion) VALUES (?,?,?,?,?)");

    $insert->bindParam(1, $titulo);
    $insert->bindParam(2, $subtitulo);
    $insert->bindParam(3, $contenido);
    $insert->bindParam(4, $img);
    $insert->bindParam(5, $fecha_craecion);
    $todobien = $insert->execute();

    if ($todobien) {
        $respuesta =  "Creado Correctamente";
    } else {
        $respuesta = "Error";
    }

    unset($insert);
    unset($conexion);

    return $respuesta;
}




