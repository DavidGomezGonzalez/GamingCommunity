<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './Funciones.php';

error_reporting(0);
session_start();

header("Content-Type: application/json; charset=UTF-8");

if ($_REQUEST['accion']) {
    $accion = $_REQUEST['accion'];
}

if ($_REQUEST["objeto"]) {
    $obj = json_decode($_REQUEST["objeto"], false);
}





switch ($accion) {
    case "registarse":
        $respuesta = Registrarse($obj->nick, $obj->nombre, $obj->apellidos, $obj->pass, $obj->email);
        echo json_encode($respuesta);
        break;
    case "verificarNick":
        $respuesta = verificarNick($obj->nick);
        echo json_encode($respuesta);
        break;
    case "verificarEmail":
        $respuesta = verificarEmail($obj->email);
        echo json_encode($respuesta);
        break;
    case "iniciarSesion":
        $respuesta = iniciarSesionEmail($obj->email, $obj->pass);

        if ($respuesta == FALSE) {
            $respuesta = iniciarSesionNick($obj->email, $obj->pass);
            if ($respuesta == TRUE) {
                $_SESSION['user'] = $obj->email;
            }
        } else {
            $_SESSION['user'] = verNick($obj->email);
        }

        echo json_encode($respuesta);
        break;
    case "guardarComentarioForo":
        $respuesta = insetarComentarioForo($obj->contenido, $obj->fecha, $obj->user, $obj->id_tema);
        echo json_encode($respuesta);
        break;
    case "guardarTemaForo":
        $respuesta = insetarTemaForo($obj->titulo, $obj->contenido, $obj->user, $obj->fecha);
        echo json_encode($respuesta);
        break;

    default:
        break;
}
