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
if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<?php
require_once '../modelo/Paginator.php';
require_once '../modelo/Conexion.php';
require_once '../Controladores/Funciones.php';



$conn = Conexion::conectarMysqli();

$limit      = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
$page       = (isset($_GET['page'])) ? $_GET['page'] : 1;
$links      = (isset($_GET['links'])) ? $_GET['links'] : 7;

$id      = $_REQUEST['id'];
visitasForo($id);

$query      = "SELECT * FROM comentarios WHERE id_tema = " . $id . "";

//$query = "SELECT * FROM tema";

$Paginator  = new Paginator($conn, $query);

$results    = $Paginator->getData($limit, $page);
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
        background-color: #2386B7;
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

    .ck-content {
        height: 200px !important;
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
                    <a href="#">Ranking</a>
                </li>
                <li>
                    <a href="videojuegos.php">Video Juegos</a>
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
                    <h4 style="margin-left: 10px;"><?php echo $tema['titulo']; ?></h4>
                    <div id="comentario_contenido">

                        <?php

                        $avatar =  existe_Avatar($tema['autor']);

                        if ($avatar == "") {

                        ?>

                            <p><img id="foto_Avatar" src="../img/usuario.svg" alt="avatar">

                            <?php

                        } else {
                            ?>

                                <p><img id="foto_Avatar" src="<?php echo "../Download/fotos_Avatar/" . $avatar; ?>" alt="avatar">

                                <?php
                            }

                            echo "<b>" . $tema['autor'] . "</b></p>";
                            echo "" . $tema['contenido'] . "";
                                ?>
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

                            $avatar =  existe_Avatar($results->data[$i]['nick_user']);

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
</body>

<script>
    $(document).ready(inicio);

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
            console.log("none");
        }else {
            $("#foto_user").click(verPerfil);
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

        $("#bt_Guardar").click(function() {


            var datos = editor.getData();

            console.log(datos);

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
                "contenido": datos,
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
    }

    function iniciarSesion() {
        window.location = "login.php";
    }

    function verPerfil() {
        window.location = "Perfil.php";
    }
</script>

</html>