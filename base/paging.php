<?php
class paging {

    protected $array;
    protected $num;
    protected $total_num;
    protected $page_num;

    public function __construct() {
        $this->array     = NULL;
        $this->num       = 0;
        $this->total_num = 0;
        $this->page_num  = 10;
    }

    public function set_array($array = array()) {

        if(FALSE !== $this->_validate_paging_data($array)) {
            $this->array = $array;
            $this->num   = count($this->array);
        }
    }

    public function set_page_num($page_num = 10) {

        $page_num = (0 < (int) $page_num) ? (int) $page_num : FALSE;

        if(FALSE === $page_num)
            return FALSE;

        $this->page_num = $page_num;
        $this->total_num = ceil((int) $this->num / (int) $this->page_num);
    }

    private function _validate_paging_data($array = array()) {
        $array = (FALSE === empty($array) && TRUE === is_array($array)) ? $array : FALSE;

        if(FALSE === $array)
						return FALSE;

				foreach($array as $rows)
						foreach($rows as $column => $value)
							if(TRUE === empty($array[0][$column]))
								return FALSE;
    }

    public function page($page = 1) {

        $page = (0 < (int) $page) ? (int) $page : FALSE;

        if(FALSE === $page)
            return FALSE;

        $page = ((int) $this->total_num > (int) $page) ? (int) $page : (int) $this->total_num;

        $array = array(
            'first' => 1,
            'prev'  => (0 < ($page - 1)) ? ($page - 1) : 1,
            'next'  => ((int) $this->total_num > $page + 1) ? ($page + 1) : $this->total_num,
            'page'  => $page,
            'last'  => (int) $this->total_num,
            'data'  => array()
        );

        $begin = ( $page - 1) * (int) $this->page_num;
        $end   = $page * (int) $this->page_num;

        for($i = $begin; $i < $end; $i++) {
            if(TRUE === empty($this->array[$i]))
                break;
            array_push($array['data'], $this->array[$i]);
        }

        return $array;
    }
}
