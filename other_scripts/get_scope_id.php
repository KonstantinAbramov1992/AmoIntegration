<?php
/*
Подключение аккаунта amoCRM к новому каналу online чатов
*/
// Секрет нашего канала, для формирования подписи
$secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
// ID нашего канала
$channel_id = "0fb1afb7-8c4d-40ee-a406-1e9736598b4d";
// Идентификатор аккаунта для сервиса online чатов
$account_id = '989186f9-e54f-4b03-be7d-2414b016be28';
// Тело запроса
$body = json_encode([
    'account_id' => $account_id,
    //"title"=> "ChatIntegration",
    "hook_api_version"=> "v2"
]);
// Формируем подпись
$signature = hash_hmac('sha1', $body, $secret);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://amojo.amocrm.ru/v2/origin/custom/$channel_id/connect",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "Content-Type: application/json",
        "X-Signature: $signature"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
    //file_put_contents("scope_id_connect.json", $response);
}