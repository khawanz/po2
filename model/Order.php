<?php

include_once dirname(__DIR__) . '/config/config.php';

class Order 
{
    private $dbconnection;
    private $db = DB;
    private $host = HOST;
    private $user = USERNAME;
    private $password = PASSWORD;
    
    function __construct() 
    {        
        $this->dbconnection = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->password);
    }
    
    public function getOrderById($id)
    {
        $query = "SELECT "
                . "order_number, "
                . "s.name AS supplier_name, "
                . "order_inout, "
                . "status, "
                . "total "
                . "FROM orders o "
                . "LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE order_id=:order_id";
        
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':order_id', $id);
        return $sth->execute();
    }
    
    public function getOrderByYear($year)
    {
        $query = "SELECT "
                . "order_number, "
                . "s.name AS supplier_name, "
                . "order_inout, "
                . "status, "
                . "total "
                . "FROM orders o "
                . "LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE year(o.created_at)=:year";
        
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':year', $year, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function getAllOrder()
    {
        $query = 'SELECT '
                . 'order_id, '
                . 'order_number, '
                . 's.name AS supplier_name, '
                . 'order_inout, '
                . 'status, '
                . 'total '
                . 'FROM orders o'
                . 'LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id';
        $result = $this->dbconnection->query($query);
        return $result->fetchAll();
    }
    
    public function getOrderBySupplier($supplier_id)
    {
        $query = "SELECT "
                . "order_number, "
                . "s.name AS supplier_name, "
                . "order_inout, "
                . "status, "
                . "total "
                . "FROM orders o "
                . "LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE supplier_id=:supplier_id";
        
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':supplier_id', $supplier_id);
        return $sth->execute();
    }
    
    public function getTopSupplier()
    {
        $query = "SELECT s.name AS supplier_name,
                count(*) AS order_count 
                FROM orders o
                LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id
                GROUP BY s.name
                ORDER BY order_count DESC";
        
        return $this->dbconnection->query($query);
    }
    
    public function getTotalOrderByStatusOrder()
    {
        $query = "SELECT status,"
                . " COUNT(status) AS order_total "
                . "FROM orders o GROUP BY status ";
        
        return $this->dbconnection->query($query, PDO::FETCH_ASSOC);                
    }
    
    public function getTotalOrderGroupByYear()
    {
        $query = "SELECT s.name AS supplier_name, "
                . "COUNT(order_id) AS order_total, "
                . "year(o.created_at) AS period "
                . "FROM orders o LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE o.order_inout = 'IN' "
                . "GROUP BY period, supplier_name ";
        
        return $this->dbconnection->query($query, PDO::FETCH_ASSOC); 
    }
    
    public function getTotalOrderGroupByMonth($year)
    {
        $query = "SELECT s.name AS supplier_name, "
                . "COUNT(order_id) AS order_total, "
                . "month(o.created_at) AS period "
                . "FROM orders o LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE o.order_inout = 'IN' AND year(o.created_at) = :year "
                . "GROUP BY period, supplier_name ";
        
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':year', $year, PDO::PARAM_STR);
        $sth->execute();
        
        return $sth->fetchAll(); 
    }
    
    public function getTotalOrderGroupByWeek()
    {
        $query = "SELECT s.name AS supplier_name, "
                . "COUNT(order_id) AS order_total, "
                . "day(o.created_at) AS period "
                . "FROM orders o "
                . "LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE o.order_inout = 'IN' AND o.created_at BETWEEN DATE_ADD(NOW(), INTERVAL -6 DAY) AND NOW() "
                . "GROUP BY period, supplier_name ";
        
        $sth = $this->dbconnection->query($query);                
        
        return $sth->fetchAll(); 
    }
    
    public function getTotalItemByYear()
    {
        $query = "SELECT i.name, "
                . "SUM(oi.quantity) AS total, "
                . "year(o.created_at) as period "
                . "FROM orders o "
                . "LEFT JOIN order_item oi ON o.order_id=oi.order_id "
                . "LEFT JOIN items i ON i.item_id=oi.item_id "
                . "LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE o.order_inout = 'IN' "
                . "GROUP BY period, i.name ";
               
        $result = $this->dbconnection->query($query);        
        return $result->fetchAll();
    }
    
    public function getTotalItemByMonth($year)
    {
        $query = "SELECT i.name, "
                . "SUM(oi.quantity) AS total, "
                . "month(o.created_at) as period "
                . "FROM orders o "
                . "LEFT JOIN order_item oi ON o.order_id=oi.order_id "
                . "LEFT JOIN items i ON i.item_id=oi.item_id "
                . "LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE o.order_inout = 'IN' AND year(o.created_at)=:year "
                . "GROUP BY period, i.name ";
               
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':year', $year, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function getTotalItemByWeek()
    {
        $query = "SELECT i.name, "
                . "SUM(oi.quantity) AS total, "
                . "day(o.created_at) as period "
                . "FROM orders o "
                . "LEFT JOIN order_item oi ON o.order_id=oi.order_id "
                . "LEFT JOIN items i ON i.item_id=oi.item_id "
                . "LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE o.order_inout = 'IN'  AND o.created_at BETWEEN DATE_ADD(NOW(), INTERVAL -6 DAY) AND NOW() "
                . "GROUP BY period, i.name ";
               
        $result = $this->dbconnection->query($query);        
        return $result->fetchAll();
    }
    
    public function getTotalInventoryByYear()
    {
        $query = "SELECT i.name, "
                . "SUM(oi.quantity) as total, "
                . "year(o.created_at) as period "
                . "FROM items i "
                . "LEFT JOIN order_item oi ON oi.item_id=i.item_id "
                . "LEFT JOIN orders o ON o.order_id=oi.order_id "
                . "LEFT JOIN inventories inv ON inv.item_id=i.item_id "
                . "WHERE o.order_inout = 'OUT' AND o.status IN ('new','done') "
                . "GROUP BY period, i.name ";
               
        $result = $this->dbconnection->query($query);        
        return $result->fetchAll();
    }
    
    public function getTotalInventoryByMonth($year)
    {
        $query = "SELECT i.name, "
                . "SUM(oi.quantity) as total, "
                . "month(o.created_at) as period "
                . "FROM items i "
                . "LEFT JOIN order_item oi ON oi.item_id=i.item_id "
                . "LEFT JOIN orders o ON o.order_id=oi.order_id "
                . "LEFT JOIN inventories inv ON inv.item_id=i.item_id "
                . "WHERE o.order_inout = 'OUT' AND o.status IN ('new','done') AND year(o.created_at)=:year "
                . "GROUP BY period, i.name ";
               
        $sth = $this->dbconnection->prepare($query);
        $sth->bindParam(':year', $year, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();        
    }
    
    public function getTotalInventoryByWeek()
    {
        $query = "SELECT i.name, "
                . "SUM(oi.quantity) as total, "
                . "day(o.created_at) as period "
                . "FROM items i "
                . "LEFT JOIN order_item oi ON oi.item_id=i.item_id "
                . "LEFT JOIN orders o ON o.order_id=oi.order_id "
                . "LEFT JOIN inventories inv ON inv.item_id=i.item_id "
                . "WHERE o.order_inout = 'OUT' AND o.status IN ('new','done') AND o.created_at BETWEEN DATE_ADD(NOW(), INTERVAL -6 DAY) AND NOW() "
                . "GROUP BY period, i.name ";
               
        $result = $this->dbconnection->query($query);        
        return $result->fetchAll();
    }
    
    public function getDayLeftProgressSelling()
    {
        $query = "SELECT s.name AS supplier_name, "
                . "DATEDIFF(o.estimated_delivery, NOW()) AS day_left "
                . "FROM orders o LEFT JOIN suppliers s ON s.supplier_id=o.supplier_id "
                . "WHERE o.order_inout = 'IN' AND o.status = 'on progress' AND o.estimated_delivery > NOW()";
               
        $result = $this->dbconnection->query($query);        
        return $result->fetchAll();
    }
}

