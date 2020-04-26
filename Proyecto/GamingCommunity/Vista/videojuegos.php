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
</style>

<body>
    <?php
    session_start();
    error_reporting(0);
    header('Access-Control-Allow-Origin: *');
    $user = "";
    if ($_SESSION['user'] != "") {
        $user = $_SESSION['user'];
    }
    ?>
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
                    <a title="Cerrar Sesión" href="Controladores/cerrar_sesion.php" id="cerrar_sesion"><img src="../img/puerta_2.svg"></a>
                </div>
            </div>
        </div>

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