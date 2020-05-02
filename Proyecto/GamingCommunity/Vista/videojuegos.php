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

<?php
session_start();
//error_reporting(0);
header('Access-Control-Allow-Origin: *');
require_once '../modelo/Conexion.php';
require_once '../Controladores/Funciones.php';
if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
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

    #foto_user {
        height: 70px;
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
                    <?php
                    $foto_avatar =  existe_Avatar($user);

                    if ($foto_avatar == "") {

                    ?>

                        <img id="foto_user" src="../img/usuario.svg" alt="avatar">

                    <?php

                    } else {
                    ?>

                        <img id="foto_user" src="<?php echo "../Download/fotos_Avatar/" . $foto_avatar; ?>" alt="avatar">

                    <?php
                    }
                    ?>

                    <?php
                    echo "<span id='user'>$user</span>";
                    ?>

                </div>
                <div id="sub_cabecera_right_right">
                    <a title="Cerrar Sesión" href="Controladores/cerrar_sesion.php" id="cerrar_sesion"><img src="../img/puerta_2.svg"></a>
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
                    <a href="Foro.php">Foro</a>
                </li>
                <li>
                    <a href="#">Clips TV</a>
                </li>
                <li>
                    <a href="#">Ranking</a>
                </li>
                <li>
                    <a class="activa" href="videojuegos.php">Video Juegos</a>
                </li>
            </ul>
        </nav>

        <p><span>Buscar Juego: </span><input type="text" id="game-search"></p>

        <p><span>Juego: </span><input type="text" id="game"></p>
        <p><span>Plataforma: </span>
            <select id="plataform">
                <option value="pc">PC</option>
                <option value="playstation-4">PS4</option>
                <option value="playstation-3">PS3</option>
                <option value="xbox-one">Xbox One</option>
                <option value="xbox-360">Xbox 360</option>
                <option value="switch">Nintendo Switch</option>
            </select>
        </p>
        <button id="bt">Ver</button>
        <button id="bt_Traducir">Traducir</button>

        <h3 id="titulo"></h3>
        <p id="descripcion"></p>
        <img id="image" src="">
        <p id="p_plataforma" style="display: none"><b>Plataformas: </b>
            <ul id="plataformas"></ul>
        </p>
        <p style="display: none"><b>Fecha Publicación: </b><span id="fecha_publicacion"></span></p>



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

        $("#bt").click(function() {

            var game = $("#game").val();
            var plataform = $("#plataform").val();

            var res = game.replace(" ", "%20");

            var settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://chicken-coop.p.rapidapi.com/games/" + res + "?platform=" + plataform,
                "method": "GET",
                "headers": {
                    "x-rapidapi-host": "chicken-coop.p.rapidapi.com",
                    "x-rapidapi-key": "412b82af91msh660aa8cc1361f72p172b47jsnb01a5ab61790"
                }
            }

            $.ajax(settings).done(function(response) {
                console.log(response);

                var descripcion = response.result.description;
                var image = response.result.image;
                var plataformas = response.result.alsoAvailableOn;
                var fecha_publicacion = response.result.releaseDate;
                var title = response.result.title;

                $("#plataformas").empty();
                for (var i = 0; i < plataformas.length; i++) {
                    $("#plataformas").append("<li>" + plataformas[i] + "</li>");
                }

                $("#p_plataforma").css("display", "block");
                $("#fecha_publicacion").parent().css("display", "block");
                $("#fecha_publicacion").text(fecha_publicacion);
                $("#titulo").text(title);




                $("#image").attr("src", image);

                //translate(descripcion);

                $("#descripcion").html(descripcion);


            });

        });


        $("#bt_Traducir").click(function() {

            var descripcion = $("#descripcion").text();

            translate(descripcion);

        });


        $("#game-search").keyup(function() {

            var gamesearch = $("#game-search").text();
            var settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://chicken-coop.p.rapidapi.com/games?title=" + gamesearch,
                "method": "GET",
                "headers": {
                    "x-rapidapi-host": "chicken-coop.p.rapidapi.com",
                    "x-rapidapi-key": "412b82af91msh660aa8cc1361f72p172b47jsnb01a5ab61790"
                }
            }

            $.ajax(settings).done(function(response) {
                console.log(response);
            });

        });


        function translate(text) {
            $.get("https://www.googleapis.com/language/translate/v2", {
                    key: "AIzaSyAM1CKHNN_D7U3M7YXue0zu48HJwH2yGOU",
                    source: "en",
                    target: "es",
                    q: text
                },
                function(response) {
                    $("#descripcion").html(response.data.translations[0].translatedText);
                }, "json").fail(function(jqXHR, textStatus, errorThrown) {
                console.log("error :" + errorThrown);
                $("#descripcion").text(text);
            });
        }

        function iniciarSesion() {
            window.location = "./login.php";
        }

    }
</script>

</html>