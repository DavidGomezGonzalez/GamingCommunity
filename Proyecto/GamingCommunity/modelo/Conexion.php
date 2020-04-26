<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Conexion
{

    public static function conectar()
    {
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $conexion = new PDO("mysql:host=localhost;dbname=gamingcommunity", "root", "Alfonso11", $opciones);
        return $conexion;
    }
    public static function conectarMysqli()
    {
        $conn = new mysqli('localhost', 'root', 'Alfonso11', 'gamingcommunity');
        return $conn;
    }
}
