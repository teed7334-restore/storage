<?php
class join {

		protected $left_table;
		protected $right_table;
		protected $left_table_name;
		protected $right_table_name;
		protected $left_index;
		protected $right_index;
		protected $use_reverse;

		public function __construct() {
				$this->_clear();
				$this->left_table_name = 'l';
				$this->right_table_name = 'r';
				$this->use_reverse = FALSE;
		}

		private function _validate_join_data($array = array(), $join = array(), $bind = array()) {
				$array = (FALSE === empty($array) && TRUE === is_array($array)) ? $array : FALSE;
				$join  = (FALSE === empty($join)  && TRUE === is_array($join))  ? $join  : FALSE;
				$bind  = (FALSE === empty($bind)  && TRUE === is_array($bind))  ? $bind  : FALSE;

				if(FALSE === $array || FALSE === $join || FALSE === $bind)
						return FALSE;

				foreach($array as $rows)
						foreach($rows as $column => $value)
							  if(FALSE === isset($array[0][$column]))
								    return FALSE;

				foreach($join as $rows)
						foreach($rows as $column => $value)
							  if(FALSE === isset($join[0][$column]))
								    return FALSE;

				foreach($bind as $role)
						if(TRUE === empty($role))
								return FALSE;

				return TRUE;
		}

		private function _set_bind($bind = array()) {

				foreach($bind as $left => $right) {
						$this->left_index  = $left;
						$this->right_index = $right;
				}

		}

		private function _set_table_name($array = array(), $join = array()) {

				$columns = array();

				foreach($array as $rows) {

						foreach($rows as $column => $value) {
								$columns["{$this->left_table_name}.{$column}"] = $value;
						}

						array_push($this->left_table, $columns);
						$columns = array();

				}

				foreach($join as $rows) {

						foreach($rows as $column => $value)
								$columns["{$this->right_table_name}.{$column}"] = $value;

						array_push($this->right_table, $columns);
						$columns = array();
				}
		}

		private function _clear() {
				$this->left_table    = array();
				$this->right_table   = array();
		}

		private function _get_join_table_schema($array = array(), $join = array()) {

				$columns = array();

				foreach($array as $rows)
						foreach($rows as $column => $value)
								$columns["{$this->left_table_name}.{$column}"] = NULL;

				foreach($join as $rows)
						foreach($rows as $column => $value)
								$columns["{$this->right_table_name}.{$column}"] = NULL;

				return $columns;
		}

		private function _set_reverse() {
				$swap                   = $this->left_table;
				$this->left_table       = $this->right_table;
				$this->right_table      = $swap;
				$swap                   = $this->left_table_name;
				$this->left_table_name  = $this->right_table_name;
				$this->right_table_name = $swap;
				$swap                   = $this->left_index;
				$this->left_index       = $this->right_index;
				$this->right_index      = $swap;
		}

		private function _set_use_reverse($use_reverse = FALSE) {
				$this->use_reverse = (bool) $use_reverse;
		}

		public function set_table_name($table_name = array()) {

				$table_name = (FALSE === empty($table_name) && TRUE === is_array($table_name)) ? $table_name : FALSE;

				if(FALSE === $table_name)
						return FALSE;

				foreach($table_name as $left_table_name => $right_table_name) {
						$this->left_table_name  = $left_table_name;
						$this->right_table_name = $right_table_name;
				}
		}

		public function inner_join($array = array(), $join = array(), $bind = array()) {

				$this->_clear();

				if(FALSE === $this->_validate_join_data($array, $join, $bind))
					  return FALSE;

				$swap = array();

				$this->_set_bind($bind);
				$this->_set_table_name($array, $join);

				foreach($this->left_table as $left_rows)
						foreach($this->right_table as $right_rows)
								if(FALSE === empty($left_rows["{$this->left_table_name}.{$this->left_index}"]) && FALSE === empty($right_rows["{$this->right_table_name}.{$this->right_index}"]) && (string) $left_rows["{$this->left_table_name}.{$this->left_index}"] === (string) $right_rows["{$this->right_table_name}.{$this->right_index}"])
										array_push($swap, array_merge($left_rows, $right_rows));

				return $swap;

		}

		public function left_join($array = array(), $join = array(), $bind = '') {

				$this->_clear();

				if(FALSE === $this->_validate_join_data($array, $join, $bind))
					return false;

				$swap   = array();
				$pass		= FALSE;
				$schema = $this->_get_join_table_schema($array, $join);

				$this->_set_bind($bind);
				$this->_set_table_name($array, $join);

				if(TRUE === $this->use_reverse)
					$this->_set_reverse();

				foreach($this->left_table as $left_rows) {

						foreach($this->right_table as $right_rows)
								if(FALSE === empty($left_rows["{$this->left_table_name}.{$this->left_index}"]) && FALSE === empty($right_rows["{$this->right_table_name}.{$this->right_index}"]) && (string) $left_rows["{$this->left_table_name}.{$this->left_index}"] === (string) $right_rows["{$this->right_table_name}.{$this->right_index}"]) {
										array_push($swap, array_merge($left_rows, $right_rows));
										$pass = TRUE;
								}

						if(FALSE === $pass)
								array_push($swap, array_merge($schema, $left_rows));

						$pass = FALSE;

				}

				if(TRUE === $this->use_reverse)
						$this->_set_reverse();

				$this->_set_use_reverse(FALSE);

				return $swap;
		}

		public function right_join($array = array(), $join = array(), $bind = array()) {
				$this->_set_use_reverse(TRUE);
				return $this->left_join($array, $join, $bind);
		}

		public function full_join($array = array(), $join = array(), $bind = array()) {

				$swap       = array();
				$left_join  = $this->left_join($array, $join, $bind);
				$right_join = $this->right_join($array, $join, $bind);
				$inner_join = $this->inner_join($array, $join, $bind);

				if(FALSE === $left_join || FALSE === $right_join || FALSE === $inner_join)
						return FALSE;

				$swap = $inner_join;

				foreach($left_join as $left_rows)
						if(NULL === $left_rows["{$this->right_table_name}.{$this->right_index}"])
								array_push($swap, $left_rows);

				foreach($right_join as $right_rows)
						if(NULL === $right_rows["{$this->left_table_name}.{$this->left_index}"])
								array_push($swap, $right_rows);

				return $swap;
		}

		public function cross_join($array = array(), $join = array()) {

				$this->_clear();

				if(FALSE === $this->_validate_join_data($array, $join, array('id' => 'id')))
					return FALSE;

				$swap = array();
				$this->_set_table_name($array, $join);

				foreach($this->left_table as $left_rows)
						foreach($this->right_table as $right_rows)
								array_push($swap, array_merge($left_rows, $right_rows));

				return $swap;
		}

		public function natural_join($array = array(), $join = array(), $type = 'inner') {

				$this->_clear();
				$accept = array('inner', 'left', 'right');
				$type   = in_array(strtolower($type), $accept) ? strtolower($type) : FALSE;
				$bind   = array();
				$swap   = array();

				if(FALSE === $type)
						return FALSE;

				foreach($array as $left_rows)
						foreach($join as $right_rows)
								foreach($left_rows as $left_column => $left_value)
										if(FALSE === empty($right_rows[$left_column])) {
												$bind[$left_column] = $left_column;
												break;
										}

				if('inner' === $type)
						$swap = $this->inner_join($array, $join, $bind);
				else if('left' === $type)
						$swap = $this->left_join($array, $join, $bind);
				else if('right' === $type)
						$swap = $this->right_join($array, $join, $bind);

				return $swap;
		}
}
