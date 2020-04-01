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
    <script>
        $(document).ready(inicio);

        function inicio() {
            $("#b_registrarse").click(registrar);
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

                            $("#correctamente").remove();

                            var p = document.createElement('p');
                            p.textContent = "Creado Correctamente.";
                            p.setAttribute("id", "correctamente");


                            var email = document.getElementById("email").parentElement;

                            email.parentNode.insertBefore(p, email.nextSibling);

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
        * {
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
            display: flex;
            justify-content: center;
            margin-bottom: 20px;


        }
    </style>
</head>

<body>

    <h1>Registrarse</h1>

    <p><span>Nickname: </span><input id="nick" type="text" name="nick"></p>
    <p><span>Nombre: </span><input id="nombre" type="text" name="nombre"></p>
    <p><span>Apellidos: </span><input id="apellidos" type="text" name="apellidos"></p>
    <p><span>Contraseña: </span><input id="pass" type="password" name="pass"></p>
    <p><span>Email: </span><input id="email" type="email" name="email"></p>
    <p><input type="submit" id="b_registrarse" value="Registrarse"></p>
    <form action="login.php" method="post">
        <p><input type="submit" value="Iniciar Sesión"></p>
    </form>

    <?php
    ?>
</body>

</html>