<?php

/**
 * Return list of users.
 */
function get_users($conn)
{
    $sql = "
    SELECT DISTINCT u.id, u.name
    FROM users u
    JOIN user_accounts ua ON u.id = ua.user_id
    JOIN transactions t ON ua.id = t.account_from OR ua.id = t.account_to
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[$row['id']] = $row['name'];
    }
    return $users;
}

/**
 * Return transactions balances of the given user per month.
 *
 * @param int $user_id The ID of the user.
 * @param PDO $conn The database connection.
 * @return array An array of monthly balances.
 */
function get_user_transactions_balances($user_id, $conn)
{
    $sql = "
    SELECT
        strftime('%Y-%m', t.trdate) AS month,
        SUM(CASE WHEN ua.id = t.account_to THEN t.amount ELSE 0 END) -
        SUM(CASE WHEN ua.id = t.account_from THEN t.amount ELSE 0 END) AS balance
    FROM transactions t
    JOIN user_accounts ua ON ua.id = t.account_from OR ua.id = t.account_to
    WHERE ua.user_id = ?
    GROUP BY month
    ORDER BY month
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $balances = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $balances;
}