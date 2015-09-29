<?php
class index {

    public $database;
    public $file;
    public $find;
    public $join;
    public $mmcache;
    public $order;
    public $paging;

    public function __construct() {
        $this->database = NULL;
        $this->file     = NULL;
        $this->find     = NULL;
        $this->join     = NULL;
        $this->mmcache  = NULL;
        $this->order    = NULL;
        $this->paging   = NULL;
    }

    public function load($library = '') {

        $accept = array('database', 'file', 'find', 'join', 'mmcache', 'order', 'paging');
        $library = in_array(strtolower($library), $accept) ? strtolower($library) : FALSE;

        if(FALSE === $library)
            return FALSE;

        include_once('config/config_setting.php');

        if(NULL === $this->{$library}) {
            $config    = config_setting::get_config();
            $base_path = $config['base_path'];
            include_once("{$base_path}/{$library}.php");
            $command = "\$this->{$library} = new {$library}();";
            eval($command);
        }
    }
}
