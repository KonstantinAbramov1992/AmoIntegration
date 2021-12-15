<?php
$secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
$secret_dev = '3e9d42d42e66b24a89e6715523e3e17d181d1e50';
// Scope id для публикации сообщений в аккаунт
$scope_id = "0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28";
$scope_id_dev = "e63e41bd-8b53-4ce0-a5b4-d388b735835f_031bfad9-d6f2-49b2-adc4-f35e30b085df";
// Тело запроса
$pictures = [
    'https://montessoriself.ru/wp-content/uploads/2016/03/v4-2.jpg',
    'https://whatsapp-files.services.mobilon.ru/false_79876276519@c.us_5EBF041A33B09518D26B/file.jpeg',
    'https://whatsapp-files.services.mobilon.ru/false_79876276519@c.us_5EE8EE840CF630033F3A/file.jpeg',
    'https://whatsapp-files.services.mobilon.ru/false_79876276519@c.us_5EBF041A33B09518D26B/file.jpeg',
    'https://whatsapp-files.services.mobilon.ru/false_79876276519@c.us_5EE8EE840CF630033F3A/file.jpeg',
    'https://montessoriself.ru/wp-content/uploads/2016/03/v4-2.jpg',
    'https://whatsapp-files.services.mobilon.ru/false_79876276519@c.us_5EBF041A33B09518D26B/file.jpeg',
    'https://whatsapp-files.services.mobilon.ru/false_79876276519@c.us_5EE8EE840CF630033F3A/file.jpeg',
    'https://whatsapp-files.services.mobilon.ru/false_79876276519@c.us_5EBF041A33B09518D26B/file.jpeg',
    'https://whatsapp-files.services.mobilon.ru/false_79876276519@c.us_5EE8EE840CF630033F3A/file.jpeg'
];

//while (true) {
    $body = json_encode(
        /*[
            'event_type' => 'new_message',
            "account_id" => "989186f9-e54f-4b03-be7d-2414b016be28",
            'payload' => [
                'timestamp' => time(),
                'msgid' => uniqid(),
                'conversation_id' => '7a7d0d40-50e0-491c-aedb-0832f072a350',
                'conversation_ref_id' => '7a7d0d40-50e0-491c-aedb-0832f072a350',
                'sender' => [
                    'id' => '23117231-32d3-4e17-9fd2-eea1be4e7fd3',
                    'ref_id' => '23117231-32d3-4e17-9fd2-eea1be4e7fd3',
                    'name' => 'John',
                    "profile" => [
                        "phone" => "79154266287"
                    ],
                ],
                'message' => [
                    'type' => 'text',
                    'text' => (string)time(),
                    'media' => $picture,
                    'file_name' => "",
                    'file_size' => 0,
                ],
                "silent" => false,
            ]
        ]*/
        [
            "event_type"=> "new_message",
            "payload"=> [
              "timestamp"=> time(),
              //"msec_timestamp"=> time(),
              "msgid"=> uniqid('m'),
              "conversation_id"=> uniqid('c'),
              'conversation_ref_id'=> 'be19339c-cc9d-4c79-9738-7c2374f5d887',
              "silent"=> false,
              "sender"=> [
                'ref_id'=> '8469089e-06e9-4ab7-a00c-37aa73209ec9',
                "id"=> uniqid('s'),
                "name"=> "Гмгмг",
                "avatar"=> "https://api.pact.im/avatars/original/missing.png",
                "profile"=>[
                    'phone'=>'+79769921456'
                ]
              ],
              "message"=> [
                "type"=> "text",
                "text"=> "1"
              ]
            ]
        ]
    );
    // Формируем подпись
    $signature = hash_hmac('sha1', $body, $secret);
    $curl = curl_init();
    curl_setopt_array(
        $curl, 
        array(
            CURLOPT_URL => "https://amojo.amocrm.ru/v2/origin/custom/$scope_id",
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
        )
    );
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
    echo PHP_EOL;
    usleep(0.01 * 1000000);
//}

/*{
    "event_type":"new_message",
    "payload":{
        "timestamp":time(),
        "msgid":uniqid(),
        "conversation_id":"1332372665_1240661186",
        "sender":{
            "id":"1332372665_1240661186",
            "avatar":"https:\/\/cdnnew.leadfeed.ru\/bvc\/https:\/\/scontent-waw1-1.cdninstagram.com\/v\/t51.2885-19\/s150x150\/106134328_707229373343306_8929888066818758942_n.jpg?_nc_ht=scontent-waw1-1.cdninstagram.com&_nc_ohc=RmiBI2VoU_QAX-cDGZe&edm=AJXOVykBAAAA&ccb=7-4&oh=825606fdbba541cd3f154f14b0111cd5&oe=6145296C&_nc_sid=9c1db7",
            "name":"Instagram murmurous.cat[drnesterenko]",
            "profile_link":"https:\/\/instagram.com\/murmurous.cat"
        },
        "message":{
            "type":"text",
            "text":"[\u0441\u0438\u0441\u0442\u0435\u043c\u043d\u043e\u0435 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u0435]\n[\u0441\u0441\u044b\u043b\u043a\u0430 \u043d\u0430 \u0432\u0435\u0441\u044c \u0447\u0430\u0442](https:\/\/leadfeed.ru\/chat?thread_id=014b0a662db787f277aa25d819acbd8a)"
        }
    }
}*/
//{"event_type":"new_message","payload":{"timestamp":1632995055,"msgid":"615586ef36cb7","conversation_id":"1670543","silent":false,"sender":{"id":"U1670543","avatar":"https:\/\/wahelp.ru\/i\/img\/amoprofile.png","name":"\u041c\u0438\u0445\u0430\u0438\u043b","profile":{"phone":"79772627081"},"ref_id":"a5401ebc-2f28-4114-9713-cc060519ce68"},"message":{"type":"text","text":"\u0442\u0435\u0441\u04422"},"conversation_ref_id":"ce3d2e88-91e7-48a4-b9f3-80d071fabad4"}}