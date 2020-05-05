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

    #contenido {
        padding: 1% 5%;
    }

    /*************** Videojuegos *******************/

    #div_flex {
        display: flex;
        flex-direction: row;
        flex-wrap: 20px;
        align-items: center;
        justify-content: space-between;


    }

    #descripcion {
        width: 95%;
    }

    #image {
        width: 120px;
    }

    #div_plataforma {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
    }

    #plataformas {
        margin-left: 20px;
    }

    #game-search {
        margin-top: 30px;
    }

    #plataformas li {
        margin: 5px;

    }

    #p_search_game {
        margin-top: 50px;
    }
    

    #game, #game-search, #plataform {
        width: 400px;
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

        <div id="contenido">

            <p><span>Buscar Juego: </span><input type="text" id="game-search">
                <button id="bt_Buscar" class="btn btn-primary">Buscar</button>
            </p>

            <div id="alerta2" class="alert alert-danger" role="alert">
                ¡Sin Resultados!
            </div>
            <img id="carga2" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" />
            <div id="div_search_game">

                <table class="table table-striped table-condensed table-bordered table-rounded">
                    <thead>
                        <tr>
                            <th width="45%">Juegos</th>
                            <th width="20%">Plataforma</th>
                            <th width="2%"></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_search_games">


                    </tbody>
                </table>
            </div>


            <p id="p_search_game"><span>Juego: </span><input type="text" id="game">
                <button id="bt" class="btn btn-primary">Ver</button>
            </p>
            <p><span>Plataforma: </span>
                <select id="plataform">
                    <option value="pc">PC</option>
                    <option value="playstation-4">PS4</option>
                    <option value="playstation-3">PS3</option>
                    <option value="playstation-2">PS2</option>
                    <option value="playstation">PS1</option>
                    <option value="playstation-vita">PS VITA</option>
                    <option value="xbox-one">Xbox One</option>
                    <option value="xbox-360">Xbox 360</option>
                    <option value="switch">Nintendo Switch</option>
                    <option value="3ds">Nintendo 3DS</option>
                    <option value="ds">Nintendo DS</option>
                    <option value="nintendo-64">Nintendo 64</option>
                    <option value="wii-u">Wii U</option>
                    <option value="wii">Wii</option>
                    <option value="stadia">Google Stadia</option>
                    <option value="ios">iOS</option>
                    <option value="game-boy-advance">GBA</option>
                    <option value="gamecube">GameCube</option>
                </select>
            </p>


            <img id="carga" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" />
            <div id="alerta" class="alert alert-danger" role="alert">
                ¡Sin Resultados!
            </div>
            <div id="div_game" style="visibility: hidden">
                <h3 id="titulo"></h3>
                <div id="div_flex">
                    <div id="div_descripcion">
                        <p id="descripcion"></p>
                    </div>
                    <div>
                        <img id="image" src="">
                    </div>
                </div>

                <div id="div_plataforma">
                    <div>
                        <p id="p_plataforma"><b>Plataformas: </b>
                            <ul id="plataformas"></ul>
                        </p>
                    </div>
                    <div>
                        <p><b>Desarrollador: </b><span id="developer"></span></p>
                        <p><b>Fecha Publicación: </b><span id="fecha_publicacion"></span></p>
                        <!-- <button id="bt_Traducir" class="btn btn-primary">Traducir</button> -->
                    </div>
                </div>

            </div>



        </div>
    </div>

    </div>
</body>

<script>
    function verchange(title, plataform) {
        //console.log(title + " " + plataform);

        $("#game").val(title);
        $("#game").change();


        if (plataform == "PS4") {
            $("#plataform").val("playstation-4");
        } else if (plataform == "PS3") {
            $("#plataform").val("playstation-3");
        } else if (plataform == "PS2") {
            $("#plataform").val("playstation-2");
        } else if (plataform == "PS") {
            $("#plataform").val("playstation");
        } else if (plataform == "XONE") {
            $("#plataform").val("xbox-one");
        } else if (plataform == "X360") {
            $("#plataform").val("xbox-360");
        } else if (plataform == "PC") {
            $("#plataform").val("pc");
        } else if (plataform == "iOS") {
            $("#plataform").val("ios");
        } else if (plataform == "Switch") {
            $("#plataform").val("switch");
        } else if (plataform == "GBA") {
            $("#plataform").val("game-boy-advance");
        } else if (plataform == "GC") {
            $("#plataform").val("gamecube");
        } else if (plataform == "3DS") {
            $("#plataform").val("3ds");
        } else if (plataform == "WII") {
            $("#plataform").val("wii");
        } else if (plataform == "WIIU") {
            $("#plataform").val("wii-u");
        } else if (plataform == "VITA") {
            $("#plataform").val("playstation-vita");
        } else if (plataform == "DS") {
            $("#plataform").val("ds");
        } else if (plataform == "N64") {
            $("#plataform").val("nintendo-64");
        }

        $("#plataform").change();


        $("body, html").animate({
            scrollTop: $(document).height()
        }, 400)



        $("#bt").click();

    }

    $(document).ready(inicio);

    function inicio() {
        $("#carga").hide();
        $("#carga2").hide();
        $("#alerta").hide();
        $("#alerta2").hide();
        $("#div_search_game").hide();
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

            if (game) {

                $("#alerta").hide();
                $("#carga").show();
                $("#div_game").hide();
                $("#p_plataforma").hide();




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
                    // $("#carga").hide();
                    // $("#div_game").show();

                    if (response.result == "No result") {
                        $("#alerta").show();
                        $("#carga").hide();
                    }

                    console.log(response);

                    var descrp = response.result.description;

                    var descripcion = descrp.replace("Expand", "");

                    var image = response.result.image;
                    var plataformas = response.result.alsoAvailableOn;
                    var fecha_publicacion = response.result.releaseDate;
                    var title = response.result.title;
                    var developer = response.result.developer;

                    $("#plataformas").empty();

                    if (plataformas.length != 0) {
                        $("#p_plataforma").show();
                    }

                    for (var i = 0; i < plataformas.length; i++) {


                        if (plataformas[i] == "PlayStation 4") {
                            $("#plataformas").append("<li>" +
                                "<img width='35px' alt='PS4' src='../img/logos_plataformas/logo_PS4.png'>" +
                                "</li>");
                        } else if (plataformas[i] == "PlayStation 3") {
                            $("#plataformas").append("<li>" +
                                "<img width='35px' alt='PS3' src='../img/logos_plataformas/logo_PS3.png'>" +
                                "</li>");
                        } else if (plataformas[i] == "PlayStation 2") {
                            $("#plataformas").append("<li>" +
                                "<img width='35px' alt='PS2' src='../img/logos_plataformas/logo_PS2.png'>" +
                                "</li>");
                        } else if (plataformas[i] == "PlayStation Vita") {
                            $("#plataformas").append("<li>" +
                                "<img width='45px' alt='PSVITA' src='../img/logos_plataformas/logo_PSVITA.png'>" +
                                "</li>");
                        } else if (plataformas[i] == "Xbox One") {
                            $("#plataformas").append("<li>" +
                                "<img width='60px' alt='Xbox One' src='../img/logos_plataformas/logo_Xbox.png'> - <b>One</b>" +
                                "</li>");
                        } else if (plataformas[i] == "Xbox 360") {
                            $("#plataformas").append("<li>" +
                                "<img width='60px' alt='Xbox 360' src='../img/logos_plataformas/logo_Xbox.png'> - <b>360</b>" +
                                "</li>");
                        } else if (plataformas[i] == "Switch") {
                            $("#plataformas").append("<li>" +
                                "<img width='25px' alt='Switch' src='../img/logos_plataformas/logo_Switch.png'> - <b>Switch</b>" +
                                "</li>");
                        } else if (plataformas[i] == "Stadia") {
                            $("#plataformas").append("<li>" +
                                "<img width='45px' alt='Stadia' src='../img/logos_plataformas/logo_Stadia.jpg'>" +
                                "</li>");
                        } else if (plataformas[i] == "PC") {
                            $("#plataformas").append("<li>" +
                                "<img width='35px' alt='PC' src='../img/logos_plataformas/logo_PC.png'> - <b>PC</b>" +
                                "</li>");
                        } else if (plataformas[i] == "3DS") {
                            $("#plataformas").append("<li>" +
                                "<img width='65px' alt='PC' src='../img/logos_plataformas/logo_nintendo.png'> - <b>3DS</b>" +
                                "</li>");
                        } else if (plataformas[i] == "Wii U") {
                            $("#plataformas").append("<li>" +
                                "<img width='45px' alt='WiiU' src='../img/logos_plataformas/logo_WIIU.png'>" +
                                "</li>");
                        } else if (plataformas[i] == "DS") {
                            $("#plataformas").append("<li>" +
                                "<img width='45px' alt='WiiU' src='../img/logos_plataformas/logo_nintendo_ds.png'>" +
                                "</li>");
                        } else {
                            $("#plataformas").append("<li>" + plataformas[i] + "</li>");
                        }
                    }

                    $("#div_game").css("visibility", "visible");
                    $("#fecha_publicacion").text(fecha_publicacion);
                    $("#titulo").text(title);
                    $("#developer").text(developer);


                    $("#image").attr("src", image);

                    $("#descripcion").html(descripcion);

                    $("body, html").animate({
                        scrollTop: $(document).height()
                    }, 400);

                    translate(descripcion);



                });

            }

        });


        // $("#bt_Traducir").click(function() {

        //     var descripcion = $("#descripcion").text();

        //     translate(descripcion);

        // });




        $("#bt_Buscar").click(function() {

            var gamesearch = $("#game-search").val();
            $("#tbody_search_games").empty();
            $("#div_search_game").hide();
            $("#alerta2").hide();



            if (gamesearch) {
                $("#carga2").show();


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

                    if (response.result != "No result") {

                        for (var i = 0; i < response.result.length; i++) {
                            var titulo = response.result[i].title;

                            titulo = titulo.replace("'", "");

                            $("#tbody_search_games").append("<tr><td>" + response.result[i].title + "</td>" + "<td>" + response.result[i].platform + "</td>" + "<td><button onclick=\"" + "verchange('" + titulo + "', '" + response.result[i].platform + "')" + "\" class='btn btn-secondary'>+</button></td></tr>");
                        }

                        $("#carga2").hide();
                        $("#div_search_game").show();



                    } else {
                        $("#carga2").hide();
                        $("#alerta2").show();

                    }
                });

            }

        });


        function translate(text) {
            $.get("https://www.googleapis.com/language/translate/v2", {
                    key: "AIzaSyAM1CKHNN_D7U3M7YXue0zu48HJwH2yGOU",
                    source: "en",
                    target: "es",
                    q: text
                },
                function(response) {
                    $("body, html").animate({
                        scrollTop: $(document).height()
                    }, 400);
                    $("#carga").hide();
                    $("#div_game").show();

                    $("#descripcion").html(response.data.translations[0].translatedText);
                }, "json").fail(function(jqXHR, textStatus, errorThrown) {
                console.log("error :" + errorThrown);

                $("#carga").hide();
                $("#div_game").show();
                $("#alerta").show();
                $("#alerta").text("¡Error al Traducir!");

            });



        }

        function iniciarSesion() {
            window.location = "./login.php";
        }



    }
</script>

</html>