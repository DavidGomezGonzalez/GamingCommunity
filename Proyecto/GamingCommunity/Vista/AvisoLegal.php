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
require_once '../modelo/Conexion.php';
require_once '../Controladores/Funciones.php';
require_once '../Controladores/FuncionesKedadas.php';

require_once('../Calendar/google-calendar-api.php');
require_once('../Calendar/settings.php');


if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<style>
    /********************** Perfil***********************/

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    #contenido {
        padding: 4% 5%;
        background: linear-gradient(to bottom, black, #800000, black);
    }

    #div_fondo {
        background-color: white;
        padding: 2% 5%;
    }

    #enlace_calendar {
        text-align: center;
        width: 200px;
        display: block;
        margin: 100px auto;
        border: 2px solid #2980b9;
        padding: 10px;
        background: none;
        color: #2980b9;
        cursor: pointer;
        text-decoration: none;
    }


    /****************** verKedadas ********************/


    .lugar {
        font-size: 18px;
        color: #800000;
        font-weight: normal;

    }

    .p_lugar {
        font-size: 18px;
        margin-top: 20px;
        font-weight: bold;

    }

    #mapid {
        height: 400px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    #coordenadas {
        display: none;
    }

    .p_datos {
        font-size: 18px;
        margin-top: 20px;
        font-weight: bold;
    }

    .p_datos span {
        font-weight: normal;
    }

    #div_contenido_kedada {
        margin-top: 20px;
    }

    #participantes {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
    }

    #h2_participante {
        margin-top: 40px;
        margin-bottom: 20px;
        text-align: center;
    }

    #foto_participante {
        width: 100px;
        height: 100px;
        border: 1px solid black;
    }

    .div_participante {
        text-align: center;
    }


    footer {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 0 5%;
        align-items: center;
        color: white;
    }

    footer img {
        width: 50%;
    }

    ul {
        padding-left: 5%;
    }

    @media (max-width: 1085px) {

        #img_logo {
            width: 500px;
        }

        footer img {
            width: 500px;
        }

    }

    @media (max-width: 860px) {

        #sub_cabecera {
            display: none;
        }

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
            <div id="div_fondo">

                <h2><b>Aviso legal y términos de uso</b></h2>

                <p class="ng-binding">
                    En este espacio, el USUARIO, podrá encontrar toda la información relativa a los términos y condiciones legales que definen las relaciones entre los usuarios y nosotros como responsables de esta web. Como usuario, es importante que conozcas estos términos antes de continuar tu navegación.
                    David Gómez González.Como responsable de esta web, asume el compromiso de procesar la información de nuestros usuarios y clientes con plenas garantías y cumplir con los requisitos nacionales y europeos que regulan la recopilación y uso de los datos personales de nuestros usuarios.
                    Esta web, por tanto, cumple rigurosamente con el RGPD (REGLAMENTO (UE) 2016/679 de protección de datos) y la LSSI-CE la Ley 34/2002, de 11 de julio, de servicios de la sociedad de la información y de comercio electrónico.

                </p>

                <h3><b>CONDICIONES GENERALES DE USO</b></h3>

                <p class="ng-binding">Las presentes Condiciones Generales regulan el uso (incluyendo el mero acceso) de las páginas de la web, integrantes del sitio web de GamingCommunity.com incluidos los contenidos y servicios puestos a disposición en ellas. Toda persona que acceda a la web, GamingCommunity.com (“Usuario”) acepta someterse a las Condiciones Generales vigentes en cada momento del portal GamingCommunity.com.</p>


                <h3><b>DATOS PERSONALES QUE RECABAMOS Y CÓMO LO HACEMOS</b></h3>

                Leer <a href="PoliticaPrivacidad.php">Política de Privacidad</a>

                <h3><b>COMPROMISOS Y OBLIGACIONES DE LOS USUARIOS</b></h3>


                <p class="ng-binding">
                    El Usuario queda informado, y acepta, que el acceso a la presente web no supone, en modo alguno, el inicio de una relación comercial con GamingCommunity.com. De esta forma, el usuario se compromete a utilizar el sitio Web, sus servicios y contenidos sin contravenir la legislación vigente, la buena fe y el orden público.<br>
                    Queda prohibido el uso de la web, con fines ilícitos o lesivos, o que, de cualquier forma, puedan causar perjuicio o impedir el normal funcionamiento del sitio web. Respecto de los contenidos de esta web, se prohíbe:Su reproducción, distribución o modificación, total o parcial, a menos que se cuente con la autorización de sus legítimos titulares;Cualquier vulneración de los derechos del prestador o de los legítimos titulares;Su utilización para fines comerciales o publicitarios.<br>

                    <br>
                    En la utilización de la web, GamingCommunity.com, el Usuario se compromete a no llevar a cabo ninguna conducta que pudiera dañar la imagen, los intereses y los derechos de GamingCommunity.com o de terceros o que pudiera dañar, inutilizar o sobrecargar el portal (indicar dominio) o que impidiera, de cualquier forma, la normal utilización de la web.
                    No obstante, el Usuario debe ser consciente de que las medidas de seguridad de los sistemas informáticos en Internet no son enteramente fiables y que, por tanto GamingCommunity.com no puede garantizar la inexistencia de virus u otros elementos que puedan producir alteraciones en los sistemas informáticos (software y hardware) del Usuario o en sus documentos electrónicos y ficheros contenidos en los mismos.

                </p>

                <h3><b>MEDIDAS DE SEGURIDAD</b></h3>
                <p class="ng-binding">
                    Los datos personales comunicados por el usuario a GamingCommunity.com pueden ser almacenados en bases de datos automatizadas o no, cuya titularidad corresponde en exclusiva a GamingCommunity.com, asumiendo ésta todas las medidas de índole técnica, organizativa y de seguridad que garantizan la confidencialidad, integridad y calidad de la información contenida en las mismas de acuerdo con lo establecido en la normativa vigente en protección de datos.<br>
                    La comunicación entre los usuarios y GamingCommunity.com utiliza un canal seguro, y los datos transmitidos son cifrados gracias a protocolos a https, por tanto, garantizamos las mejores condiciones de seguridad para que la confidencialidad de los usuarios esté garantizada.

                </p>

                <h3><b>RECLAMACIONES</b></h3>
                <p class="ng-binding">GamingCommunity.com informa que existen hojas de reclamación a disposición de usuarios y clientes.
                    El Usuario podrá realizar reclamaciones solicitando su hoja de reclamación o remitiendo un correo electrónico a <a href="mailto:gomezdavid234@gmail.com" class="ng-binding">gomezdavid234@gmail.com</a> indicando su nombre y apellidos, el servicio y/o producto adquirido y exponiendo los motivos de su reclamación.<br><br>
                    El usuario/comprador podrá notificarnos la reclamación, bien a través de correo electrónico a: <a href="mailto:gomezdavid234@gmail.com" class="ng-binding">gomezdavid234@gmail.com</a>, si lo desea adjuntando el siguiente formulario de reclamación:
                    El servicio/producto:
                    Adquirido el día:
                    Nombre del usuario:
                    Domicilio del usuario:
                    Firma del usuario (solo si se presenta en papel):
                    Fecha:
                    Motivo de la reclamación:
                </p>

                <h3><b>PLATAFORMA DE RESOLUCIÓN DE CONFLICTOS</b></h3>

                <p>Por si puede ser de tu interés, para someter tus reclamaciones puedes utilizar también la plataforma de resolución de litigios que facilita la Comisión Europea y que se encuentra disponible en el siguiente enlace: <a href="http://ec.europa.eu/consumers/odr/" rel="no-follow">http://ec.europa.eu/consumers/odr/</a></p>

                <h3><b>DERECHOS DE PROPIEDAD INTELECTUAL E INDUSTRIAL</b></h3>

                <p class="ng-binding">En virtud de lo dispuesto en los artículos 8 y 32.1, párrafo segundo, de la Ley de Propiedad Intelectual, quedan expresamente prohibidas la reproducción, la distribución y la comunicación pública, incluida su modalidad de puesta a disposición, de la totalidad o parte de los contenidos de esta página web, con fines comerciales, en cualquier soporte y por cualquier medio técnico, sin la autorización de GamingCommunity.com. El usuario se compromete a respetar los derechos de Propiedad Intelectual e Industrial titularidad de GamingCommunity.com.<br>
                    El usuario conoce y acepta que la totalidad del sitio web, conteniendo sin carácter exhaustivo el texto, software, contenidos (incluyendo estructura, selección, ordenación y presentación de los mismos) podcast, fotografías, material audiovisual y gráficos, está protegida por marcas, derechos de autor y otros derechos legítimos, de acuerdo con los tratados internacionales en los que España es parte y otros derechos de propiedad y leyes de España.
                    En el caso de que un usuario o un tercero consideren que se ha producido una violación de sus legítimos derechos de propiedad intelectual por la introducción de un determinado contenido en la web, deberá notificar dicha circunstancia a GamingCommunity.com indicando:<br>

                </p>
                <ul>
                    <li>
                        Datos personales del interesado titular de los derechos presuntamente infringidos, o indicar la representación con la que actúa en caso de que la reclamación la presente un tercero distinto del interesado.
                    </li>

                    <li>
                        Señalar los contenidos protegidos por los derechos de propiedad intelectual y su ubicación en la web, la acreditación de los derechos de propiedad intelectual señalados y declaración expresa en la que el interesado se responsabiliza de la veracidad de las informaciones facilitadas en la notificación
                    </li>
                </ul>

                <p></p>

                <h3><b>ENLACES EXTERNOS</b></h3>

                <p class="ng-binding">Las páginas de la web GamingCommunity.com, podría proporcionar enlaces a otros sitios web propios y contenidos que son propiedad de terceros.
                    El único objeto de los enlaces es proporcionar al Usuario la posibilidad de acceder a dichos enlaces.
                    GamingCommunity.com no se responsabiliza en ningún caso de los resultados que puedan derivarse al Usuario por acceso a dichos enlaces.<br>
                    Asimismo, el usuario encontrará dentro de este sitio, páginas, promociones, programas de afiliados que acceden a los hábitos de navegación de los usuarios para establecer perfiles. Esta información siempre es anónima y no se identifica al usuario.<br><br>
                    La Información que se proporcione en estos Sitios patrocinado o enlaces de afiliados está sujeta a las políticas de privacidad que se utilicen en dichos Sitios y no estará sujeta a esta política de privacidad. Por lo que recomendamos ampliamente a los Usuarios a revisar detalladamente las políticas de privacidad de los enlaces de afiliado.<br>
                    El Usuario que se proponga establecer cualquier dispositivo técnico de enlace desde su sitio web al portal GamingCommunity.com deberá obtener la autorización previa y escrita de GamingCommunity.com El establecimiento del enlace no implica en ningún caso la existencia de relaciones entre GamingCommunity.com y el propietario del sitio en el que se establezca el enlace, ni la aceptación o aprobación por parte de GamingCommunity.com de sus contenidos o servicios
                </p>

                <h3><b>POLÍTICA DE COMENTARIOS</b></h3>
                <p>En nuestra web y se permiten realizar comentarios para enriquecer los contenidos y realizar consultas.
                    No se admitirán comentarios que no estén relacionados con la temática de esta web, que incluyan difamaciones, agravios, insultos, ataques personales o faltas de respeto en general hacia el autor o hacia otros miembros.
                    También serán suprimidos los comentarios que contengan información que sea obviamente engañosa o falsa, así como los comentarios que contengan información personal, como, por ejemplo, domicilios privado o teléfonos y que vulneren nuestra política de protección de datos.<br>
                    Se desestimará, igualmente, aquellos comentarios creados sólo con fines promocionales de una web, persona o colectivo y todo lo que pueda ser considerado spam en general.<br>
                    No se permiten comentarios anónimos, así como aquellos realizados por una misma persona con distintos apodos. No se considerarán tampoco aquellos comentarios que intenten forzar un debate o una toma de postura por otro usuario.
                </p>

                <h3><b>EXCLUSIÓN DE GARANTÍAS Y RESPONSABILIDAD</b></h3>

                <p>El Prestador no otorga ninguna garantía ni se hace responsable, en ningún caso, de los daños y perjuicios de cualquier naturaleza que pudieran traer causa de:

                </p>
                <ul>
                    <li>
                        La falta de disponibilidad, mantenimiento y efectivo funcionamiento de la web, o de sus servicios y contenidos;
                    </li>
                    <li>
                        La existencia de virus, programas maliciosos o lesivos en los contenidos;
                    </li>
                    <li>
                        El uso ilícito, negligente, fraudulento o contrario a este Aviso Legal;
                    </li>
                    <li>
                        La falta de licitud, calidad, fiabilidad, utilidad y disponibilidad de los servicios prestados por terceros y puestos a disposición de los usuarios en el sitio web.
                    </li>
                    <li>
                        El prestador no se hace responsable bajo ningún concepto de los daños que pudieran dimanar del uso ilegal o indebido de la presente página web.
                    </li>
                </ul>
                <p></p>

                <h3><b>LEY APLICABLE Y JURISDICCIÓN</b></h3>
                <p class="ng-binding">Con carácter general las relaciones entre GamingCommunity.com con los Usuarios de sus servicios telemáticos, presentes en esta web se encuentran sometidas a la legislación y jurisdicción españolas y a los tribunales.</p>


                <h3><b>CONTACTO</b></h3>
                <p class="ng-binding">En caso de que cualquier Usuario tuviese alguna duda acerca de estas Condiciones legales o cualquier comentario sobre el portal GamingCommunity.com, por favor diríjase a <a href="mailto:gomezdavid234@gmail.com" class="ng-binding">gomezdavid234@gmail.com</a></p>
                <p class="ng-binding">
                    De parte del equipo que formamos David Gómez González te agradecemos el tiempo dedicado en leer este Aviso Legal
                </p>

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

        var user = $("#user").text();
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

    }

    function iniciarSesion() {
        window.location = "login.php";
    }

    function verPerfil() {
        window.location = "Perfil.php";
    }
</script>

</html>