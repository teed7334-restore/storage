<?php
include_once('../../config/config_setting.php');
$config    = config_setting::get_config();
$base_path = $config['base_path'];
include_once("{$base_path}/mmcache.php");
$memcache = new mmcache();
$expire   = 86400;
$key      = 'order';
$order    = array(
    array('id' => 10, 'customer_id' => 1, 'order_no' => 'A123456789'),
    array('id' => 9, 'customer_id' => 2, 'order_no' => 'B123456789'),
    array('id' => 8, 'customer_id' => 3, 'order_no' => 'C123456789'),
    array('id' => 7, 'customer_id' => 5, 'order_no' => 'D123456789'),
    array('id' => 6, 'customer_id' => 1, 'order_no' => 'E123456789'),
    array('id' => 5, 'customer_id' => 5, 'order_no' => 'F123456789'),
    array('id' => 4, 'customer_id' => 3, 'order_no' => 'G123456789'),
    array('id' => 3, 'customer_id' => 2, 'order_no' => 'H123456789'),
    array('id' => 2, 'customer_id' => 8, 'order_no' => 'I123456789'),
    array('id' => 1, 'customer_id' => 9, 'order_no' => 'J123456789'),
);
$memcache->set_expire($expire);
print_r($memcache->update($key, $order));
