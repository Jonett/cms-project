<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author jonih
 */
class user extends database {

    public $userId;
    public $userEmail;
    public $userOid;

    public function __construct($f3, $id) {
        parent::__construct($f3);
        $this->id = $id;
        $this->setUser();
    }

    private function setUser() {
        $database = $this->db;
        $userQuery = $database->exec('SELECT * FROM users WHERE id = ' . $this->id);
        $this->userId = $userQuery[0]['id'];
        $this->userEmail = $userQuery[0]['email'];
        $this->userOid = $userQuery[0]['oid'];
        $this->onBreak = $userQuery[0]['onBreak'];
        $this->breakTimeId = $userQuery[0]['breakTimeId'];
    }

    public function startUserSession() {
        $this->f3->set('SESSION.uid', $this->userId);
        $this->f3->set('SESSION.userEmail', $this->userEmail);
        $this->f3->set('SESSION.oid', $this->userOid);
    }

    public function clearUserSession() {
        $this->f3->clear('SESSION');
    }
}
