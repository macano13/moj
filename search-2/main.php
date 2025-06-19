<?php

// get Config
$config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);

function login($login = "login")
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.opensubtitles.com/api/v1/' . $login,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{"username":"macano13","password":"mjesecar111"}',
        CURLOPT_HTTPHEADER => array(
            'Api-Key: ' . $config["auth"]["apiKey"],
            'Content-Type: application/json'
        )
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true)['token'];
}

if (isset($_GET['query'])) {
    $curl = curl_init();
    $url = 'https://api.opensubtitles.com/api/v1/subtitles?query=' . urlencode($_GET['query']) ;

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Api-Key: ' . $config["auth"]["apiKey"]
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
} elseif (isset($_GET['file_id'])) {
    // First login
    // $token = login();

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.opensubtitles.com/api/v1/download',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array('file_id' => $_GET['file_id'])),
        CURLOPT_HTTPHEADER => array(
            'Api-Key: ' . $config["auth"]["apiKey"],
            'Content-Type: application/json'
        )
    ));

    $response = json_decode(curl_exec($curl), true);

    curl_close($curl);

    if (is_array($response) && isset($response['link'])) {
        // download file
        file_put_contents('temp/' . $response['file_name'], file_get_contents($response['link']))   ;

        echo json_encode(array('filename' => $response['file_name'], 'localLink' => 'temp/' . $response['file_name'], 'link' => $response['link']));
    }

    // logout
    // login("logout");

    // clean old files
    $files = glob("temp/*");
    $now   = time();

    foreach ($files as $file) {
        if (is_file($file)) {
            if ($now - filemtime($file) >= 60 * 10) { // 10 minutes
                unlink($file);
            }
        }
    }
}
