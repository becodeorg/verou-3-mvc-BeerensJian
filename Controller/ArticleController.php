<?php

declare(strict_types = 1);

class ArticleController
{
    // TODO: prepare the database connection
    private DatabaseManager $databaseManager;
    public int $arrayLength;

    public function __construct(DatabaseManager $databaseManager)
    {
    $this->databaseManager = $databaseManager;
    }

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
        // Note: you might want to use a re-usable databaseManager class - the choice is yours
        // TODO: fetch all articles as $rawArticles (as a simple array)
        $sql = "SELECT * FROM articles";
        $result = $this->databaseManager->connection->query($sql, PDO::FETCH_ASSOC);
        $rawArticles = $result->fetchAll();

        $articles = [];
        foreach ($rawArticles as $rawArticle) {
            // We are converting an article from a "dumb" array to a much more flexible class
            $articles[] = new Article( $rawArticle['title'], $rawArticle['description'], $rawArticle['date'], (int)$rawArticle['id']);
        }
        $this->arrayLength = count($articles);
        return $articles;
    }

    public function show()
    {

        $sql = "SELECT * FROM articles WHERE id={$_GET['id']}";
        $dumbArticle = $this->databaseManager->connection->query($sql, PDO::FETCH_ASSOC)->fetch();
        $article = new Article($dumbArticle['title'], $dumbArticle['description'], $dumbArticle['date'], (int)$dumbArticle['id']);
        // TODO: this can be used for a detail page
        require 'View/articles/show.php';
    }

    public function nextArticle() // Returns an id based on the current id
    {
        return $_GET['id'] + 1;
    }
}