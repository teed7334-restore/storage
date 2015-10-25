<?php
include_once('../../config/config_setting.php');
$config    = config_setting::get_config();
$base_path = $config['base_path'];
include_once("{$base_path}/database.php");
$database = new database();
$table  = array('user');
$column = array(
  'account'     => 'Hebe',
  'password'    => '25d55ad283aa400af464c76d713c07ad',
  'group_id'    => '1000',
  'home'        => '/home/Hebe',
  'shell'       => '/bin/bash',
  'is_disabled' => 0
);
$role = array(
    'account'     => 'Selina',
    'password'    => '25d55ad283aa400af464c76d713c07ad',
    'group_id'    => '1000',
    'home'        => '/home/Selina',
    'shell'       => '/bin/bash',
    'is_disabled' => 0
);
$key = 'users';
$database->table($table);
$database->column($column);
$database->role($role);
print_r($database->set($key));
