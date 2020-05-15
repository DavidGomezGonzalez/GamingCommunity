<?php


$directorio = getcwd(); //obtenemos el directorio Actual
$directorio  = str_replace("modelo", "img/noticias/", $directorio);


chdir($directorio);
if (is_array($_FILES) && count($_FILES) > 0) {
    if (($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/gif")
    ) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $directorio . $_FILES['file']['name'])) {
            //more code here...
            echo $_FILES['file']['name']. " Subido Correctamente";
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}



// //echo $directorio;

// if (empty($_FILES['txtFile']['name']) == false) {
//     if (is_uploaded_file($_FILES['txtFile']['tmp_name'])) {

//         $capacidad = filesize($_FILES['txtFile']['tmp_name']);
//         $arch = $_FILES['txtFile']['name'];

//         if ($capacidad <= 5000000) {  //5000000 bytes = 5 MB
//             if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $_FILES['txtFile']['name']) == false)
//                 echo "No se ha podido el mover el archivo.";
//             else
//                 echo "Archivo [" . $_FILES['txtFile']['name'] . "] subido y movido al directorio actual." . $directorio;
//             echo "<br>Tamaño:  $capacidad  bytes";
//         } else {
//             echo "No se ha podido subir el archivo [" . $arch . "] tamaño mayor a 5MB";
//             echo "<br>Tamaño:  $capacidad  bytes";
//         }
//     }
// }  else {
//     echo "No se seleccionó ningún archivo.";
// }
