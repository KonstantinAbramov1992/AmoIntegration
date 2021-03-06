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
$redirectUri = 'https://webhook.site/77ee9e16-75f6-4a84-898a-1a8c330421ae';
$code = 'def50200619d8f3cb029ee50ec8fa0b12fbc53d056792c5d546038ab9e11ada543cc45519c17a27850f8b90116e2ea16e7888f7055b582e97777033fb661b354e86929563e71935fdb4917c7b7903c941d147a4a57671e42ade3ab09fe5ebfd510970498de6b9c53f780b737aae054aabaa9851f55ad6edc8887d17641f98c9bf54f97de5ead5d0e438fe76e42ce59cae8b2861b0c413dad62d0ad7191434b91f10efe84a595d0917c037ce27d1245541a45603992aea27419837bb23be374e1697234ec407a2a7165151ea9b037e0212578626d41ae33e665d1c151754cf5e54b1f3c643e1800e3d097a1f79cedddbad0b0d5b89db50497716f0f149310c6d697796b7ec185674315a546ae7b41cecaa34426e00d616a054c4f614384fffabd9b20d9c16ccb2a8b738cdfb007cac33870dfbbb7f598468686f10397a8560a411bc5ba5533b10c23bd8b941fa5d4346c0dd4bf366ad5bd5c1e8d8bd127604f094a587de9dea161fee3e0608b1760132ab8448c29e62c99833c3232d4f15ccd184557d75c97440780e47950e251a8cf88521e975bfbce6af133dd8cc1287532f456a096394a3a74c9d7c120080351dd2ff777ca911c17233bf8791456cdef95c684b9520bfd2cde028fe80dec03f4a7c7b17f8b37d290319d41083c8f69978afadba618fb';

/*$accessToken = new AccessToken([
    'access_token' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjUyOGZiYzFhYjI3OTNhYzllYzlkM2MyMzA3NjEzZDA2ZTE3ZDg5MWZlZjU3YmZlZWI5OGI4ZTJiNjU2N2ZmMWJmODViZDNmNzI2ZjFkOWI0In0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiI1MjhmYmMxYWIyNzkzYWM5ZWM5ZDNjMjMwNzYxM2QwNmUxN2Q4OTFmZWY1N2JmZWViOThiOGUyYjY1NjdmZjFiZjg1YmQzZjcyNmYxZDliNCIsImlhdCI6MTYzNTQyMDg3OSwibmJmIjoxNjM1NDIwODc5LCJleHAiOjE2MzU1MDcyNzksInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.CX7incClV-FxfP8SC5kXE2eRnjNP0s-9SU0QxlWf6cDYZGDE4UtC7rB5a6bJbU4CDYT4YBHlRp8eqaVhj7-SlX2OZz00l2cVJHEelNzIHmcW1z1oZiqFFzTTtd5XXOa9Fhr6YuJ1505-54fWfybuaA4PGDkucn1mo94dy73527DQztGepfes_SgzU0yTHoag8QFuSK-euz4stHcWgvMbnd4FYTN2BtrBROuPQvQnGvnrtSZh21bYZTUloJDf5prWBK8thR4g36MJdMTBLFdaiXtfx8Q8fGDCXlwvhSmxA2erYwZm3HEaQOSKAvciZKImsNpTu-Ko_zK8B9hvWtrCVw",
    'refresh_token' => "def5020066ac1a0c9d18f50434a420b11ff66e567931d6f84b42cc2a6b750c1956453095430b4590ebbd2950d5f96b7b5a5ca015f3d3eb2f3959c5994f5a98f71deaf733a71f336eadf851ed478670084b903e89f512e5d379289cf48591d754a364cad5961e321856c07a6a852ad3a3abce3c4c561b29fb4c2443d3871fc1c5e2c5172f4ce04562f2476f74fbc6c2be27930049df2fd2b78c89e2128604ceac3edaf3cc735ee6e743d5a2f239565f21ea465402aad0a4bf6d6efd3685f70271ccc38e353a2d971f5f14c5f877f39072164112b8cac887a756d998e314d3ee2487db6af04a84cd21a6a02be850257f1783bfd4638e335ae251a26df06e153978af5ae9680e0b747fa9bc46622c5625dc9f37dd3e9678b21cbdc9b39d7bf5286b4ea0a0e3b46af84fcb4e55f33a7511808f88d5d2c04e9c445a24696d2f2b36b052c2d20debe8526bb0a8b4c5b245a13b5005886fb55e18ea12114e69351a106dd6f3b927d859a6c892443d432dd37d3539992254940f5549d6d8c9479c5d4feab9fc52ca864b92c969c591b590376499255e5fbe91a4d347ee8949425ddd84ea1fa98f8df9da9ea7a81cec136dc06e88ed1da6805fbe8bc3c6f5ab52a74e231b1b54e43b4428d825793c",
    'expires' => 86400,
    'baseDomain' => 'tehkabramov.amocrm.ru',
]);*/

$apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain('tehkabramov.amocrm.ru');
$accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);

$apiClient->setAccessToken($accessToken);

//???????????? ???????????? ?????????? ?????? ????????????
$customFieldsService = $apiClient->customFields(EntityTypesInterface::LEADS);
$next_page;
$fields = $next_page = $customFieldsService->get();
//var_dump($fields);


            $next_page = $customFieldsService->nextPage($next_page);


    //$fields = array_merge($fields, (array)$next_page);
    //var_dump($fields);

//$fields = (object)$fields;
//var_dump($fields);
//file_put_contents('fields.json', $fields);