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

    $noticia = array();


    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
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


function insetarValoracion($user, $user_valorado, $puntuacion)
{
    $conexion = Conexion::conectar();
    $respuesta = "";
    $insert = $conexion->prepare("INSERT INTO votos (valoracion, user_valorado, nick_user) VALUES (?,?,?)");

    $insert->bindParam(1, $puntuacion);
    $insert->bindParam(2, $user_valorado);
    $insert->bindParam(3, $user);

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


function votos_puntuacion($nick, $user_valorado)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM votos WHERE nick_user = '" . $nick . "' AND user_valorado = '" . $user_valorado . "'");

    $puntuacion = 0;

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $puntuacion = $row["valoracion"];
        }
    }

    unset($conexion);

    return $puntuacion;
}

function verComentarios($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM comentarios_noticias WHERE id_noticia = " . $id . " ORDER BY fecha_creacion DESC");
    $temas = array();
    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tema = array();
            $tema["id"] = $row["id"];
            $tema["contenido"] = $row["contenido"];
            $tema["fecha_creacion"] = $row["fecha_creacion"];
            $tema["nick_user"] = $row["nick_user"];
            array_push($temas, $tema);
        }
    }

    unset($conexion);

    return $temas;
}


function comentariosNoticia($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT count(*) FROM comentarios_noticias WHERE id_noticia = " . $id . "")->fetchColumn();

    echo $resultado;

    unset($conexion);
}


function insetarComentario($contenido, $fecha, $user, $id_noticia)
{
    $conexion = Conexion::conectar();
    $respuesta = "";
    $insert = $conexion->prepare("INSERT INTO comentarios_noticias (contenido, fecha_creacion, nick_user, id_noticia) VALUES (?,?,?,?)");

    $insert->bindParam(1, $contenido);
    $insert->bindParam(2, $fecha);
    $insert->bindParam(3, $user);
    $insert->bindParam(4, $id_noticia);

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


function verRoot($nick)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT tipo FROM users WHERE nick = '$nick'");

    $tipo = null;


    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tipo = $row["tipo"];
        }
    }

    if ($tipo == 1) {
        $tipo = "root";
    }

    unset($conexion);

    return $tipo;
}
