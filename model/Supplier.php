<?php

include_once dirname(__DIR__) . '/config/config.php';

class Supplier{
    private $dbconnection;
    
    function __construct($db, $host, $username, $password) 
    {
        $this->dbconnection = new PDO("mysql:db=$db;host=$host", $username, $password);
    }
    
    public function getAllSupplier()
    {
        $query = 'SELECT supplier_id, name, pic_name, pic_hp FROM suppliers';
        $result = $this->dbconnection->query($query);
        return $result->fetchAll();
    }
}

