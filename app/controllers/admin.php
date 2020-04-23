<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class admin extends database {

    public function __construct($f3) {
        parent::__construct($f3);
    }

    public function getBusinessArray() {
        $database = $this->db;
        $businessQuery = $database->exec('SELECT * FROM business');
        $businessArray = array();
        foreach ($businessQuery as $key => $value) {
            $businessArray[$value['id']] = $value['name'];
        }
        return $businessArray;
    }

    public function getUsersArray() {
        $database = $this->db;
        $usersArray = array();
        $usersQuery = $database->exec('SELECT * FROM users');
        foreach ($usersQuery as $key => $value) {
            $usersArray[$value['id']] = $value['email'];
        }
        return $usersArray;
    }

    public function registerNew($f3) {
        $f3->set('content', 'register/register.htm');
        echo \Template::instance()->render('layout.htm');
    }

}
