<?php

require_once('../../../App/Account.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*
    --
    # Reset state before starting tests - OK

    POST /reset

    200 OK
    */

    $account = new Account();
    $account->resetAccounts();
    
    http_response_code(200);
    echo 'OK';
    exit();

}

http_response_code(500);
exit();

