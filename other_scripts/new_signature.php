<?php

$secret = '53c77b058109182c040eb683657b90beb30df362';
$method = 'POST';
$contentType = 'application/json';
$date = date(DATE_RFC822);
echo $date . PHP_EOL;
$path = '/v2/origin/custom/f3c1ab20-67b1-4b4b-8cc0-7059660d43af/connect';

$url = "https://amojo.amocrm.ru" . $path;

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

$requestBody = json_encode(
    ["account_id"=>"989186f9-e54f-4b03-be7d-2414b016be28","title"=>"ScopeTitleKostic","hook_api_version"=>"v2"]
);

$checkSum = md5($requestBody);

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

var_dump($curlHeaders);

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
    file_put_contents('signature.json', $result);
} else {
    echo "Status: " . $info['http_code'] . PHP_EOL;
    echo $response . PHP_EOL;
    file_put_contents('signature.json', $response);
}
