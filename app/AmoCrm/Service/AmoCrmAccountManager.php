<?php
declare(strict_types=1);

namespace App\AmoCrm\Service;

use Illuminate\Support\Facades\DB;

class AmoCrmAccountManager
{
    public function deleteAccount (int $accountId) {
        DB::delete(
            'delete from amo_account_settings where account_id = ?', 
            [$accountId]
        );
    }

    public function addAccountToDB (int $accountId, string $accountSubdomain, string $amojoId, string $refreshToken) {
        $scopeId = $this->getScopeId($amojoId);
        DB::insert(
            'insert into amo_account_settings (account_id, amojo_id, scope_id, domain, refresh_token) values (?, ?, ?, ?, ?)', 
            [$accountId, $amojoId, $scopeId, $accountSubdomain, $refreshToken]
        );
    }

    private function getScopeId (string $amojoId) {
        $secret = 'ec16c4876da4102bc43692d23afcd2eb0a023ce4';
        $channel_id = '0fb1afb7-8c4d-40ee-a406-1e9736598b4d';
        $account_id = $amojoId;
        $body = json_encode([
            'account_id' => $account_id,
            'hook_api_version' => 'v2'
        ]);
        $signature = hash_hmac('sha1', $body, $secret);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://amojo.amocrm.ru/v2/origin/custom/{$channel_id}/connect",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/json",
                "X-Signature: {$signature}"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            file_put_contents('curl_err_get_scope_id_' . $account_id . '.txt', $err);
        } else {
            return json_decode($response)->scope_id;
        }
    }

    public function getStoredAccountId (int $accountId) {
        return DB::select('select account_id from amo_account_settings where account_id = ?', [$accountId]);
    }
}
