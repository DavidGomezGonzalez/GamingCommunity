<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './FuncionesNoticias.php';

//error_reporting(0);
session_start();

header("Content-Type: application/json; charset=UTF-8");


if ($_REQUEST["accion"]) {
    $accion = $_REQUEST["accion"];
}


switch ($accion) {
    case "carrusel":
        $respuesta = ver_Noticias_Carrousel();
        echo json_encode($respuesta);
        break;
    case "noticias":
        $respuesta = ver_Noticias();
        echo json_encode($respuesta);
        break;
    case "crearNoticia":
        $respuesta = insetarNoticia($_REQUEST["titulo"], $_REQUEST["subtitulo"], $_REQUEST["contenido"], $_REQUEST["img"], $_REQUEST["fecha"]);
        echo json_encode($respuesta);
        break;
    case "valoracion":
        $respuesta = insetarValoracion($_REQUEST['user'], $_REQUEST['user_valorado'], $_REQUEST["puntuacion"]);
        echo json_encode($respuesta);
        break;
    case "verpuntuacion":
        $respuesta = votos_puntuacion($_REQUEST['user'], $_REQUEST['user_valorado']);
        echo json_encode($respuesta);
        break;
    case "insertarComentario":
        $respuesta = insetarComentario($_REQUEST['contenido'], $_REQUEST['fecha'], $_REQUEST['user'], $_REQUEST['id_noticia']);
        echo json_encode($respuesta);
        break;
    default:
        break;
}
