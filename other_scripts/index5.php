<?php
/*
 Подключение аккаунта amoCRM к новому каналу online чатов
 */
// Секрет нашего канала, для фомирования подписи
$secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
// Scope id для публикации сообщений в аккаунт
$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';
// Тело запроса
$body = json_encode([
    'event_type' => 'new_message',
    'payload' => [
        'timestamp' => time(),
        'msgid' => uniqid(),
        'conversation_id' => uniqid('c'),
        'sender' => [
            'id' => 'U1',
            'avatar' => 'https://www.amocrm.ru/version2/images/logo_bill.png',
            'name' => 'John',
            'profile' => [
                'phone' => 79151112233,
                'email' => 'email@domain.com',
            ],
            'profile_link' => 'http://example.com',
        ],
        'message' => [
            'type' => 'text',
            'text' => 'Привет! Сколько стоит разработать сайт? ggggggggggggggggggggggggggggg'
        ]
    ]
]);
// Формируем подпись
$signature = hash_hmac('sha1', $body, $secret);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://amojo.amocrm.ru/v2/origin/custom/$scope_id",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "x-signature: {$signature}"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    file_put_contents('response6.json', $response);
    echo $response;
    echo uniqid('c') . '<br>';
    echo uniqid('c');
}