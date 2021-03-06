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
//$code = 'def50200e9c351055faf0465083f0ffb116ac86fe2470d12d5bdd47391b615ee35981e3f029177ffd069935bb29be8bd818d80044943a2c7dd315af4ea995c4912e9060f0c0179b419a130d4ef33917d394f97af9e81b25095688573f5b220cc192de32c54bc6b9075a11e23d01744766478dd579c4ee66e6bad39431e6edc7a599a0a36988f3800483df7c924e58c7ccfcbea0d7e55a343492d3c07b841361c2cf4f452a65dc44f12645f8bfe52c760cf66626c7f320fcb01cdd9ecbbe8a824e0a44c745c39586feb00010f6c97e001aacc36cb3d5d3d8622a1d8654083d5abcc9648f18d94c6a76caa159f459ef88f02e683bb22c1e97fb1418a8c876fa52b9a0f4220f720875bdf125447bf71415a341aafbaa7f235b429f5cd5b7910341b3545955870db63a9424c35c751fae4caf72bacf270d84ab799e192df89285063c9dd5e6a471910b737e2802678241289f7cc07d1191b67f553a0df726e902a568ce0262a7ccf7b931c36f5353f2c86a9e57d3af761b29d351dc59cfeeee47ab560dd59d726baba68fb4f345c6d04500e0609083e267daf81aae014ae0f1c6274b2f7ac0a9d49d86daddf56e6eb5e9bcc6f26e102d56d1efd0fa6ce8af3640a';

$accessToken = new AccessToken([
    'access_token' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjUyOGZiYzFhYjI3OTNhYzllYzlkM2MyMzA3NjEzZDA2ZTE3ZDg5MWZlZjU3YmZlZWI5OGI4ZTJiNjU2N2ZmMWJmODViZDNmNzI2ZjFkOWI0In0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiI1MjhmYmMxYWIyNzkzYWM5ZWM5ZDNjMjMwNzYxM2QwNmUxN2Q4OTFmZWY1N2JmZWViOThiOGUyYjY1NjdmZjFiZjg1YmQzZjcyNmYxZDliNCIsImlhdCI6MTYzNTQyMDg3OSwibmJmIjoxNjM1NDIwODc5LCJleHAiOjE2MzU1MDcyNzksInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.CX7incClV-FxfP8SC5kXE2eRnjNP0s-9SU0QxlWf6cDYZGDE4UtC7rB5a6bJbU4CDYT4YBHlRp8eqaVhj7-SlX2OZz00l2cVJHEelNzIHmcW1z1oZiqFFzTTtd5XXOa9Fhr6YuJ1505-54fWfybuaA4PGDkucn1mo94dy73527DQztGepfes_SgzU0yTHoag8QFuSK-euz4stHcWgvMbnd4FYTN2BtrBROuPQvQnGvnrtSZh21bYZTUloJDf5prWBK8thR4g36MJdMTBLFdaiXtfx8Q8fGDCXlwvhSmxA2erYwZm3HEaQOSKAvciZKImsNpTu-Ko_zK8B9hvWtrCVw",
    'refresh_token' => "def5020066ac1a0c9d18f50434a420b11ff66e567931d6f84b42cc2a6b750c1956453095430b4590ebbd2950d5f96b7b5a5ca015f3d3eb2f3959c5994f5a98f71deaf733a71f336eadf851ed478670084b903e89f512e5d379289cf48591d754a364cad5961e321856c07a6a852ad3a3abce3c4c561b29fb4c2443d3871fc1c5e2c5172f4ce04562f2476f74fbc6c2be27930049df2fd2b78c89e2128604ceac3edaf3cc735ee6e743d5a2f239565f21ea465402aad0a4bf6d6efd3685f70271ccc38e353a2d971f5f14c5f877f39072164112b8cac887a756d998e314d3ee2487db6af04a84cd21a6a02be850257f1783bfd4638e335ae251a26df06e153978af5ae9680e0b747fa9bc46622c5625dc9f37dd3e9678b21cbdc9b39d7bf5286b4ea0a0e3b46af84fcb4e55f33a7511808f88d5d2c04e9c445a24696d2f2b36b052c2d20debe8526bb0a8b4c5b245a13b5005886fb55e18ea12114e69351a106dd6f3b927d859a6c892443d432dd37d3539992254940f5549d6d8c9479c5d4feab9fc52ca864b92c969c591b590376499255e5fbe91a4d347ee8949425ddd84ea1fa98f8df9da9ea7a81cec136dc06e88ed1da6805fbe8bc3c6f5ab52a74e231b1b54e43b4428d825793c",
    'expires' => 86400,
    'baseDomain' => 'tehkabramov.amocrm.ru',
]);

$apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain('tehkabramov.amocrm.ru');
//$accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);

$apiClient->setAccessToken($accessToken);

//???????????? ???????????? ?????????? ?????? ????????????
$customFieldsService = $apiClient->customFields(EntityTypesInterface::LEADS);
$fields = [];
$next_page;
$fields = (array)$next_page = $customFieldsService->get();
while (true) {
    try {
        $next_page = $customFieldsService->nextPage($next_page);
    } catch (AmoCRMApiPageNotAvailableException $e) {
        break;
    }
    $fields = array_merge($fields, (array)$next_page);
    //var_dump($fields);
}
$fields = (object)$fields;
var_dump($fields);
file_put_contents('fields.json', $fields);