<?php

declare(strict_types = 1);

class ArticleController
{
    private $config ;

    public function index()
    {
        // Load all required data

        $articles = $this->getArticles();

        // Load the view
        require 'View/articles/index.php';
    }

    // Note: this function can also be used in a repository - the choice is yours
    private function getArticles()
    {
        include 'config.php';
        // TODO: prepare the database connection
        $DatabaseManager = new DatabaseManager($config["host"], $config ["user"], $config["password"], $config["dbname"]);
        $DatabaseManager->connect();
        // Note: you might want to use a re-usable databaseManager class - the choice is yours
        // TODO: fetch all articles as $rawArticles (as a simple array)
        $sql = "SELECT * FROM articles";
        $result = $DatabaseManager ->connection->query($sql, PDO::FETCH_ASSOC);
        $rawArticles = $result->fetchAll();


        $articles = [];
        foreach ($rawArticles as $rawArticle) {
            // We are converting an article from a "dumb" array to a much more flexible class
            $articles[] = new Article($rawArticle['title'], $rawArticle['description'], $rawArticle['date']);
        }

        return $articles;
    }

    public function show()
    {
        // TODO: this can be used for a detail page
    }
}