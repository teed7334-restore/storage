<?php
include_once('../../config/setting.php');
include_once("{$base_path}/find.php");
$find = new find();
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
$role = array('name' => 'er', 'mobile' => '123456');
$use  = 'and';
$find->set_fuzzy_search(TRUE);
print_r($find->search($customer, $role, $use));
