<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of authenticationController
 *
 * @author jonih
 */
class authenticationModel extends database {

    public function __construct($f3) {
        parent::__construct($f3);
    }

    public function isUser($email) {
        $emailQuery = ( $email ? $this->db->exec('SELECT email, password FROM users WHERE email = "' . $email . '"') : array() );
        
        return (count($emailQuery) > 0 ? TRUE : FALSE);
    }
    
    public function getUserCredentials($email){
        $database = $this->db;
        $passwordQuery = $database->exec('SELECT id, password FROM users WHERE email = "' . $email . '"');
        $userPassword = $passwordQuery[0]['password'];
        $userId = $passwordQuery[0]['id'];
        return array($userId, $userPassword);
    }
    public function updateUserPasswordByEmail($email, $passwordHash){
        $database = $this->db;
        $database->exec('UPDATE users SET password = "' . $passwordHash . '" WHERE email = "' .$email.'"');
    }
    
}
