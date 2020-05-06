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
    
    public function createNewBusiness(){
        $payload = $this->f3->get('POST');

        $database = $this->db;
        $database->exec('INSERT INTO business (owner_id, status, name) VALUES ('.$payload['owner_id'].', '.$payload['status'].', "'.$payload['name'].'")');
        $this->f3->reroute('/');
    }
    public function newUser(){
        $payload = $this->f3->get('POST');

        $database = $this->db;
        $database->exec('INSERT INTO users (email, oid, status) VALUES ("'.$payload['email'].'", '.$payload['oid'].', '.$payload['status'].')');
        $this->f3->reroute('/');
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

    public function createNewUser() {
        $this->f3->set('content', 'register/register.htm');
        echo \Template::instance()->render('layout.htm');
    }
    
    public function selectBusiness(){
        $payload = $this->f3->get('POST');
        $business = new business($this->f3, $payload['business_id']);
        $businessTemplate = $business->getBusinessTemplate();
        print $businessTemplate;
    }
    
    public function selectUser(){
        $payload = $this->f3->get('POST');
        $user = new user($this->f3, $payload['user_id']);
        $userTemplate = $user->getUserTemplate();
        print $userTemplate;
    }

}
