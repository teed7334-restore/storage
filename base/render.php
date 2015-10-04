<?php
class render {

    protected $adapter;
    protected $params;

    public function __construct() {
        $this->adapter    = NULL;
        $this->params = NULL;
    }

    public function html($html = NULL) {
        $html = FALSE === empty($html) ? $html : FALSE;

        if(FALSE === $html)
            return FALSE;

        $this->_load_config();
        $this->adapter = str_get_html($html);
    }

    public function params($params = array()) {
        $params = TRUE === is_array($params) ? $params : FALSE;

        if(FALSE === $params)
            return FALSE;

        $this->params = $params;
    }

    public function get_adapter() {
        return $this->adapter;
    }

    private function _load_config() {
        if(TRUE === empty(config_setting::get_config())) {
            $path = dirname(dirname(dirname(__FILE__)));
            include_once("{$path}/config/config_setting.php");
        }
        $config_path = config_setting::get_config();
        $library_path = $config_path['library_path'];
        include_once("{$library_path}/simplehtmldom/simple_html_dom.php");
    }

    public function render($by = 'id') {

        $accept = array('id', 'name', 'class');
        $by      = strtolower($by);

        if(NULL === $this->adapter || FALSE === in_array($by, $accept))
            return FALSE;

        $this->_load_config();
        $ret    = NULL;

        foreach($this->params as $index => $params) {
            if(FALSE === is_array($params)) {
                $query = "[{$by}={$index}]";
                $ret = $this->adapter->find($query, 0);
                if(FALSE === empty($ret))
                    if('input' === $ret->tag)
                        $ret->value = $params;
                    else
                        $ret->innertext = $params;
            }
            else {
                foreach($params as $params_index => $params_value) {
                    if(TRUE === is_array($params_value))
                        foreach($params_value as $key => $value) {
                            $query = "[{$by}={$key}]";
                            $ret = $this->adapter->find($query, $params_index);
                            if(FALSE === empty($ret))
                                if('input' === $ret->tag)
                                    $ret->value = $value;
                                else
                                    $ret->innertext = $value;
                        }
                }
            }
        }

        echo $this->adapter;
    }
}
