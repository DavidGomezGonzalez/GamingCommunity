<?php

include_once '../Modelo/Conexion.php';


function ver_Kedadas()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM kedadas ORDER BY fecha_inicio");

    $kedadas = array();


    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $kedada = array();
            $kedada["id"] = $row["id"];
            $kedada["titulo"] = $row["titulo"];
            $kedada["contenido"] = $row["contenido"];
            $kedada["fecha_inicio"] = $row["fecha_inicio"];
            $kedada["fecha_fin"] = $row["fecha_fin"];
            $kedada["imagen"] = $row["imagen"];
            $kedada["lugar"] = $row["lugar"];
            $kedada["lat"] = $row["lat"];
            $kedada["lng"] = $row["lng"];
            array_push($kedadas, $kedada);
        }
    }

    unset($conexion);

    return $kedadas;
}

function ver_Kedadas_id($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM kedadas WHERE id = " . $id . "");


    $kedada = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $kedada["id"] = $row["id"];
            $kedada["titulo"] = $row["titulo"];
            $kedada["contenido"] = $row["contenido"];
            $kedada["fecha_inicio"] = $row["fecha_inicio"];
            $kedada["fecha_fin"] = $row["fecha_fin"];
            $kedada["imagen"] = $row["imagen"];
            $kedada["lugar"] = $row["lugar"];
            $kedada["lat"] = $row["lat"];
            $kedada["lng"] = $row["lng"];
        }
    }

    unset($conexion);

    return $kedada;
}


function insetarParticipante($id_kedada, $nick_user)
{
    $conexion = Conexion::conectar();
    $respuesta = "";
    $insert = $conexion->prepare("INSERT INTO participantes (id_kedada, nick_user) VALUES (?,?)");

    $insert->bindParam(1, $id_kedada);
    $insert->bindParam(2, $nick_user);
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


function verificarKedadaParticipante($id, $nick)
{
    $conexion = Conexion::conectar();

    $existe = FALSE;
    $resultado = $conexion->query("SELECT * FROM participantes WHERE nick_user='" . $nick . "' AND id_kedada=" . $id . "");
    $resultado2 = $resultado->fetch(PDO::FETCH_ASSOC);
    if ($resultado2) {
        $existe = TRUE;
    }

    unset($conexion);
    return $existe;
}

function participantesKedada($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT count(*) FROM participantes WHERE id_kedada = " . $id . "")->fetchColumn();

    unset($conexion);

    return $resultado;
}


function insetarKedada($titulo, $contenido, $img, $direccion, $f_inicio, $f_fin, $lat, $lng)
{
    $conexion = Conexion::conectar();
    $respuesta = "";
    $insert = $conexion->prepare("INSERT INTO kedadas (titulo, contenido, fecha_inicio, fecha_fin, imagen, lugar, lat, lng) VALUES (?,?,?,?,?,?,?,?)");

    $insert->bindParam(1, $titulo);
    $insert->bindParam(2, $contenido);
    $insert->bindParam(3, $f_inicio);
    $insert->bindParam(4, $f_fin);
    $insert->bindParam(5, $img);
    $insert->bindParam(6, $direccion);
    $insert->bindParam(7, $lat);
    $insert->bindParam(8, $lng);
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


function verParticipantesKedadas($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM participantes WHERE id_kedada = " . $id . "");


    $kedadas = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $kedada = array();
            $kedada["nick_user"] = $row["nick_user"];
            array_push($kedadas, $kedada);
        }
    }

    unset($conexion);

    return $kedadas;
}
