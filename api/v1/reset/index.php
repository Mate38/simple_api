<?php

require_once('../../../App/Account.php');

ob_clean();
header_remove();
header("Content-type: application/json; charset=utf-8");

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Irá criar o accounts (array com account)
    
}

http_response_code(500);
echo json_encode(['error' => 'Rota inválida']);
exit();

