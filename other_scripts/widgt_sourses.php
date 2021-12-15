<?php

use AmoCRM\Exceptions\AmoCRMApiException;
use League\OAuth2\Client\Token\AccessToken;

require 'vendor/autoload.php';

/** Соберем данные для запроса */
$data = json_encode([[
	
]]);
/*
$clientSecret = 'vu1wdv1bwSq85UoaYumznASc4HLjonCmrW2QwPUPGMMHt8qVVHmIoIoTPBsWlZxQ';
$clientId = '16d78112-73ff-4731-8812-0eb50a44fdde';
$redirectUri = 'https://youtube.com';
$baseDomain = 'tehkabramov.amocrm.ru';

$code = <<<EOF
def50200d1c19b139690d5054ad49c2f4006a5003f6f0afe40ae640716b547569b403e8c4b54211d18d91b375b1e901983987a33b79cb3fccf7a90300fe73007b23ce9b68a3c89c7db170cf05ef2cf2f32de3abb68646d1716ba96b8ab65dc1bae4a79d045ec153ec81902376f5a92d4509cf96c889f68d1e0c1fee36eb84c7a564b01d6330d1177b0e2da625a82e5dbb74d9393ab053183585457abae96016b92138fc4214d7567322b59e62e74fce8b198307cf7ef6f701465cfc03bcd7720c761807ebf9922765021589e3dff5203b98f957425ad16f0b589b6e02813890128b093aea1980b03a8316e934728890bf1bc6199ed4cd942fd7c9d4537cb8ee7cb221080f448815383ffc63f3f4584e3b0754ba953d73aa86282afd02c25b64ac3e7e711862380aaf20c35c53cbaeea8f693c242723190a46b173d22e945fe556ffc1a0cdd63f84d026112019dcbbf89ccfc00ed198a9295618eb4ff3a53464cfda6424b50f85c656436a9b1ef75743faef2dda4faffec12cd4594fa39fe69483de47f728261a87efbaf5780ff8e7024558504ce8b04ce0d19290aaf28da17f41ce835c7fe3ecfa8ef2f899ec2de168dc613ff64fdf4a3b2799adbd955
EOF;

$apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain($baseDomain);

$accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);
file_put_contents('token_' . time() . '.json', $accessToken);*/

$accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImVlNjQzNGRhMmNjMjU1YWI3NGQ2YzI1NjJiMjU1ZTc5YzFiMDBkOTljOTkzNWFlNmFmYzk1NmI2NmIwZGJkODMwOTQ5MDMyYzkzZmNiYzU2In0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiJlZTY0MzRkYTJjYzI1NWFiNzRkNmMyNTYyYjI1NWU3OWMxYjAwZDk5Yzk5MzVhZTZhZmM5NTZiNjZiMGRiZDgzMDk0OTAzMmM5M2ZjYmM1NiIsImlhdCI6MTYzODU0MDgzMCwibmJmIjoxNjM4NTQwODMwLCJleHAiOjE2Mzg2MjcyMzAsInN1YiI6IjI3OTQ2NDIiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.fUa4FkDZwNkfb0e87IettXJ0I1SHi5hsZzUde8MnLQJ2BXlnJXczm6UYzz3wgagMQI597I-v24Ntw43OVTYGobaNh8YjuFBaNrmT8iIbonunFgwWduqX9aBX8ILHw5-_jhPFQvrgfMvpnz6q9baCx6lFtp9HN1gAq0IGtFZzvNtrPS8mZsNo_yVKj06TAx_SJdpkuGINUtBgE9d9sLURR_ddr6kzWpkF-CEFSqz7zIeTjcMCj7peY4DvRDC8aaTNIWdtjXFO8gzBcS6lKgbY1jsEb6-Fcl1A8KxoJw6asBbwK58LuvQ11qGarD4IHeXfjRrFjOSKu_P52qtTFH7uTg';

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://tehkabramov.amocrm.ru/api/v4/tasks",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $accessToken"
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
