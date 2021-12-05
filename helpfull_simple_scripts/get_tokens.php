<?php
$subdomain = 'tehkabramov'; //Поддомен нужного аккаунта
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

/** Соберем данные для запроса */
$data = [
	'client_id' => '16d78112-73ff-4731-8812-0eb50a44fdde',
	'client_secret' => 'vu1wdv1bwSq85UoaYumznASc4HLjonCmrW2QwPUPGMMHt8qVVHmIoIoTPBsWlZxQ',
	'grant_type' => 'authorization_code',
	'code' => 'def50200abd990f9dc7c445fc02f0a6f751ad72bc818816c61d8e3bebd9d5eb4f3927eaf9a2620ab947962d97ebb9e19a4311974c5c80c3940334ec4a7a4fe1b051e5424863dd48510bbd517bcd0214ceee3539b1611f878f3b20440b43d37440a2b1885af34ed802a0e91a630edb3ca5546acd42bcd019a1fcf47c866de8cbd7da18031165676fd5761ec0d1b910417b95ce25c15283d8f0d04342b64b6211ed6f2ad59112140f977907b272016481b84536f4e90f93b387315c8c6fffdb16f9462e79b88d62d1328903cf383f1111cb984f4ed2d9c9f0f0739935a0081d7f7198fe14db5a366f92b03cfc073dd3e44e2e3c9aaca81142b88c3e331027a70416c12a344128583d386a6483d6da7c56b59ccc5ca298ad6207f8860855b411dab116423b2c2ffeb4cc7a7d0f2dc0ec29860421db2aae2c5ffe0f2515c026a2af9023c990b6c27df3c00c26c69fb343e914b88068e425004d4fc1e9f817f4a989ab76840b9ce788f4a4f2090e3d6543717f0c0d9a203ed0c66f82996c8f57e571cd198d4c9f86604f47cd96ab202dabe302a94381ef482740e7d6423e5fceba8b205534f4c7a06e9126104812808e5467f4fa9fc982d2ac1a01426e419809c5cea278b8ba400906a850d17cb757f15b3aa24098a56904ba14c0d621e8d2dde7f91423cc2b7',
	'redirect_uri' => 'https://webhook.site/77ee9e16-75f6-4a84-898a-1a8c330421ae',
];

/**
 * Нам необходимо инициировать запрос к серверу.
 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
 */
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
$code = (int)$code;
$errors = [
	400 => 'Bad request',
	401 => 'Unauthorized',
	403 => 'Forbidden',
	404 => 'Not found',
	500 => 'Internal server error',
	502 => 'Bad gateway',
	503 => 'Service unavailable',
];

try
{
	/** Если код ответа не успешный - возвращаем сообщение об ошибке  */
	if ($code < 200 || $code > 204) {
		throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
	}
}
catch(\Exception $e)
{
	die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
}

/**
 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
 * нам придётся перевести ответ в формат, понятный PHP
 */
file_put_contents('auth_tokens.json', $out);
$response = json_decode($out, true);

$access_token = $response['access_token']; //Access токен
$refresh_token = $response['refresh_token']; //Refresh токен
$token_type = $response['token_type']; //Тип токена
$expires_in = $response['expires_in']; //Через сколько действие токена истекает