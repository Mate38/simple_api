<?php

class Account
{
    protected $file = '../Storage/accounts.json';

    protected $account;

    public function __construct( string $account_id )
    {
        if($account_id != 1234) {
            $this->account = [
                'id' => $account_id,
                'balance' => 1000
            ];
        } else {
            $this->account = null;
        }
    }

    public function getBalance() {
        if($this->account) {
            return $this->account['balance'];
        }
        return null;
    }

    public function setBalance($event_type, $amount, $origin = null) {

        if($origin) {
            $origin_account = new Account($origin);
            if(!$origin_account) {
                return null;
            }
        }

        if($this->account) {
            switch($event_type) {
                case 'deposit':
                    $this->increaseBalance($amount);
                    return $this->balance;
                case 'withdraw':
                    $this->decreaseBalance($amount);
                    return $this->balance;
                case 'transfer':
                    $this->transferBalance($amount, $origin_account);
                default:
                    return null;
            }
        } else {
            return null;
        }
    }

    private function increaseBalance($amount) {
        $this->account['balance'] += $amount;
    }

    private function decreaseBalance($amount) {
        $this->account['balance'] -= $amount;
    }

    private function transferBalance($amount, $origin_account) {
        $origin_account->decreaseBalance($amount);
        $this->increaseBalance($amount);
    }

}