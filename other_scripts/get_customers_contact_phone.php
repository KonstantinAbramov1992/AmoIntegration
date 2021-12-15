<?php
use AmoCRM\Collections\Customers\Segments\SegmentsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Filters\CustomersFilter;
use AmoCRM\Models\Customers\CustomerModel;
use AmoCRM\Models\Customers\Segments\SegmentModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NullCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use League\OAuth2\Client\Token\AccessTokenInterface;

require 'vendor/autoload.php';

$clientId = '2c81d8dc-8dfb-49db-ab33-269dec15b1e7';
$clientSecret = 'tP5ErVOt3Xvj405IKHNZZnubI5g5cuBKtptOZSCkiINmVtumGTfP99aZGHjfyezw';
$redirectUri = 'https://youtube.com/';
$baseDomain = 'tehkabramov.amocrm.ru';
$code = <<<EOF
def50200d6cd312a07731fde12728d32d4e466c1742aea374f3b936e8d6cb53dc22dae166e0152ef19fb062a01d827278b00a32900520c446c1b20019d3cc3ebe0e972bd62ba48448423729f9a1a73704e666389b65b8e64be17d6164bf597ba7e9ce40165f66e05d4d8c71d60bae6d124299b75e4e374a347d1441882b0cf5c7930ce445fb6c82966664a6d87f430f4a0ca071bf4fee089f597b719da3c070c1b54b1b3af1b7186d797f97cdf642f30ebcf1532a05889528f12f3d1c180536fb4aa262df5ebc789b88a3d9ca307b1f987d0da02bca2d156a92f4dc9e5303654c6f58a7d531e91c82ef16ce678c32b860b664bc934f41acf1ab60b7e9e19a7e5ec080acb70551eec906857f2c18e9107c89cae45d759d5e0e5204bc36a52af31f0a1d528c716d3c5b31f66a78f6e81c9cd0c82b31f012468da0a140c4005a2bda06c374965e3fe3727d239b0c720815d8443486d318d088e15b1c3995641b2cb8e09b9890b25301f0b522e5e3df0a48319818347174101d98c21503061748adc8367e19642725d5135e1e5d8a4b5a460ff1f0e072e0f0cc7440abd14d6b22f50a1cd1ca7df76ee0a0b21f649f38b6bb36e91db6903ed1c7e764a06223bc398
EOF;

$scope_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d_989186f9-e54f-4b03-be7d-2414b016be28';

$account_id = '989186f9-e54f-4b03-be7d-2414b016be28';

$apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain($baseDomain);

$accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);

$apiClient->setAccessToken($accessToken);

$customersService = $apiClient->customers();
$contactsService = $apiClient->contacts();

$customer = new CustomerModel();
$customer->setName('Byuer');

try {
    $customer = $customersService->addOne($customer);
} catch (AmoCRMApiException $e) {
    printError($e);
    die;
}

try {
    $contact = $contactsService->getOne(9204111);
    $contact->setIsMain(false);
} catch (AmoCRMApiException $e) {
    printError($e);
    die;
}

$links = new LinksCollection();
$links->add($contact);
try {
    $customersService->link($customer, $links);
} catch (AmoCRMApiException $e) {
    printError($e);
    die;
}

//Создадим фильтр по id покупателя
/*$filter = new CustomersFilter();
$filter->setQuery();

//Получим покупателя по фильтру
try {
    $customers = $customersService->get($filter);
} catch (AmoCRMApiException $e) {
    printError($e);
    die;
}*/