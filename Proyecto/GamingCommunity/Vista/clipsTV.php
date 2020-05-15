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
<link rel="stylesheet" href="../css/menu.css">


<?php
session_start();
//error_reporting(0);
require_once '../modelo/Conexion.php';
require_once '../Controladores/Funciones.php';
if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<style>
    /*************** ClipsTV *******************/


    #contenido_stream {
        margin-top: 20px;
        display: flex;
        direction: row;
        flex-wrap: nowrap;
        overflow-x: auto;
        border: 2px solid black;
        visibility: hidden;
        border-radius: 50px;
        background-color: white;


    }

    .div_stream,
    .div_stream2 {
        flex: 0 0 auto;
        align-self: flex-end;
        width: 50%;
        padding: 0 3%;
        height: 100%;
    }


    .div_stream_flex_2 {
        margin-top: 20px;
        display: flex;
        direction: row;
        justify-content: space-between;
    }

    .div_stream_flex_2 p a {
        font-family: monospace;
        font-size: 20px;
    }

    .div_stream_languaje {
        display: flex;
        direction: row;
        justify-content: space-between;
    }

    .div_stream_languaje h3,
    .div_stream_languaje h4 {
        margin-top: 20px;
        margin-left: 20px;
        font-size: 24px;
        color: #2386B7;
        text-transform: uppercase;
        width: 40px;
        cursor: pointer;
    }

    .viewers img {
        width: 25px;
    }

    .viewers {
        font-size: 20px;
        display: flex;
        color: red;
    }


    #div_button {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    #div_button div {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    #bt_top_stream {
        margin-right: 10px;
    }




    /***************************   MOVIL    ****************************/

    @media (max-width: 1007px) {

        .div_stream,
        .div_stream2 {
            width: 100%;
            /*border: 2px solid black;*/
            padding: 0 3%;
            margin-bottom: 2%;
        }

        .div_stream_flex_2 p a {
            font-family: monospace;
            font-size: 20px;
        }
    }
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

                    if (isset($_SESSION['foto_avatar'])) {

                    ?>

                        <img id="foto_user" src="<?php echo $_SESSION['foto_avatar']; ?>" alt="avatar">

                        <?php

                    } else {

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
                    }
                    ?>

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
                    <a href="Foro.php">Foro</a>
                </li>
                <li>
                    <a class="activa" href="clipsTV.php">Gaming TV</a>
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

            <div id="div_button">

                <div>
                    <button id="bt_top_stream" class="btn btn-primary">Top Stream</button>
                    <button id="bt_stream_castellano" class="btn btn-primary">Stream en Español</button>
                </div>
                <div>
                    <label>Nº Streams: </label>
                    <input id="n_peticiones" value="10" type="number" min="2" max="40" step="2">
                </div>
            </div>







            <div id="contenido_stream">

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
        } else {
            $("#foto_user").click(verPerfil);
        }

        function print_Game(game, i) {
            $(".div_stream2 h3").eq(i).append("<a>");
            $(".div_stream2 h3 a").eq(i).attr("href", "videojuegos.php?game=" + game);
            $(".div_stream2 h3 a").eq(i).text(game);
            $(".div_stream2 h3 .carga").eq(i).css("display", "none");

        }

        function idGame(id, i) {
            $.ajax({
                    data: {
                        "accion": "id_game",
                        "id_game": id
                    },
                    type: "POST",
                    dataType: "json",
                    url: "../Controladores/controllerTV.php",
                })
                .done(function(data, textStatus, jqXHR) {

                    //console.log(data);
                    print_Game(data, i);


                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    if (console && console.log) {
                        console.log("La solicitud a fallado: " + textStatus);
                    }

                    $(".div_stream2 h3").eq(i).append("<span>");
                    $(".div_stream2 h3 span").eq(i).text("Video Juego");
                    $(".div_stream2 h3 .carga").eq(i).css("display", "none");
                });
        }

        function url_Channel(id, i) {
            $.ajax({
                    data: {
                        "accion": "url_channel",
                        "id_channel": id
                    },
                    type: "POST",
                    dataType: "json",
                    url: "../Controladores/controllerTV.php",
                })
                .done(function(data, textStatus, jqXHR) {

                    //console.log(data);
                    $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).attr("href", "https://www.twitch.tv/" + data);
                    $(".div_stream2 .div_stream_flex .miniatura_stream").eq(i).attr("id", data);
                    $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).attr("title", data);





                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    if (console && console.log) {
                        console.log("La solicitud a fallado: " + textStatus);
                    }
                });
        }


        $("#bt_top_stream").click(function() {

            $("#contenido_stream").css("visibility", "hidden");

            var n_peticiones = $("#n_peticiones").val();

            if (n_peticiones > 40) {
                n_peticiones = 40;
                $("#n_peticiones").val(40);
            }

            console.log(n_peticiones);

            $.ajax({
                    data: {
                        "accion": "top_stream",
                        "n_peticiones": n_peticiones
                    },
                    type: "POST",
                    dataType: "json",
                    url: "../Controladores/controllerTV.php",
                })
                .done(function(data, textStatus, jqXHR) {
                    console.log(data);

                    //console.log(data['data'].length);

                    var miniatura = "";

                    $("#contenido_stream").empty();

                    for (var i = 0; i < data['streams'].length; i++) {
                        //console.log(data["data"][i]["title"]);


                        $("#contenido_stream").append("<div class='div_stream2'>");


                        $(".div_stream2").eq(i).append("<div class='div_stream_languaje'>");

                        $(".div_stream2 .div_stream_languaje").eq(i).append("<h2>");
                        $(".div_stream2 .div_stream_languaje h2:last-child").text((data["streams"][i]["channel"]["status"]));

                        $(".div_stream2 .div_stream_languaje").eq(i).append("<h4>");
                        $(".div_stream2 .div_stream_languaje h4").eq(i).attr("title", "Idioma");
                        $(".div_stream2 .div_stream_languaje h4").eq(i).text((data["streams"][i]["channel"]["broadcaster_language"]));


                        $(".div_stream2").eq(i).append("<h3>");
                        $(".div_stream2 h3").eq(i).attr("title", "Videojuego");

                        var game = data["streams"][i]["game"];

                        $(".div_stream2 h3").eq(i).append("<a>");
                        $(".div_stream2 h3 a").eq(i).attr("href", "videojuegos.php?game=" + game);
                        $(".div_stream2 h3 a").eq(i).text(game);


                        $(".div_stream2").eq(i).append("<div class='div_stream_flex'>");
                        $(".div_stream2 .div_stream_flex").eq(i).append("<div class='miniatura_stream'>");
                        $(".div_stream2 .div_stream_flex .miniatura_stream").eq(i).append("<img class='miniatura_img'>");

                        miniatura = data["streams"][i]["preview"]["large"];
                        //console.log(miniatura);

                        $(".div_stream2 .div_stream_flex .miniatura_stream .miniatura_img").eq(i).attr("src", miniatura);
                        $(".div_stream2 .div_stream_flex .miniatura_stream .miniatura_img").eq(i).attr("width", "100%");
                        $(".div_stream2 .div_stream_flex .miniatura_stream .miniatura_img").eq(i).attr("height", "auto");

                        $(".div_stream2 .div_stream_flex").eq(i).append("<div class='div_stream_flex_2'>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2").eq(i).append("<p class='channel'>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel").eq(i).append("<a>");

                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).attr("href", "https://www.twitch.tv/" + data["streams"][i]["channel"]["name"]);
                        $(".div_stream2 .div_stream_flex .miniatura_stream").eq(i).attr("id", data["streams"][i]["channel"]["name"]);
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).attr("title", data["streams"][i]["channel"]["display_name"]);


                        //console.log(data["data"][i]["id"]);

                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).attr("target", "_blank");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).text(data["streams"][i]["channel"]["display_name"]);

                        $(".div_stream2 .div_stream_flex .div_stream_flex_2").eq(i).append("<p class='viewers'>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .viewers").eq(i).append("<img>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .viewers").eq(i).append("<span>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .viewers img").eq(i).attr("src", "../img/viewers.png");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .viewers span").eq(i).text(data["streams"][i]["viewers"]);

                    }

                    miniatura_stream();



                    $("#contenido_stream").css("visibility", "visible");



                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    if (console && console.log) {
                        console.log("La solicitud a fallado: " + textStatus);
                    }
                });






        });

        $("#bt_stream_castellano").click(function() {

            $("#contenido_stream").css("visibility", "hidden");
            var n_peticiones = $("#n_peticiones").val();

            if (n_peticiones > 40) {
                n_peticiones = 40;
                $("#n_peticiones").val(40);
            }

            $.ajax({
                    data: {
                        "accion": "stream_castellano",
                        "n_peticiones": n_peticiones
                    },
                    type: "POST",
                    dataType: "json",
                    url: "../Controladores/controllerTV.php",
                })
                .done(function(data, textStatus, jqXHR) {

                    console.log(data);
                    $("#contenido_stream").empty();

                    for (var i = 0; i < data['streams'].length; i++) {
                        //console.log(data["data"][i]["title"]);


                        $("#contenido_stream").append("<div class='div_stream2'>");




                        $(".div_stream2 ").eq(i).append("<h2>");
                        $(".div_stream2 h2:last-child").text((data["streams"][i]["channel"]["status"]));

                        $(".div_stream2").eq(i).append("<h3>");
                        $(".div_stream2 h3").eq(i).attr("title", "Videojuego");

                        var game = data["streams"][i]["game"];

                        $(".div_stream2 h3").eq(i).append("<a>");
                        $(".div_stream2 h3 a").eq(i).attr("href", "videojuegos.php?game=" + game);
                        $(".div_stream2 h3 a").eq(i).text(game);


                        $(".div_stream2").eq(i).append("<div class='div_stream_flex'>");
                        $(".div_stream2 .div_stream_flex").eq(i).append("<div class='miniatura_stream'>");
                        $(".div_stream2 .div_stream_flex .miniatura_stream").eq(i).append("<img class='miniatura_img'>");

                        miniatura = data["streams"][i]["preview"]["large"];
                        //console.log(miniatura);

                        $(".div_stream2 .div_stream_flex .miniatura_stream .miniatura_img").eq(i).attr("src", miniatura);
                        $(".div_stream2 .div_stream_flex .miniatura_stream .miniatura_img").eq(i).attr("width", "100%");
                        $(".div_stream2 .div_stream_flex .miniatura_stream .miniatura_img").eq(i).attr("height", "auto");

                        $(".div_stream2 .div_stream_flex").eq(i).append("<div class='div_stream_flex_2'>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2").eq(i).append("<p class='channel'>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel").eq(i).append("<a>");

                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).attr("href", "https://www.twitch.tv/" + data["streams"][i]["channel"]["display_name"]);
                        $(".div_stream2 .div_stream_flex .miniatura_stream").eq(i).attr("id", data["streams"][i]["channel"]["display_name"]);
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).attr("title", data["streams"][i]["channel"]["display_name"]);


                        //console.log(data["data"][i]["id"]);

                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).attr("target", "_blank");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .channel a").eq(i).text(data["streams"][i]["channel"]["display_name"]);

                        $(".div_stream2 .div_stream_flex .div_stream_flex_2").eq(i).append("<p class='viewers'>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .viewers").eq(i).append("<img>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .viewers").eq(i).append("<span>");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .viewers img").eq(i).attr("src", "../img/viewers.png");
                        $(".div_stream2 .div_stream_flex .div_stream_flex_2 .viewers span").eq(i).text(data["streams"][i]["viewers"]);

                    }

                    miniatura_stream();

                    // var height = $("#contenido_stream").height();
                    // var hijo_height = 0;

                    // for (var i = 0; i < data['streams'].length; i++) {
                    //     hijo_height = $(".div_stream2").eq(i).height();
                    //     $(".div_stream_flex").eq(i).css("margin-top", (height - hijo_height));
                    // }

                    $("#contenido_stream").css("visibility", "visible");



                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    if (console && console.log) {
                        console.log("La solicitud a fallado: " + textStatus);
                    }
                });


        });

        function miniatura_stream() {

            $(".miniatura_stream").click(function() {

                //console.log(this);

                var canal = $(this).attr('id');
                //console.log(canal);

                //$(this).empty();
                var height = $(this).children("img").height();

                $(this).children("img").css("display", "none");


                var enlace = "https://player.twitch.tv/?channel=" + canal + "&parent=streamernews.example.com";


                //console.log(height);

                $(this).append("<iframe></iframe>");
                $(this).children("iframe").attr("src", enlace);
                $(this).children("iframe").attr("width", "100%");
                $(this).children("iframe").attr("height", height);
                $(this).children("iframe").attr("frameborder", "0");
                $(this).children("iframe").attr("scrolling", "no");
                $(this).children("iframe").attr("allowfullscreen", "");
                $(this).children("iframe").attr("webkitallowfullscreen", "");
                $(this).children("iframe").attr("mozallowfullscreen", "");

            });

        }

        miniatura_stream();

        $("#bt_top_stream").click();
        //$("#bt_stream_castellano").click();




    }

    function iniciarSesion() {
        window.location = "./login.php";
    }

    function verPerfil() {
        window.location = "Perfil.php";
    }
</script>

</html>