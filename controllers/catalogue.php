<?php

require_once(__DIR__ . '/../includes/dbh.inc.php');


if ($uri == "/~plokhart/"){
    $paging_start = 0;
    $rows_per_page = 16; 

    $query_records = "SELECT * FROM recipes";
    $statement_records = $pdo->query($query_records);
    $records = $statement_records->fetchAll(PDO::FETCH_ASSOC);

    $nr_of_rows = count($records);

    $pages = ceil($nr_of_rows / $rows_per_page);


    if(isset($_GET["page-nr"])){
        $page = $_GET["page-nr"] - 1;
        $paging_start = $page * $rows_per_page;
    }


    $query_recipes = "SELECT * FROM recipes ORDER BY created_at DESC LIMIT $paging_start, $rows_per_page";
    $statement_recipes = $pdo->query($query_recipes);
    $all_recipes = $statement_recipes->fetchAll(PDO::FETCH_ASSOC);


}