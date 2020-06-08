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

        if ($respuesta == TRUE) {
            $resp = verRoot($_SESSION['user']);

            if ($resp == "root") {
                $respuesta = "root";
            }
        }

        echo json_encode($respuesta);
        break;
    case "iniciarSesionGoogle":

        $_SESSION['user'] = $obj->name;
        $_SESSION['foto_avatar'] = $obj->image;

        echo json_encode("Logged");
        break;
    case "guardarComentarioForo":
        $respuesta = insetarComentarioForo($obj->contenido, $obj->fecha, $obj->user, $obj->id_tema, $obj->id_tema);
        echo json_encode($respuesta);
        break;
    case "guardarTemaForo":
        $respuesta = insetarTemaForo($obj->titulo, $obj->contenido, $obj->user, $obj->fecha, $obj->plataforma);
        echo json_encode($respuesta);
        break;
    case "editarTemaForo":
        $respuesta = editarTemaForo($obj->titulo, $obj->contenido, $obj->fecha, $obj->id);
        echo json_encode($respuesta);
        break;
    case "verGame":
        $respuesta = verGame($obj->titulo, $obj->plataforma);
        echo json_encode($respuesta);
        break;
    case "insertarGame":
        $respuesta = insetarGame($obj->titulo, $obj->descripcion, $obj->plataformas, $obj->plataforma, $obj->img, $obj->developer, $obj->fecha, $obj->genero);
        echo json_encode($respuesta);
        break;
    case "verLikes_Dislikes":
        $respuesta = verLikes_Dislikes($obj->id);
        echo json_encode($respuesta);
        break;
    case "insertarLikes":
        $respuesta = Likes_DislikesInsertar($obj->id, $obj->likes, $obj->dislikes);
        echo json_encode($respuesta);
        break;
    case "verLikes_Dislikes_votos":
        $respuesta = verLikes_Dislikes_Votos($obj->id, $obj->user);
        echo json_encode($respuesta);
        break;
    case "buscarNoticia":
        $respuesta = verNoticiasBuscador($obj->noticia);
        echo json_encode($respuesta);
        break;
    case "verEmail":
        $respuesta = email_User_Nick($obj->nick_user);
        echo json_encode($respuesta);
        break;
    case "insertarCarrito":
        $respuesta = insertarCarrito($obj->game, $obj->plataforma, $obj->precio, $obj->img);
        echo json_encode($respuesta);
        break;
    case "insertarLikesVotos":
        $array = verLikes_Dislikes_Votos($obj->id, $obj->user);

        if (count($array) == 0) {
            $respuesta = insetar_Votos_LikeDislike($obj->id, $obj->user, $obj->likes, $obj->dislikes);
            echo json_encode($respuesta);
        } else {
            $respuesta = update_Votos_Like($obj->id, $obj->user, $obj->likes, $obj->dislikes);
            echo json_encode($respuesta);
        }

        break;
    default:
        break;
}
