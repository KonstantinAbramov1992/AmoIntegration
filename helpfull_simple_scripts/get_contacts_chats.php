<?php

$method = 'GET';
$contentType = 'application/json';
$path = "api/v4/contacts/chats";

$url = "https://tehkabramov.amocrm.ru/$path";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_HTTPHEADER => array(
        "Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU4M2MyMGI2NzNiYjY0NDE2YzJkYTgzNTRkMWNmNTk5N2M4YTU5YzUxYzJmYmVlMGM5NzdlNjhiMjBmM2E4MmE0YWE2M2IwZDBiM2NkYWMxIn0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiJlODNjMjBiNjczYmI2NDQxNmMyZGE4MzU0ZDFjZjU5OTdjOGE1OWM1MWMyZmJlZTBjOTc3ZTY4YjIwZjNhODJhNGFhNjNiMGQwYjNjZGFjMSIsImlhdCI6MTYzNzc1NDkxMiwibmJmIjoxNjM3NzU0OTEyLCJleHAiOjE2Mzc4NDEzMTIsInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.qow4cVnoKuMxwhnckKq1DPkqUyaqZ0nEuqhuhL3zin-YwBp00CgTT02ux2uEDLxWcBBMvCi4itSRW34lmokVpwj2DGo4RQ8lSKH911_nPZRV6Pm_eF_YEZetW3ZZzFJrLdyPrI9hzKMcnKBoBgT2LX0R9mMoH3aHXg-07x0vhGN7CnyeP-upEF_gM9LQSFMYYZRe3a9RCwmJK_YWPDXIGvOkFMjeF4aC-LHROcNfT6A-R4vBhQ1XCFWUx1YYnF29JERv5NIkXLnex11a37TiFJfKVfms8Uzzui_a3STZDIrWDo0bhzQbSfMzELpGqwNq4wFbDsyhHELkQZYbXqw3VQ"
    )
]);

$response = curl_exec($curl);
$err = curl_error($curl);
$info = curl_getinfo($curl);
curl_close($curl);
if ($err) {
    $result = "cURL Error #:" . $err;
} else {
    echo "Status: " . $info['http_code'] . PHP_EOL;
    echo $response . PHP_EOL;
}
