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
    public $organisationAdmin;
    public $status;

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
        $this->status = $userQuery[0]['status'];
        
        $businessQuery = $database->exec('SELECT * FROM business WHERE id = ' . $this->userOid);
        $this->organisationAdmin = ($businessQuery[0]['owner_id'] == $this->userId ? 1 : 0);
    }

    public function startUserSession() {
        $this->f3->set('SESSION.uid', $this->userId);
        $this->f3->set('SESSION.userEmail', $this->userEmail);
        $this->f3->set('SESSION.oid', $this->userOid);
        $this->f3->set('SESSION.organisationAdmin', $this->organisationAdmin);
    }

    public function clearUserSession() {
        $this->f3->clear('SESSION');
    }

    public function setStatus($status) {
        $database = $this->db;
        $database->exec('UPDATE users SET status = ' . $status . ' WHERE id = ' . $this->userId);
    }

    public function setPassword($passwordHash) {
        $database = $this->db;
        $database->exec('UPDATE users SET password = "' . $passwordHash . '" WHERE id = ' . $this->userId);
    }

    public function setEmail($email) {
        $database = $this->db;
        $database->exec('UPDATE users SET email = "' . $email . '" WHERE id = ' . $this->userId);
    }

}
