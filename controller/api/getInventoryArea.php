<?php

require_once dirname(dirname(__DIR__)) . '/controller/DashboardController.php';
require_once dirname(dirname(__DIR__)) . '/model/Order.php';

$period = filter_input(INPUT_POST, 'period');

$dashboardController = new DashboardController();
// display bar chart (total order yang masuk)
$dataArea = $dashboardController->displayAreaChartBuying($period);
$data = array();
$items = array();
$i = 0;
foreach ($dataArea as $year => $values) {
    $data[$i]['period'] = (string)$year;
    foreach ($values as $item_name => $total) {            
        $data[$i][$item_name] = (int)$total;
        if (!in_array($item_name, $items)) {
            $items[] = $item_name;
        }
    }
    $i++;
}

$reply = array(
    'data' => $data,
    'items' => $items
);

echo json_encode($reply);
