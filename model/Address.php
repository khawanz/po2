<?php

include_once dirname(__DIR__) . '/config/config.php';

class Address{
    private $dbconnection;
    
    function __construct($db, $host, $username, $password) 
    {
        $this->dbconnection = new PDO("mysql:db=$db;host=$host", $username, $password);
    }
    
    public function getAllAddress()
    {
        $query = 'SELECT place_id, label_name, address FROM places';
        $result = $this->dbconnection->query($query);
        return $result->fetchAll();
    }
}

