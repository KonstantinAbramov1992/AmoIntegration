<?php

$secret = "ec16c4876da4102bc43692d23afcd2eb0a023ce4";
$method = 'GET';
$contentType = 'application/json';
$date = date(DATE_RFC822);
//echo $date . PHP_EOL;
$chat_id = '34e8a9a4-ca0e-43b1-b269-d2ddd66be83a';
$scope_id = "0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28";
$path = "/v2/origin/custom/$scope_id/chats/$chat_id/history";

$url = "https://amojo.amocrm.ru" . $path . '?limit=50&offset=0';

/*$requestBody = json_encode(
    [
        "account_id"=> "989186f9-e54f-4b03-be7d-2414b016be28",
        'event_type' => 'new_message',
        'payload' => [
            'timestamp' => time(),
            'msgid' => uniqid(),
            'conversation_id' => '7657454578464676899900',
            "silent" => false,
            'sender' => [
                'id' => '7657454578464676899900',
                //"avatar" => "https://sun9-71.userapi.com/c830709/v830709733/12f640/NnS_B_gd-CM.jpg?ava=1",
                'name' => "Igor99",
                //"profile_link" => "https://youtube.com",
                "profile" => [
                    "phone" => "79154266299",
                ],
                //"ref_id" => "a5401ebc-2f28-4114-9713-cc060519ce68"
            ],
            'message' => [
                'type' => 'text',
                'text' => "Hi",
            ]
        ]
    ]
);*/

/*$requestBody = json_encode([
    'limit'=>50,
    'offset'=>0
]);*/
$requestBody = '';

$checkSum = md5($requestBody);

//echo $checkSum . 'dddddd';

$str = implode("\n", [
    strtoupper($method),
    $checkSum,
    $contentType,
    $date,
    $path
]);

echo $str . PHP_EOL;

$signature = hash_hmac('sha1', $str, $secret);

$headers = [
    "Date" => $date,
    "Content-Type" => $contentType,
];
$headers['Content-MD5'] = strtolower($checkSum);
$headers['X-Signature'] = strtolower($signature);

$curlHeaders = [];
foreach ($headers as $name => $value) {
    $curlHeaders[] = $name . ": " . $value;
}

//var_dump($curlHeaders);

//echo $method . ' ' . $url . PHP_EOL;
foreach ($curlHeaders as $header) {
    //echo $header . PHP_EOL;
}
//echo PHP_EOL . $requestBody . PHP_EOL;

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $method,
    //CURLOPT_POSTFIELDS => $requestBody,
    CURLOPT_HTTPHEADER => $curlHeaders,
]);

$response = curl_exec($curl);
$err = curl_error($curl);
$info = curl_getinfo($curl);
curl_close($curl);
if ($err) {
    $result = "cURL Error #:" . $err;
    file_put_contents('signature.json', $result);
} else {
    echo "Status: " . $info['http_code'] . PHP_EOL;
    echo $response . PHP_EOL;
    file_put_contents('chat_history.json', $response);
}
