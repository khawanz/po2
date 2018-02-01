<?php

include_once dirname(__DIR__) . '/config/config.php';

class User{
    private $dbconnection;
    
    function __construct($db, $host, $username, $password) 
    {
        $this->dbconnection = new PDO("mysql:db=$db;host=$host", $username, $password);
    }
    
    public function getAllUser()
    {
        $query = 'SELECT user_id, username, password, email  FROM users';
        $result = $this->dbconnection->query($query);
        return $result->fetchAll();
    }
    
    public function getUserByUsername($username)
    {
        $query = 'SELECT user_id, password, email FROM users WHERE username=:username';
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':username', $username);
        return $sth->execute();
    }
}

