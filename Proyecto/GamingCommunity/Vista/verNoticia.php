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
    error_reporting(0);
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

        .noticia h4,
        .noticia h2 {
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
            /*background-image: url('../img/seamless-pattern-of-abstract-black-hexagon-background-with-red-line-vector.jpg');*/
            padding: 4% 10%;
            background-color: black;
            background: linear-gradient(to bottom, black, #800000, black);
        }

        #comentarios {
            margin-top: 30px;
            background-color: white;
            padding: 1% 5%;
            padding-bottom: 5%;
            text-align: justify;

        }

        .foto_comentario {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid black;
        }

        .cabecera_comentario {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-top: 20px;
        }

        .cabecera_comentario .cabecera_p {
            background-color: #EEEEEE;
            border-radius: 10px;
            padding-right: 10px;
        }

        #insertar_Comentarios {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }

        #res_comentario {
            margin-left: 10px;
        }

        #div_bt_comentar {
            margin-top: 10px;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
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
                        <a class="activa" href="../index.php">Inicio</a>
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
                        <a href="Kedadas.php">Quedadas</a>
                    </li>
                </ul>
            </nav>

            <div id="contenido">
                <?php
                if (!empty($_REQUEST['id'])) {
                    $noticia = ver_Noticias_id($id);

                    if (!empty($noticia)) {
                        ?>
                        <div class="noticia">
                            <h2><?php echo $noticia['titulo']; ?></h2>
                            <h4><?php echo $noticia['subtitulo']; ?></h2>
                                <img src="<?php echo "../" . $noticia['img']; ?>"></h2>
                                <div class="noticia-contenido">
                                    <?php echo $noticia['contenido']; ?>
                                </div>
                        </div>


                        <div id="comentarios">

                            <h3><?php echo comentariosNoticia($id); ?> - Comentarios</h3>

                            <hr>
                            <div id="insertar_Comentarios">
                                <?php
                                $avatar_usuario = existe_Avatar($user);

                                if ($avatar_usuario == "") {
                                    ?>
                                    <img class="foto_comentario" src="../img/usuario.svg" alt="avatar">
                                    <?php
                                } else {
                                    ?>
                                    <img class="foto_comentario" src="<?php echo "../Download/fotos_Avatar/" . $avatar_usuario; ?>" alt="avatar">

                                    <?php
                                }
                                ?>
                                <textarea class="form-control" id="res_comentario" rows="3" placeholder="Añade un comentario público…"></textarea>
                            </div>
                            <div id="div_bt_comentar">
                                <button type="button" id="bt_comentar" class="btn btn-light">Comentar</button>
                            </div>

                            <div class="alert alert-danger" style="text-align: center;" role="alert">
                                Inicia Sesion para comentar
                            </div>


                            <?php
                            $comentarios = verComentarios($id);

                            for ($i = 0; $i < count($comentarios); $i++) {
                                $avatar = existe_Avatar($comentarios[$i]['nick_user']);


                                $fechaActual = date('Y-m-d H:i:s');

                                $fecha_creacion = $comentarios[$i]['fecha_creacion'];

                                $fechaActual_dia_fecha = date_create($fechaActual);
                                $fecha_creacion_dia_fecha = date_create($fecha_creacion);

                                $diff = $fechaActual_dia_fecha->diff($fecha_creacion_dia_fecha);

                                if ($avatar == "") {
                                    ?>

                                    <div class="cabecera_comentario">
                                        <p class="cabecera_p"><span><?php echo $comentarios[$i]['nick_user']; ?></span></p>

                                        <?php
                                    } else {
                                        ?>
                                        <div class="cabecera_comentario">
                                            <p class="cabecera_p"><b><img class="foto_comentario" src="<?php echo "../Download/fotos_Avatar/" . $avatar; ?>" alt="avatar">
                                                    <?php
                                                    echo $comentarios[$i]['nick_user'];
                                                }
                                                if ($diff->days == 0) {

                                                    if ($diff->h == 0) {

                                                        if ($diff->i > 1) {
                                                            ?>
                                                        </b><span> - hace <?php echo $diff->i . " minutos"; ?></span></p>
                                                    <?php
                                                } else {

                                                    if ($diff->i == 0) {
                                                        ?>
                                                        </b><span> - hace <?php echo $diff->s . " segundos"; ?></span></p>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        </b><span> - hace <?php echo $diff->i . " minuto"; ?></span></p>
                                                        <?php
                                                    }
                                                }
                                            } else {
                                                ?>
                                                </b><span> - hace <?php echo $diff->h . " horas"; ?></span></p>
                                                <?php
                                            }
                                        } else {

                                            if ($diff->d > 1) {
                                                ?>
                                                </b><span> - hace <?php echo $diff->d . " días"; ?></span></p>
                                                <?php
                                            } else {
                                                ?>
                                                </b><span> - hace <?php echo $diff->d . " dia"; ?></span></p>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </p>
                                    </div>


                                    <?php
                                    $string = $comentarios[$i]['contenido'];

                                    $string = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $string);

                                    echo $string;
                                    ?>




                                    <?php
                                }
                                ?>



                            </div>
                        </div>

                        <?php
                    } else {
                        ?>
                        <div class="alert alert-danger" style="text-align: center" role="alert">
                            <p>Noticia no encontarda</p>
                        </div>
                        <?php
                    }
                } else {
                    ?>

                    <div class="alert alert-danger" style="text-align: center" role="alert">
                        <p>Noticia no encontarda</p>
                    </div>



                    <?php
                }
                ?>



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
                xhr.onreadystatechange = function () {
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

                        $(".div_resultado").click(function () {

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
                $("#insertar_Comentarios").css("display", "none");
                $("#bt_comentar").css("display", "none");
                console.log("none");
            } else {
                $("#foto_user").click(verPerfil);
                $(".alert").css("display", "none");
            }

            $("#sub_cabecera button").click(buscar);
            $("#sub_cabecera input[type=search]").on('keypress', function (e) {
                if (e.which == 13) {
                    $("#sub_cabecera button").click();
                }
            });


            $("#bt_comentar").click(function () {

                var comentario = $("#res_comentario").val();
                console.log(comentario);

                if (comentario) {

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

                    $.ajax({
                        data: {
                            "accion": "insertarComentario",
                            "contenido": comentario,
                            "fecha": output,
                            "user": user,
                            "id_noticia": <?php echo $id; ?>,
                        },
                        type: "POST",
                        dataType: "json",
                        url: "../Controladores/controllerNoticias.php",
                    })
                            .done(function (data, textStatus, jqXHR) {

                                console.log(data);

                                if (data == "Creado Correctamente") {
                                    location.reload();
                                }


                            })
                            .fail(function (jqXHR, textStatus, errorThrown) {
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