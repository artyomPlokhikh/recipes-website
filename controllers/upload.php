<?php

require_once(__DIR__ . '/../functions.php');

$units = ['Please select...', 'bag', 'bar', 'bulb', 'capsule', 'cl', 'clove', 'cup', 'drop', 'g', 'gallon', 'head', 'kg', 'l', 'lb', 'leaf', 'loaf', 'meter', 'ml', 'package', 'piece', 'pinch', 'pint', 'scoop', 'sheet', 'slice', 'spoon', 'stick', 'tea bag', 'tea spoon'];


if (!isset($_SESSION["user_id"]))
{
    header("Location: /");
    exit();
}



/**
 * Checks and displays any upload errors associated with a specific error key.
 *
 * @param string $error Error key to check.
 */
function check_upload_errors($error): void {
    if (isset($_SESSION["errors_upload"][$error])) {
        echo "<p style='color: red;font-size: 14px;'>". $_SESSION["errors_upload"][$error] ."</p>";
        unset($_SESSION["errors_upload"][$error]);
    }
}



/**
 * Checks and displays upload errors related to image upload.
 */
function check_upload_errors_image(): void {
    check_upload_errors("invalid_image_ext");
    check_upload_errors("image_errors");
    check_upload_errors("image_small");
    check_upload_errors("image_big");
}


/**
 * Checks and displays upload errors related to ingredient upload.
 */
function check_upload_errors_ingredients(): void {
    check_upload_errors("invalid_ingredientAmount");
    check_upload_errors("empty_ingredientAmount");
    check_upload_errors("invalid_ingredientUnit");
    check_upload_errors("no_ingredients");
}



require('views/upload.view.php');