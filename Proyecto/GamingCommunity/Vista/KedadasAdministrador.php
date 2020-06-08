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
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<link rel="stylesheet" href="../css/menu.css">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>



<?php
session_start();
//error_reporting(0);
require_once '../modelo/Conexion.php';
require_once '../Controladores/FuncionesNoticias.php';


if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

$root = verRoot($user);

if ($root != "root") {
    header("Location:../index.php");
}


?>

<style>
    #contenido {
        padding: 2% 5%;
        background: linear-gradient(to bottom, black, #800000, black);
    }

    #div_fondo {
        background-color: white;
        padding: 4% 5%;
    }

    body {
        background-color: black;
    }

    #logo {
        background-image: url("../img/logo_Administration.svg");
    }

    h1 {
        text-align: center;
        color: #30b0e5;
    }

    #bt_Guardar_Kedada,
    #bt_Geo {
        margin-top: 20px;
    }


    #mapid {
        height: 600px;
        margin-top: 20px;
    }

    #div_adm {
        margin-bottom: 20px;
    }

    .form-group {
        margin-top: 20px !important;
    }

    /************* CKEDITOR 5 *****************/

    /* Ocultar Video*/
    .ck-dropdown:nth-of-type(3) {
        background-color: red !important;
        display: none;
    }

    /* Ocultar Imagen*/
    .ck-file-dialog-button {
        background-color: red !important;
        display: none;
    }


    /***************************   MOVIL    ****************************/

    @media (max-width: 1007px) {}
</style>

<body>

    <div id="contenedor">
        <div id="cabecera">
            <img id="img_logo" src="../img/logo_Administration.svg">
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
                    <a href="NoticiasAdministrador.php">Noticias</a>
                </li>
                <li>
                    <a class="activa" href="KedadasAdministrador.php">Kedadas</a>
                </li>
            </ul>
        </nav>

        <div id="contenido">
            <div id="div_fondo">


                <h1>Administración Quedadas</h1>

                <div id="div_adm">

                    <div class="form-group">
                        <label for="exampleInputTitulo">Titulo</label>
                        <input type="text" class="form-control" id="titulo" aria-describedby="emailHelp">
                    </div>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleFormControlFile">Imagen Portada</label>
                            <input type="file" class="form-control-file" name="txtFile" id="txtFile">
                        </div>

                        <textarea name="editor1"></textarea>
                        <script>
                            CKEDITOR.replace('editor1');
                        </script>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input class="form-control" type="datetime-local" id="fecha_inicio">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fecha_fin">Fecha Fin</label>
                        <input class="form-control" type="datetime-local" id="fecha_fin">
                    </div>
                </div>


                <div class="form-group">
                    <label for="exampleInputTitulo">Dirección</label>
                    <input type="text" class="form-control" id="direccion" aria-describedby="emailHelp">
                </div>

                <div id="mapid"></div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lat">Latitud</label>
                            <input type="text" class="form-control" id="lat" placeholder="" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lng">Longitud</label>
                            <input type="text" class="form-control" id="lng" placeholder="" value="">
                        </div>
                    </div>
                </div>


                <button name="bt_Guardar_Kedada" type="button" id="bt_Guardar_Kedada" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Guardar</button>
                </form>



                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM1CKHNN_D7U3M7YXue0zu48HJwH2yGOU&callback=initMap">
                </script>


            </div>
        </div>
    </div>
    <footer>
        <img src="../img/logo_Administration.svg">
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

    var marker = null;
    var mymap = null;
    var geocoder = null;

    function subirarchivo() {
        var formData = new FormData();
        var files = $('#txtFile')[0].files[0];
        formData.append('file', files);
        $.ajax({
            url: '../modelo/upload3.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

                console.log(response);

            }
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

        $("#bt_Guardar_Kedada").click(function() {
            var data = CKEDITOR.instances.editor1.getData();

            var titulo = $("#titulo").val();
            var img = $("#txtFile").val();
            var direccion = $("#direccion").val();
            var latitud = $("#lat").val();
            var longitud = $("#lng").val();
            var f_inicio = $("#fecha_inicio").val();
            var f_fin = $("#fecha_fin").val();

            console.log(f_inicio);
            console.log(f_fin);

            img = img.replace('C:\\fakepath\\', "img/kedadas/");

            if (titulo && img && direccion && f_inicio && f_fin) {

                subirarchivo();

                $.ajax({
                        data: {
                            "accion": "crearKedada",
                            "titulo": titulo,
                            "contenido": data,
                            "img": img,
                            "direccion": direccion,
                            "f_inicio": f_inicio,
                            "f_fin": f_fin,
                            "lat": latitud,
                            "lng": longitud
                        },
                        type: "POST",
                        dataType: "json",
                        url: "../Controladores/controllerKedadas.php",
                    })
                    .done(function(data, textStatus, jqXHR) {
                        console.log(data);
                        //$(".noticia-admin").html(data);

                        if (data == "Creado Correctamente") {
                            location.reload();
                        }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        if (console && console.log) {
                            console.log("La solicitud a fallado: " + textStatus);
                        }
                    });

            }




        });

        mymap = L.map('mapid').setView([37.4601457, -3.9351636], 14);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(mymap);

        function onMapClick(e) {
            if (marker !== null) {
                mymap.removeLayer(marker);
            }
            //alert("You clicked the map at " + e.latlng);

            var lat_lng = e.latlng + "";

            var latlng_array = lat_lng.split(" ");

            var lat = latlng_array[0];
            var lng = latlng_array[1];


            lat = lat.replace("LatLng(", "");
            lat = lat.replace(",", "");

            lng = lng.replace(")", "");

            $("#lat").val(lat);
            $("#lng").val(lng);

            console.log(e.latlng);

            marker = L.marker(e.latlng).addTo(mymap);

            geocoder = new google.maps.Geocoder();
            geocodeLatLng(geocoder);


        }

        mymap.on('click', onMapClick);



    }



    function iniciarSesion() {
        window.location = "login.php";
    }

    function verPerfil() {
        window.location = "Perfil.php";
    }

    function initMap() {
        geocoder = new google.maps.Geocoder();

        document.getElementById('direccion').addEventListener('blur', function() {
            geocodeAddress(geocoder);
        });

        document.getElementById('lat').addEventListener('blur', function() {
            geocodeLatLng(geocoder);
        });

        document.getElementById('lng').addEventListener('blur', function() {
            geocodeLatLng(geocoder);
        });


    }

    function onMapClick(e) {
        if (marker !== null) {
            mymap.removeLayer(marker);
        }
        //alert("You clicked the map at " + e.latlng);

        var lat_lng = e.latlng + "";

        var latlng_array = lat_lng.split(" ");

        var lat = latlng_array[0];
        var lng = latlng_array[1];


        lat = lat.replace("LatLng(", "");
        lat = lat.replace(",", "");

        lng = lng.replace(")", "");

        $("#lat").val(lat);
        $("#lng").val(lng);


        console.log(e.latlng);

        marker = L.marker(e.latlng).addTo(mymap);

        geocoder = new google.maps.Geocoder();
        geocodeLatLng(geocoder);



    }


    function geocodeAddress(geocoder) {
        var address = document.getElementById('direccion').value;
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            //console.log(results[0].geometry.location);

            if (status === 'OK') {
                console.log(results[0].geometry.location);

                if (marker !== null) {
                    mymap.removeLayer(marker);
                }

                var lat = results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();


                var array = {
                    "lat": lat,
                    "lng": lng
                };

                array['lat'] = lat;
                array['lng'] = lng;

                $("#lat").val(lat);
                $("#lng").val(lng);
                $("#direccion").val(results[0].formatted_address);


                console.log(array);

                mymap.remove();
                $("#mapid").html("");

                mymap = L.map('mapid').setView([lat, lng], 14);

                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
                }).addTo(mymap);

                marker = L.marker(array).addTo(mymap);

                mymap.on('click', onMapClick);



            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }


    function geocodeLatLng(geocoder) {
        var latlng = {
            lat: parseFloat(document.getElementById('lat').value),
            lng: parseFloat(document.getElementById('lng').value)
        };

        console.log(latlng);
        geocoder.geocode({
            'location': latlng
        }, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    console.log(results[0].formatted_address);
                    $('#direccion').val(results[0].formatted_address);

                } else {
                    console.log('No results found');
                }
            } else {
                console.log('Geocoder failed due to: ' + status);
            }
        });
    }
</script>

</html>