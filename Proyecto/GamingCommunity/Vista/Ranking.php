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
require_once '../Controladores/Funciones.php';


if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<style>
    /********************** Perfil***********************/

    #contenido {
        padding: 4% 10%;
        background: linear-gradient(to bottom, black, #800000, black);
    }

    .div_ranking,
    #ranking_foros {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }

    .div_posicion {
        border: 1px solid lightgray;
        margin: 10px;
        min-width: 180px;
        background-color: white;
    }

    .contenido_posicion {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 10%;
    }

    .div_posicion img {
        width: 100px;
        height: 100px;
        border: 1px solid black;
    }

    .puesto {
        display: flex;
        justify-content: flex-end;
    }

    .puesto p {
        text-align: center;
        padding: 5px 10px;
        color: white;
        background-color: black;
        font-weight: bold;
    }


    h2 {
        text-align: center;
        color: white;
    }

    .span_puntuacion {
        font-weight: bold;
    }

    .valoracion label {
        transform: scale(1.5);
        margin: 2px;
    }

    .valoracion {
        margin-bottom: 10px;
    }


    .div_posicion_likes {
        border: 1px solid lightgray;
        width: 40%;
        margin: 10px;
        min-width: 180px;
        background-color: white;
    }

    .div_posicion_likes img {
        width: 100px;
        height: 100px;
        border: 1px solid black;
    }

    .div_posicion_likes .contenido_posicion p {
        margin-top: 10px;
        text-align: center;
    }


    #div_likes img {
        width: 30px;
        height: 30px;
        border: none;
    }

    .div_posicion_likes {
        cursor: pointer;
    }

    .div_posicion_likes:hover {
        opacity: 0.9;
    }






    /***************************   MOVIL    ****************************/

    @media (max-width: 1007px) {
        .div_posicion {
            border: 1px solid lightgray;
            width: 31%;
            margin: 10px;
            min-width: 180px;
        }
    }
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
                    <a class="activa" href="Ranking.php">Ranking</a>
                </li>
                <li>
                    <a href="videojuegos.php">Video Juegos</a>
                </li>
                <li>
                    <a href="Kedadas.php">Quedadas</a>
                </li>
            </ul>
        </nav>

        <div id="contenido">

            <h2>Usuarios mejor valorados</h2>

            <div class="div_ranking">

                <?php
                $users = verUserVotados();
                $arrays = array();

                for ($i = 0; $i < count($users); $i++) {
                    $array = array();

                    $array['puntuacion'] = (verPuntuacionUser($users[$i]) / votosUsuario($users[$i]));
                    $array['opiniones'] = votosUsuario($users[$i]);
                    $array['user'] = $users[$i];

                    array_push($arrays, $array);
                }


                rsort($arrays);


                for ($i = 0; $i < count($arrays); $i++) {
                ?>
                    <div class="div_posicion">

                        <div class="puesto">
                            <p> <?php echo (($i) + 1); ?>º</p>
                        </div>
                        <div class="contenido_posicion">

                            <?php
                            $foto_avatar = existe_Avatar($arrays[$i]['user']);

                            if ($foto_avatar == "") {
                            ?>

                                <img src="../img/usuario.svg" alt="avatar">

                            <?php
                            } else {
                            ?>

                                <img src="<?php echo "../Download/fotos_Avatar/" . $foto_avatar; ?>" alt="avatar">

                            <?php
                            }
                            ?>
                            <p><b><?php echo $arrays[$i]['user']; ?></b></p>
                            <div class="valoracion">
                                <label for="radio1">★</label>
                                <label for="radio2">★</label>
                                <label for="radio3">★</label>
                                <label for="radio4">★</label>
                                <label for="radio5">★</label>
                            </div>
                            <p><?php
                                if ($arrays[$i]['opiniones'] > 1) {
                                    echo "<span class='span_puntuacion'>" . $arrays[$i]['puntuacion'] . "</span><b> / 5 </b> (" . $arrays[$i]['opiniones'] . " opiniones)";
                                } else {
                                    echo "<span class='span_puntuacion'>" . $arrays[$i]['puntuacion'] . "</span><b> / 5 </b> (" . $arrays[$i]['opiniones'] . " opinión)";
                                }
                                ?><p>
                        </div>

                    </div>
                <?php
                }
                ?>
            </div>

            <h2>Foros con más Me Gustas</h2>

            <div id="ranking_foros">

                <?php
                $foroLikes = verforosRankingLikes();
                //print_r($foroLikes);

                for ($i = 0; $i < 4; $i++) {
                ?>
                    <div class="div_posicion_likes" id="<?php echo $foroLikes[$i]['id']; ?>">

                        <div class="puesto">
                            <p> <?php echo (($i) + 1); ?>º</p>
                        </div>
                        <div class="contenido_posicion">

                            <?php
                            $foto_avatar = existe_Avatar($foroLikes[$i]['autor_nick']);

                            if ($foto_avatar == "") {
                            ?>
                                <img src="../img/usuario.svg" alt="avatar">
                            <?php
                            } else {
                            ?>
                                <img src="<?php echo "../Download/fotos_Avatar/" . $foto_avatar; ?>" alt="avatar">
                            <?php
                            }
                            ?>
                            <p><b><?php echo $foroLikes[$i]['autor_nick']; ?></b></p>

                            <?php
                            echo "<p>" . $foroLikes[$i]['titulo'] . "</p>";
                            ?>
                            <div id="div_likes">
                                <img id="img_me_gusta" src="../img/me-gusta.png"><span id="span_me_gusta"><?php echo $foroLikes[$i]['me_gustas']; ?></span>
                                <img id="img_no_me_gusta" src="../img/no-me-gusta.png"><span id="span_no_me_gusta"><?php echo $foroLikes[$i]['no_me_gustas']; ?></span>
                            </div>
                            <?php
                            echo "<p>" . $foroLikes[$i]['vistas'] . " vistas </p>";
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
            <h2>Foros con más No Me Gustas</h2>

            <div id="ranking_foros">

                <?php
                $foroLikes = verforosRankingDisLikes();
                //print_r($foroLikes);

                for ($i = 0; $i < 4; $i++) {
                ?>
                    <div class="div_posicion_likes" id="<?php echo $foroLikes[$i]['id']; ?>">


                        <div class="puesto">
                            <p> <?php echo (($i) + 1); ?>º</p>
                        </div>
                        <div class="contenido_posicion">

                            <?php
                            $foto_avatar = existe_Avatar($foroLikes[$i]['autor_nick']);

                            if ($foto_avatar == "") {
                            ?>
                                <img src="../img/usuario.svg" alt="avatar">
                            <?php
                            } else {
                            ?>
                                <img src="<?php echo "../Download/fotos_Avatar/" . $foto_avatar; ?>" alt="avatar">
                            <?php
                            }
                            ?>
                            <p><b><?php echo $foroLikes[$i]['autor_nick']; ?></b></p>

                            <?php
                            echo "<p>" . $foroLikes[$i]['titulo'] . "</p>";
                            ?>
                            <div id="div_likes">
                                <img id="img_no_me_gusta" src="../img/no-me-gusta.png"><span id="span_no_me_gusta"><?php echo $foroLikes[$i]['no_me_gustas']; ?></span>
                                <img id="img_me_gusta" src="../img/me-gusta.png"><span id="span_me_gusta"><?php echo $foroLikes[$i]['me_gustas']; ?></span>
                            </div>
                            <?php
                            echo "<p>" . $foroLikes[$i]['vistas'] . " vistas </p>";
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
            <h2>Foros con más Visitas</h2>

            <div id="ranking_foros">

                <?php
                $foroLikes = verforosRankingVisitas();
                //print_r($foroLikes);

                for ($i = 0; $i < 4; $i++) {
                ?>
                    <div class="div_posicion_likes" id="<?php echo $foroLikes[$i]['id']; ?>">


                        <div class="puesto">
                            <p> <?php echo (($i) + 1); ?>º</p>
                        </div>
                        <div class="contenido_posicion">

                            <?php
                            $foto_avatar = existe_Avatar($foroLikes[$i]['autor_nick']);

                            if ($foto_avatar == "") {
                            ?>
                                <img src="../img/usuario.svg" alt="avatar">
                            <?php
                            } else {
                            ?>
                                <img src="<?php echo "../Download/fotos_Avatar/" . $foto_avatar; ?>" alt="avatar">
                            <?php
                            }
                            ?>
                            <p><b><?php echo $foroLikes[$i]['autor_nick']; ?></b></p>

                            <?php
                            echo "<p>" . $foroLikes[$i]['titulo'] . "</p>";
                            ?>
                            <div id="div_likes">
                                <img id="img_me_gusta" src="../img/me-gusta.png"><span id="span_me_gusta"><?php echo $foroLikes[$i]['me_gustas']; ?></span>
                                <img id="img_no_me_gusta" src="../img/no-me-gusta.png"><span id="span_no_me_gusta"><?php echo $foroLikes[$i]['no_me_gustas']; ?></span>
                            </div>
                            <?php
                            echo "<p>" . $foroLikes[$i]['vistas'] . " vistas </p>";
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>

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

        $(".div_posicion_likes").click(function() {

            //console.log(this);

            var id = $(this).attr('id');

            console.log(id);

            window.location = "../Vista/verForo.php?id=" + id;

        });


        /* ******* Pintar Estrellas ****** */

        var puntuaciones = $(".span_puntuacion").toArray();

        for (var i = 0; i < puntuaciones.length; i++) {
            //console.log(puntuaciones[i]);

            var punt = $(puntuaciones[i]).text();
            console.log(punt);


            if (punt == 5) {
                $(puntuaciones[i]).parent().prev().children().css("color", "rgb(255, 255, 0)");

            } else if (punt >= 4) {
                $(puntuaciones[i]).parent().prev().children().css("color", "rgb(255, 255, 0)");
                $(puntuaciones[i]).parent().prev().children().eq(4).css("color", "");
            } else if (punt >= 3) {
                $(puntuaciones[i]).parent().prev().children().css("color", "rgb(255, 255, 0)");
                $(puntuaciones[i]).parent().prev().children().eq(4).css("color", "");
                $(puntuaciones[i]).parent().prev().children().eq(3).css("color", "");
            } else if (punt >= 2) {
                $(puntuaciones[i]).parent().prev().children().eq(0).css("color", "rgb(255, 255, 0)");
                $(puntuaciones[i]).parent().prev().children().eq(1).css("color", "rgb(255, 255, 0)");
            } else if (punt >= 1) {
                $(puntuaciones[i]).parent().prev().children().eq(0).css("color", "rgb(255, 255, 0)");
            }

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