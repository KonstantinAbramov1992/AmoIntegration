<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AmoCrm\AmoCrmClientFactory;
use App\AmoCrm\Service\AmoCrmTokenManager;
use App\AmoCrm\Service\AmoCrmAccountManager;

class OauthController extends Controller
{
    /**
    * @var AmoCrmClientFactory
    */
    protected AmoCrmClientFactory $clientFactory;

    /**
    * @var AmoCrmTokenManager
    */
    protected AmoCrmTokenManager $tokenManager;

    /**
    * @var AmoCrmAccountManager
    */
    protected AmoCrmAccountManager $accountManager;

    public function __construct(
        AmoCrmClientFactory $clientFactory,
        AmoCrmTokenManager $tokenManager,
        AmoCrmAccountManager $accountManager
    )
    {
        $this->clientFactory = $clientFactory;
        $this->tokenManager = $tokenManager;
        $this->accountManager = $accountManager;
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
            'amojo_id',
        ]);

        $accountId = $account->getId();
        $accountSubdomain = $account->getSubdomain();
        $amojoId = $account->getAmojoId();

        $this->tokenManager->updateCache($accountId, $accessToken->getToken());
        $this->tokenManager->saveRefreshToken($accountId, $accountSubdomain, $amojoId, $accessToken->getRefreshToken());

        return 'ok';
    }

    public function uninstall (Request $request) {
        $accountId = $request->query->get('account_id');
        file_put_contents('amoId.txt', json_encode($this->accountManager->getStoredAmojoId($accountId)));
        $amojoId = $this->accountManager->getStoredAmojoId($accountId)[0]->amojo_id;
        $this->accountManager->disconnectChannelFromAccount($amojoId);
        $this->accountManager->deleteAccount($accountId);
    }
}
