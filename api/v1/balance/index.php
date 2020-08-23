<?php

require_once('../../../App/Account.php');

$account = new Account('100', 1000);

ob_clean();
header_remove();
header("Content-type: application/json; charset=utf-8");

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    if(isset($_GET['account_id'])) {

        /*
        --
        # Get balance for non-existing account

        GET /balance?account_id=1234

        404 0

        --
        # Get balance for existing account

        GET /balance?account_id=100

        200 20
        */
        if($_GET['account_id'] == 1234) {
            http_response_code(404);
            echo 0;
            exit();
        }

    }

}

http_response_code(500);
echo json_encode(['error' => 'Rota inválida']);
exit();