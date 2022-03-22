<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    pre_r($_GET);
    //echo '<h2>$_POST</h2>';
    //pre_r($_POST);
    //echo '<h2>$_COOKIE</h2>';
   // pre_r($_COOKIE);
   // echo '<h2>$_SESSION</h2>';
    //pre_r($_SESSION);

}

function pre_r($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
//include all your model files here
require 'config.php';
require 'Controller/DatabaseManager.php';
require 'Model/Article.php';
//include all your controllers here
require 'Controller/HomepageController.php';
require 'Controller/ArticleController.php';


$DatabaseManager = new DatabaseManager($config["host"], $config ["user"], $config["password"], $config["dbname"]);
$DatabaseManager->connect();
whatIsHappening();
// Get the current page to load
// If nothing is specified, it will remain empty (home should be loaded)
$page = $_GET['page'] ?? null;

// Load the controller
// It will *control* the rest of the work to load the page
switch ($page) {
    case 'articles':
        // This is shorthand for:
        // $articleController = new ArticleController;
        // $articleController->index();
        (new ArticleController($DatabaseManager))->index();
        break;
    case 'detail':
        // TODO: detail page
        (new ArticleController($DatabaseManager))->show();
    case 'home':
    default:
        (new HomepageController())->index();
        break;
}