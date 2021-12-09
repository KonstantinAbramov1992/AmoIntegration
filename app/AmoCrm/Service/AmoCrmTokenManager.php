<?php
declare(strict_types=1);


namespace App\AmoCrm\Service;


use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AmoCrmTokenManager
{
        /**
    * @var AmoCrmAccountManager
    */
    protected AmoCrmAccountManager $accountManager;

    public function __construct(
        AmoCrmAccountManager $accountManager
    )
    {
        $this->accountManager = $accountManager;
    }

    public function updateCache(int $accountId, string $token)
    {
        $cacheExpires = new DateTime('@' . 24*60*60);

        Cache::put(
            sprintf('account_token_%d', $accountId),
            json_encode([
                'access_token' => $token,
                'expires' => 24*60*60,
            ]),
            $cacheExpires
        );
    }

    public function getCache(int $accountId): string
    {

        $data = Cache::get(sprintf('account_token_%d', $accountId));
        $token = null;
        if (!empty($data)) {
            $data = json_decode($data, true);
            if (!empty($data)) {
                $token = $data['access_token'];
            }
        }

        return $token;
    }

    public function getTokensByRefreshToken (int $accouIdnt) {

    }

    public function saveRefreshToken (
        int $accountId, 
        string $accountSubdomain = null, 
        string $amojoId = null, 
        string $refreshToken
        ) 
        {
        $storedAccountId = $this->accountManager->getStoredAccountId($accountId);
        
        if ($storedAccountId) {
            DB::update(
                'update amo_account_settings set refresh_token = ? where account_id = ?',
                [$refreshToken, $accountId]
            );
        } else {
            if ($accountSubdomain && $amojoId) {
                $this->accountManager->addAccountToDB($accountId, $accountSubdomain, $amojoId, $refreshToken);
            } else {
                throw new Exception("no account in db and could not get accountSubdomain && amojoId", 500);
            }
        }
    }
}
