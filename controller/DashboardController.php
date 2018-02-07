<?php

require_once dirname(__DIR__) . '/model/Order.php';
require_once dirname(__DIR__) . '/model/Item.php';

class DashboardController{            
    private $order;
    private $item;
    
    function __construct() {
        $this->order = new Order();
        $this->item = new Item();
    }
    public function displayStatusOrder()
    {
        // get total order based on status order       
        $orderTotal = $this->order->getTotalOrderByStatusOrder();
        
        $new = $booked = $onProgress = $done = 0;
        foreach ($orderTotal as $data){
            if ($data['status'] == 'new') {
                $new = $data['order_total'];
            } else if ($data['status'] == 'booked') {
                $booked = $data['order_total'];
            } else if ($data['status'] == 'on progress') {
                $onProgress = $data['order_total'];
            } else if ($data['status'] == 'done') {
                $done = $data['order_total'];
            }
        }
        
        return array(
            'new' => $new,
            'booked' => $booked,
            'onProgress' => $onProgress,
            'done' => $done,
        );
    }
    
    public function displayBar($period)
    {
        if ($period == 'year') {
            $orderTotal = $this->order->getTotalOrderGroupByYear();    
        } elseif ($period == 'month') {
            $orderTotal = $this->order->getTotalOrderGroupByMonth('2017');//(date('y'));
        } else {
            $orderTotal = $this->order->getTotalOrderGroupByWeek();
        }
                
        $result = array();             
        foreach($orderTotal as $data) {            
            $result[$data['period']][$data['supplier_name']] = $data['order_total'];            
        }
        
        return $result;
    }
    
    public function displayAreaChartSelling($period)
    {       
        if ($period == 'year') {
            $totalItems = $this->order->getTotalItemByYear();
        } elseif ($period == 'month') {
            $totalItems = $this->order->getTotalItemByMonth('2017');
        } else {
            $totalItems = $this->order->getTotalItemByWeek();
        }
        
        $result = array();
        foreach ($totalItems as $data) {            
            $result[$data['period']][$data['name']] = $data['total'];  
        }
        
        return $result;
    }
    
    public function displayAreaChartBuying($period)
    {        
        if ($period == 'year') {
            $totalItems = $this->order->getTotalInventoryByYear();
        } elseif ($period == 'month') {
            $totalItems = $this->order->getTotalInventoryByMonth('2017');
        } else {
            $totalItems = $this->order->getTotalInventoryByWeek();
        }
        
        $result = array();
        foreach ($totalItems as $data) {            
            $result[$data['period']][$data['name']] = $data['total'];  
        }
        
        return $result;
    }
    
    public function displayDonut()
    {
        $dayLeftArray = $this->order->getDayLeftProgressSelling();
        $result = array();
        $i = 0;
        foreach ($dayLeftArray as $data) {
            $result[$i]['label'] = $data['supplier_name'];
            $result[$i++]['value'] = $data['day_left'];
        }
        
        return $result;
    }
}

