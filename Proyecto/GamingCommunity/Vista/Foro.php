<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<script src="../JavaScript/jQuery v3.4.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" <link rel="stylesheet" href="http://path/to/font-awesome/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php
session_start();
//error_reporting(0);
if ($_SESSION['user'] != "") {
    $user = $_SESSION['user'];
}
?>

<?php
require_once '../modelo/Paginator.php';
require_once '../modelo/Conexion.php';
require_once '../Controladores/Funciones.php';


$conn = Conexion::conectarMysqli();

$limit      = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
$page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
$links      = (isset($_GET['links'])) ? $_GET['links'] : 7;
$query      = "SELECT * FROM tema";

$Paginator  = new Paginator($conn, $query);

$results    = $Paginator->getData($limit, $page);
?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    #contenedor {
        width: 100%;
    }

    #cabecera {
        width: 100%;
        display: inline-flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: nowrap;
        background-color: black;
    }

    #sub_cabecera {
        display: inline-flex;
        align-items: center;
        flex-wrap: nowrap;
    }

    #sub_cabecera_right {
        background-color: transparent;
        padding: 5px 10px;

        display: inline-flex;
        text-align: center;
        justify-content: flex-end;
    }

    #sub_cabecera_right img {
        width: 70px;
        border: 1px solid black;
        border-radius: 50%;
        background-color: white;

        margin-bottom: 10px;
    }

    #sub_cabecera_right span {
        color: white;
        width: auto;
    }

    #sub_cabecera input {
        padding: 5px;
        height: 30px;
        border-radius: 10px;
        border: 2px solid white;
    }

    #sub_cabecera button {
        font-size: 2rem;
        border: none;
        background-color: transparent;
    }

    #logo {
        background-image: url("../img/logo.svg");
        display: flex;
        width: 95vh;
        height: 19vh;
        background-repeat: no-repeat;
        background-position: center;
    }


    #cerrar_sesion {
        width: auto;
    }

    #cerrar_sesion img {
        width: 27px;
    }


    #sub_cabecera_right_left {
        display: flex;
        flex-direction: column;
        align-items: center;
    }


    #sub_cabecera_right_right {
        display: flex;
        align-items: center;
        margin-left: 10px;
    }

    .disabled a {
        cursor: no-drop;
        pointer-events: none !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
    }

    h3 {
        border: 2px solid red;
        padding: 5px;
        margin: 0;
    }

    #sub_opciones {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        border: 2px solid black;
        padding: 30px 0;
        text-align: center;

    }

    #sub_opciones>div {
        display: flex;
        flex-direction: column;
    }

    #leyendas-permisos {
        margin-top: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
    }

    #leyenda {
        display: flex;
        flex-direction: column;
        width: 47%;
        border: 2px solid black;
    }

    #permisos {
        display: flex;
        flex-direction: column;
        width: 47%;
        border: 2px solid black;

    }

    #contenido {
        padding: 1% 5%;
    }



    /***************************** MENU Hamburguesa ********************************************/

    .nav {
        padding: 5px;
        margin: 0;
        background-color: #fff;
        box-shadow: 1px 1px 4px 0 rgba(0, 0, 0, 0.1);
        width: 100%;
        height: 70px;
        z-index: 3;
        background-color: #2486b7;

        margin-bottom: 20px;
    }

    .nav ul {
        margin: 0;
        padding: 0;
        list-style: none;
        overflow: hidden;
        background-color: #fff;
        background-color: #2486b7;
    }

    .nav li a {
        display: block;
        padding: 20px 20px;
        text-decoration: none;
        color: white;
        font-family: "Raleway";
    }

    .activa {
        background-color: #f4f4f4;
        color: #0d557a !important;
    }

    .nav li:hover,
    .nav .menu-btn:hover {
        background-color: #0d557a;
        color: white !important;
    }

    .nav .menu {
        clear: both;
        max-height: 0;
        transition: max-height 0.2s ease-out;
    }

    /* menu icon */

    .nav .menu-icon {
        cursor: pointer;
        display: inline-block;
        float: right;
        padding: 28px 40px;
        position: relative;
        user-select: none;
    }

    .nav .menu-icon .navicon {
        background: #333;
        display: block;
        height: 2px;
        position: relative;
        transition: background 0.2s ease-out;
        width: 18px;
    }

    .nav .menu-icon .navicon:before,
    .nav .menu-icon .navicon:after {
        background: #333;
        content: "";
        display: block;
        height: 100%;
        position: absolute;
        transition: all 0.2s ease-out;
        width: 100%;
    }

    .nav .menu-icon .navicon:before {
        top: 5px;
    }

    .nav .menu-icon .navicon:after {
        top: -5px;
    }

    /* menu btn */

    .nav .menu-btn {
        display: none;
    }

    .nav .menu-btn:checked~.menu {
        max-height: 240px;
    }

    .nav .menu-btn:checked~.menu-icon .navicon {
        background: transparent;
    }

    .nav .menu-btn:checked~.menu-icon .navicon:before {
        transform: rotate(-45deg);
    }

    .nav .menu-btn:checked~.menu-icon .navicon:after {
        transform: rotate(45deg);
    }

    .nav .menu-btn:checked~.menu-icon:not(.steps) .navicon:before,
    .nav .menu-btn:checked~.menu-icon:not(.steps) .navicon:after {
        top: 0;
    }



    /* 48em = 768px */
    @media (min-width: 768px) {
        .nav {
            display: flex;
            justify-content: center;
        }

        .nav li {
            float: left;
        }

        .nav li a {
            padding: 20px 30px;
        }

        .nav .menu {
            clear: none;
            max-height: none;
        }

        .nav .menu-icon {
            display: none;
        }

    }


    /***************************   MOVIL    ****************************/

    @media (max-width: 1007px) {}
</style>

<body>

    <div id="contenedor">
        <div id="cabecera">
            <div id="logo"></div>
            <div id="sub_cabecera">
                <input type="search">
                <button>🔍</button>
            </div>
            <div id="sub_cabecera_right">
                <div id="sub_cabecera_right_left">
                    <img src="../img/usuario.svg" id="foto_user">

                    <?php
                    echo "<span id='user'>$user</span>";
                    ?>

                </div>
                <div id="sub_cabecera_right_right">
                    <a title="Cerrar Sesión" href="../Controladores/cerrar_sesion.php" id="cerrar_sesion"><img src="../img/puerta_2.svg"></a>
                </div>
            </div>
        </div>

        <nav class="nav">
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li>
                    <a href="../index.php">Inicio</a>
                </li>
                <li>
                    <a class="activa" href="Foro.php">Foro</a>
                </li>
                <li>
                    <a href="#">Clips TV</a>
                </li>
                <li>
                    <a href="#">Ranking</a>
                </li>
                <li>
                    <a href="videojuegos.php">Video Juegos</a>
                </li>
            </ul>
        </nav>

        <div id="contenido">

            <div>

                <table class="table table-striped table-condensed table-bordered table-rounded">
                    <thead>
                        <tr>
                            <th width="25%">Titulo / Autor</th>
                            <th width="20%">Respuestas / Visitas</th>
                            <th width="20%">Ultimo mensaje por</th>
                        </tr>
                    </thead>

                    <tbody><?php for ($i = 0; $i < count($results->data); $i++) : ?>
                            <tr>
                                <td>
                                    <p><?php echo $results->data[$i]['titulo'];
                                        echo "</p><p>Iniciado por <b>";
                                        echo $results->data[$i]['autor_nick'];
                                        echo "</b> , ";
                                        echo $results->data[$i]['fecha_creacion'];
                                        ?></p>
                                </td>
                                <td><?php echo "<p>Respuestas:";
                                    respuestasTema($results->data[$i]['id']) ?></p>
                                    <?php echo "<p>Vistas:";
                                    echo $results->data[$i]['vistas']; ?></p>
                                </td>
                                <td>
                                    <p><?php
                                        ultimoComentarioForo($results->data[$i]['id']);
                                        echo " <a href='verForo.php?id=" . $results->data[$i]['id'] . "'>&#x25b6;</a>";              ?></p>
                                </td>
                            </tr>
                        <?php endfor; ?></tbody>
                </table>

                <?php echo $Paginator->createLinks($links, 'pagination pagination-sm'); ?>
            </div>

            <div id="opciones">
                <h3>Opciones de Desplegado de Temas</h3>
                <div id="sub_opciones">

                    <div>
                        <span>Mostrar temas desde ...</span>
                        <select id="mostrar_temas">
                            <option value="Principio">Principio</option>
                            <option value="ultimoDia">El Ultimo Día</option>
                            <option value="ultimoDosDias">Los Ultimos 2 Días</option>
                        </select>
                    </div>
                    <div>
                        <span>Ordenar temas por:</span>
                        <select id="orden_temas">
                            <option value="ultimoMsg">Fecha último mensaje</option>
                            <option value="inicioDia">Fecha Inicio Tema</option>
                            <option value="NRespuesta">Nº Respuesta</option>
                        </select>
                    </div>
                    <div>
                        <span>Plataforma:</span>
                        <select id="plataforma">
                            <option value="ultimoMsg">Fecha último mensaje</option>
                            <option value="inicioDia">Fecha Inicio Tema</option>
                            <option value="NRespuesta">Nº Respuesta</option>
                        </select>
                    </div>
                    <div>
                        <span>Videojuego:</span>
                        <div id="games">
                            <input type="search">
                            <button>🔍</button>
                        </div>
                    </div>

                </div>

                <div id="leyendas-permisos">
                    <div id="leyenda">
                        <h3>Leyenda de Iconos</h3>
                        <span>Contiene Mensajes sin Leer</span>
                        <span>No contiene mensajes sin leer</span>
                        <span>Tema caliente con mensajes no leídos</span>
                    </div>
                    <div id="permisos">
                        <h3>Permisos de Publicación</h3>
                        <?php

                        if (!$user) {
                            echo "<span>No puedes crear temas</span>";
                            echo "<span>No puedes responder temas</span>";
                            echo "<span>No puedes subir archivos adjuntos</span>";
                            echo "<span>No puedes editar tus mensajes</span>";
                        } else {
                            echo "<span>Puedes crear temas</span>";
                            echo "<span>Puedes responder temas</span>";
                            echo "<span>Puedes subir archivos adjuntos</span>";
                            echo "<span>Puedes editar tus mensajes</span>";
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</body>

<script>
    $(document).ready(inicio);

    function inicio() {
        var user = $("#user").text();
        console.log(user);
        if (user == "") {
            $("#foto_user").click(iniciarSesion);
            $("#foto_user").css("cursor", "pointer");
            $("#foto_user").attr("title", "Iniciar Sesión");
            $("#cerrar_sesion").css("display", "none");
            console.log("none");
        }
    }

    function iniciarSesion() {
        window.location = "login.php";
    }
</script>

</html>