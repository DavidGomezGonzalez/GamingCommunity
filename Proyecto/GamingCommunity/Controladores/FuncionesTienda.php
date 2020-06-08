<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once '../Modelo/Usuario.php';
include_once '../Modelo/Password.php';
include_once '../Modelo/Conexion.php';
error_reporting(0);


function verGamesShop()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM games WHERE plataforma='pc'");
    $games = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $game = array();
            $game["id"] = $row["id"];
            $game["titulo"] = $row["titulo"];
            $game["descripcion"] = $row["descripcion"];
            $game["plataformas_compatibles"] = $row["plataformas_compatibles"];
            $game["plataforma"] = $row["plataforma"];
            $game["img"] = $row["img"];
            $game["developer"] = $row["developer"];
            $game["fecha_publicacion"] = $row["fecha_publicacion"];
            $game["genero"] = $row["genero"];
            array_push($games, $game);
        }
    }

    unset($conexion);

    return $games;
}

function verGamesShopId($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM games WHERE id=" . $id . "");

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $game = array();
            $game["id"] = $row["id"];
            $game["titulo"] = $row["titulo"];
            $game["descripcion"] = $row["descripcion"];
            $game["plataformas_compatibles"] = $row["plataformas_compatibles"];
            $game["plataforma"] = $row["plataforma"];
            $game["img"] = $row["img"];
            $game["developer"] = $row["developer"];
            $game["fecha_publicacion"] = $row["fecha_publicacion"];
            $game["genero"] = $row["genero"];
        }
    }

    unset($conexion);

    return $game;
}



function verPlataformas($titulo, $plataforma)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT DISTINCT plataforma, img, id FROM games WHERE titulo='" . $titulo . "' AND plataforma !='" . $plataforma . "'");

    $games = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $game = array();
            $game["id"] = $row["id"];
            $game["plataforma"] = $row["plataforma"];
            $game["img"] = $row["img"];
            array_push($games, $game);
        }
    }

    unset($conexion);

    return $games;
}
