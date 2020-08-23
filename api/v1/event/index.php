<?php
ob_clean();
header_remove();
header("Content-type: application/json; charset=utf-8");

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*
    --
    # Create account with initial balance

    POST /event {"type":"deposit", "destination":"100", "amount":10}

    201 {"destination": {"id":"100", "balance":10}}


    --
    # Deposit into existing account

    POST /event {"type":"deposit", "destination":"100", "amount":10}

    201 {"destination": {"id":"100", "balance":20}}

    --
    # Withdraw from non-existing account

    POST /event {"type":"withdraw", "origin":"200", "amount":10}

    404 0

    --
    # Withdraw from existing account

    POST /event {"type":"withdraw", "origin":"100", "amount":5}

    201 {"origin": {"id":"100", "balance":15}}

    --
    # Transfer from existing account

    POST /event {"type":"transfer", "origin":"100", "amount":15, "destination":"300"}

    201 {"origin": {"id":"100", "balance":0}, "destination": {"id":"300", "balance":15}}

    --
    # Transfer from non-existing account

    POST /event {"type":"transfer", "origin":"200", "amount":15, "destination":"300"}

    404 0
    */
    http_response_code(201);
    echo json_encode([
        'destination' => [
            'id' => '100',
            'balance' => 10
        ]
    ]);
    exit();

}

http_response_code(500);
echo json_encode(['error' => 'Rota inválida']);
exit();

