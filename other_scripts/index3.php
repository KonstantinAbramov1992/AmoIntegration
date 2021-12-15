<?php

function milliseconds() {
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
}
/*
Подключение аккаунта amoCRM к новому каналу online чатов
*/
// Секрет нашего канала, для формирования подписи
$secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
// ID нашего канала
$channel_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d';
// Идентификатор аккаунта для сервиса online чатов
$account_id = '989186f9-e54f-4b03-be7d-2414b016be28';
// Тело запроса\
$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';

$j=1*(file_get_contents('number.txt'));

for($i=$j;$i<($j+1);$i++) {
    $body = json_encode([
        "account_id"=> $account_id,
        "event_type"=> "new_message",
        "payload"=> [
    "timestamp"=> time(),
    "msec_timestamp"=> milliseconds(),
    "msgid"=> "122334$i",
    "conversation_id"=> "122334455gg",
    "conversation_ref_id" => 'a8714067-5fcb-4ef8-ab0f-722e34c8bc5e',
    "sender"=> [
        "id"=> "9204111",
        "name"=> "Константин Абрамов"
    ],
    "receiver"=> [
        'ref_id' => 'df43caa1-9893-44fe-9026-c6009c40ab0c',
        "id"=> "9095937",
        "name"=> "rrrrr"
    ],
    "message"=> [
        "type"=> "picture",
        "text"=>"",
        "file_name"=>"",
        "file_size"=>0,
        "media"=>"https://whatsapp-files.services.mobilon.ru/false_79173516829@c.us_58BE8E7976D14BCBB1EB76DD94BD1652/file.jpeg"
    ]
    ],
    "silent"=> false
    ]);
    // Формируем подпись
    $signature = hash_hmac('sha1', $body, $secret);
    $curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://amojo.amocrm.ru/v2/origin/custom/$scope_id",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "Content-Type: application/json",
        "X-Signature: {$signature}"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    file_put_contents("response{$i}3.json", $response);
    echo $response;
}
}

file_put_contents('number.txt', $j+4);
