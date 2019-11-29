<?php

/**
 * Class to init fatfree Mapper object, more at:
 * https://fatfreeframework.com/3.6/sql-mapper
 *
 * @author jonih
 */
class database {

    protected $db;
    protected $mapper;
    public $f3;

    public function __construct($f3) {
        $this->db = new \DB\SQL('mysql:host=' . $f3->HOSTSQL . ';port=' . $f3->PORTSQL . ';dbname=' . $f3->NAME, $f3->USER, $f3->PASW, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES LATIN1;'));
        $this->f3 = $f3;
    }

    /**
     * @param type $table db table mapper inits to
     */
    public function setMapper($table) {
        $this->mapper = new \DB\SQL\Mapper($this->db, $table);
    }

    /**
     * Returns mapper object
     */
    public function getMapper() {
        return $this->mapper;
    }

}
