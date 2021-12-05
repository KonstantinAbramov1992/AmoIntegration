<?php

$secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
$method = 'POST';
$contentType = 'application/json';
$date = date(DATE_RFC822);
$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';
$path = "/v2/origin/custom/$scope_id";

$url = "https://amojo.amocrm.ru/$path";

$requestBody = json_encode([
    "account_id"=> "989186f9-e54f-4b03-be7d-2414b016be28",
    "event_type"=> "new_message",
    "payload"=> [
      "timestamp"=> time(),
      "msgid"=> uniqid(),
      "conversation_id"=> "skc-8e3e7640-49af-4448-a2c6-d5a421f7f217",
      "sender"=> [
        "id"=> "a253a13e1bb5",
        "name"=> "Менеджер"
      ],
      /*"receiver": {
        "id": "sk-1376265f-86df-4c49-a0c3-a4816df41af9",
        "avatar": "https:/example.com/users/avatar.png",
        "name": "Example Client",
        "profile": {
            "phone": "79151112233",
            "email": "example.client@example.com"
        },
        "profile_link": "http://example.com/profile/example.client"
      },*/
      "message"=> [
        "type"=> "text",
        "text"=> "Можем обговорить ваши условия дополнительно, если наше предложение вас устраивает"
      ],
      "silent"=> false
    ]
]);
$checkSum = md5($requestBody);

$str = implode("\n", [
    strtoupper($method),
    $checkSum,
    $contentType,
    $date,
    $path,
]);

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

echo $method . ' ' . $url . PHP_EOL;
foreach ($curlHeaders as $header) {
    echo $header . PHP_EOL;
}
echo PHP_EOL . $requestBody . PHP_EOL;

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_POSTFIELDS => $requestBody,
    CURLOPT_HTTPHEADER => $curlHeaders,
]);

$response = curl_exec($curl);
$err = curl_error($curl);
$info = curl_getinfo($curl);
curl_close($curl);
if ($err) {
    $result = "cURL Error #:" . $err;
} else {
    echo "Status: " . $info['http_code'] . PHP_EOL;
    echo $response . PHP_EOL;
}
