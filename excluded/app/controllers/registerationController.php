<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of homeController
 *
 * @author jonih
 */
class registerationController extends registerationModel{
    
    public function __construct($f3) {
        parent::__construct($f3);
    }
    
    public function register(){
        $f3 = $this->f3;
        if($f3->get('SESSION.uid')){
            $f3->reroute('/controlpanel');
        }
        $registerationCodeStatus = $f3->get('SESSION.registerationCodeStatus');
        $passwordStatus = $f3->get('SESSION.passwordStatus');
        if($passwordStatus){
            $f3->set('passwordComparisonCheck', 'TRUE');
        }
        if($registerationCodeStatus){
            $f3->set('invalidCode', 'TRUE');
        }
        $f3->set('content', 'register/register.htm');
        echo \Template::instance()->render('layout.htm');
        $f3->clear('SESSION');
    }
    
    public function registerNewUser(){
        $f3 = $this->f3;
        $userPassword = $f3->clean($f3->get('POST')['password']);
        $userPasswordCheck = $f3->clean($f3->get('POST')['passwordCheck']);
        if(strlen($userPassword) <= 5){
            $f3->set('SESSION.passwordStatusTooShort', 'TRUE');
            $f3->reroute('/register');
        }
        if($userPassword != $userPasswordCheck){
            $f3->set('SESSION.passwordStatus', 'TRUE');
            $f3->reroute('/register');
        }
        $registerationCode = $f3->get('POST')['registerationCode'];
        if($this->validateRegisteration($registerationCode)){
            $userEmail = $f3->clean($f3->get('POST')['email']);
            $organisationId = $f3->get('SESSION.organisationId');
            $userPasswordHash =  password_hash($userPassword, PASSWORD_BCRYPT);
            $this->saveNewUser($userEmail, $userPasswordHash, $organisationId);
            $f3->reroute('/');
        }else{
            $f3->set('SESSION.registerationCodeStatus', 'TRUE');
            $f3->reroute('/register');
        }
    }
    
}
