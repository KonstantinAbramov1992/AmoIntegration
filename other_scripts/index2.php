<?php
$subdomain = 'tehabramov'; //Поддомен нужного аккаунта
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

/** Соберем данные для запроса */
$data = [
	'client_id' => '16d78112-73ff-4731-8812-0eb50a44fdde',
	'client_secret' => 'vu1wdv1bwSq85UoaYumznASc4HLjonCmrW2QwPUPGMMHt8qVVHmIoIoTPBsWlZxQ',
	'grant_type' => 'authorization_code',
	'code' => 'xxxxxx',
	'redirect_uri' => 'https://youtube.com/',
];

$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';

$secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
// ID нашего канала
$channel_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d';
// Идентификатор аккаунта для сервиса online чатов
$account_id = '989186f9-e54f-4b03-be7d-2414b016be28';
// Тело запроса
$body = json_encode([
    "conversation_id"=>"62000256_36861029",
    "user"=>[
        "id"=>"62000277_36861029",
        "name"=>"tel:+79154266287"
    ]
]);

$signature = hash_hmac('sha1', $body, $secret);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://amojo.amocrm.ru/v2/origin/custom/$scope_id/chats",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "x-signature: $signature"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    var_dump($response);
    file_put_contents('response454545.json', $response);
}
