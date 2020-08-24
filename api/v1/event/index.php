<?php

require_once('../../../App/Account.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*
    --
    # Create account with initial balance - OK

    POST /event {"type":"deposit", "destination":"100", "amount":10}

    201 {"destination": {"id":"100", "balance":10}}


    --
    # Deposit into existing account - OK

    POST /event {"type":"deposit", "destination":"100", "amount":10}

    201 {"destination": {"id":"100", "balance":20}}

    --
    # Withdraw from non-existing account - OK

    POST /event {"type":"withdraw", "origin":"200", "amount":10}

    404 0

    --
    # Withdraw from existing account - OK

    POST /event {"type":"withdraw", "origin":"100", "amount":5}

    201 {"origin": {"id":"100", "balance":15}}

    --
    # Transfer from existing account - OK

    POST /event {"type":"transfer", "origin":"100", "amount":15, "destination":"300"}

    201 {"origin": {"id":"100", "balance":0}, "destination": {"id":"300", "balance":15}}

    --
    # Transfer from non-existing account - OK

    POST /event {"type":"transfer", "origin":"200", "amount":15, "destination":"300"}

    404 0
    */

    $post_json = json_decode(file_get_contents('php://input'), true);

    $type = $post_json['type'];
    $amount = $post_json['amount'];
    $destination = $post_json['destination'] ?? null;
    $origin = $post_json['origin'] ?? null;

    $return = null;
    if($type == 'deposit') {
        $account = new Account($destination);
        if(!$account->exists()) {
            $account_id = $account->create($destination);
            $account = new Account($account_id);
        }
        $return = $account->deposit($amount);
    } else if($type == 'withdraw') {
        $account = new Account($origin);
        if($account->exists()) {
            $return = $account->withdraw($amount);
        }
    } else if($type == 'transfer') {
        $account = new Account($origin);
        if($account->exists()) {
            $return = $account->transfer($amount, $destination);
        }
    }

    if($return) {
        http_response_code(201);
        echo $return;
        exit();
    }

    
    http_response_code(404);
    echo 0;
    exit();

}

http_response_code(500);
exit();

