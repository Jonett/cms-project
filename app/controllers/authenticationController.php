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
class authenticationController extends authenticationModel {
    public function __construct($f3) {
        parent::__construct($f3);
    }
    
    public function login(){
        $userPassword = $this->f3->clean($this->f3->get('POST')['password']);
        $userEmail = $this->f3->clean($this->f3->get('POST')['email']);
        $userSavelogin = $this->f3->clean($this->f3->get('POST')['saveLogin']);
        
        if(strlen($userPassword) > 5){
            if($this->isUser($userEmail) && $userId = $this->autheticateUser($userEmail, $userPassword)){
                $user = new user($this->f3, $userId);
                if($user->status == 0){
                    $this->f3->set('SESSION.disabledAccountWarning', 'TRUE');
                    $this->f3->reroute('/');
                }
                $user->startUserSession();
                $this->f3->reroute('/dashboard');
            }else{
                $this->f3->reroute('/');
            }
        }else{
            $this->f3->reroute('/');
        }
    }
    
    public function logout(){
        $userId = $this->f3->get('SESSION.uid');
        $user = new user($this->f3, $userId);
        $user->clearUserSession();
        $this->f3->reroute('/');
    }
    
    private function autheticateUser($email, $password){
        $userPasswordHash = $this->getUserCredentials($email);
        $result = password_verify($password, $userPasswordHash[1]);
        return ($result ? $userPasswordHash[0] : NULL);
    }    
    
}
