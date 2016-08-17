<?php
include_once('../../config/config_setting.php');
$config    = config_setting::get_config();
$base_path = $config['base_path'];
include_once("{$base_path}/images.php");

$images = new images();
$images->open('blackberries.jpg');
$images->slice(100);
$images->close();
