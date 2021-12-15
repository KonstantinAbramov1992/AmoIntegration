<?php
require __DIR__ . '/vendor/autoload.php';

use AmoCRM\Filters\Interfaces\HasOrderInterface;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\Factories\UnsortedModelFactory;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\Unsorted\FormsUnsortedCollection;
use AmoCRM\Collections\Leads\Unsorted\SipUnsortedCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Filters\UnsortedFilter;
use AmoCRM\Filters\UnsortedSummaryFilter;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\Unsorted\BaseUnsortedModel;
use AmoCRM\Models\Unsorted\FormsMetadata;
use AmoCRM\Models\Unsorted\FormUnsortedModel;
use AmoCRM\Models\Unsorted\SipMetadata;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Ramsey\Uuid\Uuid;

$clientId = '16d78112-73ff-4731-8812-0eb50a44fdde';
$clientSecret = 'vu1wdv1bwSq85UoaYumznASc4HLjonCmrW2QwPUPGMMHt8qVVHmIoIoTPBsWlZxQ';
$redirectUri = 'https://youtube.com';
$baseDomain = 'tehkabramov.amocrm.ru';
$code = <<<EOF
def50200683c5d1afa49fe957546c8b36395951f80e8f1580b03c2e71fd7284c94abaefa112105a0830bfcd4f5935df9c4155d983a7a0ec25c5798c9d6d3d296032c0331b3d696207d7899a744293f136bef88ab09054733d6d5daccf19a072c2dc04935a81c1c82fb8a38cf66d9c6af2422f70a815b1515c33ea9c774f5ff1e01c761cdd7237bb349cccd863546a9c935a8e3ab5cb6477c367dcc7acc665172356bad73f8f5d88e686c03ace90e731cfe005c79c205a0fd344aa7a0f1d7e2cb676affdfa872df4b86710c06b2059956de7037ee52a403df5b363e4a2124bc834f4ef1349f72c67515186891d15db506d86ff675a0bfc052e2011a421f762dcc0043021248f97a9d09b1f9d11938d919deb005bdb839b402e901ce7817cc8af67060a016fbe97b788142b5c439eb84c75ec60386782621e869646c8ea46064ae0a1b1a0f5176ec29f9798102297841cba805fe93da537a321c1bc8b15845b6f91d1df0ba5089885b65cedeff29e59ea62ed56feaf2f74dbd547de6e9fd7a6361cba374ff661745b9a5a9adca548274a8888c46d65fbc858ed85c3673cf5ab1079857d4ce09562a5ad70e3314859ece913aec6345812fda9e8fb5d328c5
EOF;
try {
    $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
    $apiClient->setAccountBaseDomain($baseDomain);
    
    $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);
    
    $apiClient->setAccessToken($accessToken);
    
    $unsortedService = $apiClient->unsorted();
} catch (AmoCRMApiException $e) {
    var_dump($e);
}

for ($i=0;$i<6;$i++) {
    $formsUnsortedCollection = new FormsUnsortedCollection();
    $formUnsorted = new FormUnsortedModel();
    $formMetadata = new FormsMetadata();
    $formMetadata
        ->setFormName('Обратная связь')
        ->setFormPage('https://example.com/form')
        ->setFormSentAt(time())
        ->setReferer('https://google.com/search');

    $unsortedLead = new LeadModel();
    $unsortedLead->setName('Сделка')
        ->setPrice(500000);

    $unsortedContactsCollection = new ContactsCollection();
    $unsortedContact = new ContactModel();
    $unsortedContact->setName('Контакт');
    $contactCustomFields = new CustomFieldsValuesCollection();
    $phoneFieldValueModel = new MultitextCustomFieldValuesModel();
    $phoneFieldValueModel->setFieldCode('PHONE');
    $phoneFieldValueModel->setValues(
        (new MultitextCustomFieldValueCollection())
            ->add((new MultitextCustomFieldValueModel())->setValue('+79123456789'))
    );
    $unsortedContact->setCustomFieldsValues($contactCustomFields->add($phoneFieldValueModel));
    $unsortedContactsCollection->add($unsortedContact);

    $formUnsorted
        ->setSourceUid(uniqid())
        ->setCreatedAt(time())
        ->setMetadata($formMetadata)
        ->setLead($unsortedLead)
        ->setContacts($unsortedContactsCollection);

    $formsUnsortedCollection->add($formUnsorted);

    try {
        $formsUnsortedCollection = $unsortedService->add($formsUnsortedCollection);
    } catch (AmoCRMApiException $e) {
        var_dump($e);
        die;
    }
    $formUnsorted = $formsUnsortedCollection->first();

    try {
        $unsortedFiler = new UnsortedFilter();
        $unsortedFiler
            ->setCategory([BaseUnsortedModel::CATEGORY_CODE_FORMS,  BaseUnsortedModel::CATEGORY_CODE_SIP])
            ->setOrder('created_at', HasOrderInterface::SORT_ASC);
        $unsortedCollection = $unsortedService->get($unsortedFiler);
    } catch (AmoCRMApiException $e) {
        var_dump($e);
        die;
    }
}
