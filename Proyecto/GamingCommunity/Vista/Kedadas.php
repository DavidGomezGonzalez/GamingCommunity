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

// Google passes a parameter 'code' in the Redirect Url
if (isset($_GET['code'])) {
    try {
        $capi = new GoogleCalendarApi();

        // Get the access token 
        $data = $capi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);

        // Save the access token as a session variable
        $_SESSION['access_token'] = $data['access_token'];

        // Redirect to the page where user can create event
        header('Location: /ProyectosPhp/GamingCommunity/Proyecto/GamingCommunity/Calendar/peticion.php');
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
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
        padding: 4% 5%;
        background: linear-gradient(to bottom, black, #800000, black);
    }

    #div_fondo {
        background-color: white;
        padding: 2% 5%;
    }

    /****************** Kedadas ********************/

    p {
        margin: 0 !important;
    }

    .img_monigotes {
        width: 50px;
    }


    .div_kedada {
        border: 2px solid black;
        padding-top: 5px;
        color: #000000;
        cursor: pointer;
        margin-bottom: 30px;
        background: linear-gradient(to right, #800000, #ffffff, #800000);
    }

    .div_kedada .lugar {
        text-align: right;
    }

    .div_kedada .lugar span {
        background-color: #800000;
        border-top: 2px solid black;
        border-bottom: 2px solid black;
        border-left: 2px solid black;
        padding: 7px;
        color: white;
        font-weight: bold;
        font-size: 16px;
    }

    .div_kedada h3 {
        text-align: center;
        font-weight: bold;
    }

    .img_fondo {
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        height: 200px;
    }

    .img_fondo:hover {
        opacity: 0.8;
    }

    .div_inferior {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
        font-weight: bold;
        font-size: 19px;
    }


    #mapid {
        height: 600px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    h2 {
        text-align: center;
        padding: 0 5%;
        margin-bottom: 40px;
        font-weight: bold;
    }

    .div_radio {
        text-align: right;
    }

    .div_radio span {
        font-weight: bold;
    }

    #radio {
        width: 100px;
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


                <h2>Quedadas Mapa</h2>

                <div class="div_radio"><span>Radio </span><input type="text" id="radio" value="100" min="1"> <span>Km</span></div>
                <div id="mapid">
                </div>



                <div id="div_kedadas">


                    <?php
                    $kedadas = ver_Kedadas();

                    for ($i = 0; $i < count($kedadas); $i++) {
                    ?>

                        <div class="div_kedada" id="<?php echo $kedadas[$i]['id']; ?>">

                            <p class="lugar"><span><?php echo $kedadas[$i]['lugar']; ?></span></p>

                            <h3><?php echo $kedadas[$i]['titulo']; ?></h3>

                            <div class="img_fondo" style="background-image: url('<?php echo '../' . $kedadas[$i]['imagen']; ?>');">

                            </div>

                            <div class="div_inferior">

                                <div>
                                    <p><?php echo participantesKedada($kedadas[$i]['id']); ?><img class="img_monigotes" src="../img/grupo-de-usuarios.png" alt="monigote"></p>
                                </div>

                                <div>
                                    <p><?php echo $kedadas[$i]['fecha_inicio']; ?></p>
                                </div>
                            </div>

                        </div>

                    <?php
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
    $(document).ready(inicio);
    $(document).ready(geolocationTest());

    var mymap = null;
    var id = null;
    var marker = null;
    var polygon = null;

    var lon_geo = null;
    var lat_geo = null;


    function ver_kedada() {

        $(".div_kedada").click(function() {

            //console.log(this);

            var id = $(this).attr('id');

            console.log(id);

            window.location = "verKedadas.php?id=" + id;

        });

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

        $("#radio").blur(inicio);

        ver_kedada();

        if (mymap != undefined || mymap != null) {
            mymap.remove();
            $("#mymap").html("");
        }

        mymap = L.map('mapid').setView([40.173648, -5.0232598], 6);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(mymap);


        $.ajax({
                data: {
                    "accion": "obtenerKedadas"
                },
                type: "POST",
                dataType: "json",
                url: "../Controladores/controllerKedadas.php",
            })
            .done(function(data, textStatus, jqXHR) {
                console.log(data);

                for (var i = 0; i < data.length; i++) {

                    var array = {
                        "lat": data[i].lat,
                        "lng": data[i].lng
                    };

                    id = data[i].id;

                    var radio = $("#radio").val();
                    var mtr = radio * 1000;

                    if (lat_geo == null) {
                        var array2 = {
                            "lat": 40.401797,
                            "lng": -3.707943
                        };
                        var circle = L.circle([40.401797, -3.707943], {
                            color: 'green',
                            fillColor: '#99d8a4',
                            fillOpacity: 0.2,
                            radius: mtr
                        }).addTo(mymap);

                    } else {
                        var array2 = {
                            "lat": lat_geo,
                            "lng": lon_geo
                        };

                        var circle = L.circle([lat_geo, lon_geo], {
                            color: 'green',
                            fillColor: '#99d8a4',
                            fillOpacity: 0.2,
                            radius: mtr
                        }).addTo(mymap);

                    }


                    var distancia = getDistanciaMetros(array, array2);
                    console.log(distancia);

                    marker = L.marker(array).addTo(mymap);

                    marker.bindPopup("<b>" + data[i].titulo + "</b><br><a href='verKedadas.php?id=" + id + "'>Ver</a>");

                }


            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("La solicitud a fallado: " + textStatus);
                }
            });

    }

    function iniciarSesion() {
        window.location = "login.php";
    }

    function verPerfil() {
        window.location = "Perfil.php";
    }


    function getDistanciaMetros(latlon1, latlon2) {

        var lat1 = latlon1['lat'];
        var lon1 = latlon1['lng'];
        var lat2 = latlon2['lat'];
        var lon2 = latlon2['lng'];

        rad = function(x) {
            return x * Math.PI / 180;
        }
        var R = 6378.137; //Radio de la tierra en km 
        var dLat = rad(lat2 - lat1);
        var dLong = rad(lon2 - lon1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(rad(lat1)) *
            Math.cos(rad(lat2)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        //aquí obtienes la distancia en metros por la conversion 1Km =1000m
        var d = R * c * 1000;

        var radio = $("#radio").val();
        var mtr = radio * 1000;

        console.log(mtr);
        console.log(Math.round(d));

        if (mtr < Math.round(d)) {
            polygon = L.polygon([
                [lat1, lon1],
                [lat2, lon2]
            ]).addTo(mymap);

            polygon.setStyle({
                color: 'red'
            });


        } else {
            polygon = L.polygon([
                [lat1, lon1],
                [lat2, lon2]
            ]).addTo(mymap);
        }




        return Math.round(d);
    }


    function geolocationTest() {


        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(objPosition) {
                lon_geo = objPosition.coords.longitude;
                lat_geo = objPosition.coords.latitude;

                console.log(lat_geo);
                console.log(lon_geo);


            }, function(objPositionError) {
                switch (objPositionError.code) {
                    case objPositionError.PERMISSION_DENIED:
                        console.log("No se ha permitido el acceso a la posición del usuario.");
                        break;
                    case objPositionError.POSITION_UNAVAILABLE:
                        console.log("No se ha podido acceder a la información de su posición.");
                        break;
                    case objPositionError.TIMEOUT:
                        console.log("El servicio ha tardado demasiado tiempo en responder.");
                        break;
                    default:
                        console.log("Error desconocido.");
                }
            }, {
                maximumAge: 75000,
                timeout: 15000
            });
        } else {
            console.log("Su navegador no soporta la API de geolocalización.");
        }
    }
</script>

</html>