<?php

class DatabaseManager
{
private string $host;
private string $user;
private string $password;
private string $dbname;

// variable to save our connection to the database
public PDO $connection;

public function __construct(string $host, string $user, string $password, string $dbname)
{
    $this -> host = $host;
    $this -> user = $user;
    $this -> password = $password;
    $this -> dbname = $dbname;
}

public function connect()
{
    try {
        // make connetion to DB with PDO
        $dsn = "mysql:host={$this ->host};dbname={$this ->dbname}";
        $this ->connection = new PDO($dsn, $this->user,$this->password);
        $this -> connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }

}



}