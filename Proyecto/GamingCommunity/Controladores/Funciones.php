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

function verRoot($nick)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT tipo FROM users WHERE nick = '$nick'");

    $tipo = null;


    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tipo = $row["tipo"];
        }
    }

    if ($tipo == 1) {
        $tipo = "root";
    }

    unset($conexion);

    return $tipo;
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

            echo "<a href='verForo.php?id=" . $id_tema . "&ultimo=yes'>" . $nick . "</a></p><p>";

            $fecha = $row['fecha_creacion'];
            $fecha = cambiarFecha($fecha);
            echo $fecha;
        }
    }

    if (!$nick) {

        $conexion2 = Conexion::conectar();
        $resultado2 = $conexion2->query("SELECT * FROM tema WHERE id = " . $id_tema . "");
        if ($resultado2) {
            while ($row2 = $resultado2->fetch(PDO::FETCH_ASSOC)) {
                echo "<a href='verForo.php?id=" . $id_tema . "&ultimo=yes'>" . $row2["autor_nick"] . "</a></p><p>";
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

function email_User_Nick($nick)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM users WHERE nick = '" . $nick . "'");

    $email = "";

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $email = $row["email"];
        }
    }

    unset($conexion);

    return $email;
}


function insetarComentarioForo($contenido, $fecha, $nick, $id_tema)
{
    $conexion = Conexion::conectar();

    $insert = $conexion->prepare("INSERT INTO comentarios (contenido, fecha_creacion, nick_user, id_tema) VALUES (?,?,?,?)");

    $insert->bindParam(1, $contenido);
    $insert->bindParam(2, $fecha);
    $insert->bindParam(3, $nick);
    $insert->bindParam(4, $id_tema);
    $todobien = $insert->execute();

    if ($todobien) {
        echo "Creado Correctamente";
    } else {
        echo "Error";
    }

    unset($insert);
    unset($conexion);
}

function insetarTemaForo($titulo, $contenido, $autor, $fecha, $plataformas)
{
    $conexion = Conexion::conectar();

    $insert = $conexion->prepare("INSERT INTO tema (titulo, contenido, fecha_creacion, abierto, autor_nick, vistas, plataforma) VALUES (?,?,?,?,?,?,?)");

    $abierto = TRUE;
    $vistas = 0;

    $insert->bindParam(1, $titulo);
    $insert->bindParam(2, $contenido);
    $insert->bindParam(3, $fecha);
    $insert->bindParam(4, $abierto);
    $insert->bindParam(5, $autor);
    $insert->bindParam(6, $vistas);
    $insert->bindParam(7, $plataformas);
    $todobien = $insert->execute();

    if ($todobien) {
        echo "Creado Correctamente";
    } else {
        echo "Error";
    }

    unset($insert);
    unset($conexion);
}

function editarTemaForo($titulo, $contenido, $fecha, $id)
{
    $conexion = Conexion::conectar();
    $conexion->beginTransaction();

    $insert = $conexion->prepare("UPDATE tema SET titulo=?,  contenido=?, fecha_creacion=? WHERE id = ?");

    $insert->bindParam(1, $titulo);
    $insert->bindParam(2, $contenido);
    $insert->bindParam(3, $fecha);
    $insert->bindParam(4, $id);

    $todobien = $insert->execute();

    if ($todobien == TRUE) {
        $conexion->commit();
        echo "Modificado Correctamente";
    } else {
        $conexion->rollback();
        echo "Error";
    }
    unset($conexion);
}


function verForo($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM tema WHERE id = " . $id . "");
    $tema = array();
    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tema["titulo"] = $row["titulo"];
            $tema["contenido"] = $row["contenido"];
            $tema["fecha"] = $row["fecha_creacion"];
            $tema["abierto"] = $row["abierto"];
            $tema["autor"] = $row["autor_nick"];
            $tema["visitas"] = $row["vistas"];
        }
    }

    unset($conexion);

    return $tema;
}


function votosUsuario($user)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT count(*) FROM votos WHERE user_valorado = '" . $user . "'")->fetchColumn();

    unset($conexion);

    return $resultado;
}


function verPuntuacionUser($nick)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM votos WHERE user_valorado = '" . $nick . "'");
    $valoracion = 0;
    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $valoracion += $row["valoracion"];
        }
    }

    unset($conexion);

    return $valoracion;
}

function verUserVotados()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT DISTINCT user_valorado FROM votos");
    $users = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $user = array();
            $user = $row["user_valorado"];
            array_push($users, $user);
        }
    }

    unset($conexion);

    return $users;
}


function verGame($titulo, $plataforma)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM games WHERE titulo = '" . $titulo . "' AND plataforma ='" . $plataforma . "'");
    $game = array();
    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $game["id"] = $row["id"];
            $game["titulo"] = $row["titulo"];
            $game["descripcion"] = $row["descripcion"];
            $game["plataformas_compatibles"] = $row["plataformas_compatibles"];
            $game["plataforma"] = $row["plataforma"];
            $game["img"] = $row["img"];
            $game["developer"] = $row["developer"];
            $game["fecha_publicacion"] = $row["fecha_publicacion"];
        }
    }

    unset($conexion);

    return $game;
}


function insetarGame($titulo, $descripcion, $plataformas, $plataforma, $img, $developer, $fecha, $genero)
{
    $conexion = Conexion::conectar();

    $insert = $conexion->prepare("INSERT INTO games (titulo, descripcion, plataformas_compatibles, plataforma, img, developer, fecha_publicacion, genero) VALUES (?,?,?,?,?,?,?,?)");

    $insert->bindParam(1, $titulo);
    $insert->bindParam(2, $descripcion);
    $insert->bindParam(3, $plataformas);
    $insert->bindParam(4, $plataforma);
    $insert->bindParam(5, $img);
    $insert->bindParam(6, $developer);
    $insert->bindParam(7, $fecha);
    $insert->bindParam(8, $genero);
    $todobien = $insert->execute();

    if ($todobien) {
        echo "Creado Correctamente";
    } else {
        //echo "Error";
        print_r($insert->errorInfo());
    }

    unset($insert);
    unset($conexion);
}

function verLikes_Dislikes($id)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM tema WHERE id = " . $id . "");
    $tema = array();
    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tema["me_gustas"] = $row["me_gustas"];
            $tema["no_me_gustas"] = $row["no_me_gustas"];
        }
    }

    unset($conexion);

    return $tema;
}

function Likes_DislikesInsertar($id, $likes, $dislikes)
{

    $conexion = Conexion::conectar();
    $conexion->beginTransaction();

    $insert = $conexion->prepare("UPDATE tema SET me_gustas=?,  no_me_gustas=? WHERE id = ?");

    $insert->bindParam(1, $likes);
    $insert->bindParam(2, $dislikes);
    $insert->bindParam(3, $id);

    $todobien = $insert->execute();

    if ($todobien == TRUE) {
        $conexion->commit();
        echo "Modificado Correctamente";
    } else {
        $conexion->rollback();
        echo "Error";
    }

    unset($conexion);
}


function insetar_Votos_LikeDislike($id_tema, $nick, $likes, $dislikes)
{
    $conexion = Conexion::conectar();

    $insert = $conexion->prepare("INSERT INTO votos_likes (id_tema, nick_user, me_gusta, no_me_gusta) VALUES (?,?,?,?)");

    $insert->bindParam(1, $id_tema);
    $insert->bindParam(2, $nick);
    $insert->bindParam(3, $likes);
    $insert->bindParam(4, $dislikes);
    $todobien = $insert->execute();

    if ($todobien) {
        echo "Creado Correctamente";
    } else {
        //echo "Error";
        print_r($insert->errorInfo());
    }

    unset($insert);
    unset($conexion);
}


function verLikes_Dislikes_Votos($id, $nick)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM votos_likes  WHERE id_tema = " . $id . " AND nick_user ='" . $nick . "'");
    $tema = array();
    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tema["me_gusta"] = $row["me_gusta"];
            $tema["no_me_gusta"] = $row["no_me_gusta"];
        }
    }

    unset($conexion);

    return $tema;
}


function update_Votos_Like($id_tema, $user, $likes, $dislikes)
{

    $conexion = Conexion::conectar();
    $conexion->beginTransaction();

    $insert = $conexion->prepare("UPDATE votos_likes  SET me_gusta=?, no_me_gusta=?  WHERE id_tema = ? AND nick_user = ?");

    $insert->bindParam(1, $likes);
    $insert->bindParam(2, $dislikes);
    $insert->bindParam(3, $id_tema);
    $insert->bindParam(4, $user);

    $todobien = $insert->execute();


    if ($todobien == TRUE) {
        $conexion->commit();
        echo "Modificado Correctamente";
    } else {
        $conexion->rollback();
        echo "Error";
    }

    unset($conexion);
}


function verforosRankingLikes()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM tema ORDER BY me_gustas DESC");
    $temas = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tema = array();
            $tema["id"] = $row["id"];
            $tema["titulo"] = $row["titulo"];
            $tema["contenido"] = $row["contenido"];
            $tema["fecha_creacion"] = $row["fecha_creacion"];
            $tema["abierto"] = $row["abierto"];
            $tema["autor_nick"] = $row["autor_nick"];
            $tema["vistas"] = $row["vistas"];
            $tema["me_gustas"] = $row["me_gustas"];
            $tema["no_me_gustas"] = $row["no_me_gustas"];
            array_push($temas, $tema);
        }
    }

    unset($conexion);

    return $temas;
}

function verforosRankingDisLikes()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM tema ORDER BY no_me_gustas DESC");
    $temas = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tema = array();
            $tema["id"] = $row["id"];
            $tema["titulo"] = $row["titulo"];
            $tema["contenido"] = $row["contenido"];
            $tema["fecha_creacion"] = $row["fecha_creacion"];
            $tema["abierto"] = $row["abierto"];
            $tema["autor_nick"] = $row["autor_nick"];
            $tema["vistas"] = $row["vistas"];
            $tema["me_gustas"] = $row["me_gustas"];
            $tema["no_me_gustas"] = $row["no_me_gustas"];
            array_push($temas, $tema);
        }
    }

    unset($conexion);

    return $temas;
}

function verforosRankingVisitas()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM tema ORDER BY vistas DESC");
    $temas = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tema = array();
            $tema["id"] = $row["id"];
            $tema["titulo"] = $row["titulo"];
            $tema["contenido"] = $row["contenido"];
            $tema["fecha_creacion"] = $row["fecha_creacion"];
            $tema["abierto"] = $row["abierto"];
            $tema["autor_nick"] = $row["autor_nick"];
            $tema["vistas"] = $row["vistas"];
            $tema["me_gustas"] = $row["me_gustas"];
            $tema["no_me_gustas"] = $row["no_me_gustas"];
            array_push($temas, $tema);
        }
    }

    unset($conexion);

    return $temas;
}

function verId_tema_UltComentarios()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT DISTINCT id_tema FROM comentarios ORDER BY fecha_creacion DESC");
    $temas = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tema = array();
            $tema["id_tema"] = $row["id_tema"];
            array_push($temas, $tema);
        }
    }

    unset($conexion);

    return $temas;
}


function verNoticiasBuscador($noticia)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM noticias WHERE lower(titulo) LIKE " . "'" . $noticia . "%'" . " OR lower(titulo) LIKE " . "'%" . $noticia . "%'");
    $noticias = array();
    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $noticia = array();
            $noticia["id"] = $row["id"];
            $noticia["titulo"] = $row["titulo"];
            $noticia["subtitulo"] = $row["subtitulo"];
            $noticia["contenido"] = $row["contenido"];
            $noticia["img"] = $row["img"];
            $noticia["fecha_creacion"] = $row["fecha_creacion"];
            array_push($noticias, $noticia);
        }
    }

    unset($conexion);

    return $noticias;
}



function verPlataformasBD()
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM plataformas");
    $plataformas = array();

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $plataforma = array();
            $plataforma["titulo"] = $row["titulo"];
            $plataforma["value"] = $row["value"];
            array_push($plataformas, $plataforma);
        }
    }

    unset($conexion);
    return $plataformas;
}

function verTituloPlataformas($value)
{
    $conexion = Conexion::conectar();
    $resultado = $conexion->query("SELECT * FROM plataformas WHERE value ='" . $value . "'");

    if ($resultado) {
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $titulo = $row["titulo"];
        }
    }

    unset($conexion);
    return $titulo;
}

function insertarCarrito($game, $plataforma, $precio, $img)
{
    session_start();

    $repetido = FALSE;

    if (empty($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    } else {

        for ($i = 0; $i < count($_SESSION['carrito']); $i++) {

            if ($_SESSION['carrito'][$i]['game'] == $game && $_SESSION['carrito'][$i]['plataforma'] == $plataforma) {
                $repetido = TRUE;
            }
        }
    }

    $array = [
        "game" => $game,
        "plataforma" => $plataforma,
        "precio" => $precio,
        "img" => $img
    ];

    if ($repetido == FALSE) {
        array_push($_SESSION['carrito'], $array);
        $res = "Insertado ha Carrito";
    } else {
        $res = "Repetido";
    }


    return $res;
}
