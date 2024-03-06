<?php
require_once(__DIR__ . '/../includes/dbh.inc.php');


$queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);


require "views/index.view.php";