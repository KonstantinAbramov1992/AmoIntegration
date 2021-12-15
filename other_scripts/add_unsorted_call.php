<?php

$subdomain = 'tehkabramov';

$body = json_encode([
    [
        "source_name"=> "ОАО Коспромсfерgис",
        "source_uid"=> "a1fee7c0fc436088e64bage8822fba213",
        "_embedded"=> [
            "leads"=> [
                [
                    "name"=> "Тех обслуживанgиеf Ne2",
                    "price"=> 5008,
                    "custom_fields_values"=> [
                        [
                            "field_id"=> 1138397,
                            "values"=> [
                                [
                                    "value"=> "abramovk.a1992@gmail.com"
                                ]
                            ]
                        ]
                    ],
                    "_embedded"=> []
                ]
            ],
            "contacts"=> [
                [
                    "name"=> "Контакт дляdfg примера",
                ]
            ],
            "companies"=> [
                [
                    "name"=> "ОАО Коспgрcомсfервис"
                ]
            ]
        ],
        "metadata"=> [
            "is_call_event_needed"=> true,
            "uniq"=> "a1fe231cc88e64ba2e88f2c2ba2hb3ewrw",
            "duration"=> 54,
            "service_code"=> "CkAvbEwPcafmh6sad",
            "link"=> "https://example.com",
            "phone"=> 79998888856,
            "called_at"=> 1510261200,
            "from"=> "onlinePBX"
        ]
    ]
]);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://tehkabramov.amocrm.ru/api/v4/leads/unsorted/sip",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM3ODhkN2JjM2I0Zjk4NDk3OTRlMzI5ZTY4YmQ3ZDBiNjhhMjM4ODBhNTU2Yzc1NmQwZDBmNWJkN2VlMGNlODNjYmExM2Y4ODVlMTcxYWQ4In0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiJjNzg4ZDdiYzNiNGY5ODQ5Nzk0ZTMyOWU2OGJkN2QwYjY4YTIzODgwYTU1NmM3NTZkMGQwZjViZDdlZTBjZTgzY2JhMTNmODg1ZTE3MWFkOCIsImlhdCI6MTYzOTU2NzYxOCwibmJmIjoxNjM5NTY3NjE4LCJleHAiOjE2Mzk2NTQwMTgsInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.coiBvkmnlf0N9ajJyP6Xc0ULlJyvxBfUZ1FPlqE9bEckXWFoUtPnAm8bTffvnRKW1KQqKOSZPemkjLmudknWYP5UC91fH-dmopE4kInr8I4HWBgSOBBxd7Xi2EBaierszoKULtUDplnGHteQwPnmgJhLBBWA0PUyjpcf5uLD02Rol5cjBaOt4kG0pqtCYB39hR1SgH8FvCzayfz29mUKkuJ12Uiz7p1w5sUlb4pyKESTU6xjPx7ouOt3oR8r38hEwOEcoCJQdyxCc3lSt9Mf9QZ3aqW4rcEV7yP0--wp65EQKMV4F6ssyHgXnyKgUJGZhKqk_6tPaWB5stVoweDzBA'
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    var_dump($response);
    file_put_contents('response_add_chat_to_contact_dev.json', $response);
}


