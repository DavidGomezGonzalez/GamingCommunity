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

<?php
session_start();
//error_reporting(0);
if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<?php
require_once '../modelo/Paginator.php';
require_once '../modelo/Conexion.php';
require_once '../Controladores/Funciones.php';



$conn = Conexion::conectarMysqli();

$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$links = (isset($_GET['links'])) ? $_GET['links'] : 7;

$id = $_REQUEST['id'];
visitasForo($id);


if ($_REQUEST['ultimo']) {
    $query = "SELECT * FROM comentarios WHERE id_tema = " . $id . " ORDER BY 	fecha_creacion DESC";
} else {
    $query = "SELECT * FROM comentarios WHERE id_tema = " . $id . "";
}

//$query = "SELECT * FROM tema";

$Paginator = new Paginator($conn, $query);

$results = $Paginator->getData($limit, $page);
?>
<style>
    .disabled a {
        cursor: no-drop;
        pointer-events: none !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
    }

    h3 {
        border: 2px solid red;
        padding: 5px;
        margin: 0;
    }

    #sub_opciones {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        border: 2px solid black;
        padding: 30px 0;
        text-align: center;

    }

    #sub_opciones>div {
        display: flex;
        flex-direction: column;
    }

    #leyendas-permisos {
        margin-top: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
    }

    #leyenda {
        display: flex;
        flex-direction: column;
        width: 47%;
        border: 2px solid black;
    }

    #permisos {
        display: flex;
        flex-direction: column;
        width: 47%;
        border: 2px solid black;

    }

    #contenido {
        padding: 1% 5%;
    }

    #comentario {
        border: 4px solid #E5E5E5;
        margin-bottom: 3px;
    }

    #fecha {
        background-color: #800000;
        padding: 1%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        color: white;
    }

    #comentario_contenido {
        padding: 1%;
    }

    #foto_Avatar {
        width: 80px;
        height: 80px;
        border: 2px solid black;
        background-color: white;
    }

    #div_Respuesta {
        margin-top: 10px;
    }

    table {
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }


    .pagination>.active>a,
    .pagination>.active>a:focus,
    .pagination>.active>a:hover,
    .pagination>.active>span,
    .pagination>.active>span:focus,
    .pagination>.active>span:hover {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #800000;
        border-color: #800000;
    }

    /**************** Valoracion  *******************/

    .valoracion {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .valoracion input {
        position: absolute;
        top: -100px;
    }


    .valoracion label {
        float: right;
        color: #c1b8b8;
        font-size: 30px;
    }

    .valoracion label:hover,
    .valoracion label:hover~label,
    .valoracion input:checked~label {
        color: #ffff00;
    }

    #div_likes img {
        width: 30px;
        opacity: 0.3;
    }

    #div_likes img:hover {
        opacity: 1;
        cursor: pointer;
    }

    #img_editar,
    #img_guardar {
        width: 40px;
    }

    .div_editar,
    .div_guardar {
        display: block;
        float: right;
        padding: 10px;
        cursor: pointer;
    }

    #input_titulo {
        width: 90%;
    }


    /************* CKEDITOR 5 *****************/

    .ck-content {
        height: 200px !important;
    }

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
                    <a class="activa" href="Foro.php">Foro</a>
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

            <div>

                <?php
                $tema = verForo($id);
                ?>

                <div id="comentario">
                    <div id="fecha">
                        <span>
                            <?php
                            $fecha = $tema['fecha'];

                            cambiarFecha($fecha);
                            ?>
                        </span>

                    </div>
                    <div class="div_editar">
                        <img id="img_editar" src="../img/editar.png">
                    </div>
                    <div style="display: none;" class="div_guardar">
                        <img id="img_guardar" src="../img/salvar.png">
                    </div>

                    <h4 id="titulo_tema" style="margin-left: 10px;"><?php echo $tema['titulo']; ?></h4>

                    <div id="comentario_contenido">

                        <?php
                        $avatar = existe_Avatar($tema['autor']);

                        if ($avatar == "") {
                        ?>

                            <p><img id="foto_Avatar" src="../img/usuario.svg" alt="avatar">

                            <?php
                        } else {
                            ?>

                                <p><img id="foto_Avatar" src="<?php echo "../Download/fotos_Avatar/" . $avatar; ?>" alt="avatar">

                                <?php
                            }

                            echo "<b id='b_autor'>" . $tema['autor'] . "</b></p>";
                                ?>

                                <div class="valoracion">
                                    <input id="radio1" type="radio" name="estrellas" value="5">
                                    <label for="radio1">★</label>
                                    <input id="radio2" type="radio" name="estrellas" value="4">
                                    <label for="radio2">★</label>
                                    <input id="radio3" type="radio" name="estrellas" value="3">
                                    <label for="radio3">★</label>
                                    <input id="radio4" type="radio" name="estrellas" value="2">
                                    <label for="radio4">★</label>
                                    <input id="radio5" type="radio" name="estrellas" value="1">
                                    <label for="radio5">★</label>
                                </div>

                                <div id="div_contenido_tema">
                                    <?php
                                    echo "" . $tema['contenido'] . "";
                                    ?>
                                </div>
                                <div id="div_likes">
                                    <img id="img_me_gusta" src="../img/me-gusta.png"><span id="span_me_gusta"><?php echo 0 ?></span>
                                    <img id="img_no_me_gusta" src="../img/no-me-gusta.png"><span id="span_no_me_gusta"><?php echo 0 ?></span>
                                </div>
                    </div>

                </div>


                <?php for ($i = 0; $i < count($results->data); $i++) : ?>
                    <div id="comentario">
                        <div id="fecha">
                            <span>
                                <?php
                                $fecha = $results->data[$i]['fecha_creacion'];

                                cambiarFecha($fecha);
                                ?>
                            </span>
                            <span>
                                <?php echo "#" . ($i + 1) . ""; ?>
                            </span>
                        </div>
                        <div id="comentario_contenido">

                            <?php
                            $avatar = existe_Avatar($results->data[$i]['nick_user']);

                            if ($avatar == "") {
                            ?>

                                <p><img id="foto_Avatar" src="../img/usuario.svg" alt="avatar">

                                <?php
                            } else {
                                ?>

                                    <p><img id="foto_Avatar" src="<?php echo "../Download/fotos_Avatar/" . $avatar; ?>" alt="avatar">

                                    <?php
                                }


                                $contenido = utf8_encode($results->data[$i]['contenido']);

                                echo "<b>" . $results->data[$i]['nick_user'] . "</b></p>";
                                echo "" . $contenido . "";
                                    ?>
                        </div>

                    </div>

                <?php endfor; ?>
                <?php echo $Paginator->createLinks2($links, 'pagination pagination-sm', $id); ?>

                <div id="alert_Error" style="display: none" class="alert alert-danger" role="alert">
                    ¡Error!
                </div>

                <button id="bt_Responder" type="button" class="btn btn-primary">Responder</button>
                <button style="display: none; text-align: right;" id="bt_Cerrar" type="button" class="btn btn-danger">Cerrar</button>

                <div id="div_Respuesta" style="display: none">
                    <div id="editor"></div>
                </div>

                <button style="display: none" id="bt_Guardar" type="button" class="btn btn-primary">Guardar</button>

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

    function verLikes_Dislikes() {
        var objeto = {
            "id": <?php echo $id; ?>,
        };


        var parametros = JSON.stringify(objeto);
        console.log(parametros);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            console.log(this.readyState + " " + this.status);
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                console.log(myObj);

                $("#span_me_gusta").text(myObj.me_gustas);
                $("#span_no_me_gusta").text(myObj.no_me_gustas);

            }
        };

        xhr.open("POST", "../Controladores/controller.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("accion=verLikes_Dislikes&objeto=" + parametros);
    }

    function verLikes_Dislikes_Voto(user) {
        var objeto = {
            "id": <?php echo $id; ?>,
            "user": user
        };

        var parametros = JSON.stringify(objeto);
        console.log(parametros);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            console.log(this.readyState + " " + this.status);
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                console.log(myObj);

                if (myObj.me_gusta == 1) {
                    $("#img_me_gusta").css("opacity", "1");
                } else if (myObj.no_me_gusta == 1) {
                    $("#img_no_me_gusta").css("opacity", "1");
                }


            }
        };

        xhr.open("POST", "../Controladores/controller.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("accion=verLikes_Dislikes_votos&objeto=" + parametros);
    }

    function Likes_DislikesInsertar() {

        var likes = parseInt($("#span_me_gusta").text());
        var dislikes = parseInt($("#span_no_me_gusta").text());

        var objeto = {
            "id": <?php echo $id; ?>,
            "likes": likes,
            "dislikes": dislikes
        };

        var parametros = JSON.stringify(objeto);
        console.log(parametros);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            console.log(this.readyState + " " + this.status);
            if (this.readyState == 4 && this.status == 200) {
                var myObj = this.responseText;
                console.log(myObj);
            }
        };

        xhr.open("POST", "../Controladores/controller.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("accion=insertarLikes&objeto=" + parametros);
    }

    function Insertar_votos_Likes(user, likes, dislikes) {

        var objeto = {
            "id": <?php echo $id; ?>,
            "user": user,
            "likes": likes,
            "dislikes": dislikes
        };

        var parametros = JSON.stringify(objeto);
        console.log(parametros);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            console.log(this.readyState + " " + this.status);
            if (this.readyState == 4 && this.status == 200) {
                var myObj = this.responseText;
                console.log(myObj);
            }
        };

        xhr.open("POST", "../Controladores/controller.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("accion=insertarLikesVotos&objeto=" + parametros);

    }


    $(document).ready(inicio);

    var editor2;

    function inicio() {

        var editor;

        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        var user = $("#user").text();
        console.log(user);
        if (user == "") {
            $("#foto_user").click(iniciarSesion);
            $("#foto_user").css("cursor", "pointer");
            $("#foto_user").attr("title", "Iniciar Sesión");
            $("#cerrar_sesion").css("display", "none");
            $("#bt_Responder").css("display", "none");
            $('.div_likes img').click(false);
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

        verLikes_Dislikes();

        if (user != "") {

            $("#div_likes img").css("opacity", "0.3");

            $("#img_me_gusta").click(function() {

                if ($("#img_no_me_gusta").css("opacity") == "1") {
                    var no_me_gusta = parseInt($("#span_no_me_gusta").text());
                    $("#span_no_me_gusta").text(no_me_gusta - 1);
                }

                if ($(this).css("opacity") == "0.3") {
                    $(this).css("opacity", "1");
                    $("#img_no_me_gusta").css("opacity", "0.3");
                    var me_gusta = parseInt($("#span_me_gusta").text());

                    $("#span_me_gusta").text(me_gusta + 1);
                    Insertar_votos_Likes(user, 1, 0);

                } else {
                    $(this).css("opacity", "0.3");
                    $("#img_no_me_gusta").css("opacity", "0.3");
                    var me_gusta = parseInt($("#span_me_gusta").text());

                    $("#span_me_gusta").text(me_gusta - 1);
                    Insertar_votos_Likes(user, 0, 0);

                }

                Likes_DislikesInsertar();
            });
            $("#img_no_me_gusta").click(function() {
                if ($("#img_me_gusta").css("opacity") == "1") {
                    var no_me_gusta = parseInt($("#span_me_gusta").text());
                    $("#span_me_gusta").text(no_me_gusta - 1);
                }

                if ($(this).css("opacity") == "0.3") {
                    $(this).css("opacity", "1");
                    $("#img_me_gusta").css("opacity", "0.3");
                    var no_me_gusta = parseInt($("#span_no_me_gusta").text());

                    //console.log(no_me_gusta);
                    $("#span_no_me_gusta").text(no_me_gusta + 1);
                    Insertar_votos_Likes(user, 0, 1);


                } else {
                    $(this).css("opacity", "0.3");
                    $("#img_me_gusta").css("opacity", "0.3");
                    var no_me_gusta = parseInt($("#span_no_me_gusta").text());

                    //console.log(no_me_gusta);
                    $("#span_no_me_gusta").text(no_me_gusta - 1);
                    Insertar_votos_Likes(user, 0, 0);

                }
                Likes_DislikesInsertar();
                Insertar_votos_Likes(user, 0, 1);
            });

        }

        verLikes_Dislikes_Voto(user);

        if (user == "") {
            $('#img_me_gusta').click(false);
            $('#img_no_me_gusta').click(false);
            $('#img_me_gusta').css("opacity", "1");
            $('#img_me_gusta').css("cursor", "no-drop");
            $('#img_me_gusta').attr('title', 'Inicia Sesión');

            $('#img_no_me_gusta').css("opacity", "1");
            $('#img_no_me_gusta').css("cursor", "no-drop");
            $('#img_no_me_gusta').attr('title', 'Inicia Sesión');
            $('.valoracion label').css("cursor", "no-drop");

            $('.valoracion label').hover().css("color", "#c1b8b8");
            $('.valoracion label').attr('title', 'Inicia Sesión');
            $('.valoracion input').attr('title', 'Inicia Sesión');
        }


        $("#bt_Responder").click(function() {
            $("#div_Respuesta").css("display", "block");
            $("#bt_Responder").css("display", "none");
            $("#bt_Cerrar").css("display", "block");
            $("#bt_Guardar").css("display", "block");

        });

        $("#bt_Cerrar").click(function() {
            $("#div_Respuesta").css("display", "none");
            $("#bt_Responder").css("display", "block");
            $("#bt_Cerrar").css("display", "none");
            $("#bt_Guardar").css("display", "none");
        });

        $(".div_editar").click(function() {

            var titulo = $("#titulo_tema").text();

            $("#titulo_tema").html("<input id='input_titulo' type='text'>");
            $("#input_titulo").val(titulo);

            var contenido_html = $("#div_contenido_tema").html();

            ClassicEditor
                .create(document.querySelector('#div_contenido_tema'))
                .then(newEditor => {
                    editor2 = newEditor;
                })
                .catch(error => {
                    console.error(error);
                });


            $(".div_editar").hide();
            $(".div_guardar").show();

        });

        if ($("#b_autor").text() != user) {
            $(".div_editar").hide();
        }

        $(".div_guardar").click(function() {

            var titulo = $("#input_titulo").val();
            var contenido = editor2.getData();

            if (titulo && contenido) {

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

                var objeto = {
                    "id": <?php echo $_REQUEST['id']; ?>,
                    "titulo": titulo,
                    "contenido": contenido,
                    "fecha": output
                };

                var parametros = JSON.stringify(objeto);
                console.log(parametros);

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    console.log(this.readyState + " " + this.status);
                    if (this.readyState == 4 && this.status == 200) {
                        var myObj = this.responseText;
                        console.log(myObj);

                        if (myObj = "Modificado Correctamentenull") {
                            location.reload();
                        } else {
                            alert("Error al Modificar");
                        }

                    }
                };

                xhr.open("POST", "../Controladores/controller.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("accion=editarTemaForo&objeto=" + parametros);
            }

        });


        $("#bt_Guardar").click(function() {

            var datos = editor.getData();

            console.log(datos);
            var dato = datos.replace(/&nbsp;/g, '');
            console.log(dato);

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

            var objeto = {
                "contenido": dato,
                "user": user,
                "id_tema": <?php echo $id; ?>,
                "fecha": output
            };


            var parametros = JSON.stringify(objeto);
            console.log(parametros);

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                console.log(this.readyState + " " + this.status);
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = this.responseText;
                    console.log(myObj);
                    if (myObj != "Errornull") {
                        location.reload();
                    } else {
                        $("#alert_Error").css("display", "block");
                    }
                }
            };

            xhr.open("POST", "../Controladores/controller.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("accion=guardarComentarioForo&objeto=" + parametros);
        });

        var user_valorado = $("#comentario_contenido p b").eq(0).text();

        $.ajax({
                data: {
                    "accion": "verpuntuacion",
                    "user": user,
                    "user_valorado": user_valorado
                },
                type: "POST",
                dataType: "json",
                url: "../Controladores/controllerNoticias.php",
            })
            .done(function(data, textStatus, jqXHR) {

                console.log(data);



                if (data == 5) {
                    pintar_estrellas();
                    $(".valoracion label").css("color", "#ffff00");

                } else if (data == 4) {
                    pintar_estrellas();
                    $(".valoracion label").css("color", "#ffff00");
                    $(".valoracion label").eq(0).css("color", "#c1b8b8");

                } else if (data == 3) {
                    pintar_estrellas();
                    $(".valoracion label").css("color", "#ffff00");
                    $(".valoracion label").eq(0).css("color", "#c1b8b8");
                    $(".valoracion label").eq(1).css("color", "#c1b8b8");

                } else if (data == 2) {
                    pintar_estrellas();
                    $(".valoracion label").eq(3).css("color", "#ffff00");
                    $(".valoracion label").eq(4).css("color", "#ffff00");

                } else if (data == 1) {
                    pintar_estrellas();
                    $(".valoracion label").eq(4).css("color", "#ffff00");

                } else if (data == 0) {
                    if (user != "") {
                        valorar();
                    }
                }

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("La solicitud a fallado: " + textStatus);
                }
            });


        function valorar() {

            $(".valoracion").find("input").change(function() {
                var valor = $(this).val();
                console.log(valor);

                var user_valorado = $("#comentario_contenido p b").eq(0).text();

                $.ajax({
                        data: {
                            "accion": "valoracion",
                            "user": user,
                            "user_valorado": user_valorado,
                            "puntuacion": valor
                        },
                        type: "POST",
                        dataType: "json",
                        url: "../Controladores/controllerNoticias.php",
                    })
                    .done(function(data, textStatus, jqXHR) {

                        console.log(data);

                        if (data == "Creado Correctamente") {
                            location.reload();
                        }

                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        if (console && console.log) {
                            console.log("La solicitud a fallado: " + textStatus);
                        }
                    });
            });


        }

        function pintar_estrellas() {
            $(".valoracion label").hover().css("color", "#c1b8b8");
            $(".valoracion input:checked").css("color", "#c1b8b8");
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