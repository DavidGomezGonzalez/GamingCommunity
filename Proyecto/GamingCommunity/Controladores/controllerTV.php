<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './FuncionesTV.php';

//error_reporting(0);
session_start();

header("Content-Type: application/json; charset=UTF-8");


if ($_REQUEST["accion"]) {
    $accion = $_REQUEST["accion"];
}


switch ($accion) {
    case "top_stream":
        $n_peticiones = $_REQUEST["n_peticiones"];
        $respuesta = top_Stream($n_peticiones);
        echo json_encode($respuesta);
        break;
    case "id_game":
        $respuesta = id_Game($_REQUEST["id_game"]);
        echo json_encode($respuesta);
        break;
    case "url_channel":
        $respuesta = url_Channel($_REQUEST["id_channel"]);
        echo json_encode($respuesta);
        break;
    case "stream_castellano":
        $n_peticiones = $_REQUEST["n_peticiones"];
        $respuesta = stream_Castellano($n_peticiones);
        echo json_encode($respuesta);
        break;
    default:
        break;
}
