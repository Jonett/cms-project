<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class role extends database {
    public $roleId;
    public function __construct($f3, $roleId) {
        parent::__construct($f3);
        $this->roleId = $roleId;
    }
    public function getRoleName(){
        $database = $this->db;
        $roleQuery = $database->exec('SELECT name FROM role WHERE id = '.$this->roleId);
        return $roleQuery[0]['name'];
    }
}