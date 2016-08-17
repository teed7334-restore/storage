<?php
class config_images {
    public static function get_directory() {

        $directory = array();

        $type                         = 'slice';
        $path                         = dirname(dirname(__FILE__)) . '/test/images/images';
        $directory[$type]['100-100'] = "{$path}/100-100s";
        $directory[$type]['200-200'] = "{$path}/200-200s";
        $directory[$type]['300-300'] = "{$path}/300-300s";
        $directory[$type]['400-400'] = "{$path}/400-400s";
        $directory[$type]['500-500'] = "{$path}/500-500s";
        $directory[$type]['600-600'] = "{$path}/600-600s";

        $type                         = 'resize';
        $path                         = dirname(dirname(__FILE__)) . '/test/images/images';
        $directory[$type]['100-100'] = "{$path}/100-100";
        $directory[$type]['200-200'] = "{$path}/200-200";
        $directory[$type]['300-300'] = "{$path}/300-300";
        $directory[$type]['400-400'] = "{$path}/400-400";
        $directory[$type]['500-500'] = "{$path}/500-500";
        $directory[$type]['600-600'] = "{$path}/600-600";

        return $directory;
    }
}
