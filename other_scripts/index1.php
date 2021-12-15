<?php

function milliseconds() {
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
}

use AmoCRM\Exceptions\AmoCRMApiException;
use League\OAuth2\Client\Token\AccessToken;

require 'vendor/autoload.php';

$clientId = '2c81d8dc-8dfb-49db-ab33-269dec15b1e7';
$clientSecret = 'tP5ErVOt3Xvj405IKHNZZnubI5g5cuBKtptOZSCkiINmVtumGTfP99aZGHjfyezw';
$redirectUri = 'https://youtube.com/';
$baseDomain = 'tehkabramov.amocrm.ru';
$code = <<<EOF
def502009be55c3b0df2cc50c8fa566d9892b36cf9980a58516dfe7b9c324272d53b852a869914dd4a5079b7fb3ad6dd9eec144ad9abc2d1f379f545adc2319b6fb6e53ba0ce3f53b5c26f8cd9b86d0d5f6a838634d305b90d0803dca82648e02d7cf0d3fb92bd493f42a415c774a94e86c6e31048247aab8ebd35bd8e6ca9062e6e1cd2d7b66f0d059ceec7e37f81196fec36b4fb82e863c85fd42b34dd6973289fedd9f70f91d87908966cc53c4619c589e7c2bcc8f69bd88161bab058aca62d3e128180a0a711ae0c82de2edf3328041c952b10582946ac529a1a63ce7f3754623ba92efca66c1f05411a423d73b8c6314892bd9382bf4ecae373bfde0ca0fd58262f5d085458cca2e38ba63f2471e69732101cd878e8d8e9d1fbadeae8e8e21a98f815b760b67a9c255cdba1266a90a9713671976898ffe2534e90c67ab9ddc739e39ee73b83dcb5fec41d3c21eb8bbcdffa148e4aede005f15c90ca033d52a34f87f33dd62500d3b70656cc69cfc5a79453509720e4f728cf6e3ee009f669749e7f7c289aac4058d52de00a6742487001c25b91af9d1f043e38f84084549ef98b59a551df13b9a819b9dbb86f4495be823881f147f23d548e9755ebc1
EOF;

$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';

$account_id = '989186f9-e54f-4b03-be7d-2414b016be28';

$apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain($baseDomain);

    $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);

    $apiClient->setAccessToken($accessToken);

    /*$response = $apiClient->getRequest()->post("api/v2/origin/custom/$scope_id/chats", [
        "conversation_id"=> "skc-8e3e7640-49af-4448-a2c6-d5a421f7f217",
        "user"=> [
            "id"=> "sk-1376265f-86df-4c49-a0c3-a4816df41af9",
            "name"=> "Константин Абрамов",
            'ref_id'=>9204111,
            "profile"=> [
                "phone"=> "79154266287",
                "email"=> "abramovk_a@mail.ru"
            ]
        ]
    ]);

    echo json_encode($response) . '<br>';
    file_put_contents("response12.json", json_encode($response));*/


           $response = $apiClient->getRequest()->get("/api/v4/contacts/chats");
            var_dump($response);
            file_put_contents("response1221.json", json_encode($response));


    /*$account = $apiClient->account()->getCurrent([\AmoCRM\Models\AccountModel::AMOJO_ID]);
    $amojo_id = $account->getAmojoId();
    echo "amojoId: " . $amojo_id . PHP_EOL;
    file_put_contents('amojo_id.txt', $amojo_id);*/

//{"method":"POST","body":{"event_type":"new_message","payload":{"timestamp":1629313014,"msgid":"89173516829-1629313014","conversation_id":"89173516829","conversation_ref_id":"be58764b-b5b7-43fd-8a09-d2c2b5210c03","message":{"type":"picture","text":"","media":"https://whatsapp-files.services.mobilon.ru/false_79173516829@c.us_58BE8E7976D14BCBB1EB76DD94BD1652/file.jpeg","file_name":"","file_size":0},"sender":{"id":"89173516829","ref_id":"b3eed91b-9af2-47c9-9227-d3efd8cb2dab","name":"Андрей","avatar":"https://filebump.services.mobilon.ru/file/CzwSP6WjoYkPsqVmDw6cr16LWktZSdqK50Uv/avatar.jpg","profile":{"phone":"89173516829"}}}},"headers":{"x-signature":"45d8dd5df8891b4eca8d40e39e95c8075e14a774"}}
