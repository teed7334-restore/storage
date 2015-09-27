<?php
class index {

    public $file;
    public $find;
    public $join;
    public $order;
    public $paging;

    public function __construct() {
        $this->file   = NULL;
        $this->find   = NULL;
        $this->join   = NULL;
        $this->order  = NULL;
        $this->paging = NULL;
    }

    public function load($library = '') {

        $accept = array('file', 'find', 'join', 'order', 'paging');
        $library = in_array(strtolower($library), $accept) ? strtolower($library) : FALSE;

        if(FALSE === $library)
            return FALSE;

        include_once('config/setting.php');

        if(NULL === $this->{$library}) {
            global $base_path;
            include_once("{$base_path}/{$library}.php");
            $command = "\$this->{$library} = new {$library}();";
            eval($command);
        }
    }
}
