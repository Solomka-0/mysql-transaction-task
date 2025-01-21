<?php
header('Content-Type: application/json');

include_once('db.php');
include_once('model.php');

$conn = get_connect();

if (isset($_GET['user']) && is_numeric($_GET['user'])) {
    $user_id = intval($_GET['user']);
    $balances = get_user_transactions_balances($user_id, $conn);
    echo json_encode($balances);
} else {
    echo json_encode([]);
}
?>