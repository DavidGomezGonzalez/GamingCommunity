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
<script src="JavaScript/jQuery v3.4.1.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/menu.css">

<?php
session_start();
error_reporting(0);
//header('Access-Control-Allow-Origin: *');
require_once 'modelo/Conexion.php';
require_once 'Controladores/FuncionesNoticias.php';

if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<style>
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    .nav {
        margin: 0 !important;
    }


    /*************************** CAROUSEL *******************************/

    .carrusel {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        grid-template-areas: "Carrusel";
        z-index: 1;
        box-sizing: border-box;
    }


    @keyframes slidy {
        0% {
            left: 0%;
        }

        20% {
            left: 0%;
        }

        25% {
            left: -100%;
        }

        45% {
            left: -100%;
        }

        50% {
            left: -200%;
        }

        70% {
            left: -200%;
        }

        75% {
            left: -300%;
        }

        95% {
            left: -300%;
        }

        100% {
            left: -400%;
        }
    }

    figure {
        margin: 0;
        background: #101010;
        font-family: Istok Web, sans-serif;
        font-weight: 100;
    }

    .carrusel #captioned-gallery {
        grid-area: "Carrusel";
        width: 100%;
        overflow: hidden;
    }

    figure.slider {
        position: relative;
        width: 500%;
        font-size: 0;
        animation: 30s slidy infinite;
    }

    figure.slider figure {
        width: 20%;
        height: auto;
        display: inline-block;
        position: inherit;
    }

    figure.slider img {
        width: 100%;
        height: 350px;
    }

    figure.slider figure figcaption {
        position: absolute;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        color: #fff;
        width: 100%;
        font-size: 1.5rem;
        padding: .6rem;
    }


    /************************ Noticias ******************************* */

    #noticia1 {
        grid-area: noticia1;
    }

    #noticia2 {
        grid-area: noticia2;
    }

    #noticia3 {
        grid-area: noticia3;
    }

    #noticia4 {
        grid-area: noticia4;
    }

    #noticia5 {
        grid-area: noticia5;
    }

    #noticia6 {
        grid-area: noticia6;
    }

    #noticia1,
    #noticia2,
    #noticia3,
    #noticia4,
    #noticia5,
    #noticia6 {
        padding: 10px 10%;
        display: grid;
        width: 100%;
        height: 400px;
        grid-template-rows: 100%;
    }

    .noticia-p {
        text-align: justify;
    }


    .contenido-noticia {
        display: grid;
        width: 100%;
        height: 100%;
        grid-template-columns: 1fr;
        /* 40% fondo 60% noticia*/
        grid-template-rows: 40% 60%;
        outline: 3px solid black;
        background-color: white;
    }

    .contenido-noticia:hover {
        cursor: pointer;
    }



    .noticia-p {
        display: grid;
        padding: 10px;
        overflow: hidden;
        /* Para Desbordamiento del <p>*/
    }

    .noticia-p p {
        /*Interlineado*/
        line-height: 1.5rem;
        margin: 5px;
    }

    .noticia-img {
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    /* HOVER*/

    .noticia-img:hover {
        opacity: 0.8;
    }

    .noticia-p:hover {
        background-color: #d8d8d836;
    }

    /********************** Contenido Principal *************************/
    #contenido {
        width: 100%;
        display: grid;
        grid-row-gap: 20px;
        grid-template-columns: repeat(2, 1fr);
        grid-template-areas:
            "noticia1 noticia2"
            "noticia3 noticia4"
            "noticia5 noticia6";
        text-align: justify;
        padding-top: 5%;
        /*background-image: url(img/seamless-pattern-of-abstract-black-hexagon-background-with-red-line-vector.jpg);*/
        background: linear-gradient(to bottom, black, #800000, black);
    }





    @media (max-width: 1007px) {

        #contenido {
            margin-top: 20px;
            width: 100%;
            display: grid;
            grid-row-gap: 20px;
            grid-template-columns: 1fr;
            grid-template-areas:
                "noticia1"
                "noticia2"
                "noticia3"
                "noticia4"
                "noticia5"
                "noticia6";
        }

        #noticia1,
        #noticia2,
        #noticia3,
        #noticia4,
        #noticia5,
        #noticia6 {
            padding: 10px 10%;
            display: grid;
            width: 100%;
            height: 350px;
            /*Tamaño desde Móvil*/
            grid-template-rows: 100%;
        }

        .carrusel {
            z-index: 1;
        }

        figure.slider img {
            width: 100%;
            height: 200px;
            /*Tamaño desde Móvil*/
        }

        figure.slider figure figcaption {
            position: static;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            color: #fff;
            width: 100%;
            font-size: 1.5rem;
            padding: .6rem;
        }

    }
</style>

<body>

    <div id="contenedor">
        <div id="cabecera">
            <img id="img_logo" src="img/logo.svg">
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

                        $foto_avatar = existe_Avatar($user);

                        if ($foto_avatar == "") {
                        ?>

                            <img id="foto_user" src="img/usuario.svg" alt="avatar">

                        <?php
                        } else {
                        ?>

                            <img id="foto_user" src="<?php echo "Download/fotos_Avatar/" . $foto_avatar; ?>" alt="avatar">

                    <?php
                        }
                    }
                    ?>

                    <?php
                    echo "<span id='user'>$user</span>";
                    ?>

                </div>
                <div id="sub_cabecera_right_right">
                    <a title="Cerrar Sesión" href="Controladores/cerrar_sesion.php" id="cerrar_sesion"><img src="img/puerta_2.svg"></a>
                </div>
            </div>
        </div>

        <nav class="nav">
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li>
                    <a class="activa" href="index.php">Inicio</a>
                </li>
                <li>
                    <a href="Vista/Foro.php">Foro</a>
                </li>
                <li>
                    <a href="Vista/clipsTV.php">Gaming TV</a>
                </li>
                <li>
                    <a href="Vista/Ranking.php">Ranking</a>
                </li>
                <li>
                    <a href="Vista/videojuegos.php">Video Juegos</a>
                </li>
                <li>
                    <a href="Vista/Kedadas.php">Quedadas</a>
                </li>
            </ul>
        </nav>
        <div class="carrusel">
            <div id="captioned-gallery">
                <figure class="slider">

                </figure>
            </div>
        </div>
        <div id="contenido">

        </div>
        <footer>
            <img src="img/logo.svg">
            <p><b>&copy; David Gómez </b> - Diseñador Web</p>
            <p><a href="Vista/PoliticaPrivacidad.php">POLÍTICA DE PRIVACIDAD</a> &bull; <a href="Vista/AvisoLegal.php"> AVISO LEGAL</a> &bull; <a href="Vista/Contacto.php"> CONTACTO</a></p>
        </footer>
</body>
</div>

<script>
    var t1 = null;
    var t0 = null;
    $(document).ready(inicio);

    function ver_noticia() {

        $(".contenido-noticia").click(function() {

            //console.log(this);

            var id = $(this).attr('id');

            console.log(id);

            window.location = "./Vista/verNoticia.php?id=" + id;

        });

    }

    function carrusel() {
        $.ajax({
                data: {
                    "accion": "carrusel"
                },
                type: "POST",
                dataType: "json",
                url: "Controladores/controllerNoticias.php",
            })
            .done(function(data, textStatus, jqXHR) {

                //console.log(data);
                data = data.reverse();

                for (var i = 0; i < data.length; i++) {
                    $(".slider").append("<a>");
                    $(".slider a").eq(i).attr("href", "Vista/verNoticia.php?id=" + data[i].id);
                    $(".slider a").eq(i).append("<figure>");
                    $(".slider a figure").eq(i).append("<img>");
                    $(".slider a figure img").eq(i).attr("src", data[i].img);

                    $(".slider a figure").eq(i).append("<figcaption>");
                    $(".slider a figure figcaption").eq(i).text(data[i].titulo);
                }

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("La solicitud a fallado: " + textStatus);
                }
            });
    }


    function noticias() {
        $.ajax({
                data: {
                    "accion": "noticias"
                },
                type: "POST",
                dataType: "json",
                url: "Controladores/controllerNoticias.php",
            })
            .done(function(data, textStatus, jqXHR) {

                console.log(data);

                for (var i = 0; i < data.length; i++) {

                    $("#contenido").append("<div class='noticia_id'>");
                    $("#contenido .noticia_id").eq(i).attr("id", "noticia" + (i + 1));
                    $("#contenido .noticia_id").eq(i).append("<div class='contenido-noticia'>");
                    $("#contenido .noticia_id .contenido-noticia").eq(i).attr("id", data[i].id);
                    $("#contenido .noticia_id .contenido-noticia").eq(i).append("<div class='noticia-img'>");
                    $("#contenido .noticia_id .contenido-noticia .noticia-img").eq(i).css("background-image", "url(" + data[i].img + ")");
                    $("#contenido .noticia_id .contenido-noticia").eq(i).append("<div class='noticia-p'>");
                    $("#contenido .noticia_id .contenido-noticia .noticia-p").eq(i).append("<h3>");
                    $("#contenido .noticia_id .contenido-noticia .noticia-p h3").eq(i).text(data[i].titulo);
                    $("#contenido .noticia_id .contenido-noticia .noticia-p").eq(i).append("<p>");
                    $("#contenido .noticia_id .contenido-noticia .noticia-p p").eq(i).text(data[i].subtitulo);

                }

                ver_noticia();

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("La solicitud a fallado: " + textStatus);
                }
            });
    }

    function buscar() {

        var noticia = $("input[type=search]").val();

        console.log(noticia);

        if (noticia) {

            t0 = performance.now();

            var objeto = {
                "noticia": noticia
            };

            var parametros = JSON.stringify(objeto);
            console.log(parametros);

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                console.log(this.readyState + " " + this.status);
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    console.log(myObj);

                    $("#contenido").empty();
                    $("#contenido").css("background-image", "none");
                    $("#contenido").css("background-color", "white");
                    $("#contenido").css("display", "block");
                    $("#contenido").append("<p class='p_res'></p>");

                    t1 = performance.now();
                    console.log("La llamada a hacerAlgo tardó " + (t1 - t0) + " milisegundos.");

                    $("#contenido p").text("Aproximadamente " + myObj.length + " resultados (0," + Math.trunc(t1 - t0) + " segundos)");



                    if (myObj.length != 0) {

                        for (var i = 0; i < myObj.length; i++) {
                            var titulo = (myObj[i].titulo).toUpperCase();

                            noticia = noticia.toUpperCase();

                            var str_2 = "<b>" + noticia + "</b>";

                            titulo = titulo.replace(noticia, str_2);

                            $("#contenido").append("<div class='div_resultado'></div>");
                            $("#contenido .div_resultado").eq(i).attr("id", myObj[i].id);
                            $("#contenido .div_resultado").eq(i).append("<h1>" + titulo + "</h1>");
                            $("#contenido .div_resultado").eq(i).append("<h2>" + myObj[i].subtitulo + "</h2>");
                            $("#contenido .div_resultado").eq(i).append("<h3>" + myObj[i].fecha_creacion + "</h3>");
                        }

                    }

                    $(".div_resultado").click(function() {

                        //console.log(this);

                        var id = $(this).attr('id');

                        console.log(id);

                        window.location = "./Vista/verNoticia.php?id=" + id;

                    });



                }
            };

            xhr.open("POST", "Controladores/controller.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("accion=buscarNoticia&objeto=" + parametros);
        }
    }

    function inicio() {
        var user = $("#user").text();
        console.log(user);
        if (user == "") {
            $("#foto_user").click(iniciarSesion);
            $("#foto_user").attr("title", "Iniciar Sesión");
            $("#cerrar_sesion").css("display", "none");
            console.log("none");
        } else {
            $("#foto_user").click(verPerfil);
        }

        carrusel();
        noticias();

        // $("input[type=search]").blur(buscar);

        $("#sub_cabecera button").click(buscar);
        $("#sub_cabecera input[type=search]").on('keypress', function(e) {
            if (e.which == 13) {
                $("#sub_cabecera button").click();
            }
        });

        $(".div_resultado").click(function() {

            //console.log(this);

            var id = $(this).attr('id');

            console.log(id);

            window.location = "./Vista/verNoticia.php?id=" + id;

        });




    }

    function iniciarSesion() {
        window.location = "./Vista/login.php";
    }

    function verPerfil() {
        window.location = "./Vista/Perfil.php";
    }
</script>

</html>