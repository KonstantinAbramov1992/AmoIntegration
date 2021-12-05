<?php

$secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
$method = 'POST';
$contentType = 'application/json';
$date = date(DATE_RFC822);
$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';
$path = "/v2/origin/custom/$scope_id";

$url = "https://amojo.amocrm.ru/$path";

$body = json_encode([
    'event_type' => 'new_message',
    'payload' => [
        'timestamp' => time(),
        'msgid' => uniqid(),
        'conversation_id' => uniqid('c'),
        'sender' => [
            'id' => 'U1',
            'name' => 'John',
            'profile' => [
                'phone' => 79151112233,
                'email' => 'email@domain.com',
            ]
        ],
        'message' => [
            'type' => 'text',
            'text' => 'Привет! Сколько стоит разработать сайт?'
        ]
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

$signature = hash_hmac('sha1', $body, $secret);

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
    CURLOPT_URL => "https://amojo.amocrm.ru/v2/origin/custom/{$scope_id}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_POSTFIELDS => $requestBody,
    CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "Content-Type: application/json",
        "X-Signature: $signature"
    )
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
