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
    <script src="../JavaScript/jQuery v3.4.1.js" type="text/javascript"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="132036441250-rtmolq0cq03ff18l5r27vnv052ccf4tq.apps.googleusercontent.com">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" <link rel="stylesheet" href="http://path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script>
        $(document).ready(inicio);

        function inicio() {
            $("#b_iniciarSesion").click(iniciarSesion);
            $("#b_Registrarse").click(irRegistrarse);

            $("#pass").on('keypress', function(e) {
                if (e.which == 13) {
                    $("#b_iniciarSesion").click();
                }
            });
        }

        function iniciarSesion() {

            var email = $("#email").val();
            var pass = $("#pass").val();

            console.log(email);
            console.log(pass);

            if (email && pass) {


                var objeto = {
                    "email": email,
                    "pass": pass
                };

                var parametros = JSON.stringify(objeto);

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    console.log(this.readyState + " " + this.status);
                    if (this.readyState == 4 && this.status == 200) {
                        var myObj = this.responseText;
                        console.log(myObj);

                        $("#alerta").hide();

                        if (JSON.parse(myObj) == "root") {
                            setTimeout(irRoot, 1000);
                        } else if (myObj == "true") {
                            setTimeout(irIndex, 1000);
                        } else if (myObj == "false") {
                            setTimeout(datosIncorrectos, 500);
                        }

                    }
                };

                xhr.open("POST", "../Controladores/controller.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("accion=iniciarSesion&objeto=" + parametros);
            }
        }


        function irIndex() {
            window.location = "../index.php";
        }

        function irRegistrarse() {
            window.location = "registrarse.php";
        }

        function irRoot() {
            window.location = "NoticiasAdministrador.php";
        }

        function datosIncorrectos() {
            //alert("La cuenta o la contraseña es incorrecta.");

            $("#alerta").show();


        }

        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            // console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
            // console.log('Name: ' + profile.getName());
            // console.log('Image URL: ' + profile.getImageUrl());
            // console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

            insertar_BD_Google(profile);
        }

        function insertar_BD_Google(profile) {
            var name = profile.getName();

            name = name.replace(/ /g, "");

            var objeto = {
                "name": name,
                "image": profile.getImageUrl()
            };

            var parametros = JSON.stringify(objeto);

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                console.log(this.readyState + " " + this.status);
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = this.responseText;
                    console.log(myObj);
                    irIndex();
                }
            };

            xhr.open("POST", "../Controladores/controller.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("accion=iniciarSesionGoogle&objeto=" + parametros);
        }
    </script>
    <style>
        /* * {
            margin: 0;
            padding: 0;
        }


        p {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            flex-direction: row;
            align-items: center;
            margin-bottom: 10px;
        }

        span {
            width: 80px;
            margin-right: 20px;
            text-align: right;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        input[type=submit] {
            width: 100%;
            margin-right: 45%;
            margin-left: 45%;
            padding: 5px;
        }

        #b_iniciarSesion {
            margin-top: 20px;
        }

        */

        .g-signin2 {
            margin-top: 10px;
        }

        #form_IniciarSesion {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /******************************* ********************************/

        @import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");

        .login-block {
            background: #800000;
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to bottom, black, #800000, black);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            float: left;
            width: 100%;
            height: 100vh;
            padding: 50px 0;
        }

        .banner-sec {
            background: url("../img/video-games.jpg") no-repeat left bottom;
            background-size: cover;
            min-height: 500px;
            border-radius: 0 10px 10px 0;
            padding: 0;
        }

        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 15px 20px 0px rgba(0, 0, 0, 0.1);
        }

        .login-sec {
            padding: 50px 30px;
            position: relative;
        }

        .login-sec .copy-text {
            position: absolute;
            width: 80%;
            bottom: 20px;
            font-size: 13px;
            text-align: center;
        }

        .login-sec .copy-text i {
            color: #FEB58A;
        }

        .login-sec .copy-text a {
            color: #E36262;
        }

        .login-sec h2 {
            margin-bottom: 30px;
            font-weight: 800;
            font-size: 30px;
            color: #800000;
        }

        .login-sec h2:after {
            content: " ";
            width: 100px;
            height: 5px;
            background: #FEB58A;
            display: block;
            margin-top: 20px;
            border-radius: 3px;
            margin-left: auto;
            margin-right: auto
        }

        .btn-login {
            background: #800000;
            color: #fff;
            font-weight: 600;
            font-size: 2rem;
        }

        .banner-text {
            width: 70%;
            position: absolute;
            bottom: 40px;
            padding-left: 20px;
        }

        .banner-text h2 {
            color: #fff;
            font-weight: 600;
        }

        .banner-text h2:after {
            content: " ";
            width: 100px;
            height: 5px;
            background: #FFF;
            display: block;
            margin-top: 20px;
            border-radius: 3px;
        }

        .banner-text p {
            color: #fff;
        }

        .form-control {
            font-size: 2rem;
        }

        label {
            font-size: 1.5rem;
        }

        @media (max-width: 770px) {
            .login-block {
                height: auto;
            }
        }
    </style>
</head>

<body>

    <!-- <div id="form_IniciarSesion">


        <h1 id="h1">Iniciar Sesion en GamingCommunity</h1>

        <p>Email o Nick:</p>
        <p><input type="text" id="email" name="email" placeholder="ejemplo@gaming.com"></p>
        <p>Contraseña:</p>
        <p><input type="password" id="pass" name="passwd" placeholder="********"></p>
        <p><input type="submit" id="b_iniciarSesion" value="Iniciar sesión"></p>

        <form action="registrarse.php" method="post">
            <p><input type="submit" value="Registrarse"></p>
        </form>

        <div class="g-signin2" data-onsuccess="onSignIn"></div>

    </div> -->

    <section class="login-block">
        <div class="container">
            <div class="row">
                <div class="col-md-4 login-sec">
                    <h2 class="text-center">Iniciar Sesion en Gaming Community</h2>
                    <form class="login-form">
                        <div id="alerta" style="display: none;" class="alert alert-danger" role="alert">
                            La cuenta o la contraseña es incorrecta.
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="text-uppercase">Email o Nick:</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="ejemplo@gaming.com">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="text-uppercase">Contraseña:</label>
                            <input type="password" id="pass" name="passwd" class="form-control" placeholder="********">
                        </div>


                        <!-- <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input">
                                <small>Remember Me</small>
                            </label>
                        </div> -->
                        <div class="form-group ">
                            <button id="b_iniciarSesion" type="button" class="btn btn-primary btn-lg btn-block login-button btn-login">Iniciar sesión</button>
                        </div>
                        <div class="form-group ">
                            <button style="background: black;" id="b_Registrarse" type="button" class="btn btn-primary btn-lg btn-block login-button btn-login">Registrarse</button>
                        </div>

                    </form>
                </div>
                <div class="col-md-8 banner-sec">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">


                    </div>
                </div>
            </div>
    </section>

</body>

</html>