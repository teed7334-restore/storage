<?php
include_once('../../config/config_setting.php');
$config    = config_setting::get_config();
$base_path = $config['base_path'];
include_once("{$base_path}/paging.php");
$paging = new paging();
$customer = array(
    array('id' => 1, 'name' => 'Peter', 'address' => 'AAAA', 'mobile' => '0900123456'),
    array('id' => 2, 'name' => 'Bill', 'address' => 'BBBB', 'mobile' => '0910123456'),
    array('id' => 3, 'name' => 'Ryan', 'address' => 'CCCC', 'mobile' => '0920123456'),
    array('id' => 4, 'name' => 'Chris', 'address' => 'DDDD', 'mobile' => '0930123456'),
    array('id' => 5, 'name' => 'John', 'address' => 'EEEE', 'mobile' => '0940123456'),
    array('id' => 6, 'name' => 'Peter', 'address' => 'FFFF', 'mobile' => '0950123456'),
    array('id' => 7, 'name' => 'Bill', 'address' => 'GGGG', 'mobile' => '0960123456'),
    array('id' => 8, 'name' => 'Ryan', 'address' => 'HHHH', 'mobile' => '0970123456'),
    array('id' => 9, 'name' => 'Chris', 'address' => 'IIII', 'mobile' => '0980123456'),
    array('id' => 10, 'name' => 'John', 'address' => 'JJJJ', 'mobile' => '0990123456'),
);
$paging->set_array($customer);
$paging->set_page_num(5);
print_r($paging->page(2));
