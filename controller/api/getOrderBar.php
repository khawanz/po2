<?php

require_once dirname(dirname(__DIR__)) . '/controller/DashboardController.php';
require_once dirname(dirname(__DIR__)) . '/model/Order.php';

$period = filter_input(INPUT_POST, 'period');

$dashboardController = new DashboardController();
// display bar chart (total order yang masuk)
$dataBar = $dashboardController->displayBar($period);
$data = array();
$suppliers = array();
$i = 0;
foreach ($dataBar as $periodVal => $values) {
    $data[$i]['y'] = $periodVal;
    foreach ($values as $supplier_name => $total) {            
        $data[$i][$supplier_name] = $total;
        if (!in_array($supplier_name, $suppliers)) {
            $suppliers[] = $supplier_name;
        }
    }
    $i++;
}

$reply = array(
    'data' => $data,
    'suppliers' => $suppliers
);

echo json_encode($reply);
