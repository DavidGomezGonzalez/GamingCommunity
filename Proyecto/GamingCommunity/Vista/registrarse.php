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

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" <link rel="stylesheet" href="http://path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

    <script src="../JavaScript/jQuery v3.4.1.js" type="text/javascript"></script>
    <script>
        $(document).ready(inicio);

        function inicio() {
            $("#b_registrarse").click(registrar);
            $("#b_login").click(function() {
                window.location = "login.php";
            });
            $("#nick").blur(verificarNick);
            $("#email").blur(verificarEmail);
        }

        function verificarNick() {

            var nick = $("#nick").val();

            $("*").css("border", "");

            if (nick) {


                var objeto = {
                    "nick": nick
                };

                var parametros = JSON.stringify(objeto);

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    console.log(this.readyState + " " + this.status);
                    if (this.readyState == 4 && this.status == 200) {
                        var myObj = this.responseText;
                        console.log(myObj);

                        if (myObj == "true") {
                            $("#nick").css("border", "2px solid red");
                        }
                    }
                };

                xhr.open("POST", "../Controladores/controller.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("accion=verificarNick&objeto=" + parametros);
            }
        }


        function verificarEmail() {

            var email = $("#email").val();
            //console.log(nick);

            $("*").css("border", "");

            if (email) {


                var objeto = {
                    "email": email
                };

                var parametros = JSON.stringify(objeto);

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    console.log(this.readyState + " " + this.status);
                    if (this.readyState == 4 && this.status == 200) {
                        var myObj = this.responseText;
                        console.log(myObj);

                        if (myObj == "true") {
                            $("#email").css("border", "2px solid red");
                        }
                    }
                };

                xhr.open("POST", "../Controladores/controller.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("accion=verificarEmail&objeto=" + parametros);
            }

        }

        function registrar() {
            var nick = $("#nick").val();
            var nombre = $("#nombre").val();
            var apellidos = $("#apellidos").val();
            var pass = $("#pass").val();
            var email = $("#email").val();

            console.log(nick);
            console.log(nombre);
            console.log(apellidos);
            console.log(pass);
            console.log(email);

            $("*").css("border", "");

            if (nick == "") {
                $("#nick").css("border", "2px solid red");
            }
            if (nombre == "") {
                $("#nombre").css("border", "2px solid red");
            }
            if (apellidos == "") {
                $("#apellidos").css("border", "2px solid red");
            }
            if (pass == "") {
                $("#pass").css("border", "2px solid red");
            }
            if (email == "") {
                $("#email").css("border", "2px solid red");
            }

            if (nick && nombre && apellidos && pass && email) {

                var objeto = {
                    "nick": nick,
                    "nombre": nombre,
                    "apellidos": apellidos,
                    "pass": pass,
                    "email": email
                };

                var parametros = JSON.stringify(objeto);

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    console.log(this.readyState + " " + this.status);
                    if (this.readyState == 4 && this.status == 200) {
                        var myObj = this.responseText;
                        console.log(myObj);
                        if (myObj == '"Email"') {
                            $("#email").css("border", "2px solid red");
                        }
                        if (myObj == '"Usuario"') {
                            $("#nick").css("border", "2px solid red");
                        }
                        if (myObj == "Creado Correctamentenull") {

                            $("#alerta").show();

                            $("input[type=text]").val("");
                            $("input[type=password]").val("");
                            $("input[type=email]").val("");
                        }
                    }
                };

                xhr.open("POST", "../Controladores/controller.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("accion=registarse&objeto=" + parametros);
            }
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

        #b_registrarse {
            margin-top: 20px;
        }

        #correctamente {

            padding: 10px;
            border: 2px solid green;
            background-color: lightgreen;
            width: 300px;
            margin: auto;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;


        } */



        /**************************** *****************************/

        body,
        html {
            height: 100%;
            background-repeat: no-repeat;
            background-color: #d3d3d3;
            font-family: 'Oxygen', sans-serif;
            background: linear-gradient(to bottom, black, #800000, black);
        }

        .main {
            margin-top: 70px;
        }

        h1.title {
            font-size: 50px;
            font-family: 'Passion One', cursive;
            font-weight: 400;
            color: white;
        }

        hr {
            width: 10%;
            color: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            margin-bottom: 15px;
        }

        input,
        input::-webkit-input-placeholder {
            font-size: 11px;
            padding-top: 3px;
        }

        .main-login {
            background-color: #fff;
            /* shadows and rounded borders */
            -moz-border-radius: 2px;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

        }

        .main-center {
            max-width: 330px;
            margin-top: 30px;
            margin: 0 auto;
            padding: 40px 40px;

        }

        .login-button {
            margin-top: 5px;
        }

        .login-register {
            font-size: 11px;
            text-align: center;
        }

        .btn-primary {
            color: #fff;
            background-color: #800000;
            border-color: #800000;
        }


        @media (max-width: 1007px) {

            .main-center {
                max-width: 90%;
            }

        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row main">
            <div class="panel-heading">
                <div class="panel-title text-center">
                    <h1 class="title">Gaming Community</h1>
                </div>
            </div>
            <div class="main-login main-center">
                <form class="form-horizontal" method="post" action="#">

                    <div class="form-group">
                        <label for="nick" class="cols-sm-2 control-label">Nickname</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" id="nick" name="nick" placeholder="Introduce Nickname" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="cols-sm-2 control-label">Nombre</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduce Nombre" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="cols-sm-2 control-label">Apellidos</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Introduce Apellidos" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="cols-sm-2 control-label">Contraseña</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="pass" id="pass" placeholder="Introduce Contraseña" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm" class="cols-sm-2 control-label">Email</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Introduce Email" />
                            </div>
                        </div>
                    </div>

                    <div style="display: none;" id="alerta" class="alert alert-success" role="alert">
                        Creado Correctamente
                    </div>

                    <div class="form-group ">
                        <button id="b_registrarse" type="button" class="btn btn-primary btn-lg btn-block login-button">Registrarse</button>
                    </div>
                    <div class="form-group ">
                        <button style="background: black;" id="b_login" type="button" class="btn btn-primary btn-lg btn-block login-button">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>