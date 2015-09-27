<?php
class find {

    protected $fuzzy_search;

    public function __construct() {
        $this->fuzzy_search = FALSE;
    }

    public function set_fuzzy_search($fuzzy_search = FALSE) {
        $this->fuzzy_search = (bool) $fuzzy_search;
    }

    private function _validate_search_data($array = array(), $role = array(), $use = 'or') {
        $array  = (FALSE === empty($array) && TRUE === is_array($array)) ? $array : FALSE;
        $role   = (FALSE === empty($role)  && TRUE === is_array($role))  ? $role  : FALSE;
        $accept = array('and', 'or');
        $use    = in_array(strtolower($use), $accept) ? $use : FALSE;

        if(FALSE === $array || FALSE === $role || FALSE === $use)
            return FALSE;

        foreach($array as $rows)
            foreach($rows as $column => $value)
              if(TRUE === empty($array[0][$column]))
                return FALSE;

        foreach($role as $r)
            if(TRUE === empty($r))
                return FALSE;
    }

    private function _validate_full_text_search_data($array = array(), $keyword = '') {
        $array  = (FALSE === empty($array) && TRUE === is_array($array)) ? $array : FALSE;
        $keyword = (FALSE === empty(trim($keyword))) ? $keyword : FALSE;

        if(FALSE === $array || FALSE === $keyword)
            return FALSE;
    }

    public function search($array = array(), $role = array(), $use = 'or') {

        if(FALSE === $this->_validate_search_data($array, $role, $use))
            return FALSE;

        $swap     = array();
        $pass     = 0;
        $use      = strtolower($use);
        $role_num = count($role);

        foreach($array as $rows) {
            foreach($role as $column => $value)
                if(FALSE === $this->fuzzy_search && FALSE === empty($rows[$column]) && (string) $rows[$column] === (string) $value)
                    $pass++;
                else if(TRUE === $this->fuzzy_search && FALSE === empty($rows[$column]) && 1 === preg_match("/{$value}/i", (string) $rows[$column]))
                    $pass++;

            if('or' === $use && 0 < $pass)
                array_push($swap, $rows);
            else if('and' === $use && $role_num === $pass)
                array_push($swap, $rows);

            $pass = 0;
        }

        return $swap;
    }

    public function full_text_search($array = array(), $keyword = '') {

        if(FALSE === $this->_validate_full_text_search_data($array, $keyword))
            return FALSE;

        $swap = array();

        foreach($array as $rows)
            foreach($rows as $column => $value)
                if(FALSE === $this->fuzzy_search && (string) $keyword === (string) $value)
                    array_push($swap, $rows);
                else if(TRUE === $this->fuzzy_search && 1 === preg_match("/{$keyword}/i", (string) $value))
                    array_push($swap, $rows);

        return $swap;
    }
}
