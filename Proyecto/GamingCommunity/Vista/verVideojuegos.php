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


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@2/dist/email.min.js">
</script>
<script type="text/javascript">
    (function() {
        emailjs.init("user_0z3t0EQeV5xLVZF4Heh66");
    })();
</script>


<?php
session_start();
//error_reporting(0);
header('Access-Control-Allow-Origin: *');
require_once '../modelo/Conexion.php';
require_once '../Controladores/Funciones.php';
require_once '../Controladores/FuncionesTienda.php';
if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
if (!empty($_REQUEST['game'])) {
    $game_url = $_REQUEST['game'];
}

if (!empty($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
    //$carrito = array_unique($carrito);
    //print_r($carrito);
}





?>

<style>
    /****************** Tienda **************/


    #contenido {
        padding: 2% 5%;
        background: linear-gradient(to bottom, black, #800000, black);
    }

    #div_fondo {
        background-color: white;
        padding: 0 4% 5% 5%;
    }

    #carrito {
        display: flex;
        justify-content: flex-end;
        padding: 20px;
        font-size: 18px;
        cursor: pointer;
    }

    #carrito span {
        padding: 15px;
        border: 2px solid;
    }

    #div_game {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        text-align: center;
        min-height: 377px;
    }

    #div_game h2 {
        background-color: black;
        color: white;
        padding: 20px 40px;
        margin: 0;
    }


    #div_producto {
        border: 2px solid black;
        width: 60%;
    }

    .div_contenido_producto {
        height: 40%;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #div_pataformas {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        flex-wrap: nowrap;
        margin-bottom: 10px;
    }

    #div_genero {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        flex-wrap: nowrap;
        margin-bottom: 10px;
    }

    a:hover {
        text-decoration: none;
    }

    .span_plataform {
        background-color: #ff4102;
        font-weight: bold;
        padding: 10px 20px;
        color: white;
        border-radius: 5px;
        font-size: 18px;
    }


    .span_plataform_gris {
        background-color: #777;
        font-weight: bold;
        padding: 10px 20px;
        color: white;
        border-radius: 5px;
        font-size: 18px;
    }

    .span_plataform_gris:hover {
        background-color: black;
        cursor: pointer;
    }

    #img_game {
        width: 271px;
        height: 377px;
    }


    .div_cabecera_producto {
        height: 20%;
    }

    .div_footer_producto {
        width: 100%;
        height: 40%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: black;
    }

    #precio {
        font-size: 42px;
        font-weight: 700;
        display: inline-block;
        height: 44px;
        margin-left: 10px;
        color: #ff4102;
    }

    #descuento {
        font-size: 23px;
        color: #fff;
        font-weight: 700;
        display: inline-block;
    }


    .div_sub_footer,
    .div_sub_footer_der {
        background-color: black;
        height: 100%;
        width: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .precio_publico {
        font-size: 14px;
        color: #777;
        margin: 3px 0;
    }

    #bt_comprar {
        background-color: #ff4102;
        width: 200px;
        font-size: 25px;
        padding: 19px 0;
        border-radius: 10px;
        color: #fff;
        font-weight: 700;
        border: none;
    }


    .div_sub_footer_der a:link,
    .div_sub_footer_der a:visited,
    .div_sub_footer_der a:active .div_sub_footer_der a:hover {
        text-decoration: none;
    }

    #bt_comprar:hover {
        background-color: #800000;
    }

    .div_contenido_producto hr {
        width: 90%;
        border-top: 2px solid #bebebe;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .div_sub_footer_der table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
        margin-bottom: 20px;
        border-spacing: 2px;
    }

    .div_sub_footer_der table img {
        width: 100px;
        height: 130px;
    }

    .div_sub_footer_der table th {
        border: 1px solid #999;
        padding: 7px 9px 4px 7px;
        text-align: center;
        background-color: #EEEEEE;
    }

    .div_sub_footer_der table td {
        border: 1px solid #999;
        padding: 7px 9px 4px 7px;
        text-align: center;
    }

    .div_sub_footer_der table tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }

    #div_info {
        margin-top: 20px;
        line-height: 22px;
        text-align: justify;
    }

    .span_genero_gris {
        padding: 5px;
        border: 1px solid hsla(0, 0%, 46.7%, .65);
        border-radius: 5px;
    }

    /************************** ***********************/

    @import url("https://fonts.googleapis.com/css?family=Roboto:300,400,500");

    * {
        margin: 0;
        box-sizing: border-box;
    }

    html {
        --card-color: #cacaca;
        --text-color: #e1e1e1;
    }

    body {
        font-family: "Roboto", sans-serif;
    }

    .container {
        text-align: left;
        display: -webkit-box;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        flex-direction: row;
        -webkit-box-align: center;
        align-items: center;
        margin: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 680px;
    }

    .container .col1 {
        -webkit-perspective: 1000;
        perspective: 1000;
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }

    .container .col1 .card {
        position: relative;
        width: 420px;
        height: 250px;
        margin-bottom: 85px;
        margin-right: 10px;
        border-radius: 17px;
        box-shadow: 0 5px 20px -5px rgba(0, 0, 0, 0.1);
        -webkit-transition: all 1s;
        transition: all 1s;
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }

    .container .col1 .card .front {
        position: absolute;
        background: var(--card-color);
        border-radius: 17px;
        padding: 50px;
        width: 100%;
        height: 100%;
        transform: translateZ(1px);
        -webkit-transform: translateZ(1px);
        -webkit-transition: background 0.3s;
        transition: background 0.3s;
        z-index: 50;
        background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), -webkit-linear-gradient(-245deg, rgba(255, 255, 255, 0) 40%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 90%);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }

    .container .col1 .card .front .type {
        position: absolute;
        width: 75px;
        height: 45px;
        top: 20px;
        right: 20px;
    }

    .container .col1 .card .front .type img {
        width: 100%;
        float: right;
    }

    .container .col1 .card .front .card_number {
        position: absolute;
        font-size: 26px;
        font-weight: 500;
        letter-spacing: -1px;
        top: 110px;
        color: var(--text-color);
        word-spacing: 3px;
        -webkit-transition: color 0.5s;
        transition: color 0.5s;
    }

    .container .col1 .card .front .date {
        position: absolute;
        bottom: 40px;
        right: 55px;
        width: 90px;
        height: 35px;
        color: var(--text-color);
        -webkit-transition: color 0.5s;
        transition: color 0.5s;
    }

    .container .col1 .card .front .date .date_value {
        font-size: 12px;
        position: absolute;
        margin-left: 22px;
        margin-top: 12px;
        color: var(--text-color);
        font-weight: 500;
        -webkit-transition: color 0.5s;
        transition: color 0.5s;
    }

    .container .col1 .card .front .date:after {
        content: "MONTH / YEAR";
        position: absolute;
        display: block;
        font-size: 7px;
        margin-left: 20px;
    }

    .container .col1 .card .front .date:before {
        content: "valid \a thru";
        position: absolute;
        display: block;
        font-size: 8px;
        white-space: pre;
        margin-top: 8px;
    }

    .container .col1 .card .front .fullname {
        position: absolute;
        font-size: 20px;
        bottom: 40px;
        color: var(--text-color);
        -webkit-transition: color 0.5s;
        transition: color 0.5s;
    }

    .container .col1 .card .back {
        position: absolute;
        width: 100%;
        border-radius: 17px;
        height: 100%;
        background: var(--card-color);
        -webkit-transform: rotateY(180deg);
        transform: rotateY(180deg);
    }

    .container .col1 .card .back .magnetic {
        position: absolute;
        width: 100%;
        height: 50px;
        background: rgba(0, 0, 0, 0.7);
        margin-top: 25px;
    }

    .container .col1 .card .back .bar {
        position: absolute;
        width: 80%;
        height: 37px;
        background: rgba(255, 255, 255, 0.7);
        left: 10px;
        margin-top: 100px;
    }

    .container .col1 .card .back .seccode {
        font-size: 13px;
        color: var(--text-color);
        font-weight: 500;
        position: absolute;
        top: 100px;
        right: 40px;
    }

    .container .col1 .card .back .chip {
        bottom: 45px;
        left: 10px;
    }

    .container .col1 .card .back .disclaimer {
        position: absolute;
        width: 65%;
        left: 80px;
        color: #f1f1f1;
        font-size: 8px;
        bottom: 55px;
    }

    .container .col2 input {
        display: block;
        width: 260px;
        height: 30px;
        padding-left: 10px;
        padding-top: 3px;
        padding-bottom: 3px;
        margin: 7px;
        font-size: 17px;
        border-radius: 20px;
        background: rgba(0, 0, 0, 0.05);
        border: none;
        -webkit-transition: background 0.5s;
        transition: background 0.5s;
    }

    .container .col2 input:focus {
        outline-width: 0;
        background: rgba(31, 134, 252, 0.15);
        -webkit-transition: background 0.5s;
        transition: background 0.5s;
    }

    .container .col2 label {
        padding-left: 8px;
        font-size: 15px;
        color: #444;
    }

    .container .col2 .ccv {
        width: 40%;
    }

    .container .col2 .buy {
        width: 260px;
        height: 50px;
        position: relative;
        display: block;
        margin: 20px auto;
        border-radius: 10px;
        border: none;
        background: #42c2df;
        color: white;
        font-size: 20px;
        -webkit-transition: background 0.4s;
        transition: background 0.4s;
        cursor: pointer;
    }

    .container .col2 .buy i {
        font-size: 20px;
    }

    .container .col2 .buy:hover {
        background: #3594a9;
        -webkit-transition: background 0.4s;
        transition: background 0.4s;
    }

    .chip {
        position: absolute;
        width: 55px;
        height: 40px;
        background: #bbb;
        border-radius: 7px;
    }

    .chip:after {
        content: "";
        display: block;
        width: 35px;
        height: 25px;
        border-radius: 4px;
        position: absolute;
        top: 0;
        bottom: 0;
        margin: auto;
        background: #ddd;
    }

    #carga {
        width: 200px;
    }

    hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border: 0;
        border-top: 2px solid #afafaf;
    }



    /***************************   MOVIL    ****************************/

    @media (max-width: 900px) {
        #div_game {
            flex-direction: column;
        }

        #div_producto {
            margin: auto;
            margin-top: 20px;
            width: 100%;
            min-width: 412px;
        }

        #div_fondo {
            min-width: 450px;
        }

        #div_pataformas {
            margin-top: 20px;
        }
    }


    @media (max-width: 1000px) {
        .modal-dialog {
            min-width: 800px;
            width: 99%;
            margin: 30px auto;
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
                <div id="carrito">
                    <span class="glyphicon glyphicon-shopping-cart">
                        <?php if (!empty($_SESSION['carrito'])) {
                            echo count($carrito);
                        } else {
                            echo '0';
                        } ?></span>
                </div>
                <?php
                if (!empty($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $game = verGamesShopId($id);
                    //print_r($game);

                ?>

                    <div id="div_game">
                        <div id="div_img">
                            <img id="img_game" src="<?php echo $game['img'] ?>">
                        </div>
                        <div id="div_producto">
                            <div class="div_cabecera_producto">
                                <h2 id="titulo_game"><?php echo $game['titulo']; ?></h2>
                            </div>
                            <div class="div_contenido_producto">

                                <div id="div_pataformas">

                                    <a href=""><span class="span_plataform">
                                            <?php

                                            $plataform = $game['plataforma'];

                                            if ($plataform == 'playstation-4') {
                                                $plataform = 'PS4';
                                            }

                                            if ($plataform == 'playstation-3') {
                                                $plataform = 'PS3';
                                            }

                                            echo strtoupper($plataform);
                                            ?></span></a>

                                    <?php

                                    $plataformas =  verPlataformas($game['titulo'], $game['plataforma']);

                                    //print_r($plataformas);

                                    for ($i = 0; $i < count($plataformas); $i++) {

                                        $plataforma = $plataformas[$i]['plataforma'];

                                        if ($plataforma == 'playstation-4') {
                                            $plataforma = 'PS4';
                                        }

                                        if ($plataforma == 'playstation-3') {
                                            $plataforma = 'PS3';
                                        }

                                    ?>
                                        <a href="<?php echo "verVideojuegos.php?id=" . $plataformas[$i]['id'] ?>"><span id="<?php echo $plataformas[$i]['id'] ?>" class="span_plataform_gris"><?php echo strtoupper($plataforma); ?></span></a>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <hr>

                                <div id="div_genero">
                                    <?php
                                    $generos = $game['genero'];
                                    $array_generos = array_unique(explode(',', $generos));

                                    if ($generos != '') {

                                        for ($i = 0; $i < count($array_generos); $i++) {

                                    ?>
                                            <span class="span_genero_gris"><?php echo $array_generos[$i]; ?></span>
                                    <?php
                                        }
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="div_footer_producto">
                                <div class="div_sub_footer">
                                    <p class="precio_publico">Precio de venta al público: <?php $precio = rand(10, 60);
                                                                                            echo $precio ?>€</p>
                                    <p><span id="descuento"><?php $porcentaje = rand(10, 70);
                                                            echo "-" . $porcentaje ?>%</span>
                                        <span id="precio"><span id="precio_pro"><?php echo number_format($precio - ($precio * $porcentaje / 100), 2); ?>‎</span>€</span>

                                    </p>

                                </div>
                                <div class="div_sub_footer_der">
                                    <button type="button" id="bt_comprar" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg">Comprar</button>

                                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div id="div_modal" class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="exampleModalScrollableTitle">Resumen del pedido: </h4>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                </div>
                                                <div class="modal-body">

                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2" width="35%">Producto</th>
                                                                <th>Plataforma</th>
                                                                <th>Precio</th>
                                                                <th colspan="2">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                            if (!empty($_SESSION['carrito'])) {

                                                                for ($i = 0; $i < count($carrito); $i++) {
                                                            ?>
                                                                    <tr>
                                                                        <td style="border-right: none;"><img src="<?php echo $carrito[$i]['img'] ?>" alt="<?php $carrito[$i]['game']; ?>" title="<?php echo $carrito[$i]['game']; ?>"></td>
                                                                        <td style="border-left: none;"><?php echo $carrito[$i]['game']; ?></td>
                                                                        <td><?php echo strtoupper($carrito[$i]['plataforma']); ?></td>
                                                                        <td><?php echo $carrito[$i]['precio']; ?>€‎</td>
                                                                        <td><input style="width: 50px;" type="number" value="1" min="1" max="10"></td>
                                                                        <td><span class="total_produc"><?php echo $carrito[$i]['precio']; ?>‎</span>€</td>
                                                                    </tr>
                                                            <?php
                                                                }
                                                            }


                                                            ?>
                                                            <tr id="tr_producto" style="display: none;">
                                                                <td style="border-right: none;"><img src="<?php echo $game['img'] ?>" alt="<?php echo $game['titulo']; ?>" title="<?php echo $game['titulo']; ?>"></td>
                                                                <td style="border-left: none;"><?php echo $game['titulo']; ?></td>
                                                                <td><?php echo strtoupper($game['plataforma']); ?></td>
                                                                <td><?php echo number_format($precio - ($precio * $porcentaje / 100), 2); ?>‎€</td>
                                                                <td><input style="width: 50px;" type="number" value="1" min="1" max="10"></td>
                                                                <td><span class="total_produc"><?php echo number_format($precio - ($precio * $porcentaje / 100), 2); ?></span>€</td>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align: right;" colspan="5">Importe Total:</td>
                                                                <td>
                                                                    <span id="total_pagar">
                                                                        <?php

                                                                        $precio_carrito = 0;
                                                                        if (!empty($_SESSION['carrito'])) {

                                                                            for ($i = 0; $i < count($carrito); $i++) {
                                                                                $precio_carrito += $carrito[$i]['precio'];
                                                                            }

                                                                            echo $precio_carrito;
                                                                        } else {
                                                                            echo 0;
                                                                        }

                                                                        ?>
                                                                    </span>
                                                                    €
                                                                </td>
                                                            </tr>
                                                        </tbody>

                                                    </table>

                                                    <div class="container">
                                                        <div class="col1">
                                                            <div class="card">
                                                                <div class="front">
                                                                    <div class="type">
                                                                        <img class="bankid" />
                                                                    </div>
                                                                    <span class="chip"></span>
                                                                    <span class="card_number">&#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF; </span>
                                                                    <div class="date"><span class="date_value">MM / YYYY</span></div>
                                                                    <span class="fullname">FULL NAME</span>
                                                                </div>
                                                                <div class="back">
                                                                    <div class="magnetic"></div>
                                                                    <div class="bar"></div>
                                                                    <span class="seccode">&#x25CF;&#x25CF;&#x25CF;</span>
                                                                    <span class="chip"></span><span class="disclaimer">This card is property of Random Bank of Random corporation. <br> If found please return to Random Bank of Random corporation - 21968 Paris, Verdi Street, 34 </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <label>Número de tarjeta</label>
                                                            <input id="numero_card" class="number" type="text" ng-model="ncard" maxlength="19" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
                                                            <label>Titular de la tarjeta</label>
                                                            <input id="name_card" class="inputname" type="text" placeholder="" />
                                                            <label>Fecha de caducidad</label>
                                                            <input id="expire_card" class="expire" type="text" placeholder="MM / YYYY" />
                                                            <label>CVC</label>
                                                            <input id="ccv" class="ccv" type="text" placeholder="CVC" maxlength="3" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
                                                            <button id="bt_Pagar" class="buy"><i class="material-icons">Pagar </i><span id="precio_producto"> <?php echo $precio_carrito; ?></span> €</button>
                                                        </div>
                                                    </div>

                                                    <img style="display: none;" id="carga" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" />
                                                    <div style="display: none;" id="alerta" class="alert alert-success" role="alert">
                                                        El Pago se realizo con exito.<br>
                                                        Recicira un correo ha <b><?php echo email_User_Nick($user); ?></b>
                                                    </div>
                                                    <div style="display: none;" id="alerta_error" class="alert alert-danger" role="alert">
                                                        Pago Denegado!
                                                    </div>

                                                    <script>
                                                        // 4: VISA, 51 -> 55: MasterCard, 36-38-39: DinersClub, 34-37: American Express, 65: Discover, 5019: dankort

                                                        $(function() {

                                                            var cards = [{
                                                                nome: "mastercard",
                                                                colore: "#0061A8",
                                                                src: "https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png"
                                                            }, {
                                                                nome: "visa",
                                                                colore: "#E2CB38",
                                                                src: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2000px-Visa_Inc._logo.svg.png"
                                                            }, {
                                                                nome: "dinersclub",
                                                                colore: "#888",
                                                                src: "http://www.worldsultimatetravels.com/wp-content/uploads/2016/07/Diners-Club-Logo-1920x512.png"
                                                            }, {
                                                                nome: "americanExpress",
                                                                colore: "#108168",
                                                                src: "https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/American_Express_logo.svg/600px-American_Express_logo.svg.png"
                                                            }, {
                                                                nome: "discover",
                                                                colore: "#86B8CF",
                                                                src: "https://lendedu.com/wp-content/uploads/2016/03/discover-it-for-students-credit-card.jpg"
                                                            }, {
                                                                nome: "dankort",
                                                                colore: "#0061A8",
                                                                src: "https://upload.wikimedia.org/wikipedia/commons/5/51/Dankort_logo.png"
                                                            }];

                                                            var month = 0;
                                                            var html = document.getElementsByTagName('html')[0];
                                                            var number = "";

                                                            var selected_card = -1;

                                                            $(document).click(function(e) {
                                                                if (!$(e.target).is(".ccv") || !$(e.target).closest(".ccv").length) {
                                                                    $(".card").css("transform", "rotatey(0deg)");
                                                                    $(".seccode").css("color", "var(--text-color)");
                                                                }
                                                                if (!$(e.target).is(".expire") || !$(e.target).closest(".expire").length) {
                                                                    $(".date_value").css("color", "var(--text-color)");
                                                                }
                                                                if (!$(e.target).is(".number") || !$(e.target).closest(".number").length) {
                                                                    $(".card_number").css("color", "var(--text-color)");
                                                                }
                                                                if (!$(e.target).is(".inputname") || !$(e.target).closest(".inputname").length) {
                                                                    $(".fullname").css("color", "var(--text-color)");
                                                                }
                                                            });


                                                            //Card number input
                                                            $(".number").keyup(function(event) {
                                                                $(".card_number").text($(this).val());
                                                                number = $(this).val();

                                                                if (parseInt(number.substring(0, 2)) > 50 && parseInt(number.substring(0, 2)) < 56) {
                                                                    selected_card = 0;
                                                                } else if (parseInt(number.substring(0, 1)) == 4) {
                                                                    selected_card = 1;
                                                                } else if (parseInt(number.substring(0, 2)) == 36 || parseInt(number.substring(0, 2)) == 38 || parseInt(number.substring(0, 2)) == 39) {
                                                                    selected_card = 2;
                                                                } else if (parseInt(number.substring(0, 2)) == 34 || parseInt(number.substring(0, 2)) == 37) {
                                                                    selected_card = 3;
                                                                } else if (parseInt(number.substring(0, 2)) == 65) {
                                                                    selected_card = 4;
                                                                } else if (parseInt(number.substring(0, 4)) == 5019) {
                                                                    selected_card = 5;
                                                                } else {
                                                                    selected_card = -1;
                                                                }

                                                                if (selected_card != -1) {
                                                                    html.setAttribute("style", "--card-color: " + cards[selected_card].colore);
                                                                    $(".bankid").attr("src", cards[selected_card].src).show();
                                                                } else {
                                                                    html.setAttribute("style", "--card-color: #cecece");
                                                                    $(".bankid").attr("src", "").hide();
                                                                }

                                                                if ($(".card_number").text().length === 0) {
                                                                    $(".card_number").html("&#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF;");
                                                                }

                                                            }).focus(function() {
                                                                $(".card_number").css("color", "white");
                                                            }).on("keydown input", function() {

                                                                $(".card_number").text($(this).val());

                                                                if (event.key >= 0 && event.key <= 9) {
                                                                    if ($(this).val().length === 4 || $(this).val().length === 9 || $(this).val().length === 14) {
                                                                        $(this).val($(this).val() + " ");
                                                                    }
                                                                }
                                                            })

                                                            //Name Input
                                                            $(".inputname").keyup(function() {
                                                                $(".fullname").text($(this).val());
                                                                if ($(".inputname").val().length === 0) {
                                                                    $(".fullname").text("FULL NAME");
                                                                }
                                                                return event.charCode;
                                                            }).focus(function() {
                                                                $(".fullname").css("color", "white");
                                                            });

                                                            //Security code Input
                                                            $(".ccv").focus(function() {
                                                                $(".card").css("transform", "rotatey(180deg)");
                                                                $(".seccode").css("color", "white");
                                                            }).keyup(function() {
                                                                $(".seccode").text($(this).val());
                                                                if ($(this).val().length === 0) {
                                                                    $(".seccode").html("&#x25CF;&#x25CF;&#x25CF;");
                                                                }
                                                            }).focusout(function() {
                                                                $(".card").css("transform", "rotatey(0deg)");
                                                                $(".seccode").css("color", "var(--text-color)");
                                                            });


                                                            //Date expire input
                                                            $(".expire").keypress(function(event) {
                                                                if (event.charCode >= 48 && event.charCode <= 57) {
                                                                    if ($(this).val().length === 1) {
                                                                        $(this).val($(this).val() + event.key + " / ");
                                                                    } else if ($(this).val().length === 0) {
                                                                        if (event.key == 1 || event.key == 0) {
                                                                            month = event.key;
                                                                            return event.charCode;
                                                                        } else {
                                                                            $(this).val(0 + event.key + " / ");
                                                                        }
                                                                    } else if ($(this).val().length > 2 && $(this).val().length < 9) {
                                                                        return event.charCode;
                                                                    }
                                                                }
                                                                return false;
                                                            }).keyup(function(event) {
                                                                $(".date_value").html($(this).val());
                                                                if (event.keyCode == 8 && $(".expire").val().length == 4) {
                                                                    $(this).val(month);
                                                                }

                                                                if ($(this).val().length === 0) {
                                                                    $(".date_value").text("MM / YYYY");
                                                                }
                                                            }).keydown(function() {
                                                                $(".date_value").html($(this).val());
                                                            }).focus(function() {
                                                                $(".date_value").css("color", "white");
                                                            });
                                                        });
                                                    </script>



                                                </div>
                                                <div class="modal-footer">
                                                    <div id="alert_Error" style="display: none;  text-align: left;" class="alert alert-danger" role="alert">
                                                        ¡Error!
                                                    </div>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <!--button type="button" id="bt_guardar" class="btn btn-primary">Comprar</button-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div id="div_info">

                        <hr>

                        <h2>Información</h2>

                        <?php


                        echo $game['descripcion'];



                        ?>

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

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        return result;
    }

    function enviarEmail(user, game, precio, cant, plataforma, img, key, email) {
        var pedido = Math.round(Math.random() * 100) + "" + Math.round(Math.random() * 100) + "" + Math.round(Math.random() * 100);

        var data = {
            service_id: 'gmail',
            template_id: 'template_lbiUos2N',
            user_id: 'user_0z3t0EQeV5xLVZF4Heh66',
            template_params: {
                'user': user,
                'game': game,
                'precio': precio,
                'pedido': pedido,
                'img': img,
                'key': key,
                'cantidad': cant,
                'plataforma': plataforma,
                'correo': email
            }
        };

        $.ajax('https://api.emailjs.com/api/v1.0/email/send', {
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json'
        }).done(function() {
            console.log('Your mail is sent!');
            $("#alerta").show();
        }).fail(function(error) {
            console.log('Oops... ' + JSON.stringify(error));
            $("#alerta_error").show();
        });
    }



    function correo(user, game, precio, cant, plataforma, img, key) {

        var objeto = {
            "nick_user": user
        };

        var parametros = JSON.stringify(objeto);
        console.log(parametros);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            console.log(this.readyState + " " + this.status);
            if (this.readyState == 4 && this.status == 200) {
                var myObj = this.responseText;
                console.log(myObj);

                var email = JSON.parse(this.responseText);

                console.log(email);

                if (email) {
                    enviarEmail(user, game, precio, cant, plataforma, img, key, email);
                }


            }
        };

        xhr.open("POST", "../Controladores/controller.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("accion=verEmail&objeto=" + parametros);


    }

    function inicio() {
        var user = $("#user").text();
        console.log(user);
        if (user == "") {
            $("#foto_user").click(iniciarSesion);
            $("#foto_user").css("cursor", "pointer");
            $("#foto_user").attr("title", "Iniciar Sesión");
            $("#cerrar_sesion").css("display", "none");
            $("#bt_comprar").click(iniciarSesion);
            $("#carrito").click(iniciarSesion);

            console.log("none");
        } else {
            $("#foto_user").click(verPerfil);
        }


        $("#bt_Pagar").click(function() {
            //var precio = $("#precio_producto").text();
            //var titulo = $("#titulo_game").text();
            //var img = $("#img_game").attr("src");

            var card = $("#numero_card").val();
            var name_card = $("#name_card").val();
            var expire_card = $("#expire_card").val();
            var ccv = $("#ccv").val();

            if (card == '') {
                $("#numero_card").css("border", "2px solid red");
            } else {
                $("#numero_card").css("border", "none");
            }
            if (name_card == '') {
                $("#name_card").css("border", "2px solid red");
            } else {
                $("#name_card").css("border", "none");
            }
            if (expire_card == '') {
                $("#expire_card").css("border", "2px solid red");
            } else {
                $("#expire_card").css("border", "none");
            }
            if (ccv == '') {
                $("#ccv").css("border", "2px solid red");
            } else {
                $("#ccv").css("border", "none");
            }


            if (user && card && name_card && expire_card && ccv) {
                var key = "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "-";
                key += "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "-";
                key += "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "-";
                key += "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "" + makeid().toUpperCase() + "" + makeid().toUpperCase();

                $("#carga").show();

                var tr = $("tr");

                setTimeout(function() {
                    $("#carga").hide();
                }, 5000);

                for (i = 1; i < (tr.length) - 1; i++) {

                    if ($('tr').eq(i).css('display') != "none") {
                        var img = $('tr').eq(i).find("td img").attr('src');
                        var game = $('tr').eq(i).find("td").eq(1).text();
                        var plataforma = $('tr').eq(i).find("td").eq(2).text();
                        var cant = $('tr').eq(i).find("td").eq(4).find('input').val();
                        var precio = $('tr').eq(i).find("td").eq(5).text();
                        correo(user, game, precio, cant, plataforma, img, key);
                    }
                }




            }

        });

        $("#carrito").click(function() {
            if (user) {
                if (parseInt($(".glyphicon").text()) != 0) {
                    $(".bd-example-modal-lg").modal("show");
                }
            } else {
                iniciarSesion();
            }
        });

        $("#bt_comprar").click(function() {

            if (user) {

                $("#tr_producto").show();

                var items = $(".glyphicon").text();
                $(".glyphicon").text(" " + (parseInt(items) + 1));

                var precio = $("#precio_pro").text();
                var precio_total = $("#total_pagar").text();
                var titulo = $("#titulo_game").text();
                var plataforma = $(".span_plataform").text();
                var img = $("#img_game").attr("src");

                $("#total_pagar").text((parseFloat(precio_total) + parseFloat(precio.slice(0, -1))).toFixed(2));

                $("#precio_producto").text($("#total_pagar").text());

                var objeto = {
                    "game": titulo,
                    "plataforma": plataforma,
                    "precio": precio,
                    "img": img
                };

                var parametros = JSON.stringify(objeto);
                console.log(parametros);

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    console.log(this.readyState + " " + this.status);
                    if (this.readyState == 4 && this.status == 200) {
                        var myObj = this.responseText;
                        console.log(myObj);

                        if (JSON.parse(myObj) == "Repetido") {
                            $("#tr_producto").remove();
                            $("input[type=number]").change();
                            var items = $(".glyphicon").text();
                            $(".glyphicon").text(" " + (parseInt(items) - 1));

                            var value_cant = $("td:contains(" + titulo + ")").next().next().next().find("input").val();
                            $("td:contains(" + titulo + ")").next().next().next().find("input").val(parseInt(value_cant) + 1);


                        }

                    }
                };

                xhr.open("POST", "../Controladores/controller.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("accion=insertarCarrito&objeto=" + parametros);
            }

        });

        $("input[type=number]").change(function() {
            var cant = $(this).val();
            var precio = parseFloat($(this).parent().prev().text().slice(0, -1));
            $(this).parent().next().html("<span class='total_produc'>" + (precio * cant).toFixed(2) + "</span> €");

            var antiguo_precio = parseFloat($("#total_pagar").text());

            //console.log(precio_total);
            var array_precio = $(".total_produc");

            var precio_total_productos = 0;

            for (var i = 0; i < array_precio.length; i++) {
                precio_total_productos += parseFloat($(".total_produc").eq(i).text());
            }

            $("#total_pagar").text(precio_total_productos.toFixed(2));
            $("#precio_producto").text($("#total_pagar").text());


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