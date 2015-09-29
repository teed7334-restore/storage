<?php
class mmcache {

    protected $adapter;
    protected $expire;
    protected $compressed;

    public function __construct() {
        $this->_start_service();
    }

    public function restart_service() {
        $this->_start_service();
    }

    public function get_adapter() {
        return $this->adapter;
    }

    public function add_server($host = '', $port = 11211, $key = 'custom', $timeout = 1) {
        $host    = (FALSE === empty($host)) ? $host          : FALSE;
        $port    = (0 < (int) $port)        ? (int) $port    : FALSE;
        $key     = (FALSE === empty($key))  ? $key           : FALSE;
        $timeout = (0 < (int) $timeout)     ? (int) $timeout : FALSE;

        if(FALSE === $host || FALSE === $port || FALSE === $key || FALSE === $timeout)
            return FALSE;

        $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);

        if(FALSE === $fp)
            return FALSE;

        $connect = new Memcache();
        $connect->connect($host, $port);
        $this->adapter[$key][] = $connect;
    }

    private function _clear() {
        $this->expire     = 60;
        $this->compressed = FALSE;
        $this->adapter    = NULL;
    }

    private function _load_config() {
        if(TRUE === empty(config_setting::get_config()))
            include_once('../../config/config_setting.php');
        $config_path = config_setting::get_config();
        $config_path = $config_path['config_path'];
        include_once("{$config_path}/config_memcache.php");
    }

    private function _start_service() {
        $this->_clear();
        $this->_load_config();

        $this->adapter = array();
        $memcache      = NULL;
        $status        = FALSE;
        $type          = array('memcache');
        $connect       = config_memcache::get_connect();

        foreach($type as $t)
            foreach($connect[$t] as $config) {

                $fp = @fsockopen($config['host'], $config['port'], $errno, $errstr, $config['timeout']);

                if(FALSE !== $fp) {
                    $memcache = new Memcache();
                    $memcache->connect($config['host'], $config['port']);
                    $this->adapter[$t][] = $memcache;
                }
            }
    }

    public function set_expire($second = 0) {
        $this->expire = (0 < (int) $second) ? $second : 60;
    }

    public function set_compressed($compressed = FALSE) {
        $this->compressed = (TRUE === (bool) $compressed) ? $compressed : FALSE;
    }

    public function clear_all() {
        foreach($this->adapter['memcache'] as $memcache)
            $memcache->flush();
    }

    public function get($key = '') {

        if(TRUE === empty($this->adapter['memcache']) || TRUE === empty($key) || 0 ===(int) $this->expire)
            return FALSE;

        foreach($this->adapter['memcache'] as $memcache) {
            $data = $memcache->get($key);

            if(FALSE === empty($data))
                return $data;
        }

        return FALSE;
    }

    public function set($key = '', $value = '') {

        if(TRUE === empty($this->adapter['memcache']) || TRUE === empty($key) || TRUE === empty($value) || 0 === (int) $this->expire)
            return FALSE;

        $status = array();

        foreach($this->adapter['memcache'] as $memcache)
            array_push($status, $memcache->set($key, $value, $this->compressed, $this->expire));

        return $status;
    }

    public function add($key = '', $value = '') {

        if(TRUE === empty($this->adapter['memcache']) || TRUE === empty($key) || TRUE === empty($value) || 0 === (int) $this->expire)
            return FALSE;

        $status = array();

        foreach($this->adapter['memcache'] as $memcache)
            array_push($status, $memcache->add($key, $value, $this->compressed, $this->expire));

        return $status;
    }

    public function delete($key = '') {

        if(TRUE === empty($this->adapter['memcache']) || TRUE === empty($key) || 0 > (int) $this->expire)
            return FALSE;

        $status = array();

        foreach($this->adapter['memcache'] as $memcache)
            array_push($status, $memcache->delete($key));

        return $status;
    }
}
