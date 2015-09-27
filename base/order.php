<?php
class order {

    private function _validate_order_data($array = array(), $orderBy = array()) {
        $array   = (FALSE === empty($array)   && TRUE === is_array($array))   ? $array   : FALSE;
        $orderBy = (FALSE === empty($orderBy) && TRUE === is_array($orderBy)) ? $orderBy : FALSE;

        if(FALSE === $array || FALSE === $orderBy)
            return FALSE;

        foreach($array as $rows)
            foreach($rows as $column => $value)
              if(TRUE === empty($array[0][$column]))
                return FALSE;

        foreach($orderBy as $role)
            if(TRUE === empty($role))
                return FALSE;
    }

    public function order($array = array(), $orderBy = array()) {

        if(FALSE === $this->_validate_order_data($array, $orderBy))
            return FALSE;

        $data    = array();
        $command = NULL;
        $sort    = NULL;

        foreach($array as $key => $rows)
            foreach($rows as $column => $value) {

                if(FALSE === empty($orderBy[$column])) {
                    if('asc' === strtolower($orderBy[$column]))
                        $sort = SORT_ASC;
                    else if('desc' === strtolower($orderBy[$column]))
                        $sort = SORT_DESC;
                    $data[$column][] = $value;
                    if(0 === (int) $key)
                        $command .= "\$data['{$column}'], {$sort}, ";
                }
            }

            $command = mb_substr($command, 0, mb_strlen($command) - 2);
            $command = "{$command}, \$array";
            $command = "array_multisort({$command});";
            eval($command);

            return $array;
    }
}
