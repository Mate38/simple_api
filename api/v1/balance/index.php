<?php

require_once('../../../App/Account.php');

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    if(isset($_GET['account_id'])) {

        /*
        --
        # Get balance for non-existing account - OK

        GET /balance?account_id=1234

        404 0

        --
        # Get balance for existing account - OK

        GET /balance?account_id=100

        200 20
        */
        $account = new Account($_GET['account_id']);

        if($account->exists()) {
            $balance = $account->getBalance();
            if($balance) {
                http_response_code(200);
                echo $balance;
                exit();
            }
        }       

        http_response_code(404);
        echo 0;
        exit();

    }

}

http_response_code(500);
exit();