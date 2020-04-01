<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once '../Modelo/Usuario.php';
include_once '../Modelo/Password.php';
error_reporting(0);

function Registrarse($nick, $nombre, $apellidos, $pass, $email)
{


    //Encriptar Password
    $hash = Password::hash($pass);

    $usuario = new Usuario($nick, $nombre, $apellidos, $hash, 0, $email);

    $repetido = Usuario::verificarUsuario($nick);
    $repetidoEmail = Usuario::verificarEmail($email);

    //var_dump($repetido);

    if (!$repetido) {
        if (!$repetidoEmail) {
            $resultado = $usuario->importarBD($usuario->getNick(), $usuario->getPass(), $usuario->getEmail(), $usuario->getNombre(), $usuario->getApellidos(), $usuario->getTipo());
        } else {
            return "Email";
        }
    } else {
        return "Usuario";
    }
}

function verificarNick($nick)
{
    $respuesta = Usuario::verificarUsuario($nick);
    return $respuesta;
}

function verificarEmail($email)
{
    $respuesta = Usuario::verificarEmail($email);
    return $respuesta;
}


function iniciarSesionNick($nick, $passwd)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT password FROM users WHERE nick = '$nick'");
    $correcta = false;

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $password = $row["password"];
        }


        // Comprobar la contraseña introducida
        if (Password::verify($passwd, $password)) {
            $correcta = true;
        } else {
            $correcta = false;
        }
    }

    unset($conexion);

    return $correcta;
}
function iniciarSesionEmail($email, $passwd)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT password FROM users WHERE email = '$email'");
    $correcta = false;

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $password = $row["password"];
        }


        // Comprobar la contraseña introducida
        if (Password::verify($passwd, $password)) {
            $correcta = true;
        } else {
            $correcta = false;
        }
    }

    unset($conexion);

    return $correcta;
}


function verNick($email)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT nick FROM users WHERE email = '$email'");

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $nick = $row["nick"];
        }
    }

    unset($conexion);

    return $nick;
}
