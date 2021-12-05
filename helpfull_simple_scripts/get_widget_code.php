<?php

use AmoCRM\Exceptions\AmoCRMApiNoContentException;
use AmoCRM\Exceptions\AmoCRMApiPageNotAvailableException;
use League\OAuth2\Client\Token\AccessToken;
use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\CustomFields\CustomFieldEnumsCollection;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Collections\CustomFields\CustomFieldsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\CustomFields\CheckboxCustomFieldModel;
use AmoCRM\Models\CustomFields\CustomFieldModel;
use AmoCRM\Models\CustomFields\EnumModel;
use AmoCRM\Models\CustomFields\SelectCustomFieldModel;
use AmoCRM\Models\CustomFields\TextCustomFieldModel;
use League\OAuth2\Client\Token\AccessTokenInterface;

include_once 'vendor/autoload.php';

$clientId = '16d78112-73ff-4731-8812-0eb50a44fdde';
$clientSecret = 'vu1wdv1bwSq85UoaYumznASc4HLjonCmrW2QwPUPGMMHt8qVVHmIoIoTPBsWlZxQ';
$redirectUri = 'https://youtube.com/';
//$code = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvdGVoa2FicmFtb3YuYW1vY3JtLnJ1IiwiYXVkIjoiaHR0cHM6XC9cL3lvdXJ1YmUuY29tIiwianRpIjoiMzE2N2IwZTYtY2JiYi00YTQ0LWI0MTItYWJkNmE0M2FkMGI0IiwiaWF0IjoxNjM1NzY0MDU3LCJuYmYiOjE2MzU3NjQwNTcsImV4cCI6MTYzNTc2NTg1NywiYWNjb3VudF9pZCI6Mjk2MDMyMzksInN1YmRvbWFpbiI6InRlaGthYnJhbW92IiwiY2xpZW50X3V1aWQiOiI0YjZiMWUxYi0zOWZjLTRjODYtYTViYi00NmVhNGQ3NjU2MDQiLCJ1c2VyX2lkIjo3MjU5MjQ1fQ.tAnn5nlMZSNBKY2ZXJUfnHh6opIcoypE3rLR2lLRsDs';

$accessToken = new AccessToken([
    'access_token' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjMyMGQ2MDY3ODQ4NGNiZWNhM2NjNGZjNjA0ZmVlNGM5NGU3OTEyYzZmNjAzOWUyYTA2ODQ2M2EwNjRjOGVmZjk2NGNkN2Y2YWJlYmE3NzgzIn0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiIzMjBkNjA2Nzg0ODRjYmVjYTNjYzRmYzYwNGZlZTRjOTRlNzkxMmM2ZjYwMzllMmEwNjg0NjNhMDY0YzhlZmY5NjRjZDdmNmFiZWJhNzc4MyIsImlhdCI6MTYzNTUyMzg2NCwibmJmIjoxNjM1NTIzODY0LCJleHAiOjE2MzU2MTAyNjQsInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.qV6yqY8gNNNWVTWdwhzIz4Y8Vnf-YikAk_ucr7_jkWfzXtTSglhrNVyM2aoDvYRdDxYf7mZVVUjTMRayMCxAVcCjGUJ5C1VfZsBvfbnMDV688EsPfLdaat_7KBOOEUEe0aqAHRFOni3vqffC7DPkL6pm0EUp8pwFp5wSJLrrdqXEkg3SATsX5Dqw8u7OUIwZPIq-_EiHv9G9Yhg8JxsBuN5P_ONONJY1sDpoLoRSriRd8ziEgVNZAAaBLOwbf1AfjYErIOpSjKRImCrex5wZbscH1h2iAh5oqNLPG5e70hiefc0GARSekEaJcYgLnogAQkxV8sUkwlB9YF7skQx2SQ",
    'refresh_token' => "def502005b601a4ffeee2aca8012def33058255871d7a585c1cc85c74a558c65ed2bf30067ed2f09c2b8056882f319dcf686939e66feb64cb96f8cbf732a2bcf9197720e210a9e383256dfaf1905955498a1cd193dc2b9f12eba43eefb4ef29d38d524de14bfce7d55871d0b28ade6b27440333ec4f7ee7aa69b5c4161c5cbcc9b7cf073d13fbedbb355b3fc23171dd95f7ed8c11be55b2c331f8d02201c51da9659f71751fe0f0627a26b239125ec6df4918c523ad47c524adf0f77128a4ee727e7475d6baa261c3bc4e5dd2ea56587e648e010c9e8a00a08de5580a8ff2f624faa7db87c27a2a0fe428d7350bffc580e90fe5e195f6b223d1910fe58b10eb5dc57dea691af62d29765da0c84175f3b06c6d3bc0f96452ab317db7d6bb940138c64dadf8997388441e39cb85e5d971a5c62425d8ff9cfb185f9b4683cfb0030af5d8ccb35e19a117f5efd65eb0c3a31923f92bcbeabcb338544110e073e03714632c457d18e7e91fad3be9c2820b2c587338ecc34de170da509ca0ccb926f3f206448ce3152a3e9d4ab8070dcf668f02d3e1a2a123ae2eba8adfb368ad6f1871cf99dadaaec2c10e087c60dce7ab73e873b99a2baa766bb6ed9f20faea48484e17f7f05674d24941b7f",
    'expires' => 86400,
    'baseDomain' => 'tehkabramov.amocrm.ru',
]);

$apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain('tehkabramov.amocrm.ru');
//$accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);

$apiClient->setAccessToken($accessToken);

//Сервис кастом полей для сделок
$widgetsService = $apiClient->widgets();
var_dump($widgetsService->getOne('bhvzek4shxazf47qeyrxouyediol3rms4e6qyskw'));