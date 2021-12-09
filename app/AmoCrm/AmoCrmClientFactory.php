<?php
declare(strict_types=1);

namespace App\AmoCrm;

use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AmoCrmClientFactory
{
    protected array $config;

    /** @var callable|null */
    private $refreshCallback = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function setRefreshCallback(?callable $refreshCallback)
    {
        $this->refreshCallback = $refreshCallback;
    }

    public function getClient(int $accountId, string $domain, AccessTokenInterface $token): ?AmoCRMApiClient
    {

        $client = $this->createEmptyClient();

        $this->setupClient($client, $accountId, $domain, $token);

        return $client;
    }

    public function createEmptyClient(): AmoCRMApiClient
    {
        $clientSecret = $this->config['client_secret'];
        $clientId = $this->config['client_id'];
        $redirectUri = $this->config['redirect_uri'];

        $client = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);

        return $client;
    }


    public function setupClient(AmoCRMApiClient $client, int $accountId, string $domain, AccessTokenInterface $token)
    {
        $client->setAccountBaseDomain($domain);
        $client->setAccessToken($token);

        if (is_callable($this->refreshCallback)) {
            $client->onAccessTokenRefresh(function (AccessTokenInterface $newToken, string $domain) use ($accountId) {
                call_user_func($this->refreshCallback, $newToken, $domain, $accountId);
            });
        }

    }
}
