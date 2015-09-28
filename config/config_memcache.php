<?php
class config_memcache {
    public static function get_connect() {

        $connect = array();

        //Memcache
        $type                         = 'memcache';
        $i                            = 0;
        $connect[$type][$i]['host']   = '127.0.0.1';
        $connect[$type][$i]['port']   = 11211;

        return $connect;
    }
}
