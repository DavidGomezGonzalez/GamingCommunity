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

    #logo {
        background-image: url("../img/logo_Administration.svg");
    }

    h1 {
        text-align: center;
        color: #30b0e5;
    }

    #bt_Guardar_Noticia {
        margin-top: 20px;
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
                    <a class="activa" href="NoticiasAdministrador.php">Noticias</a>
                </li>
                <li>
                    <a href="KedadasAdministrador.php">Kedadas</a>
                </li>
            </ul>
        </nav>

        <div id="contenido">
            <div id="div_fondo">


                <h1>Administración Noticias</h1>

                <div id="div_adm">

                    <div class="form-group">
                        <label for="exampleInputTitulo">Titulo</label>
                        <input type="email" class="form-control" id="titulo" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputSubtitulo">Subtitulo</label>
                        <input type="email" class="form-control" id="subtitulo" aria-describedby="emailHelp">
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

                <button name="btnSubmit" type="button" id="bt_Guardar_Noticia" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Guardar</button>
                </form>

                <?php ?>


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

    function subirarchivo() {
        var formData = new FormData();
        var files = $('#txtFile')[0].files[0];
        formData.append('file', files);
        $.ajax({
            url: '../modelo/upload.php',
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

        $("#bt_Guardar_Noticia").click(function() {
            var data = CKEDITOR.instances.editor1.getData();

            var titulo = $("#titulo").val();
            var subtitulo = $("#subtitulo").val();
            var img = $("#txtFile").val();

            img = img.replace('C:\\fakepath\\', "img/noticias/");


            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();
            var h = d.getHours();
            var m = d.getMinutes();
            var s = d.getSeconds();

            var output = d.getFullYear() + '-' +
                (month < 10 ? '0' : '') + month + '-' +
                (day < 10 ? '0' : '') + day + " " +
                (h < 10 ? '0' : '') + h + ':' +
                (m < 10 ? '0' : '') + m + ':' +
                (s < 10 ? '0' : '') + s;

            if (titulo && subtitulo && img) {

                subirarchivo();

                $.ajax({
                        data: {
                            "accion": "crearNoticia",
                            "titulo": titulo,
                            "subtitulo": subtitulo,
                            "contenido": data,
                            "img": img,
                            "fecha": output
                        },
                        type: "POST",
                        dataType: "json",
                        url: "../Controladores/controllerNoticias.php",
                    })
                    .done(function(data, textStatus, jqXHR) {
                        console.log(data);

                        //$(".noticia-admin").html(data);

                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        if (console && console.log) {
                            console.log("La solicitud a fallado: " + textStatus);
                        }
                    });

            }




        });


    }

    function iniciarSesion() {
        window.location = "login.php";
    }

    function verPerfil() {
        window.location = "Perfil.php";
    }
</script>

</html>