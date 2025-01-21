<?php

include_once('db.php');
include_once('model.php');

$conn = get_connect();
$users = get_users($conn);

$month_names = [
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User transactions information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>User transactions information</h1>
<form id="user-form">
    <label for="user">Select user:</label>
    <select name="user" id="user">
        <option value="">-- Select user --</option>
        <?php
        foreach ($users as $id => $name) {
            echo "<option value=\"$id\">".$name."</option>";
        }
        ?>
    </select>
</form>

<div id="data">
    <!-- Данные будут загружаться сюда -->
</div>

<script src="script.js"></script>
</body>
</html>