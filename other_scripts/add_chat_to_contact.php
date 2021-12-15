<?php

$subdomain = 'tehkabramov';

$body = json_encode([
    [
        "contact_id"=> 19202403,
        "chat_id"=> "5c218ef5-f75b-4272-94f2-8262a1b70284"
    ]
]);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://tehkabramov.amocrm.ru/api/v4/contacts/chats",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI0OTI1NjM3ZTAyNmI1OGIxYzdjMmJjN2U3MTk4OWY0NGFiOGNkM2ZlZGQwNWFmYTk0NWFjN2RmNDViNWEyY2JhNmViOGEwYTg3YzE2ODY0In0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiIyNDkyNTYzN2UwMjZiNThiMWM3YzJiYzdlNzE5ODlmNDRhYjhjZDNmZWRkMDVhZmE5NDVhYzdkZjQ1YjVhMmNiYTZlYjhhMGE4N2MxNjg2NCIsImlhdCI6MTYzOTQ3NjExNiwibmJmIjoxNjM5NDc2MTE2LCJleHAiOjE2Mzk1NjI1MTYsInN1YiI6Ijc3MzI5MDkiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.fpkIDM-LzBoaM0n9tFype9It9HRtNARUXQ5MgMPDa9zECOiJEXADk6dbFU2jwuHTwSjy-bp5tvPSdp_v1uB3rw6IfeTOHsHPNsQhPJzxOWibnHVVQpBOc1_8iMPFWluXIxwZrnVAM58-T8TKdTy2Zv7eVzqs1P4UtkXkR8Gw_rzWi5SQ5LkDkIdeepocvt0eNmvyCyACIHVcxkrZ8VuiRrc_bgaAHa7QVfz0zfJyHj5a8puIn2fX7d5EtdEDkM3cAl-HrRM7TgRUtyjDJbsT4uFrLDNIf4vSKUX9cM8AYZPMRh6SH_81BSn7D7DMq9M08B0zGJIzsrCu1GJO_3pheA'
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


