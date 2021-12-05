<?php

use League\OAuth2\Client\Token\AccessToken;
use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Filters\CatalogsFilter;
use AmoCRM\Models\CustomFieldsValues\LinkedEntityCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\NumericCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\LinkedEntityCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NumericCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\LinkedEntityCustomFieldValueModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Enum\InvoicesCustomFieldsEnums;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\CatalogElementModel;
use AmoCRM\Models\CustomFieldsValues\ItemsCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\LegalEntityCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\SelectCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\ItemsCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\LegalEntityCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\SelectCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\ItemsCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\LegalEntityCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\NumericCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\SelectCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use League\OAuth2\Client\Token\AccessTokenInterface;

include_once 'vendor/autoload.php';
include_once 'error_printer.php';

//Получим каталоги счетов

//$catalogsFilter = new CatalogsFilter();
//$catalogsFilter->setType(EntityTypesInterface::INVOICES_CATALOG_TYPE_STRING);

$clientId = '6aa2441c-e017-4fee-97fb-c76912cbe7b4';
$clientSecret = 'GKFbJ5khVUGyfxkEZDKPBJTd38vr46FyfjSfVZbMlw8Mh0CSaYgtUeNgWKqsOuS7';
$redirectUri = 'https://youtube.com/';
$code = 'def5020004a3ee398b2fe9f2c7c7a24346160e56c44991a33bfd11b7ee958581a8b97b0bdd4e870deadf79d41d56eb4eb225df6557b9a36478a017ff88e723c9b4ccb4b662fa6787445b47e3ab4def9ecdd8ebb57dfa238f3b49368014339add0888b84f58aeaa365f51d68127ed828365532dfb4b80ac20053c3b1ca5931c93caa4e51795a5e6ae06dcf9f460017a28e904bfd904ccd6a9de00b8946cab0f1c8e656c4315cc6bfd883daa450f1ed3f9869f85925480c00952130e01739a2f86e0822557519c53a4806c53b50acd4528a05f28fc2319fa732c8ca8f937bf63ba7ef4a77229a4024e6e83630072a4ccce23121eb60d8385b59b4551a03d7396db6c7982c733b8e73f593318bdd9ecba1d240df3f0cc86e774601759361b6e998eb0b8e577566a79e2b31b77151ec8bc938e82dafa52bc060e235226b5b87e8a9ca4bbf40fe8a85829becf1c33e341e32ead349397b98535269ebda5c3bffe950cd75cf095c47ff5c7b5d2e293d44dfa37623749f561f48d37509dba14a5a6c1fd0349950de73b94813f14e0ece324697f84dd58fdf28cfba2c2214c355665154edc050300c86da8da439cfc74ca3fa78ee2b545378ed50d1e61bca7b25fc951';

/*$accessToken = new AccessToken([
    'access_token' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ3ZDQwZmExYWY1YzUxODQ3NGYzMWNlOGVjZGZjOWZjMGYzNzgzYmY5YTQ5MWM2ZTFkZDIzYzQyNjA5ZDBhNDQxZTIxNTIzODUyMjMzOWI1In0.eyJhdWQiOiIxNmQ3ODExMi03M2ZmLTQ3MzEtODgxMi0wZWI1MGE0NGZkZGUiLCJqdGkiOiJkN2Q0MGZhMWFmNWM1MTg0NzRmMzFjZThlY2RmYzlmYzBmMzc4M2JmOWE0OTFjNmUxZGQyM2M0MjYwOWQwYTQ0MWUyMTUyMzg1MjIzMzliNSIsImlhdCI6MTYzNTg0NzU4NSwibmJmIjoxNjM1ODQ3NTg1LCJleHAiOjE2MzU5MzM5ODUsInN1YiI6IjcyNTkyNDUiLCJhY2NvdW50X2lkIjoyOTYwMzIzOSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.IHE8aXTRf0qaiAmtrr-4x3QhD_EBn2gifTz4ORnl8_Pucirsr3l0NrL4QUWnZacWHQOLyXLKunS3T3kQyolJKhjAoFsNI2Wl81A2VJmuCzlSW7qPncCmerHhCuTQSsVBUp-cZO7x-VEenJIYAiSI1p4sG8m2pJUofGndt01mhQ_r8iX36JzjX4O_uvec8fTMlhprZlSScN-kuG5MWApELa8IBZTSCTMU0oUBl0i3k4s35_QPpUHPwfN4VbYiP-AvdwKq-CtjmtiOVxF7qpW_ErHp7LcrnX5gZW-Ori_QzrP4d7XSlI42ImZaAtkmkir59YxxzWgSU7AmTBfR9_xfzA",
    'refresh_token' => "def5020052c1c0fa8a7b5ecf8d834215e9ca43f9c5963bb25b3878054ccfde6de7eed615d5f7404fa641a4f71a92255d10803d23c9d344c15ce39d0f8634929b5980c8dc92f46ea3c588c688d594ec08788256e5fd42c301898aee4c72d1976759987c065173f0feee879e9c287b609223ed3ad5413e7a4cd97997eb29138a45f9600489528e097766baf012fb32d38881f5998e76c1d2f63eeacbffc351d7bc2b6fc9086482c4bc97e4ec3ad5483e63036262d8c292ad5ad09409a737da15e6872c7d92827a32083ba02cb2886daf288e7cae1598556e61b214318c8223cf0c0edbcd956532f37822f1a8147c3aaae80fe6522fa33580c0db17cd7c87a08273b85b8696162c8b22bdf3575cd8de58afea5188996211fe3cd3002ad0dc20d83c19695e613941a6a02aa96a5e829d6cef5766415c00889cfa1c7389b1efe635829bfe6c01a4761e9ca11b7884215328d6995e6a54f436f18b989e7f2fb023163b9a1da7d3de3edc0dd28520bf54e3cfcd4be07cf63ff7e356b37dcc77e0f77803d966cb4d42bf338df0f0f7e7389bdf552c67aaf3189a0d0ff19ee3810a6258ea134941d2e851577a4b57df58aa5c4af0d6840c76dcf22ae0a9a86681c8ebf4cba5e61091bc3f55c6d043",
    'expires' => 86400,
    'baseDomain' => 'tehkabramovchatapi.amocrm.ru',
]);*/
$apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain('tehkabramovchatapi.amocrm.ru');
$accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);
$apiClient->setAccessToken($accessToken);

$catalogsFilter = new CatalogsFilter();
$catalogsFilter->setType(EntityTypesInterface::INVOICES_CATALOG_TYPE_STRING);
$invoicesCatalog = $apiClient->catalogs()->get($catalogsFilter)->first();

//Создадим новый счет
//Обязательно должно быть название и заполнено поле статус
$newInvoice = new CatalogElementModel();
//Зададим Имя
$newInvoice->setName('Счет #238');
//Зададим дату создания
$creationDate = new DateTime('2021-05-15 10:00:00');
$newInvoice->setCreatedAt($creationDate->getTimestamp());

$invoiceCustomFieldsValues = new CustomFieldsValuesCollection();
//Зададим статус
$statusCustomFieldValueModel = new SelectCustomFieldValuesModel();
$statusCustomFieldValueModel->setFieldCode(InvoicesCustomFieldsEnums::STATUS);
$statusCustomFieldValueModel->setValues(
    (new SelectCustomFieldValueCollection())
        ->add((new SelectCustomFieldValueModel())->setValue('Оплачен в аванс')) //Текст должен совпадать с одним из значений поля статус
);
$invoiceCustomFieldsValues->add($statusCustomFieldValueModel);
//Зададим комментарий
$commentCustomFieldValueModel = new TextCustomFieldValuesModel();
$commentCustomFieldValueModel->setFieldCode(InvoicesCustomFieldsEnums::COMMENT);
$commentCustomFieldValueModel->setValues(
    (new TextCustomFieldValueCollection())
        ->add((new TextCustomFieldValueModel())->setValue('Текст комментария к счету'))
);
$invoiceCustomFieldsValues->add($commentCustomFieldValueModel);
//Зададим плательщика (до поле связанная сущность, может хранить в себе связь с сущностью (контакт или компания))
$payerCustomFieldValueModel = new LinkedEntityCustomFieldValuesModel();
$payerCustomFieldValueModel->setFieldCode(InvoicesCustomFieldsEnums::PAYER);
$payerCustomFieldValueModel->setValues(
    (new LinkedEntityCustomFieldValueCollection())
        ->add(
            (new LinkedEntityCustomFieldValueModel())
                //->setName('Вася Пупкин') //Можно передать или название сущности, или ID сущности, чтобы заполнить это поле
                ->setEntityId(10348509)
                ->setEntityType(EntityTypesInterface::CONTACTS)
        )
);
$invoiceCustomFieldsValues->add($payerCustomFieldValueModel);
//Зададим юр. лицо, от имени которого выставлен счёт
$legalEntityCustomFieldValueModel = new LegalEntityCustomFieldValuesModel();
$legalEntityCustomFieldValueModel->setFieldCode(InvoicesCustomFieldsEnums::LEGAL_ENTITY);
$legalEntityCustomFieldValueModel->setValues(
    (new LegalEntityCustomFieldValueCollection())
        ->add(
            (new LegalEntityCustomFieldValueModel())
                ->setName('ООО "Рога и копыта"')
                ->setLegalEntityType(LegalEntityCustomFieldValueModel::LEGAL_ENTITY_TYPE_JURIDICAL_PERSON)
                ->setVatId('05124214')
                ->setTaxRegistrationReasonCode('0124125125')
                ->setAddress('Москва, Красная площадь, дом 1')
                ->setKpp('124352279')
                ->setBankCode('023532795')
                ->setExternalUid('125125-4457xcsf-erhery')
        )
);
$invoiceCustomFieldsValues->add($legalEntityCustomFieldValueModel);
//Зададим товары в счете
$itemsCustomFieldValueModel = new ItemsCustomFieldValuesModel();
$itemsCustomFieldValueModel->setFieldCode(InvoicesCustomFieldsEnums::ITEMS);
$itemsCustomFieldValueModel->setValues(
    (new ItemsCustomFieldValueCollection())
        ->add(
            (new ItemsCustomFieldValueModel())
                ->setDescription('Описание товара')
                ->setExternalUid('ID товара во внешней учетной системе')
                //->setProductId('ID товара в списке товаров в amoCRM') //Необзятальное поле
                ->setQuantity(10) //количество
                ->setSku('Артикул товара')
                ->setUnitPrice(150) //цена за единицу товара
                ->setUnitType('кг') //единица измерения товвара
                ->setVatRateValue(20) //НДС 20%
                ->setDiscount([
                    'type' => ItemsCustomFieldValueModel::FIELD_DISCOUNT_TYPE_AMOUNT, //amount - скидка абсолютная, percentage - скидка в процентах от стоимости товара
                    'value' => 15.15 //15 рублей 15 копеек
                ])
                ->setBonusPointsPerPurchase(20) //Сколько бонусных баллов будет начислено за покупку
        )
);
$invoiceCustomFieldsValues->add($itemsCustomFieldValueModel);
//Зададим значение поля Итоговая сумма к оплате
//Отображается в списке счетов,
//при заходе в карточку счета, стоимость счета будет рассчитана с учетом товаров, ндс и отображена в карточке счета
//Если передать некорректную сумму, то до редактирования в интерфейсе, через API будет возвращаться некорректная сумма
$priceCustomFieldValueModel = new NumericCustomFieldValuesModel();
$priceCustomFieldValueModel->setFieldCode(InvoicesCustomFieldsEnums::PRICE);
$priceCustomFieldValueModel->setValues(
    (new NumericCustomFieldValueCollection())
        ->add(
            (new NumericCustomFieldValueModel())
                ->setValue(100)
        )
);
$invoiceCustomFieldsValues->add($priceCustomFieldValueModel);
//Зададим Тип НДС
$vatTypeCustomFieldValueModel = new SelectCustomFieldValuesModel();
$vatTypeCustomFieldValueModel->setFieldCode(InvoicesCustomFieldsEnums::VAT_TYPE);
$vatTypeCustomFieldValueModel->setValues(
    (new SelectCustomFieldValueCollection())
        ->add((new SelectCustomFieldValueModel())->setValue("НДС начисляется поверх стоимости"))
);
$invoiceCustomFieldsValues->add($vatTypeCustomFieldValueModel);

//Установим значения в модель и сохраним
$newInvoice->setCustomFieldsValues($invoiceCustomFieldsValues);
$catalogElementsService = $apiClient->catalogElements($invoicesCatalog->getId());
try {
    $newInvoice = $catalogElementsService->addOne($newInvoice);
    var_dump('ID счета - ' . $newInvoice->getId());
} catch (AmoCRMApiException $e) {
    printError($e);
    die;
}
