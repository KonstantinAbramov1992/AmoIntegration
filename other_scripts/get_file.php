<?php

$access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImY4MWFkYTY2M2M4OTJiOWUwZjEzNDJiZjhlYWU0MzVjMGU4NWVlNWNlYzkyNDdmYzk5N2I2NzIxZDE3ZDEyMGE0Y2JmYzBhNmE3NDkxNGQ2In0.eyJhdWQiOiIyYzgxZDhkYy04ZGZiLTQ5ZGItYWIzMy0yNjlkZWMxNWIxZTciLCJqdGkiOiJmODFhZGE2NjNjODkyYjllMGYxMzQyYmY4ZWFlNDM1YzBlODVlZTVjZWM5MjQ3ZmM5OTdiNjcyMWQxN2QxMjBhNGNiZmMwYTZhNzQ5MTRkNiIsImlhdCI6MTYzMTE5NDE3NywibmJmIjoxNjMxMTk0MTc3LCJleHAiOjE2MzEyODA1NzcsInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.sE8MEWu8cwzCZySo-PwNPL5HQ4Ra_rkVQ6MXGZrGCjbxuk9MFTZJHcHql4s6u6TrcAy3LVBTnu3lhunXgVuQpLEzCTdrkl2nATo9ExPDJ_yDeDVfilLVaAD1aDFpXEMrlgnabP7MCe7a3Vdio3jMVSNIaHgzGrq5m8z41pGud3yBLQv3dR2xSxBf80ioYHfVyvEO76a23fvjog1xQ19ItWn1LFnWFGOe2ek69l7W7SZJIRzLvub6gqa_jCu6n89AjqQqogNHX5JaKU8HwHf4IkzmUmuD9xCoT22Cn4-jAjrnSHccEHGzuyOzVd9qVU7VF7UOJiNrGwtqHzkfM-x-8Q";

$ch = curl_init();
$fp = fopen('logo.jpg', 'wb');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_URL, 'https://telecomdom.com/wp-content/uploads/2020/02/kartinki-na-telefon-5-576x1024.jpg');
curl_setopt($ch, CURLOPT_FILE, $fp);
//curl_setopt($ch, CURLOPT_HEADER, ["Authorization: Bearer $access_token"]);
curl_exec($ch);
curl_close($ch);
fclose($fp);
