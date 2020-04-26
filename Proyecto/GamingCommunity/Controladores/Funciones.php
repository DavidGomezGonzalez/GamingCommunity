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
    $resultado = $conexion->query("SELECT nick FROM users WHERE email = '" . $email . "'");

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $nick = $row["nick"];
        }
    }

    unset($conexion);

    return $nick;
}

function cambiarFecha($fecha)
{
    $fech = explode(" ", $fecha);

    $fe = explode("-", $fech[0]);

    $fechaFinal = "" . $fe[2] . "/" . $fe[1] . "/" . $fe[0] . " " . $fech[1];

    echo $fechaFinal;
}


function visitasForo($id_tema)
{
    $vistas = 0;
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM tema WHERE id = " . $id_tema . "");

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $vistas = $row["vistas"];
            $vistas += 1;
        }
    }

    unset($conexion);
    visitasForoInsertar($id_tema, $vistas);
}

function visitasForoInsertar($id_tema, $vistas)
{

    $conexion = Conexion::conectar();
    $conexion->beginTransaction();

    $insert = $conexion->prepare("UPDATE tema  SET vistas=? WHERE id = ?");

    $insert->bindParam(1, $vistas);
    $insert->bindParam(2, $id_tema);

    $todobien = $insert->execute();

    if ($todobien == TRUE) {
        $conexion->commit();
    } else {
        $conexion->rollback();
    }

    unset($conexion);
}

function respuestasTema($id_tema)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT count(*) FROM comentarios WHERE id_tema = " . $id_tema . "")->fetchColumn();

    echo $resultado;

    unset($conexion);
}


function ultimoComentarioForo($id_tema)
{

    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM comentarios WHERE id_tema = " . $id_tema . " ORDER BY fecha_creacion DESC LIMIT 1");

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $nick = $row["nick_user"];

            echo "<a href='#'>";
            echo $nick;
            echo "</a></p><p>";
            echo $row['fecha_creacion'];
        }
    }

    if (!$nick) {

        $conexion2 = Conexion::conectar();
        $resultado2 = $conexion2->query("SELECT * FROM tema WHERE id = " . $id_tema . "");
        if ($resultado2) {
            while ($row2 = $resultado2->fetch(PDO::FETCH_ASSOC)) {
                echo "<a href='#'>";
                echo $row2["autor_nick"];
                echo "</a></p><p>";
                echo $row2['fecha_creacion'];
            }
            unset($conexion2);
        }
    }

    unset($conexion);
}

function existe_Avatar($nick)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM users WHERE nick = '" . $nick . "'");

    $foto_Avatar = "";

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $foto_Avatar = $row["foto_Avatar"];
        }
    }

    unset($conexion);

    return $foto_Avatar;
}
