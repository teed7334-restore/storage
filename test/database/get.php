<?php
include_once('../../config/config_setting.php');
$config    = config_setting::get_config();
$base_path = $config['base_path'];
include_once("{$base_path}/database.php");
$database = new database();
$table  = array('user');
$column = array('account', 'password', 'home');
$role   = array('account' => 'Peter');
$database->table($table);
$database->column($column);
$database->role($role);
print_r($database->get($key));
