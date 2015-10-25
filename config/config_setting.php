<?php
class config_setting {
    public static function get_config() {
        $config = array();

        //Directory Structure
        $config['main_path']    = dirname(dirname(__FILE__));
        $config['base_path']    = "{$config['main_path']}/base";
        $config['cache_path']   = "{$config['main_path']}/cache";
        $config['config_path']  = "{$config['main_path']}/config";
        $config['library_path'] = "{$config['main_path']}/library";
        $config['test_path']    = "{$config['main_path']}/test";

        return $config;
    }
}
