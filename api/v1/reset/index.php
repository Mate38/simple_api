<?php

require_once('../../../App/Account.php');

ob_clean();
header_remove();
header("Content-type: application/json; charset=utf-8");

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*
    --
    # Reset state before starting tests

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
echo json_encode(['error' => 'Rota inválida']);
exit();

