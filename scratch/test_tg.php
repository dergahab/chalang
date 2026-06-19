<?php
$token = '8780437929:AAGs3n6p5yrJP4b4TdNUtdslPKqf8wHFNn8';
$url = "https://api.telegram.org/bot$token/getMe";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($response) {
    echo "Bağlantı Uğurlu: " . $response;
} else {
    echo "Bağlantı Xətası: " . $error;
}
