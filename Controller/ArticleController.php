<?php

declare(strict_types = 1);

class ArticleController
{
    // TODO: prepare the database connection
    private DatabaseManager $databaseManager;

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
        return $articles;
    }

    public function show()
    {

        // if ($_GET['id'] == 0) {
        //     $_GET['id'] = 1;
        // } elseif ($_GET['id'] > $this->getCount()) {
        //     $_GET['id'] = $this->getCount();
        // }
        
        $nextid = $this->getNextID();
        $previd = $this->getPrevID();
        
        
        pre_r($this->getNextID());
        echo $this->getMaxID();

        $sql = "SELECT * FROM articles WHERE id={$_GET['id']}";
        $dumbArticle = $this->databaseManager->connection->query($sql, PDO::FETCH_ASSOC)->fetch();
        $article = new Article($dumbArticle['title'], $dumbArticle['description'], $dumbArticle['date'], (int)$dumbArticle['id'], $dumbArticle['image_url']);

        // TODO: this can be used for a detail page
        require 'View/articles/show.php';
    }

    private function getCount()
    {
        $sql = "SELECT COUNT(*) FROM articles";
        $result = $this->databaseManager->connection->query($sql, PDO::FETCH_NUM)->fetch();
        return $result[0];
    }

    private function getNextID() 
    {
        $sql = "SELECT id FROM articles WHERE id > {$_GET['id']}";
        try {
            $nextID = $this->databaseManager->connection->query($sql, PDO::FETCH_NUM)->fetch();
            if ($nextID == false) {
                return $this->getMinID();
            } else {
                return $nextID[0];
            }
        } catch(PDOException $e) {
            echo "<br>" . $e->getMessage();
        }
    }

    private function getPrevID() 
    {
        $sql = "SELECT id FROM articles WHERE id < {$_GET['id']} ORDER BY id DESC";
        try {
            $prevID = $this->databaseManager->connection->query($sql, PDO::FETCH_NUM)->fetch();
            if ($prevID == false) {
                return $this -> getMaxID(); 
            } else {
                return $prevID[0];
            }
        } catch(PDOException $e) {
            echo "<br>" . $e->getMessage();
        }
    }

    private function getMaxID() 
    {
        $sql= "SELECT MAX(id) FROM articles";
        $maxid = $this->databaseManager->connection->query($sql, PDO::FETCH_NUM)->fetch();
        return $maxid[0];
    }

    private function getMinID() 
    {
        $sql= "SELECT MIN(id) FROM articles";
        $maxid = $this->databaseManager->connection->query($sql, PDO::FETCH_NUM)->fetch();
        return $maxid[0];
    }
}


