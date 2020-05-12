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
            $("#b_iniciarSesion").click(iniciarSesion);
            
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

                        if (myObj == "true") {
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

        function datosIncorrectos() {
            //alert("La cuenta o la contraseña es incorrecta.");

            $("#datosIncorrectos").remove();

            var p = document.createElement('p');
            p.textContent = "La cuenta o la contraseña es incorrecta.";
            p.setAttribute("id", "datosIncorrectos");


            var h1 = document.getElementById("h1");

            h1.parentNode.insertBefore(p, h1.nextSibling);

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

        #b_iniciarSesion {
            margin-top: 20px;
        }

        #datosIncorrectos{

            padding: 10px;
            border: 2px solid red;
            background-color: lightpink;
            width: 300px;
            margin: auto;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;


        }


    </style>
</head>

<body>

    <h1 id="h1">Iniciar Sesion en GamingCommunity</h1>

    <p>Email o Nick:</p>
    <p><input type="text" id="email" name="email" placeholder="ejemplo@gaming.com"></p>
    <p>Contraseña:</p>
    <p><input type="password" id="pass" name="passwd" placeholder="********"></p>
    <p><input type="submit" id="b_iniciarSesion" value="Iniciar sesión"></p>

    <form action="registrarse.php" method="post">
        <p><input type="submit" value="Registrarse"></p>
    </form>

    <?php


    ?>
</body>

</html>