<?php
class index {

    public function load($library = '') {

        include_once('config/config_setting.php');

        if(NULL === $this->{$library}) {
            $this->config('config');
            $config    = $this->config['config_setting'];
            $base_path = $config['base_path'];
            include_once("{$base_path}/{$library}.php");
            $this->{$library} = new $library();
        }
    }

    public function config($config = '') {
        $config .= '_setting';
        include_once("config/{$config}.php");
        $this->config[$config] = $config::get_config();
    }
}
