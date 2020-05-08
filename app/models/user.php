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
    public $role;
    public $addressData1;
    public $addressData2;
    public $postNumber;
    public $phone;
    public $fullName;

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
        $this->role = $userQuery[0]['role'];
        $this->addressData1 = $userQuery[0]['adressData1'];
        $this->addressData2 = $userQuery[0]['adressData2'];
        $this->postNumber = $userQuery[0]['postNumber'];
        $this->phone = $userQuery[0]['phone'];
        $this->fullName = $userQuery[0]['fullName'];
        if ($this->userOid != 0) {
            $businessQuery = $database->exec('SELECT * FROM business WHERE id = ' . $this->userOid);
            $this->organisationAdmin = ($businessQuery[0]['owner_id'] == $this->userId ? 1 : 0);
        }else{
            $this->organisationAdmin = NULL;
        }
    }

    public function startUserSession() {
        
        $this->f3->set('SESSION.uid', $this->userId);
        $this->f3->set('SESSION.userEmail', $this->userEmail);
        $this->f3->set('SESSION.oid', $this->userOid);
        $this->f3->set('SESSION.fullName', $this->fullName);
        $this->f3->set('SESSION.phone', $this->phone);
        $this->f3->set('SESSION.addressData1', $this->addressData1);
        $this->f3->set('SESSION.addressData2', $this->addressData2);
        $this->f3->set('SESSION.postNumber', $this->postNumber);
        
        $this->f3->set('SESSION.organisationAdmin', $this->organisationAdmin);
        $role = new role($this->f3, $this->role);
        $this->f3->set('SESSION.role_name', $role->getRoleName());
        $this->f3->set('SESSION.role', $this->role);
        if($this->f3->STATS == 'ENABLED'){
            $online = new onlineCount($this->f3);
            $online->increase($this->userId);
            $userLog = new userlog($this->f3);
            //TODO: FIX THIS CARBAGE
            $userLog->updateUserLog($userLog->getMessage(1));
        }
    }

    public function clearUserSession() {
        if($this->f3->STATS == 'ENABLED'){
            $online = new onlineCount($this->f3);
            $online->reduce($this->userId);
            $userLog = new userlog($this->f3);
            //TODO: FIX THIS CARBAGE
            $userLog->updateUserLog($userLog->getMessage(2));
            
        }
        $this->f3->clear('state');
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
    
    public function getUserTemplate(){
        $this->f3->set('userName', $this->userEmail);
        $this->f3->set('userId', $this->userId);
        $enc = new twoWayEncrypt($this->f3->HKEY);
        $this->f3->set('userhid', $enc->encrypt($this->userId));
        $this->f3->set('userStatus', $this->status);
        $template = \Template::instance()->render('/controlpanel/userTemplate.htm');
        return $template;
    }

}
