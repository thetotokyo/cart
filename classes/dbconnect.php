<?php

class DbConnect 
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'shopDB';

    protected function connect() {
        $dns = 'mysql:host='.$this->host.';dbname='.$this->database;
        $pdo = new PDO($dns, $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}


