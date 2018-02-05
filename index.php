<?php

$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
];

$pdo = new PDO('mysql:host=localhost:3306;dbname=blog', 'root', '', $pdoOptions);

if(!empty($_POST)){
    extract($_POST);
    $query = 'INSERT INTO posts (title, username, message) VALUES (:title, :pseudo, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
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
