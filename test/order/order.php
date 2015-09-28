<?php
include_once('../../config/config_setting.php');
$config    = config_setting::get_config();
$base_path = $config['base_path'];
include_once("{$base_path}/order.php");
$order = new order();
$data = array(
    array('id' => 1, 'name' => 'Peter', 'address' => 'AAAA', 'pay' => '100', 'date' => '2015-09-27 23:00:00'),
    array('id' => 2, 'name' => 'Peter', 'address' => 'BBBB', 'pay' => '200', 'date' => '2015-09-27 22:00:00'),
    array('id' => 3, 'name' => 'Peter', 'address' => 'AAAA', 'pay' => '300', 'date' => '2015-09-27 21:00:00'),
    array('id' => 4, 'name' => 'Peter', 'address' => 'BBBB', 'pay' => '400', 'date' => '2015-09-27 20:00:00'),
    array('id' => 5, 'name' => 'Peter', 'address' => 'AAAA', 'pay' => '500', 'date' => '2015-09-27 19:00:00'),
    array('id' => 6, 'name' => 'Peter', 'address' => 'BBBB', 'pay' => '600', 'date' => '2015-09-27 18:00:00'),
    array('id' => 7, 'name' => 'Peter', 'address' => 'AAAA', 'pay' => '700', 'date' => '2015-09-27 17:00:00'),
    array('id' => 8, 'name' => 'Peter', 'address' => 'BBBB', 'pay' => '800', 'date' => '2015-09-27 16:00:00'),
    array('id' => 9, 'name' => 'Joe', 'address' => 'CCCC', 'pay' => '900', 'date' => '2015-09-27 15:00:00'),
    array('id' => 10, 'name' => 'Kevin', 'address' => 'DDDD', 'pay' => '1000', 'date' => '2015-09-27 14:00:00')
);
$orderBy = array(
    'date' => 'ASC',
    'address' => 'DESC',
    'name' => 'ASC',
    'pay' => 'DESC'
);

print_r($order->order($data, $orderBy));
