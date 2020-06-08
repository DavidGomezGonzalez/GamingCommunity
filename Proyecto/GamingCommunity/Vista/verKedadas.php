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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

<link rel="stylesheet" href="../css/menu.css">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>


<?php
session_start();
//error_reporting(0);
require_once '../modelo/Conexion.php';
require_once '../Controladores/Funciones.php';
require_once '../Controladores/FuncionesKedadas.php';

require_once('../Calendar/google-calendar-api.php');
require_once('../Calendar/settings.php');


if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<style>
    /********************** Perfil***********************/

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    #contenido {
        padding: 2% 5%;
        background: linear-gradient(to bottom, black, #800000, black);
    }

    #div_fondo {
        background-color: white;
        padding: 3% 5%;
    }

    #enlace_calendar {
        text-align: center;
        width: 200px;
        display: block;
        margin: 100px auto;
        border: 2px solid #2980b9;
        padding: 10px;
        background: none;
        color: #2980b9;
        cursor: pointer;
        text-decoration: none;
    }


    /****************** verKedadas ********************/



    .lugar {
        font-size: 18px;
        color: #800000;
        font-weight: normal;

    }

    .p_lugar {
        font-size: 18px;
        margin-top: 20px;
        font-weight: bold;

    }

    #mapid {
        height: 400px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    #coordenadas {
        display: none;
    }

    .p_datos {
        font-size: 18px;
        margin-top: 20px;
        font-weight: bold;
    }

    .p_datos span {
        font-weight: normal;
    }

    #div_contenido_kedada {
        margin-top: 20px;
    }

    #participantes {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
    }

    #h2_participante {
        margin-top: 40px;
        margin-bottom: 20px;
        text-align: center;
    }

    #foto_participante {
        width: 100px;
        height: 100px;
        border: 1px solid black;
    }

    .div_participante {
        text-align: center;
    }

    .img_fondo {
        width: 100%;
    }




    /***************************   MOVIL    ****************************/

    @media (max-width: 1007px) {}
</style>

<body>

    <div id="contenedor">
        <div id="cabecera">
            <img id="img_logo" src="../img/logo.svg">
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
                    <a href="clipsTV.php">Gaming TV</a>
                </li>
                <li>
                    <a href="Ranking.php">Ranking</a>
                </li>
                <li>
                    <a href="videojuegos.php">Video Juegos</a>
                </li>
                <li>
                    <a class="activa" href="Kedadas.php">Quedadas</a>
                </li>
            </ul>
        </nav>

        <div id="contenido">

            <div id="div_fondo">


                <?php
                $id = $_REQUEST['id'];

                $kedada = ver_Kedadas_id($id);
                //print_r($kedada);
                ?>

                <div id="div_kedada">

                    <h2 id="titulo"><?php echo $kedada['titulo']; ?></h2>

                    <img class="img_fondo" src="<?php echo '../' . $kedada['imagen']; ?>">

                    <div id="div_contenido_kedada">
                        <?php echo $kedada['contenido']; ?>
                    </div>

                    <p class="p_datos">Inicio: <span><?php echo $kedada['fecha_inicio']; ?></span></p>
                    <p class="p_datos">Fin: <span><?php echo $kedada['fecha_fin']; ?></span></p>

                    <p class="p_lugar">Direccion: <span class="lugar"><?php echo $kedada['lugar']; ?></span></p>

                    <div id="coordenadas">
                        <input type="text" id="lat" value="<?php echo $kedada['lat']; ?>">
                        <input type="text" id="lng" value="<?php echo $kedada['lng']; ?>">
                    </div>

                    <?php
                    $_SESSION['fecha_inicio'] = str_replace(' ', 'T', $kedada['fecha_inicio']);
                    $_SESSION['fecha_fin'] = str_replace(' ', 'T', $kedada['fecha_fin']);
                    $_SESSION['titulo'] = $kedada['titulo'];
                    $_SESSION['id_kedada'] = $kedada['id'];

                    $login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
                    ?>



                    <div id="mapid"></div>

                    <?php
                    if ($user != "") {
                    ?>
                        <a id="enlace_calendar" href="<?= $login_url ?>">Asistir</a>

                    <?php
                    } else {
                    ?>

                        <div class="alert alert-danger" style="text-align: center;" role="alert">
                            Inicia Sesion para Asistir
                        </div>
                    <?php
                    }
                    ?>

                </div>

                <?php
                $participantes = verParticipantesKedadas($id);

                if (count($participantes) != 0) {
                ?>

                    <h2 id="h2_participante">Participantes</h2>

                    <div id="participantes">

                        <?php
                        //print_r($participantes);

                        for ($i = 0; $i < count($participantes); $i++) {

                            print_r($participantes['nick_user']);


                            $avatar = existe_Avatar($participantes[$i]['nick_user']);


                            if ($avatar == "") {
                        ?>

                                <p><img id="foto_Avatar" src="../img/usuario.svg" alt="avatar">

                                <?php
                            } else {
                                ?>

                                    <div class="div_participante">
                                        <img id="foto_participante" src="<?php echo "../Download/fotos_Avatar/" . $avatar; ?>" alt="avatar">
                                        <p><b><?php echo $participantes[$i]['nick_user']; ?></b></p>
                                    </div>
                        <?php
                            }
                        }
                    }
                        ?>

                    </div>
            </div>

        </div>
    </div>
    <footer>
        <img src="../img/logo.svg">
        <p><b>&copy; David Gómez </b> - Diseñador Web</p>
        <p><a href="PoliticaPrivacidad.php">POLÍTICA DE PRIVACIDAD</a> &bull; <a href="AvisoLegal.php"> AVISO LEGAL</a> &bull; <a href="Contacto.php"> CONTACTO</a></p>
    </footer>


</body>

<script>
    $(document).ready(inicio);

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

                        window.location = "verNoticia.php?id=" + id;

                    });

                }
            };

            xhr.open("POST", "../Controladores/controller.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("accion=buscarNoticia&objeto=" + parametros);
        }
    }


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

        $("#sub_cabecera button").click(buscar);
        $("#sub_cabecera input[type=search]").on('keypress', function(e) {
            if (e.which == 13) {
                $("#sub_cabecera button").click();
            }
        });


        $.urlParam = function(name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        }


        var kedada_id = $.urlParam('id');
        console.log(kedada_id);



        $("#enlace_calendar").click(function() {

            $.ajax({
                    data: {
                        "accion": "insertarParticipante",
                        "id": kedada_id,
                        "user": user
                    },
                    type: "POST",
                    dataType: "json",
                    url: "../Controladores/controllerKedadas.php",
                })
                .done(function(data, textStatus, jqXHR) {

                    console.log(data);

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    if (console && console.log) {
                        console.log("La solicitud a fallado: " + textStatus);
                    }
                });
        });


        $.ajax({
                data: {
                    "accion": "verificarParticipante",
                    "id": kedada_id,
                    "user": user
                },
                type: "POST",
                dataType: "json",
                url: "../Controladores/controllerKedadas.php",
            })
            .done(function(data, textStatus, jqXHR) {

                console.log(data);
                if (data == 1) {
                    $("#enlace_calendar").css("display", "none");
                }


            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("La solicitud a fallado: " + textStatus);
                }
            });


        var lat = $("#lat").val();
        var lng = $("#lng").val();
        var titulo = $("#titulo").text();

        var array = {
            "lat": lat,
            "lng": lng
        };


        var mymap = L.map('mapid').setView([lat, lng], 16);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(mymap);

        var marker = L.marker(array).addTo(mymap);

        marker.bindPopup("<b>" + titulo + "</b>").openPopup();



    }

    function iniciarSesion() {
        window.location = "login.php";
    }

    function verPerfil() {
        window.location = "Perfil.php";
    }
</script>

</html>