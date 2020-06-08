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

<link rel="stylesheet" href="../css/menu.css">



<?php
session_start();
//error_reporting(0);
header('Access-Control-Allow-Origin: *');
require_once '../Controladores/FuncionesTienda.php';
require_once '../Controladores/Funciones.php';

if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
if (!empty($_REQUEST['game'])) {
    $game_url = $_REQUEST['game'];
}


function limitar_cadena($cadena, $limite, $sufijo)
{
    // Si la longitud es mayor que el límite...
    if (strlen($cadena) > $limite) {
        // Entonces corta la cadena y ponle el sufijo
        return substr($cadena, 0, $limite) . $sufijo;
    }

    // Si no, entonces devuelve la cadena normal
    return $cadena;
}


?>

<style>
    /*************** Videojuegos *******************/

    #div_flex {
        display: flex;
        flex-direction: row;
        flex-wrap: 20px;
        align-items: center;
        justify-content: space-between;

    }

    #descripcion {
        width: 95%;
        text-align: justify;
    }

    #image {
        width: 120px;
    }

    #div_plataforma {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    #plataformas {
        margin-left: 20px;
    }

    #plataformas li {
        margin: 5px;

    }

    #contenido {
        width: 100%;
        height: 100%;
        min-height: 40vh;

    }

    #contenido {
        padding: 2% 15%;
        background: linear-gradient(to bottom, black, #800000, black);
    }

    #div_fondo {
        background-color: white;
        padding: 4% 1%;
    }

    #div_buscador {
        display: flex;
        align-items: flex-end;
        margin-bottom: 20px;
    }

    /****************** Tienda **************/

    #div_tienda {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-evenly;
        max-width: 740px;
        margin: auto;
        margin-top: 40px;
    }

    .item {
        width: 170px;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 4px 3px 0 rgba(0, 0, 0, .1);
        margin-bottom: 20px;
    }

    .item:hover {
        opacity: 0.8;
        cursor: pointer;
    }

    .item_image {
        width: 100%;
        height: 200px;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center;
        display: flex;
        align-items: flex-end;
    }

    .div_precio {
        background-color: #00000059;
        color: white;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        width: 100%;
    }


    .span_porcentaje {
        background-color: green;
        padding: 3px;
    }

    .span_precio {
        font-size: 18px;
        padding-right: 5px;
    }

    #div_buscar_Game {
        margin-top: 40px;
        max-width: 740px;
        margin: auto;
    }

    .div_comprar {
        padding: 5px;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-align: center;
    }

    .div_comprar a {
        background-color: #ff4102;
        color: white;
        padding: 3px 20px;
        border-radius: 5px;
        margin: auto;
    }

    .div_comprar a:link,
    .div_comprar a:visited,
    .div_comprar a:active {
        text-decoration: none;
    }

    .div_comprar a:hover {
        background-color: #800000;
    }

    .div_comprar span {
        cursor: help;
        color: #777;
        margin-bottom: 5px;
    }

    #a_comprar {
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
        padding: 10px;
        border-radius: 5px;
    }

    #a_comprar:hover {
        text-decoration: none;
    }

    #div_game {
        max-width: 740px;
        margin: auto;
        margin-left: 20px;
        margin-right: 20px;
    }

    hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border: 0;
        border-top: 2px solid #afafaf;
    }


    /***************************   MOVIL    ****************************/

    @media (max-width: 992px) {
        #div_buscar_Game {
            width: fit-content;
        }
    }


    @media (max-width: 800px) {
        #div_flex {
            flex-direction: column;
        }

        #div_plataforma {
            flex-direction: column;
            align-items: center;
        }

        #a_comprar {
            display: block;
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
                    <a href="ClipsTV.php">Gaming TV</a>
                </li>
                <li>
                    <a href="Ranking.php">Ranking</a>
                </li>
                <li>
                    <a class="activa" href="videojuegos.php">Video Juegos</a>
                </li>
                <li>
                    <a href="Kedadas.php">Quedadas</a>
                </li>
            </ul>
        </nav>

        <div id="contenido">

            <div id="div_fondo">

                <div id="div_buscar_Game">
                    <div id="div_buscador" class="form-row">
                        <div class="col-md-10">
                            <label for="exampleInputEmail1">Buscar Juego:</label>
                            <input type="text" class="form-control" id="game-search" aria-describedby="emailHelp" placeholder="Introduce Juego">
                        </div>
                        <div class="col-md-2">
                            <button style="width: 100%;" id="bt_Buscar" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Buscar</button>
                        </div>
                    </div>


                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span style="font-size: 20px;" class="modal-title" id="exampleModalScrollableTitle">Resultados:</span>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>

                                <div style="padding: 5%;">
                                    <div id="alerta2" class="alert alert-danger" role="alert">
                                        ¡Sin Resultados!
                                    </div>
                                    <div id="div_search_game">

                                        <table class="table table-striped table-condensed table-bordered table-rounded">
                                            <thead>
                                                <tr>
                                                    <th width="45%">Juegos</th>
                                                    <th width="20%">Plataforma</th>
                                                    <th width="2%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_search_games">


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <img id="carga2" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" />


                    <div id="div_buscador">
                        <div class="col-md-10">
                            <label for="exampleInputEmail1">Juego:</label>
                            <input type="text" class="form-control" id="game" aria-describedby="emailHelp" placeholder="Introduce Juego" value="<?php echo (isset($game_url)) ? $game_url : ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <button style="width: 100%;" id="bt" class="btn btn-primary">Ver</button>
                        </div>
                    </div>


                    <div id="div_buscador">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Plataforma:</label>
                            <select id="plataform" class="form-control">
                                <option value="pc">PC</option>
                                <option value="playstation-4">PS4</option>
                                <option value="playstation-3">PS3</option>
                                <option value="playstation-2">PS2</option>
                                <option value="playstation">PS1</option>
                                <option value="playstation-vita">PS VITA</option>
                                <option value="xbox-one">Xbox One</option>
                                <option value="xbox-360">Xbox 360</option>
                                <option value="switch">Nintendo Switch</option>
                                <option value="3ds">Nintendo 3DS</option>
                                <option value="ds">Nintendo DS</option>
                                <option value="nintendo-64">Nintendo 64</option>
                                <option value="wii-u">Wii U</option>
                                <option value="wii">Wii</option>
                                <option value="stadia">Google Stadia</option>
                                <option value="ios">iOS</option>
                                <option value="game-boy-advance">GBA</option>
                                <option value="gamecube">GameCube</option>
                            </select>
                        </div>
                    </div>

                    <!-- <iframe src="https://www.instant-gaming.com/affgames/igr3644585/350x350" scrolling="no" frameborder="0" style="border: 1px solid #000; border-radius: 5px; overflow:hidden; width:350px; height:350px;" allowTransparency="true"></iframe> -->


                    <img id="carga" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" />
                    <div id="alerta" class="alert alert-danger" role="alert">
                        ¡Sin Resultados!
                    </div>
                    <hr>
                </div>


                <div id="div_tienda">

                    <?php

                    $games_shop = verGamesShop();

                    for ($i = 0; $i < 12; $i++) {

                        //echo $games_shop[$i]['titulo'] . "<br>";
                    ?>
                        <div class="item" id="<?php echo $games_shop[$i]['id']; ?>">
                            <div class="item_image" style="background-image: url('<?php echo $games_shop[$i]['img']; ?>');">
                                <div class="div_precio">
                                    <span class="span_porcentaje"><?php echo "-" . rand(10, 90) . "%"; ?></span>
                                    <span class="span_precio"><?php echo "" . rand(10, 30) . "." . rand(10, 99) . "‎€"; ?></span>
                                </div>
                            </div>
                            <div class="div_comprar">
                                <span title="<?php echo $games_shop[$i]['titulo']; ?>"><?php echo limitar_cadena($games_shop[$i]['titulo'] . "", 20, "..."); ?></span>
                                <a href="verVideojuegos.php?id=<?php echo $games_shop[$i]['id']; ?>">Comprar</a>
                            </div>

                        </div>

                    <?php

                    }

                    ?>




                </div>
                <div id="div_game">
                    <hr>
                    <h3 id="titulo"></h3>
                    <div id="div_flex">
                        <div id="div_descripcion">
                            <p id="descripcion"></p>
                        </div>
                        <div>
                            <img id="image" src="">
                        </div>
                        <span style="display: none;" id="genero"></span>
                    </div>

                    <div id="div_plataforma">
                        <div>
                            <p id="p_plataforma"><b>Plataformas: </b>
                                <ul id="plataformas"></ul>
                            </p>
                        </div>
                        <div>
                            <p><b>Desarrollador: </b><span id="developer"></span></p>
                            <p><b>Fecha Publicación: </b><span id="fecha_publicacion"></span></p>
                            <!-- <button id="bt_Traducir" class="btn btn-primary">Traducir</button> -->
                        </div>
                    </div>
                    <!--button id="bt_comprar" class="btn btn-primary">Comprar</button-->
                    <a class="btn btn-primary" style="display: none;" href="" id="a_comprar">Comprar</a>

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
    function ver_game() {

        $(".item").click(function() {

            var id = $(this).attr('id');

            window.location = "verVideojuegos.php?id=" + id;

        });

    }

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

    function insertarGameBD() {

        var titulo = $("#titulo").text();
        var descripcion = $("#descripcion").text();
        var plataformas = $("#div_plataforma").html();
        var plataform = $("#plataform").val();
        var img = $("#image").attr("src");
        var developer = $("#developer").text();
        var fecha = $("#fecha_publicacion").text();
        var genero = $("#genero").text();



        var objeto = {
            "titulo": titulo,
            "descripcion": descripcion,
            "plataformas": plataformas,
            "plataforma": plataform,
            "img": img,
            "developer": developer,
            "genero": genero,
            "fecha": fecha
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
        xhr.send("accion=insertarGame&objeto=" + parametros);

    }



    function translate(text) {
        $.get("https://www.googleapis.com/language/translate/v2", {
                key: "AIzaSyAM1CKHNN_D7U3M7YXue0zu48HJwH2yGOU",
                source: "en",
                target: "es",
                q: text
            },
            function(response) {
                $("body, html").animate({
                    scrollTop: $(document).height()
                }, 400);
                $("#carga").hide();
                $("#div_game").show();

                $("#descripcion").html(response.data.translations[0].translatedText);

                insertarGameBD();


            }, "json").fail(function(jqXHR, textStatus, errorThrown) {
            console.log("error :" + errorThrown);

            $("#carga").hide();
            $("#div_game").show();
            $("#alerta").text("¡Error al Traducir!");
            $("#alerta").show();

        });

    }

    function verGameApi() {

        var game = $("#game").val();
        var plataform = $("#plataform").val();

        $("#alerta").hide();
        $("#carga").show();
        $("#div_game").hide();
        $("#p_plataforma").hide();

        var res = game.replace(" ", "%20");

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://chicken-coop.p.rapidapi.com/games/" + res + "?platform=" + plataform,
            "method": "GET",
            "headers": {
                "x-rapidapi-host": "chicken-coop.p.rapidapi.com",
                "x-rapidapi-key": "412b82af91msh660aa8cc1361f72p172b47jsnb01a5ab61790"
            }
        }

        $.ajax(settings).done(function(response) {
            // $("#carga").hide();
            // $("#div_game").show();

            if (response.result == "No result") {
                $("#alerta").show();
                $("#carga").hide();
            }

            console.log(response);

            var descrp = response.result.description;

            var descripcion = descrp.replace("Expand", "");

            var image = response.result.image;
            var plataformas = response.result.alsoAvailableOn;
            var fecha_publicacion = response.result.releaseDate;
            var title = response.result.title;
            var developer = response.result.developer;
            var genre = response.result.genre;

            var generos = "";
            for (var i = 0; i < genre.length; i++) {

                if (i != (genre.length) - 1) {
                    generos += genre[i] + ",";
                } else {
                    generos += genre[i];
                }

            }

            //console.log(generos);

            $("#plataformas").empty();

            if (plataformas.length != 0) {
                $("#p_plataforma").show();
            }

            for (var i = 0; i < plataformas.length; i++) {


                if (plataformas[i] == "PlayStation 4") {
                    $("#plataformas").append("<li>" +
                        "<img width='35px' alt='PS4' src='../img/logos_plataformas/logo_PS4.png'>" +
                        "</li>");
                } else if (plataformas[i] == "PlayStation 3") {
                    $("#plataformas").append("<li>" +
                        "<img width='35px' alt='PS3' src='../img/logos_plataformas/logo_PS3.png'>" +
                        "</li>");
                } else if (plataformas[i] == "PlayStation 2") {
                    $("#plataformas").append("<li>" +
                        "<img width='35px' alt='PS2' src='../img/logos_plataformas/logo_PS2.png'>" +
                        "</li>");
                } else if (plataformas[i] == "PlayStation Vita") {
                    $("#plataformas").append("<li>" +
                        "<img width='45px' alt='PSVITA' src='../img/logos_plataformas/logo_PSVITA.png'>" +
                        "</li>");
                } else if (plataformas[i] == "Xbox One") {
                    $("#plataformas").append("<li>" +
                        "<img width='60px' alt='Xbox One' src='../img/logos_plataformas/logo_Xbox.png'> - <b>One</b>" +
                        "</li>");
                } else if (plataformas[i] == "Xbox 360") {
                    $("#plataformas").append("<li>" +
                        "<img width='60px' alt='Xbox 360' src='../img/logos_plataformas/logo_Xbox.png'> - <b>360</b>" +
                        "</li>");
                } else if (plataformas[i] == "Switch") {
                    $("#plataformas").append("<li>" +
                        "<img width='25px' alt='Switch' src='../img/logos_plataformas/logo_Switch.png'> - <b>Switch</b>" +
                        "</li>");
                } else if (plataformas[i] == "Stadia") {
                    $("#plataformas").append("<li>" +
                        "<img width='45px' alt='Stadia' src='../img/logos_plataformas/logo_Stadia.jpg'>" +
                        "</li>");
                } else if (plataformas[i] == "PC") {
                    $("#plataformas").append("<li>" +
                        "<img width='35px' alt='PC' src='../img/logos_plataformas/logo_PC.png'> - <b>PC</b>" +
                        "</li>");
                } else if (plataformas[i] == "3DS") {
                    $("#plataformas").append("<li>" +
                        "<img width='65px' alt='PC' src='../img/logos_plataformas/logo_nintendo.png'> - <b>3DS</b>" +
                        "</li>");
                } else if (plataformas[i] == "Wii U") {
                    $("#plataformas").append("<li>" +
                        "<img width='45px' alt='WiiU' src='../img/logos_plataformas/logo_WIIU.png'>" +
                        "</li>");
                } else if (plataformas[i] == "DS") {
                    $("#plataformas").append("<li>" +
                        "<img width='45px' alt='WiiU' src='../img/logos_plataformas/logo_nintendo_ds.png'>" +
                        "</li>");
                } else {
                    $("#plataformas").append("<li>" + plataformas[i] + "</li>");
                }
            }

            //$("#div_game").css("visibility", "visible");
            $("#genero").text(generos);
            $("#fecha_publicacion").text(fecha_publicacion);
            $("#titulo").text(title);
            $("#developer").text(developer);


            $("#image").attr("src", image);

            $("#descripcion").html(descripcion);

            $("body, html").animate({
                scrollTop: $(document).height()
            }, 400);

            translate(descripcion);

        });

    }

    function verchange(title, plataform) {
        //console.log(title + " " + plataform);

        $("#game").val(title);
        $("#game").change();


        if (plataform == "PS4") {
            $("#plataform").val("playstation-4");
        } else if (plataform == "PS3") {
            $("#plataform").val("playstation-3");
        } else if (plataform == "PS2") {
            $("#plataform").val("playstation-2");
        } else if (plataform == "PS") {
            $("#plataform").val("playstation");
        } else if (plataform == "XONE") {
            $("#plataform").val("xbox-one");
        } else if (plataform == "X360") {
            $("#plataform").val("xbox-360");
        } else if (plataform == "PC") {
            $("#plataform").val("pc");
        } else if (plataform == "iOS") {
            $("#plataform").val("ios");
        } else if (plataform == "Switch") {
            $("#plataform").val("switch");
        } else if (plataform == "GBA") {
            $("#plataform").val("game-boy-advance");
        } else if (plataform == "GC") {
            $("#plataform").val("gamecube");
        } else if (plataform == "3DS") {
            $("#plataform").val("3ds");
        } else if (plataform == "WII") {
            $("#plataform").val("wii");
        } else if (plataform == "WIIU") {
            $("#plataform").val("wii-u");
        } else if (plataform == "VITA") {
            $("#plataform").val("playstation-vita");
        } else if (plataform == "DS") {
            $("#plataform").val("ds");
        } else if (plataform == "N64") {
            $("#plataform").val("nintendo-64");
        }

        $("#plataform").change();


        $("body, html").animate({
            scrollTop: $(document).height()
        }, 400)



        $("#bt").click();

    }

    $(document).ready(inicio);

    function inicio() {
        $("#carga").hide();
        $("#carga2").hide();
        $("#alerta").hide();
        $("#alerta2").hide();
        $("#div_search_game").hide();
        $("#div_game").hide();
        var user = $("#user").text();
        var game_url = $("#game").val();
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

        ver_game();

        $("#bt").click(function() {

            var game = $("#game").val();
            var plataform = $("#plataform").val();

            if (game) {


                var objeto = {
                    "titulo": game,
                    "plataforma": plataform
                };

                var parametros = JSON.stringify(objeto);
                console.log(parametros);

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    console.log(this.readyState + " " + this.status);
                    if (this.readyState == 4 && this.status == 200) {
                        var myObj = this.responseText;
                        console.log(myObj);

                        if (myObj == "[]") {
                            verGameApi();
                        } else {

                            myObj = JSON.parse(this.responseText);

                            var descripcion = myObj.descripcion;
                            var image = myObj.img;
                            var plataformas = myObj.plataformas_compatibles;
                            var id = myObj.id;

                            console.log(plataformas);
                            var title = myObj.titulo;

                            $("#plataformas").empty();

                            $("#p_plataforma").show();

                            //$("#div_game").css("visibility", "visible");
                            $("#titulo").text(title);

                            $("#div_plataforma").empty();
                            $("#div_plataforma").html(plataformas);

                            $("#image").attr("src", image);

                            $("#descripcion").text(descripcion);
                            $("#a_comprar").attr("href", "verVideojuegos.php?id=" + id);
                            $("#a_comprar").show();

                            $("#div_game").css("display", "block");

                            $("body, html").animate({
                                scrollTop: $(document).height()
                            }, 400);
                        }

                    }
                };

                xhr.open("POST", "../Controladores/controller.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("accion=verGame&objeto=" + parametros);


            }


        });

        if (game_url != '') {
            $("#bt").click();
        }

        $("#bt_comprar").click(function() {

            var game_comprar = $("#game").val();
            var plataforma_comprar = $("#plataform").val();
            console.log(game_comprar);

            game_comprar = game_comprar.replace(" ", "+");

            //url = "https://www.amazon.com/s?k=" + game_comprar + "+" + plataforma_comprar + "&i=videogames";
            url = "https://www.instant-gaming.com/es/busquedas/?q=" + game_comprar;
            window.open(url, '_blank');
            return false;
        });


        $("#plataform").change(function() {
            $("#bt").click();
        });


        // $("#bt_Traducir").click(function() {

        //     var descripcion = $("#descripcion").text();

        //     translate(descripcion);

        // });

        $("#game-search").on('keypress', function(e) {
            if (e.which == 13) {
                $("#bt_Buscar").click();
            }
        });
        $("#game").on('keypress', function(e) {
            if (e.which == 13) {
                $("#bt").click();
            }
        });




        $("#bt_Buscar").click(function() {

            var gamesearch = $("#game-search").val();
            $("#tbody_search_games").empty();
            $("#div_search_game").hide();
            $("#alerta2").hide();



            if (gamesearch != "") {
                $("#carga2").show();


                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "https://chicken-coop.p.rapidapi.com/games?title=" + gamesearch,
                    "method": "GET",
                    "headers": {
                        "x-rapidapi-host": "chicken-coop.p.rapidapi.com",
                        "x-rapidapi-key": "412b82af91msh660aa8cc1361f72p172b47jsnb01a5ab61790"
                    }
                }

                $.ajax(settings).done(function(response) {
                    console.log(response);

                    if (response.result != "No result") {

                        for (var i = 0; i < response.result.length; i++) {
                            var titulo = response.result[i].title;

                            titulo = titulo.replace("'", "");

                            $("#tbody_search_games").append("<tr><td>" + response.result[i].title + "</td>" + "<td>" + response.result[i].platform + "</td>" + "<td><button onclick=\"" + "verchange('" + titulo + "', '" + response.result[i].platform + "')" + "\" class='btn btn-secondary'>+</button></td></tr>");
                        }

                        $("#carga2").hide();
                        $("#div_search_game").show();

                    } else {
                        $("#carga2").hide();
                        $("#alerta2").show();

                    }
                });

            } else {
                $("#carga2").hide();
                $("#alerta2").show();
            }

        });


        function iniciarSesion() {
            window.location = "./login.php";
        }

        function verPerfil() {
            window.location = "Perfil.php";
        }

    }
</script>

</html>