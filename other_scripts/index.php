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

$secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
// ID нашего канала
$channel_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d';
// Идентификатор аккаунта для сервиса online чатов
$account_id = '989186f9-e54f-4b03-be7d-2414b016be28';

$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';
// Тело запроса
$conversation_id = 'skc-8e3e7640-49af-4448-a2c6-d5a421f7f217';

$body = json_encode([
   'bot_id'=> 7375,
	'entity_id'=> 9204111,
	'entity_type'=> 1
]);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://tehkabramov.amocrm.ru/api/v4/bots",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => "GET",
    //CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImZlMWU5MDhkNmU0MmMyYTVhMGU5ZGY2NzIxMzU4NTA3NjM3NWMxYmQzZmIxMWM4NGExNjE1ZTIzMzgyODA3OWY1MjEwNDAyMTE5NzYxOGI1In0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiJmZTFlOTA4ZDZlNDJjMmE1YTBlOWRmNjcyMTM1ODUwNzYzNzVjMWJkM2ZiMTFjODRhMTYxNWUyMzM4MjgwNzlmNTIxMDQwMjExOTc2MThiNSIsImlhdCI6MTYyOTgxMzMxMywibmJmIjoxNjI5ODEzMzEzLCJleHAiOjE2Mjk4OTk3MTMsInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.b4hSEZRIWwTkMvEXx9-_06jU1g7h_9kUKfvf2Mf1eINvsoWyoR3v8ezknNw9HhYfe0okpIe9cfml-ar8SiQ_A7Z7tTVz6b-_oCu0u0suYNDpIXLTse3wCyBhgIpJEFbMbSTpPl6jfze16FESz1AaJOYntJaDLNCPe1UyyGJ6PggJDnPeirAZQWkIo1GbnByqaMvryJwWhs4fj5OHxm2pix-rAe5G2HD9iYhKR30GOciuQTR1ULnHzXtqV3W3sMheSItcN8RFvfFG705QklXv_5emsoXwm_pfQZuDNWH_5CHNYwtOLK0QD7JK-aovnGfbC9TorgMSlo7-PH-SkgE9GQ'
    ],
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
    file_put_contents('response1.json', $response);
}
