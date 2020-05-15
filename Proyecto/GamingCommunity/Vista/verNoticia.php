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

<?php
session_start();
//error_reporting(0);
require_once '../modelo/Conexion.php';
require_once '../Controladores/FuncionesNoticias.php';


if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

if (!empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
}



?>

<style>
    /********************** Ver Noticias***********************/

    .noticia {
        padding: 1% 5%;
        width: 100%;
        background-color: white;
    }

    .noticia img {
        width: 100%;
    }

    .noticia-contenido p {
        margin-top: 20px;
        margin-bottom: 20px;
        text-align: justify;

    }

    .noticia h4, .noticia h2{
        text-align: center;
        padding: 0 5%;
        margin-bottom: 40px;    
        color: #30b0e5;
    }

    .noticia h4 {
        color: #999;
        padding: 0 10%;
    }

    #contenido {
        background-image: url('../img/seamless-pattern-of-abstract-black-hexagon-background-with-red-line-vector.jpg');
        padding: 4% 10%;
        background-color: black;
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

        <nav class="nav">
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li>
                    <a class="activa" href="../index.php">Inicio</a>
                </li>
                <li>
                    <a href="Foro.php">Foro</a>
                </li>
                <li>
                    <a href="clipsTV.php">Gaming TV</a>
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
            <?php
            $noticia = ver_Noticias_id($id);
            ?>
            <div class="noticia">
                <h2><?php echo $noticia['titulo']; ?></h2>
                <h4><?php echo $noticia['subtitulo']; ?></h2>
                    <img src="<?php echo "../" . $noticia['img']; ?>"></h2>
                    <div class="noticia-contenido">
                        <?php echo $noticia['contenido']; ?>
                    </div>
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

    }

    function iniciarSesion() {
        window.location = "login.php";
    }

    function verPerfil() {
        window.location = "Perfil.php";
    }
</script>

</html>