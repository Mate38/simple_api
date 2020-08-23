<?php

class Account
{
    protected $id;

    protected $balance;

    public function __construct( string $account_id, float $account_balance )
    {
        $this->id = $account_id;
        $this->balance = $account_balance;
    }

    public function getId() {
        return $this->id;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function increaseBalance($amount) {
        $this->balance += $amount;
    }

    public function decreaseBalance($amount) {
        $this->balance -= $amount;
    }

}