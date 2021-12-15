<?php

function milliseconds() {
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
}

use AmoCRM\Exceptions\AmoCRMApiException;
use League\OAuth2\Client\Token\AccessToken;

require 'vendor/autoload.php';

$clientId = '16d78112-73ff-4731-8812-0eb50a44fdde';
$clientSecret = 'vu1wdv1bwSq85UoaYumznASc4HLjonCmrW2QwPUPGMMHt8qVVHmIoIoTPBsWlZxQ';
$redirectUri = 'https://youtube.com/';
$baseDomain = 'tehkabramov.amocrm.ru';
$code = <<<EOF
def50200be7a6539c2684ad75bcb4f6604256ec097a8d607f882f218f8d154b1c198f6dbe86c33389468a74ee1cf67655db24d1d5609ce4d6e41b6093f2ad7f5ff11e3114c7cccdd483dfb7b9b8efbd3c7b513cb50453a680a80691f3ef24edd3f156ea16935dcb51a164e0c88d962457e4f838ba7946ffb94f4c5da7b157d23615b58a05403ad23a95c209677e59393a399a2603be5b65f1de23f727e9ca2cf07326591d251dc6c25db941b212bb825c3ce3848ed2742e0634f44ca90ee2c473857cab2ea45fcb64a22f218c510d2c1146cb20b13e7c0670b484882fa780478fa9d321c58307832d49bdeca3d5834984f97aeae86d29474caad83d401a548cb41aa81e5ed3c4a361df996ad5aeed8a22d50176b9e7a30daf63aec650a62c0b390ed1ef4104036d629ac440c9d3f0e18ccdce183ddaa21371bab9f1ee680c5f7aaf420a2d9c988efabb14a9b4079d44f6a15b28a74429bdca647eeb4f799e8721686be33d728619684224cc459a16357828f5706e6012c3191c7ab302057770a1d25dcef17d8917c40df1c0a457b0525237edf5aac8b19f5ec7a0eae4ec7d99e21e57f2cb6276e483120c1e6f10cee4695f0019deefa818a2b014202737dd9
EOF;

$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';

$account_id = '989186f9-e54f-4b03-be7d-2414b016be28';

$apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain($baseDomain);


    /*$accessToken = new AccessToken([
        
            "token_type"=>
            "Bearer",
            "expires_in"=>86400,
            "access_token"=>
            "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQyNzI2OWViNDc4NThhOTc4YTE5ZmNiMmNlNTEwNWM0MmZmOGM4OTFlNmE3MWVkMDNhYmZiZmE1Zjk5YWUxMjEwNTZhYmY3N2FmZDllOGZkIn0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiJkMjcyNjllYjQ3ODU4YTk3OGExOWZjYjJjZTUxMDVjNDJmZjhjODkxZTZhNzFlZDAzYWJmYmZhNWY5OWFlMTIxMDU2YWJmNzdhZmQ5ZThmZCIsImlhdCI6MTYyOTk5NjEwMywibmJmIjoxNjI5OTk2MTAzLCJleHAiOjE2MzAwODI1MDMsInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.qG79BgxpFEQVZJaoBWvldYUR77ZMpA792Lpj-6wjA2hcNQubJapzDmq1fA8q58urm6QeCewkjfZIDLmAjyNjSog0whBfkZWE1q2H4rmaWGFtRYyzMMVhGL1L38xCBQA60emaR912DlG3C1kFu7XZuoalHgrByxWckQNyw-PNgOqICpoKJ-cWVDtkZXBUPbxEc_dQjByTDD3Yv6nOP21K-ceZ0dK7wnTkxeqRm4zva5UIey4pIsRclkl8Hwek3iEJUtluGU35vriklMpvFdVMrgIQ05OT41fqw9WeKgE1jpvq0TfErbKG-iOT_5sZHsSJEXlMFeFPYNb6ZTzzjP8_sw",
            "refresh_token"=>
            "def502005680dec99ba436df82a18a473de7902ff95055ce18e448c6614589a71e71d29677c9bdb8a3e4854a21bcfad165d5482395ccc752835d81b6ddc06a37c59f765b797cb98097c75f1f7f6401d924c093fee2d6aaa4124e8465546cf51e1846ae78cb86b16c52bad05e205985faba1c6cdbf434761804f30bae39c2ab57ccce12b765438726dbc0fb9b7f54b38ed772827f41d45f908e6a2946361f9d9e038ec0fcc76ff0c0cceb2a6acedcc6fcdf571d680b41259bdbe41329781dcc148a6d2c8197df68a44da0e954487947d119d2b01c836fdbc3183f437faf72c6d2e9bc61c3194d8225be9e9faa6ac6b900f29c1e1420584322b6b5aafb6ff95fd06120ab4bd59d0453def7931e6a67c86f19a2714b88efd3826798828704dbb6917f4f3110bdbe2467889ece637fe36d2ef4c0e6850972538a2aad781579cb3d56b7b002df49dbe74cd6be9890616e7440b62d4e0f0377d847f70e4a6de713c225e06f1123d4025ff995cb0df0a6da398d2fe2bba4e84d1b0f6444d013639cb7e44a420e303d92ab107b49919eae8c0bef24047ef114d4cccf9554a8e7af7e95d7b1ded7d0642046a145e0983c4c69f9b1e5343f50f862a761442cdfba4b1eb8a1ae6114513dd407c53426"
          
    ]);*/

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

try {
    $response = $apiClient->getRequest()->post("api/v4/contacts/chats", [
        ["contact_id"=>13609817,
    "chat_id"=>"934b7a7a-f168-4d15-a864-e5f53b7a7a5f"]
    ]);
            var_dump($response);
            file_put_contents("response_chat_contact.json", json_encode($response));

} catch(AmoCRMApiException $e) {
    var_dump($e);
}
           


    /*$account = $apiClient->account()->getCurrent([\AmoCRM\Models\AccountModel::AMOJO_ID]);
    $amojo_id = $account->getAmojoId();
    echo "amojoId: " . $amojo_id . PHP_EOL;
    file_put_contents('amojo_id.txt', $amojo_id);*/

//{"method":"POST","body":{"event_type":"new_message","payload":{"timestamp":1629313014,"msgid":"89173516829-1629313014","conversation_id":"89173516829","conversation_ref_id":"be58764b-b5b7-43fd-8a09-d2c2b5210c03","message":{"type":"picture","text":"","media":"https://whatsapp-files.services.mobilon.ru/false_79173516829@c.us_58BE8E7976D14BCBB1EB76DD94BD1652/file.jpeg","file_name":"","file_size":0},"sender":{"id":"89173516829","ref_id":"b3eed91b-9af2-47c9-9227-d3efd8cb2dab","name":"Андрей","avatar":"https://filebump.services.mobilon.ru/file/CzwSP6WjoYkPsqVmDw6cr16LWktZSdqK50Uv/avatar.jpg","profile":{"phone":"89173516829"}}}},"headers":{"x-signature":"45d8dd5df8891b4eca8d40e39e95c8075e14a774"}}
