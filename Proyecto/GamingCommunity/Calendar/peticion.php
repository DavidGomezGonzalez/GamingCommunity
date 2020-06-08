<?php
session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: google-login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <style type="text/css">
        #form-container {
            width: 400px;
            margin: 100px auto;
        }

        input[type="text"] {
            border: 1px solid rgba(0, 0, 0, 0.15);
            font-family: inherit;
            font-size: inherit;
            padding: 8px;
            border-radius: 0px;
            outline: none;
            display: block;
            margin: 0 0 20px 0;
            width: 100%;
            box-sizing: border-box;
        }

        select {
            border: 1px solid rgba(0, 0, 0, 0.15);
            font-family: inherit;
            font-size: inherit;
            padding: 8px;
            border-radius: 2px;
            display: block;
            width: 100%;
            box-sizing: border-box;
            outline: none;
            background: none;
            margin: 0 0 20px 0;
        }

        .input-error {
            border: 1px solid red !important;
        }

        #event-date {
            display: none;
        }

        #create-event {
            background: none;
            width: 100%;
            display: block;
            margin: 0 auto;
            border: 2px solid #2980b9;
            padding: 8px;
            background: none;
            color: #2980b9;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div style="display: none">

        <p id="id_kedada"><?php echo $_SESSION['id_kedada']; ?></p>
        <p id="titulo"><?php echo $_SESSION['titulo']; ?></p>
        <p id="fecha_inicio"><?php echo $_SESSION['fecha_inicio']; ?></p>
        <p id="fecha_fin"><?php echo $_SESSION['fecha_fin']; ?></p>
    </div>


    <script>
        $(document).ready(inicio);

        function inicio() {


            // Event details
            // parameters = {
            //     title: "Kedada",
            //     event_time: {
            //         start_time: null,
            //         end_time: null,
            //         event_date: "2020-05-20",
            //     },
            //     all_day: 1,
            // };

            parameters = {
                title: $("#titulo").text(),
                event_time: {
                    start_time: $("#fecha_inicio").text(),
                    end_time: $("#fecha_fin").text(),
                    event_date: null
                },
                all_day: 0,
            };

            console.log(parameters);

            var id = $("#id_kedada").text();
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    event_details: parameters
                },
                dataType: 'json',
                success: function(response) {
                    //alert('Event created with ID : ' + response.event_id);
                    window.location = "../Vista/verKedadas.php?id=" + id;

                },
                error: function(response) {
                    alert(response.responseJSON.message);
                    window.location = "../Vista/verKedadas.php?id=" + id;


                }

            });


        }
    </script>

</body>

</html>