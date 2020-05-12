<?php
function top_Stream($n_peticiones)
{
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, 'https://api.twitch.tv/helix/streams?first=10');
    curl_setopt($ch, CURLOPT_URL, 'https://api.twitch.tv/kraken/streams?limit=' . $n_peticiones);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Client-ID: wvyx7uhq9sc4dwsu93n7ekyj0f2hry",
        "Accept: application/vnd.twitchtv.v5+json",
        "Authorization: http://192.168.1.144/ProyectosPhp/GamingCommunity/Proyecto/GamingCommunity/Vista/ClipsTV.php"


    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ONLY USE FOR DEVELOPMENT WITHOUT SSL

    $result = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($result, true);

    arsort($data); // This will sort the array of from most to least.

    //var_dump($data); // Here you can see the array. Should look something like this: array(5) { ["Atlas"]=> int(10) ["Tom Clancy's Rainbow Six: Siege"]=> int(8) ["Arma 3"]=> int(7) ["Minecraft"]=> int(3) ["Grand Theft Auto V"]=> int(2) }

    //print_r($data);

    return $data;
}

function id_Game($id)
{
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, 'https://api.twitch.tv/helix/games?id=' . $id);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");

    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
        "Client-ID: wvyx7uhq9sc4dwsu93n7ekyj0f2hry",
        "Accept: application/vnd.twitchtv.v5+json",
        "Authorization: http://192.168.1.144/ProyectosPhp/GamingCommunity/Proyecto/GamingCommunity/Vista/ClipsTV.php"
    ));
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false); // ONLY USE FOR DEVELOPMENT WITHOUT SSL

    $result = curl_exec($ch2);

    curl_close($ch2);

    $data2 = json_decode($result, true);

    arsort($data2); // This will sort the array of from most to least.

    //var_dump($data); // Here you can see the array. Should look something like this: array(5) { ["Atlas"]=> int(10) ["Tom Clancy's Rainbow Six: Siege"]=> int(8) ["Arma 3"]=> int(7) ["Minecraft"]=> int(3) ["Grand Theft Auto V"]=> int(2) }

    $game = $data2["data"][0]["name"];

    return $game;
}


function url_Channel($id)
{
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, 'https://api.twitch.tv/kraken/channels/' . $id);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");

    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
        "Client-ID: wvyx7uhq9sc4dwsu93n7ekyj0f2hry",
        "Accept: application/vnd.twitchtv.v5+json",
        "Authorization: http://192.168.1.144/ProyectosPhp/GamingCommunity/Proyecto/GamingCommunity/Vista/ClipsTV.php"
    ));
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false); // ONLY USE FOR DEVELOPMENT WITHOUT SSL

    $result = curl_exec($ch2);

    curl_close($ch2);

    $data2 = json_decode($result, true);

    arsort($data2); // This will sort the array of from most to least.

    //var_dump($data); // Here you can see the array. Should look something like this: array(5) { ["Atlas"]=> int(10) ["Tom Clancy's Rainbow Six: Siege"]=> int(8) ["Arma 3"]=> int(7) ["Minecraft"]=> int(3) ["Grand Theft Auto V"]=> int(2) }

    $name = $data2["name"];

    return $name;
}



function stream_Castellano($n_peticiones)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.twitch.tv/kraken/streams?language=es&limit=' . $n_peticiones);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Client-ID: wvyx7uhq9sc4dwsu93n7ekyj0f2hry",
        "Accept: application/vnd.twitchtv.v5+json",
        "Authorization: http://192.168.1.144/ProyectosPhp/GamingCommunity/Proyecto/GamingCommunity/Vista/ClipsTV.php"
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ONLY USE FOR DEVELOPMENT WITHOUT SSL

    $result = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($result, true);

    arsort($data); // This will sort the array of from most to least.

    //var_dump($data); // Here you can see the array. Should look something like this: array(5) { ["Atlas"]=> int(10) ["Tom Clancy's Rainbow Six: Siege"]=> int(8) ["Arma 3"]=> int(7) ["Minecraft"]=> int(3) ["Grand Theft Auto V"]=> int(2) }

    //print_r($data);

    return $data;
}
