<?php
class database {

    protected $adapter;
    protected $tables;
    protected $columns;
    protected $roles;

    public function __construct() {
        $this->_start_service();
    }

    public function restart_service() {
        $this->_start_service();
    }

    public function get_adapter() {
        return $this->adapter;
    }

    public function add_server($use = '', $host = '', $user = '', $password = '', $database = '', $charset = '', $name = 'custom') {
        $use      = (FALSE === empty($use))      ? $use                 : FALSE;
        $host     = (FALSE === empty($host))     ? $host                : FALSE;
        $user     = (FALSE === empty($user))     ? $user                : FALSE;
        $password = (FALSE === empty($password)) ? $password            : FALSE;
        $database = (FALSE === empty($database)) ? $database            : FALSE;
        $name     = (FALSE === empty($name))     ? $name                : FALSE;
        $charset  = (FALSE === empty($charset))  ? "charset={$charset}" : '';

        if(FALSE === $use || FALSE === $host || FALSE === $user || FALSE === $password || FALSE === $database || FALSE === $name)
            return FALSE;

        $dsn = "{$use}:host={$host};dbname={$database};{$charset}";
        $connect = new PDO($dsn, $user, $password);
        $this->adapter[$name][] = $connect;
    }

    private function _clear() {
        $this->adapter = NULL;
        $this->tables  = NULL;
        $this->columns = NULL;
        $this->roles   = NULL;
    }

    private function _load_config() {
        if(TRUE === empty(config_setting::get_config())) {
            $path = dirname(dirname(dirname(__FILE__)));
            include_once("{$path}/config/config_setting.php");
        }
        $config_path = config_setting::get_config();
        $config_path = $config_path['config_path'];
        include_once("{$config_path}/config_database.php");
    }

    private function _start_service() {
        $this->_clear();
        $this->_load_config();

        $this->adapter = array();
        $database      = NULL;
        $status        = FALSE;
        $type          = array('read', 'write');
        $connect       = config_database::get_connect();

        foreach($type as $t)
            foreach($connect[$t] as $config) {
                $charset             = (FALSE === empty($config['charset'])) ? "charset={$config['charset']}" : '';
                $dsn                 = "{$config['use']}:host={$config['host']};dbname={$config['database']};{$charset}";
                $database            = new PDO($dsn, $config['user'], $config['password']);
                $this->adapter[$t][] = $database;
            }
    }

    public function table($table = array()) {
        $table = (FALSE === empty($table) && TRUE === is_array($table)) ? $table : FALSE;

        if(FALSE === $table)
            return FALSE;

        $this->tables = $table;

        return $this->tables;
    }

    public function column($column = array()) {
        $column = (FALSE === empty($column) && TRUE === is_array($column)) ? $column : FALSE;

        if(FALSE === $column)
            return FALSE;

        $this->columns = $column;

        return $this->columns;
    }

    public function role($role = array()) {
        $role = (FALSE === empty($role) && TRUE === is_array($role)) ? $role : FALSE;

        if(FALSE === $role)
            return FALSE;

        $this->roles = $role;

        return $this->roles;
    }

    public function search() {

        if(TRUE === empty($this->tables) || TRUE === empty($this->columns))
            return FALSE;

        $select = NULL;
        $from   = NULL;
        $where  = NULL;
        $bind   = NULL;
        $data   = array();

        foreach($this->tables as $table)
            $from .= "{$table}, ";

        $from = mb_substr($from, 0, mb_strlen($from) - 2);

        foreach($this->columns as $column)
            $select .= "{$column}, ";

        $select = mb_substr($select, 0, mb_strlen($select) -2);

        if(FALSE === empty($this->roles) && TRUE === is_array($this->roles)) {
            foreach($this->roles as $column => $value) {
                $where             .= "{$column} = :{$column} AND ";
                $bind[":{$column}"] = $value;
            }

            $where = mb_substr($where, 0, mb_strlen($where) -4);
        }

        $sql = "SELECT {$select} FROM {$from} WHERE {$where}";

        $data = $this->read_database($sql, $bind);

        return $data;
    }

    public function update() {

        if(TRUE === empty($this->tables) || TRUE === empty($this->columns))
            return FALSE;

        $update = NULL;
        $set    = NULL;
        $where  = NULL;
        $bind   = NULL;
        $data   = array();

        foreach($this->tables as $table)
            $update = $table;

        foreach($this->columns as $column => $value) {
            $set                 .= "{$column} = :s_{$column}, ";
            $bind[":s_{$column}"] = $value;
        }

        $set   = mb_substr($set, 0, mb_strlen($set) -2);

        if(FALSE === empty($this->roles) && TRUE === is_array($this->roles)) {
            foreach($this->roles as $column => $value) {
                $where             .= "{$column} = :w_{$column} AND ";
                $bind[":w_{$column}"] = $value;
            }

            $where = mb_substr($where, 0, mb_strlen($where) -4);
        }

        $sql = "UPDATE {$update} SET {$set} WHERE {$where}";

        $data   = array();
        $status = array();
        $status = $this->write_database($sql, $bind);

        return $status;
    }

    public function insert() {

        if(TRUE === empty($this->tables) || TRUE === empty($this->columns))
            return FALSE;

        $insert  = NULL;
        $columns = NULL;
        $values  = NULL;
        $bind    = NULL;

        foreach($this->tables as $table)
            $insert = $table;

        foreach($this->columns as $column => $value) {
            $columns           .= "{$column}, ";
            $values            .= ":{$column}, ";
            $bind[":{$column}"] = $value;
        }

        $columns = mb_substr($columns, 0, mb_strlen($columns) -2);
        $values  = mb_substr($values,  0, mb_strlen($values)  -2);

        $sql = "INSERT INTO {$insert} ($columns) VALUES ($values)";

        $data   = array();
        $status = array();
        $status = $this->write_database($sql, $bind);

        return $status;
    }

    public function remove() {

        if(TRUE === empty($this->tables))
            return FALSE;

        $table = NULL;
        $role  = NULL;
        $bind  = NULL;

        foreach($this->tables as $table)
            $table = $table;

        if(FALSE === empty($this->roles)) {
            foreach($this->roles as $column => $value) {
                $role .= "{$column} = :{$column} AND ";
                $bind[":{$column}"] = $value;
            }

            $role = mb_substr($role, 0, mb_strlen($role) - 4);
        }

        $sql = "DELETE FROM {$table} WHERE 1 = 1 AND {$role}";

        $data   = array();
        $status = array();
        $status = $this->write_database($sql, $bind);

        return $status;
    }

    public function read_database($sql = '', $bind = array()) {

        if(TRUE === empty($this->adapter['read']) || TRUE === empty($sql))
            return FALSE;

        $sth  = NULL;
        $data = NULL;

        foreach($this->adapter['read'] as $database) {
            $sth = $database->prepare($sql);
            if(FALSE === empty($bind))
                $sth->execute($bind);
            else
                $sth->execute();
            $data = $sth->fetchAll(PDO::FETCH_ASSOC);
            if(FALSE === empty($data))
                return $data;
        }

        return $data;
    }

    public function write_database($sql = '', $bind = array()) {

        if(TRUE === empty($this->adapter['write']) || TRUE === empty($sql) || TRUE === empty($bind))
            return FALSE;

        $sth    = NULL;
        $data   = NULL;
        $status = array();

        foreach($this->adapter['write'] as $database) {
            $sth = $database->prepare($sql);
            array_push($status, $sth->execute($bind));
        }

        return $status;
    }

    public function custom_query($sql = '', $bind = array(), $name = 'custom', $step = 0) {

        if(TRUE === empty($sql) || TRUE === empty($name) || 0 > (int) $step || TRUE === empty($this->adapter[$name]))
            return FALSE;

        $sth    = NULL;
        $data   = NULL;
        $status = NULL;

        $sth = $this->adapter[$name][$step]->prepare($sql);

        if(FALSE === empty($bind))
            $sth->execute($bind);
        else
            $sth->execute();

        return $sth;

    }
}
