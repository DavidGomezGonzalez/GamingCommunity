<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author david
 */
include_once '../Modelo/Conexion.php';

class Usuario {

    private $nick;
    private $nombre;
    private $apellidos;
    private $pass;
    private $tipo;
    private $email;

    function __construct($nick, $nombre, $apellidos, $pass, $tipo, $email) {
        $this->nick = $nick;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->pass = $pass;
        $this->tipo = $tipo;
        $this->email = $email;
    }

    public static function verificarUsuario($nick) {
        $conexion = Conexion::conectar();

        $repetido = false;
        $resultado = $conexion->query("SELECT nick FROM users WHERE nick='" . $nick . "'");
        $resultado2 = $resultado->fetch(PDO::FETCH_ASSOC);
        if ($resultado2) {
            $repetido = TRUE;
        }

        unset($conexion);
        return $repetido;
    }
    
    public static function verificarEmail($email) {
        $conexion = Conexion::conectar();

        $repetido = false;
        $resultado = $conexion->query("SELECT * FROM users WHERE email='" . $email . "'");
        $resultado2 = $resultado->fetch(PDO::FETCH_ASSOC);
        if ($resultado2) {
            $repetido = TRUE;
        }

        unset($conexion);
        return $repetido;
    }

    function importarBD($nick, $password, $email, $nombre, $apellidos, $tipo) {

        $conexion = Conexion::conectar();

        $insert = $conexion->prepare("INSERT INTO users (nick, password, email, nombre, apellidos, tipo) VALUES (?,?,?,?,?,?)");

        $insert->bindParam(1, $nick);
        $insert->bindParam(2, $password);
        $insert->bindParam(3, $email);
        $insert->bindParam(4, $nombre);
        $insert->bindParam(5, $apellidos);
        $insert->bindParam(6, $tipo);
        $todobien = $insert->execute();

        if ($todobien) {
            echo "Creado Correctamente";
        } else {
            echo "Error";
        }

        unset($insert);
        unset($conexion);
    }

    function getNick() {
        return $this->nick;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getPass() {
        return $this->pass;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getEmail() {
        return $this->email;
    }

    function setNick($nick) {
        $this->nick = $nick;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setEmail($email) {
        $this->email = $email;
    }

}
