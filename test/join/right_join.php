<?php
include_once('../../config/setting.php');
include_once("{$base_path}/join.php");
$join = new join();
$customer = array(
    array('id' => 1, 'name' => 'Peter', 'address' => 'AAAA', 'mobile' => '0900123456'),
    array('id' => 2, 'name' => 'Bill', 'address' => 'BBBB', 'mobile' => '0910123456'),
    array('id' => 3, 'name' => 'Ryan', 'address' => 'CCCC', 'mobile' => '0920123456'),
    array('id' => 4, 'name' => 'Chris', 'address' => 'DDDD', 'mobile' => '0930123456'),
    array('id' => 5, 'name' => 'John', 'address' => 'EEEE', 'mobile' => '0940123456'),
);
$order = array(
    array('id' => 1, 'customer_id' => 1, 'order_no' => 'A123456789'),
    array('id' => 2, 'customer_id' => 2, 'order_no' => 'B123456789'),
    array('id' => 3, 'customer_id' => 3, 'order_no' => 'C123456789'),
    array('id' => 4, 'customer_id' => 5, 'order_no' => 'D123456789'),
    array('id' => 5, 'customer_id' => 1, 'order_no' => 'E123456789'),
    array('id' => 6, 'customer_id' => 5, 'order_no' => 'F123456789'),
    array('id' => 7, 'customer_id' => 3, 'order_no' => 'G123456789'),
    array('id' => 8, 'customer_id' => 2, 'order_no' => 'H123456789'),
    array('id' => 9, 'customer_id' => 8, 'order_no' => 'I123456789'),
    array('id' => 10, 'customer_id' => 9, 'order_no' => 'J123456789'),
);
$bind       = array('id' => 'customer_id');
$table_name = array('customer' => 'order');
$join->set_table_name($table_name);
print_r($join->right_join($customer, $order, $bind));
