<?php

include_once dirname(__DIR__) . '/config/config.php';

class Item{
    private $dbconnection;
    private $db = DB;
    private $host = HOST;
    private $user = USERNAME;
    private $password = PASSWORD;
    
    function __construct() 
    {        
        $this->dbconnection = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->password);
    }
    
    public function getItemById($item_id)
    {
        $query = "SELECT "
                . "name, "
                . "description, "
                . "price, "
                . "uom "                
                . "FROM items "                
                . "WHERE item_id=:item_id";
        
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':item_id', $item_id);
        return $sth->execute();
    }
    
    public function getAllItem()
    {
        $query = 'SELECT item_id, name, uom, description FROM items';
        $result = $this->dbconnection->query($query);
        return $result->fetchAll();
    }
    
    public function getItemsByOrderIn($order_id)
    {
        $query = "SELECT "
                . "i.item_id, "
                . "name, "
                . "description, "
                . "price, "
                . "uom "                
                . "FROM orders o "
                . "LEFT JOIN items i ON i.item_id=o.item_id "                
                . "WHERE order_id=:order_id AND order_inout='IN'";
        
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':order_id', $order_id);
        return $sth->execute();
    }
    
    public function getItemsByOrderOut($order_id)
    {
        $query = "SELECT "
                . "i.item_id, "
                . "name, "
                . "description, "
                . "price, "
                . "uom "                
                . "FROM orders o "
                . "LEFT JOIN items i ON i.item_id=o.item_id "                
                . "WHERE order_id=:order_id AND order_inout='OUT'";
        
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':order_id', $order_id);
        return $sth->execute();
    }
}

