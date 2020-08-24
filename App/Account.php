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
        
        return json_encode([
            "destination" => [
                "id" => $this->account_id, 
                "balance" => $this->account['balance']
            ]
        ]);
    }

    public function withdraw($amount, $save = true) {

        $this->account['balance'] -= $amount;
        
        if($save) {
            $this->saveAccounts();
        }

        return json_encode([
            "origin" => [
                "id" => $this->account_id, 
                "balance" => $this->account['balance']
            ]
        ]);
    }

    public function transfer($amount, $destination) {

        $destination_account = new Account($destination);
        
        if(!$destination_account->exists()) {
            $account_id = $this->create($destination);
            $destination_account = new Account($account_id);
        }

        $account_balance = $this->withdraw($amount, false);
        $destination_balance = $destination_account->deposit($amount, false);

        $this->accounts[$this->account_id] = $this->account;
        $this->accounts[$destination] = $destination_account->getAccount();
        file_put_contents($this->accounts_path, json_encode($this->accounts));

        return json_encode([
            "origin" => [
                "id" => $this->account_id, 
                "balance" => $this->account['balance']
            ],
            "destination" => [
                "id" =>  $destination, 
                "balance" => $destination_account->getBalance()
            ]
        ]);
    }

    public function saveAccounts() {
        $this->accounts[$this->account_id] = $this->account;
        file_put_contents($this->accounts_path, json_encode($this->accounts));
    }

    public function resetAccounts() {
        file_put_contents($this->accounts_path, '');
    }

}