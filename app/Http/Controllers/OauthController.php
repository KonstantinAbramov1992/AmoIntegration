<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AmoCRM\Models\AccountModel;
use App\AmoCrm\AmoCrmClientFactory;

class OauthController extends Controller
{
    /**
    * @var AmoCrmClientFactory
    */
    protected AmoCrmClientFactory $clientFactory;

    public function __construct(
        AmoCrmClientFactory $clientFactory
    )
    {
        $this->clientFactory = $clientFactory;
    }

    public function install (Request $request)
    {
        $code = $request->query->get('code');
        $domain = $request->query('referer');
        $client = $this->clientFactory->createEmptyClient();
        $client->setAccountBaseDomain($domain);

        $accessToken = $client->getOAuthClient()->getAccessTokenByCode($code);

        $client->setAccessToken($accessToken);
        $account = $client->account()->getCurrent([
            AccountModel::DATETIME_SETTINGS,
        ]);
        //Здесь закончил
        $this->updateCache($account->getId(), $accessToken->getToken());

        return $code;
    }
}
