<?php
class file {

    protected $fp;
    protected $filename;
    protected $encode;

    public function __construct() {
        $this->fp       = NULL;
        $this->filename = NULL;
        $this->encode   = 'json';
    }

    public function set_encode($encode = 'json') {

        $accept = array('json', 'php');
        $encode = in_array(strtolower($encode), $accept) ? strtolower($encode) : FALSE;

        if(FALSE === $encode)
            return FALSE;

        $this->encode = $encode;
    }

    public function get_filename() {
        return $this->filename;
    }

    public function open($filename = '') {

        $filename = (FALSE === empty(trim($filename))) ? $filename : FALSE;

        if(FALSE === $filename)
            return FALSE;

        $this->_load_config();
        $cache_path = config_setting::get_config();
        $cache_path = $cache_path['cache_path'];

        $this->filename = "{$cache_path}/{$filename}";
        $fp   = fopen($this->filename, 'a+');

        if(FALSE === $fp)
            return FALSE;

        $this->fp = $fp;

    }

    private function _load_config() {
        if(TRUE === empty(config_setting::get_config()))
            include_once('../../config/config_setting.php');
    }

    public function load() {
        $this->fp = fopen($this->filename, 'r');
        $data = @fread($this->fp, filesize($this->filename));
        $data = str_replace(array("\r", "\n", "\r\n", "\n\r"), '', $data);

        if('json' === $this->encode)
            $data = json_decode($data, true);
        else if('php' === $this->encode)
            $data = unserialize($data);

        return $data;
    }

    public function save($array = array()) {

        $array = (FALSE === empty($array) && TRUE === is_array($array)) ? $array : FALSE;

        if(FALSE === $array)
            return FALSE;

        $data = NULL;

        if('json' === $this->encode)
            $data = json_encode($array);
        else if('php' === $this->encode)
            $data = serialize($array);

        if(FALSE === $data)
            return FALSE;

        $this->fp = fopen($this->filename, 'w');
        fwrite($this->fp, $data);
    }

    public function close() {
        fclose($this->fp);
        $this->fp       = NULL;
        $this->filename = NULL;
    }
}
