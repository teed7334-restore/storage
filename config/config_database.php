<?php
class config_database {
    public static function get_connect() {

        $connect = array();

        //read
        $type                           = 'read';
        $i                              = 0;
        $connect[$type][$i]['use']      = 'mysql';
        $connect[$type][$i]['host']     = '127.0.0.1';
        $connect[$type][$i]['user']     = 'test';
        $connect[$type][$i]['password'] = '12345678';
        $connect[$type][$i]['database'] = 'test';
        $connect[$type][$i]['charset']  = 'utf8';
        $i++;

        //write
        $type                           = 'write';
        $i                              = 0;
        $connect[$type][$i]['use']      = 'mysql';
        $connect[$type][$i]['host']     = '127.0.0.1';
        $connect[$type][$i]['user']     = 'test';
        $connect[$type][$i]['password'] = '12345678';
        $connect[$type][$i]['database'] = 'test';
        $connect[$type][$i]['charset']  = 'utf8';
        $i++;

        return $connect;
    }
}
