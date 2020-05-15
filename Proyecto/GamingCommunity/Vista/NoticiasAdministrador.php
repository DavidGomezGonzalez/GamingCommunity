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



?>

<style>
    body {
        background-color: white;
    }

    #logo {
        background-image: url("../img/logo_Administration.svg");
    }

    h1 {
        text-align: center;
        color: #30b0e5;
    }

    #bt_Guardar_Noticia{
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

        <div id="contenido">

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

            <?php


            ?>


        </div>

    </div>
</body>

<script>
    $(document).ready(inicio);

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
        }else {
            $("#foto_user").click(verPerfil);
        }

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