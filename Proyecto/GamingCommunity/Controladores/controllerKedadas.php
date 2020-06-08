<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './FuncionesKedadas.php';

//error_reporting(0);
session_start();

header("Content-Type: application/json; charset=UTF-8");


if ($_REQUEST["accion"]) {
    $accion = $_REQUEST["accion"];
}


switch ($accion) {
    case "insertarParticipante":
        $respuesta = insetarParticipante($_REQUEST['id'], $_REQUEST['user']);
        echo json_encode($respuesta);
        break;
    case "verificarParticipante":
        $respuesta = verificarKedadaParticipante($_REQUEST['id'], $_REQUEST['user']);
        echo json_encode($respuesta);
        break;
    case "crearKedada":
        $respuesta = insetarKedada($_REQUEST["titulo"], $_REQUEST["contenido"], $_REQUEST["img"], $_REQUEST["direccion"], $_REQUEST["f_inicio"], $_REQUEST["f_fin"], $_REQUEST["lat"], $_REQUEST["lng"]);
        echo json_encode($respuesta);
        break;
    case "obtenerKedadas":
        $respuesta = ver_Kedadas();
        echo json_encode($respuesta);
        break;
    default:
        break;
}
