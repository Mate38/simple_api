<?php

require_once('../../../App/Config.php');

class Account
{
    protected $accounts;

    protected $account;

    protected $account_id;

    protected $accounts_path;

    public function __construct( $account_id = null )
    {
        $this->accounts_path = (new Config)->getConfig('ACCOUNTS_PATH');
        $this->accounts = json_decode(file_get_contents($this->accounts_path), true);
        $this->account = $this->accounts[$account_id] ?? null;
        $this->account_id = $account_id;
    }

    public function create($account_id) {

        $this->accounts[strval($account_id)] = [
            'balance' => 0
        ];

        file_put_contents($this->accounts_path, json_encode($this->accounts));
        return $account_id;
    }

    public function exists() {
        return $this->account ? true : false;
    }

    public function getBalance() {

        if($this->account) {
            return $this->account['balance'];
        }

        return null;
    }

    public function getAccount() {

        if($this->account) {
            return $this->account;
        }

        return null;
    }

    public function deposit($amount, $save = true) {

        $this->account['balance'] += $amount;

        if($save) {
            $this->saveAccounts();
        }
        return $this->account['balance'];
    }

    public function withdraw($amount, $save = true) {

        $this->account['balance'] -= $amount;
        
        if($save) {
            $this->saveAccounts();
        }
        return $this->account['balance'];
    }

    public function transfer($amount, $origin) {

        $origin_account = new Account($origin);
        
        if(!$origin_account->exists()) {
            return null;
        }

        $origin_balance = $origin_account->withdraw($amount, false);
        $account_balance = $this->deposit($amount, false);

        $this->accounts[$this->account_id] = $this->account;
        $this->accounts[$origin] = $origin_account->getAccount();
        file_put_contents($this->accounts_path, json_encode($this->accounts));

        return json_encode(['teste' => 'teste']);
    }

    public function saveAccounts() {
        $this->accounts[$this->account_id] = $this->account;
        file_put_contents($this->accounts_path, json_encode($this->accounts));
    }

    public function resetAccounts() {
        file_put_contents($this->accounts_path, '');
    }

}