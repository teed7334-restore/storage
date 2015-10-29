<?php
include_once('../config/config_setting.php');
$config    = config_setting::get_config();
$main_path = $config['main_path'];
include_once("{$main_path}/index.php");

cross_storage_join();

function cross_storage_join() {

    $begin = microtime();

    //crate object and load library
    $storage = new index();
    $storage->load('join');
    $storage->load('order');
    $storage->load('database');
    $storage->load('mmcache');

    //check permission data from memcache
    $permission = $storage->mmcache->get('permission');

    if(TRUE === empty($permission)) { //no permission data in memcache

        //check user data from memcache
        $mysql = $storage->mmcache->get('user');

        if(TRUE === empty($mysql)) { //no user data in memcache
            $sql = "SELECT * FROM user";
            $mysql = $storage->database->read_database($sql);

            //write into memcache
            $storage->mmcache->set_expire(3600);
            $storage->mmcache->add('user', $mysql);
            echo "user data from database <br />\n";
        }
        else {
            echo "user data from memcache <br />\n";
        }

        //check group data from memcache
        $pgsql = $storage->mmcache->get('group');

        if(TRUE === empty($pgsql)) { //no group data in memcache
            $use = 'pgsql';
            $host = '127.0.0.1';
            $user = 'test';
            $password = '12345678';
            $database = 'test';
            $storage->database->add_server($use, $host, $user, $password, $database);
            $sql = "SELECT * FROM ugroup";
            $pgsql = $storage->database->query($sql);
            $pgsql = $pgsql->fetchAll(PDO::FETCH_ASSOC);

            //write into memcache
            $storage->mmcache->set_expire(3600);
            $storage->mmcache->add('group', $pgsql);
            echo "group data from database <br />\n";
        }
        else {
            echo "group data from memcache <br />\n";
        }

        $table_name = array('user' => 'group');
        $storage->join->set_table_name($table_name);
        $bind = array('group_id' => 'id');
        $permission = $storage->join->inner_join($mysql, $pgsql, $bind);

        //write into memcache
        $storage->mmcache->set_expire(3600);
        $storage->mmcache->add('permission', $permission);
        echo "permission data from database <br />\n";
    }
    else {
        echo "permission data from memcache <br />\n";
    }

    echo "<br />\n";

    //sort permission data
    $orderBy = array('user.id' => 'ASC', 'user.account' => 'ASC');
    $storage->order->order($permission, $orderBy);

    print_r($permission);

    echo "<br /><br />\n";

    echo 'Use ' . (microtime() - $begin) . ' microseconds';
}
