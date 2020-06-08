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


if ($_REQUEST['tema_Orden']) {
    $orden = $_REQUEST['tema_Orden'];
} else {
    $orden = "DESC";
}


if (!empty($_REQUEST['plataforma'])) {
    $plataforma = $_REQUEST['plataforma'];
} else {
    $plataforma = '';
}


if ($plataforma == '') {
    if ($_REQUEST['tema'] == "NVistas") {
        $query = "SELECT * FROM tema ORDER BY vistas " . $orden;
    } else if ($_REQUEST['tema'] == "inicioDia") {
        $query = "SELECT * FROM tema ORDER BY fecha_creacion " . $orden;
    } else if ($_REQUEST['tema'] == "ultimoMsg") {

        $array_temas = verId_tema_UltComentarios();

        $ids = "";

        for ($i = 0; $i < count($array_temas); $i++) {
            if ($i != ((count($array_temas)) - 1)) {
                $ids .= "" . $array_temas[$i]['id_tema'] . ", ";
            } else {
                $ids .= "" . $array_temas[$i]['id_tema'];
            }
        }

        $query = "SELECT * FROM tema WHERE id IN(" . $ids . ") ORDER BY id " . $orden;
    } else {
        $query = "SELECT * FROM tema";
    }
} else {
    if ($_REQUEST['tema'] == "NVistas") {
        $query = "SELECT * FROM tema WHERE plataforma='" . $plataforma . "' ORDER BY vistas " . $orden;
    } else if ($_REQUEST['tema'] == "inicioDia") {
        $query = "SELECT * FROM tema WHERE plataforma='" . $plataforma . "' ORDER BY fecha_creacion " . $orden;
    } else if ($_REQUEST['tema'] == "ultimoMsg") {

        $array_temas = verId_tema_UltComentarios();

        $ids = "";

        for ($i = 0; $i < count($array_temas); $i++) {
            if ($i != ((count($array_temas)) - 1)) {
                $ids .= "" . $array_temas[$i]['id_tema'] . ", ";
            } else {
                $ids .= "" . $array_temas[$i]['id_tema'];
            }
        }

        $query = "SELECT * FROM tema WHERE id IN(" . $ids . ") AND plataforma='" . $plataforma . "'  ORDER BY id " . $orden;
    } else {
        $query = "SELECT * FROM tema WHERE plataforma='" . $plataforma . "'";
    }
}

$Paginator = new Paginator($conn, $query);

$results = $Paginator->getData($limit, $page);
?>
<style>
    #contenido {
        padding: 4% 5%;
        background: linear-gradient(to bottom, black, #800000, black);
    }

    .disabled a {
        cursor: no-drop;
        pointer-events: none !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
    }

    h3 {
        border: 2px solid #327AB7;
        background-color: #327AB7;
        color: white;
        padding: 5px;
        margin: 0;
        text-align: center;
    }

    #sub_opciones {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        border-left: 2px solid #d7d7d7;
        border-right: 2px solid #d7d7d7;
        border-bottom: 2px solid #d7d7d7;
        padding: 30px 0;
        text-align: center;
        align-items: center;

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
        background-color: white;
        border: 4px solid black;
    }

    #permisos {
        display: flex;
        flex-direction: column;
        width: 47%;
        background-color: white;
        border: 4px solid black;

    }

    #permisos div {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        border-left: 2px solid #d7d7d7;
        border-right: 2px solid #d7d7d7;
        border-bottom: 2px solid #d7d7d7;
        padding: 20px;
        text-align: center;
    }

    #bt_Insertar_Tema {
        float: right;
        margin-bottom: 10px;
    }

    textarea {
        overflow: auto;
        resize: vertical;
    }

    .sinpermisos {
        color: red;
    }

    .conpermisos {
        color: green;
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


    a {
        color: #800000;
        text-decoration: none;
        font-weight: bold;
    }


    h3 {
        border: 2px solid #800000;
        background-color: #800000;
        color: white;
        padding: 5px;
        margin: 0;
        text-align: center;
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


    .table-bordered>tbody>tr>td,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>td,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>thead>tr>th {
        border: 2px solid #ddd;
    }

    .table-bordered {
        border: 2px solid #ddd;
        background-color: white;
        border: 4px solid black;

    }



    /***************************   MOVIL    ****************************/

    @media (max-width: 1080px) {
        #leyendas-permisos {
            flex-direction: column;
        }

        #leyenda {
            width: 100%;
        }

        #permisos {
            margin-top: 20px;
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        #sub_opciones {
            flex-direction: column;
        }

        #sub_opciones div {
            margin-top: 10px;
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
                    <a class="activa" href="Foro.php">Foro</a>
                </li>
                <li>
                    <a href="ClipsTV.php">Gaming TV</a>
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

            <!-- Large modal -->
            <button type="button" id="bt_Insertar_Tema" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg">Crear Tema +</button>

            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalScrollableTitle">Crear Tema</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                        <div class="modal-body">
                            <label for="titulo" class="col-form-label">Titulo:</label>
                            <input required type="text" class="form-control" id="titulo">
                            <div style="margin-top: 10px;" class="form-group">
                                <label for="exampleFormControlSelect1">Plataforma:</label>
                                <select id="select_plataforma" class="form-control" id="exampleFormControlSelect1">
                                    <?php

                                    $plataformas =  verPlataformasBD();

                                    for ($i = 0; $i < count($plataformas); $i++) {

                                        if ($plataformas[$i]['titulo'] == 'PC') {
                                    ?>
                                            <option selected value="<?php echo $plataformas[$i]['value']; ?>"><?php echo $plataformas[$i]['titulo']; ?></option>

                                        <?php
                                        } else {

                                        ?>
                                            <option value="<?php echo $plataformas[$i]['value']; ?>"><?php echo $plataformas[$i]['titulo']; ?></option>

                                    <?php
                                        }
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="contenido" class="col-form-label">Contenido:</label>
                                <div id="div_Contenido_Tema">
                                    <div id="editor2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div id="alert_Error" style="display: none;  text-align: left;" class="alert alert-danger" role="alert">
                                ¡Error!
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="bt_guardar" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div>

                <table class="table table-striped table-condensed table-bordered table-rounded">
                    <thead>
                        <tr>
                            <th width="30%">Titulo / Autor</th>
                            <th width="10%">Respuestas / Visitas</th>
                            <th width="5%" style="text-align: center;">Plataforma</th>
                            <th width="20%" style="text-align: right; padding-right: 10px;">Ultimo mensaje por</th>
                        </tr>
                    </thead>

                    <tbody><?php for ($i = 0; $i < count($results->data); $i++) : ?>
                            <tr>
                                <td>
                                    <p><?php
                                        echo " <a href='verForo.php?id=" . $results->data[$i]['id'] . "'>" . utf8_encode($results->data[$i]['titulo']) . "</a>";
                                        echo "</p><p>Iniciado por <b>";
                                        echo utf8_encode($results->data[$i]['autor_nick']);
                                        echo "</b> , ";

                                        $fecha = $results->data[$i]['fecha_creacion'];
                                        $fecha = cambiarFecha($fecha);
                                        echo $fecha;
                                        ?></p>
                                </td>
                                <td><?php
                                    echo "<p>Respuestas:";
                                    respuestasTema($results->data[$i]['id'])
                                    ?></p>
                                    <?php
                                    echo "<p>Vistas:";
                                    echo $results->data[$i]['vistas'];
                                    ?></p>
                                </td>
                                <td>
                                    <p style="text-align: center; display: flex; justify-content: center; align-items: center; min-height: 8vh; border: none;">
                                        <?php
                                        echo verTituloPlataformas($results->data[$i]['plataforma']);

                                        ?></p>
                                </td>
                                <td style="text-align: right;">
                                    <p style="margin-right: 10px;"><?php
                                                                    ultimoComentarioForo($results->data[$i]['id']);
                                                                    echo " <a style='margin-right: 10px;' href='verForo.php?id=" . $results->data[$i]['id'] . "&ultimo=yes'>&#x25b6;</a>";
                                                                    ?></p>
                                </td>
                            </tr>
                        <?php endfor; ?></tbody>
                </table>

                <?php echo $Paginator->createLinks($links, 'pagination pagination-sm'); ?>
            </div>



            <div id="leyendas-permisos">
                <div id="leyenda">
                    <h3>Opciones de Desplegado de Temas</h3>
                    <form action="#" method="POST">
                        <div id="sub_opciones">
                            <div>
                                <span>Ordenar temas por:</span>
                                <select name="tema" id="orden_temas">
                                    <option value=""></option>
                                    <option value="ultimoMsg">Fecha último comentario</option>
                                    <option value="inicioDia">Fecha Tema</option>
                                    <option value="NVistas">Nº Vistas</option>
                                </select>
                            </div>
                            <div>
                                <span>Mostrar temas ...</span>
                                <select name="tema_Orden" id="order_by">
                                    <option value="DESC">Descendente</option>
                                    <option value="ASC">Ascendente</option>
                                </select>
                            </div>
                            <div style="display: none">
                                <div id="games">
                                    <button>🔍</button>
                                </div>
                            </div>
                            <div>
                                <span>Plataforma:</span>
                                <select name="plataforma" id="order_plataforma">
                                    <option selected value="">Todas</option>

                                    <?php

                                    $plataformas =  verPlataformasBD();

                                    for ($i = 0; $i < count($plataformas); $i++) {

                                    ?>
                                        <option value="<?php echo $plataformas[$i]['value']; ?>"><?php echo $plataformas[$i]['titulo']; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                    </form>

                </div>
            </div>
            <div id="permisos">
                <h3>Permisos de Publicación</h3>
                <div>
                    <?php
                    if (!$user) {
                        echo "<span class='sinpermisos'>No puedes crear temas</span>";
                        echo "<span class='sinpermisos'>No puedes responder temas</span>";
                        //echo "<span class='sinpermisos'>No puedes editar tus mensajes</span>";
                    } else {
                        echo "<span class='conpermisos'>Puedes crear temas</span>";
                        echo "<span class='conpermisos'>Puedes responder temas</span>";
                        //echo "<span class='conpermisos'>Puedes editar tus mensajes</span>";
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
        var editor;

        ClassicEditor
            .create(document.querySelector('#editor2'))
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
            $("#bt_Insertar_Tema").css("display", "none");
            console.log("none");
        } else {
            $("#foto_user").click(verPerfil);
        }

        $("#orden_temas").change(function() {
            $("#games button").click();
        });
        $("#order_by").change(function() {
            $("#games button").click();
        });
        $("#order_plataforma").change(function() {
            $("#games button").click();
        });

        $("#sub_cabecera button").click(buscar);
        $("#sub_cabecera input[type=search]").on('keypress', function(e) {
            if (e.which == 13) {
                $("#sub_cabecera button").click();
            }
        });



        var tema = "<?php echo $_REQUEST['tema']; ?>";
        if (tema) {
            console.log(tema);

            $("select option[value=" + tema + "]").attr("selected", "selected");
        }
        var orden = "<?php echo $_REQUEST['tema_Orden']; ?>";
        if (orden) {
            console.log(orden);

            $("select option[value=" + orden + "]").attr("selected", "selected");
        }
        var plataforma = "<?php echo $_REQUEST['plataforma']; ?>";
        if (plataforma) {
            console.log(plataforma);

            $("select option[value=" + plataforma + "]").attr("selected", "selected");
        }


        $("#bt_guardar").click(function() {

            var titulo = $("#titulo").val();
            var contenido = editor.getData();
            var plataforma = $("#select_plataforma").children("option:selected").val();

            console.log(titulo);
            console.log(contenido);


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
                    "titulo": titulo,
                    "contenido": contenido,
                    "user": user,
                    "plataforma": plataforma,
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
                xhr.send("accion=guardarTemaForo&objeto=" + parametros);
            } else {
                $("#alert_Error").css("display", "block");
                $("#alert_Error").text("¡Datos Incompletos!");
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