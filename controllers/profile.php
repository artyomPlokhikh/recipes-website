<?php

require_once(__DIR__ . '/../includes/dbh.inc.php');



$queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
parse_str($queryString, $params);

$user_id = isset($params['id']) ? $params['id'] : null;



$query = "SELECT * FROM users WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->bindParam(':id', $user_id, PDO::PARAM_INT);
$statement->execute();
$selected_author = $statement->fetch(PDO::FETCH_ASSOC);



$query = "SELECT * FROM recipes WHERE user_id = :user_id";
$statement = $pdo->prepare($query);
$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$statement->execute();
$all_recipes = $statement->fetchAll(PDO::FETCH_ASSOC);



require "views/profile.view.php";