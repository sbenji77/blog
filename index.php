<?php

$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
];

$pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '', $pdoOptions);

function sanitizeValue(&$value)
{
    $value = trim(strip_tags($value));
}

function sanitizeArray(array &$array)
{
    array_walk($array, 'sanitizeValue');

}

function sanitizePost()
{
    sanitizeArray($_POST);
    // $_POST et toutes les superglobales sont accessibles dans les fonctions
}


if (!empty($_POST)) {
    sanitizePost();
    extract($_POST);
    $query = 'INSERT INTO posts (username, title, message) VALUES (:username, :title, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Blog</title>
</head>
<body>
<form method="post">
    <input type="text" name="username" placeholder="username">
    <input type="text" name="title" placeholder="title">
    <textarea type="text" name="message" placeholder="message"></textarea>
    <button type="submit">Envoyer</button>
</form>
</body>
</html>
