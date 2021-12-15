<?php

$access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImY0Zjc3YTdlODk2NGZmOTM3MTljZmQyMzkzMjBkNTk0ZTUxNzE4MjM3YjU2ZTZmNDY1ZDczZTM2MTJkYTZlMjI1OGM2YzdmNDMxZWZkMWJkIn0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiJmNGY3N2E3ZTg5NjRmZjkzNzE5Y2ZkMjM5MzIwZDU5NGU1MTcxODIzN2I1NmU2ZjQ2NWQ3M2UzNjEyZGE2ZTIyNThjNmM3ZjQzMWVmZDFiZCIsImlhdCI6MTYzMTg3MDA1OSwibmJmIjoxNjMxODcwMDU5LCJleHAiOjE2MzE5NTY0NTksInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.GuUp5tGwGrD-Qm8SSLu86Mw0628s7tSlytWBvYkhjKhSa12dcAfW4XL_MmDKimXn1uoZ2PHdOzmu_KAJdFCziJZQUJacY0-faD3jNIK-JCrhvhonwL5mKhwd2a2Osjh89fQailmOZlKPkiOyUwJuQC27xrf07aB4yJ4w6R9UquuDgKXglvWE1co6OQFCG976YUh7CzCB9NoCzwaBrmVx9Oc05I6kyIzkhSm3UGDVNH6Vobwwcozy-ulYVJRd9xG4rRREtKaGtg9T62k13BO6jsLAzz-nsE6AJoCf2SgCeow7fzty8YdAzu5Ma5IIv1UazlghKVVajbWjQhzhg0Qj7g";

$body = json_encode([
    /*[
        "request_id"=> uniqid(),
        "source_name"=> "ОАО Коспромсервис",
        "source_uid"=> uniqid(),
        "created_at"=> time(),
        "_embedded"=> [
            "leads"=> [
                [
                    "name"=> "Тех обслуживание",
                    "visitor_uid"=> uniqid(),
                    "price"=> 5000,
                    "custom_fields_values"=> [
                        [
                            "field_id"=> 284785,
                            "values"=> [
                                [
                                    "value"=> "Дополнительное поле"
                                ]
                            ]
                        ]
                    ],
                    "_embedded"=> [
                        "tags"=> [
                            [
                                "name"=> "Тег для примера"
                            ]
                        ]
                    ]
                ]
            ],
            "contacts"=> [
                [
                    "name"=> 234,
                    "first_name"=> "123213",
                    "last_name"=> 234,
                    "custom_fields_values"=> [
                        [
                            "field_code"=> "PHONE",
                            "values"=> [
                                [
                                    "value"=> "+7912321323"
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "companies"=> [
                [
                    "name"=> "ОАО Коспромсервис"
                ]
            ]
        ],
        "metadata"=> [
            "ip"=> "123.222.2.22",
            "form_id"=> uniqid(),
            "form_sent_at"=> time(),
            "form_name"=> "Форма заявки для полёта в космос",
            "form_page"=> "https://example.com",
            "referer"=> "https://www.google.com/search?&q=elon+musk"
        ]
    ]*/
    "pipeline_id"=> 4659352,
    "status_id"=> 42738775
 ]);
 
 $curl = curl_init();
 curl_setopt_array($curl, array(
     CURLOPT_URL => "https://tehkabramov.amocrm.ru/api/v4/leads/10678541",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
     CURLOPT_CUSTOMREQUEST => "PATCH",
     CURLOPT_POSTFIELDS => $body,
     CURLOPT_HTTPHEADER => [
         "Authorization: Bearer $access_token"
     ],
 ));
 $response = curl_exec($curl);
 $err = curl_error($curl);
 curl_close($curl);
 
 if ($err) {
    var_dump($err);
 } else {
    var_dump($response);
 }
