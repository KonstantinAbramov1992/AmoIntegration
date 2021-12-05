<?php
declare(strict_types=1);


namespace App\AmoCrm\Service;


use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\AmoCrm\AmoCrmClientFactory;
use App\AmoCrm\Entities\AccountSettings;
use App\AmoCrm\Repositories\AccountSettingsRepository;
use DateTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Psr\Log\LoggerInterface;

class AmoCrmTokenManager
{

    protected AmoCrmClientFactory $clientFactory;
    private AccountSettingsRepository $repo;
    private LoggerInterface $logger;

    public function __construct(
        AmoCrmClientFactory $clientFactory,
        AccountSettingsRepository $amoTokenRepository
    )
    {
        $this->repo = $amoTokenRepository;
        $this->logger = Log::channel('stderr');
        $this->clientFactory = $clientFactory;

        $this->clientFactory->setRefreshCallback(function (AccessTokenInterface $newToken, string $domain, int $accountId) {
            $this->logger->warning(sprintf('Token for account %d %s was autorefreshed', $accountId, $domain), ['newToken' => $newToken->jsonSerialize()]);
            $this->storeAccountToken($accountId, $domain, $newToken);
        });
    }

    /**
     * @param int $accountId
     * @param string $domain
     * @param AccessTokenInterface $token
     * @return \App\AmoCrm\Entities\AccountSettings|null
     */
    public function storeAccountToken(int $accountId, string $domain, AccessTokenInterface $token): AccountSettings
    {
        $item = $this->repo->findOneByAccount($accountId);

        if ($item) {
            $this->logger->info('Token found in db', [$item->getAccountId()]);
            $item->setRefreshToken($token->getRefreshToken());
            $item->setDomain($domain);
        } else {
            $item = $this->repo->create($accountId, $domain, $token->getRefreshToken());
        }

        $this->updateCache($accountId, $token);

        $item->save();
        $this->logger->info('token updated', [$item->toArray()]);
        return $item;
    }

    public function getAccount(int $accountId): ?AccountSettings
    {
        $item = $this->repo->findOneByAccount($accountId);
        if (empty($item)) {
            return null;
        }

        return $item;
    }

    public function getAccessToken(int $accountId): ?AccessTokenInterface
    {
        $cachedToken = $this->getCache($accountId);

        if ($cachedToken && !$cachedToken->hasExpired()) {
            return $cachedToken;
        }
        if ($cachedToken) {
            $this->logger->info(sprintf('Token for account %d has expired', $accountId));
        }

        $item = $this->getAccount($accountId);
        if (empty($item)) {
            $this->logger->warning(sprintf('Token for account %d not found in database', $accountId));
            return null;
        }

        $refreshToken = new AccessToken([
            'access_token' => 'dummy',
            'refresh_token' => $item->getRefreshToken(),
        ]);

        $accessToken = null;
        try {
            $client = $this->clientFactory->getClient($accountId, $item->getDomain(), $refreshToken);
            $accessToken = $client->getOAuthClient()->getAccessTokenByRefreshToken($refreshToken);

            $this->logger->info('Access Token After Refresh Exchanges', [$accessToken]);

            $this->storeAccountToken($accountId, $client->getAccountBaseDomain(), $accessToken);

        } catch (AmoCRMoAuthApiException $e) {
            $this->logger->error('Error in refresh token exchange', [$e->getMessage()]);
        }

        return $accessToken;
    }

    private function updateCache(int $accountId, AccessTokenInterface $token)
    {
        $cacheExpires = null;
        try {
            $cacheExpires = new DateTime('@' . $token->getExpires());
        } catch (\Exception $e) {
            $this->logger->warning('Failed create date ' . $e->getMessage(), ['exp' => $token->getExpires()]);
        }
        Cache::put(
            sprintf('account_token_%d', $accountId),
            json_encode([
                'access_token' => $token->getToken(),
                'refresh_token' => $token->getRefreshToken(),
                'expires' => $token->getExpires(),
            ]),
            $cacheExpires
        );
    }

    private function getCache(int $accountId): ?AccessTokenInterface
    {

        $data = Cache::get(sprintf('account_token_%d', $accountId));
        $token = null;
        if (!empty($data)) {
            $data = json_decode($data, true);
            if (!empty($data)) {
                $token = new AccessToken($data);
            }
        }

        $this->logger->info(sprintf('Token for account %d %s in cache', $accountId, $token ? 'found' : 'not found'));

        return $token;
    }
}
