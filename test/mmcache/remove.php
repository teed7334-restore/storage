<?php
include_once('../../config/config_setting.php');
$config    = config_setting::get_config();
$base_path = $config['base_path'];
include_once("{$base_path}/mmcache.php");
$memcache = new mmcache();
$key      = 'order';
print_r($memcache->remove($key));
