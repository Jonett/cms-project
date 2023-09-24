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

    public function login() {
        $userPassword = $this->f3->clean($this->f3->get('POST')['password']);
        $userEmail = $this->f3->clean($this->f3->get('POST')['email']);
        $userSavelogin = $this->f3->clean($this->f3->get('POST')['saveLogin']);

        if (strlen($userPassword) > 5) {
            if ($this->isUser($userEmail) && $userId = $this->autheticateUser($userEmail, $userPassword)) {
                $user = new user($this->f3, $userId);
                if ($user->status == 0) {
                    $this->f3->set('SESSION.disabledAccountWarning', 'TRUE');
                    $this->f3->reroute('/');
                }
                $user->startUserSession();
                $this->f3->reroute('/dashboard');
            } else {
                $this->f3->reroute('/');
            }
        } else if ($this->isUser($userEmail)) {
            $state = new state($this->f3);
            $this->f3->set('SESSION.userEmail', $userEmail);
            $stateStatus = $state->load(array(
                "updatePwd" => "true"
            ));
            $this->f3->reroute('/updatepwd');
        } else {
            $this->f3->reroute('/');
        }
    }

    public function updatePassword() {
        $this->f3->set('content', 'home/homeNewPassword.htm');
        echo \Template::instance()->render('layout.htm');
    }

    public function updateUserPassword() {
        $userEmail = $this->f3->get('SESSION.userEmail');
        $userPassword = $this->f3->clean($this->f3->get('POST')['password']);
        $userPasswordHash = password_hash($userPassword, PASSWORD_BCRYPT);
        $this->updateUserPasswordByEmail($userEmail, $userPasswordHash);
        $state = new state($this->f3);
        $stateStatus = $state->load(array(
            "noPwdResult" => "false"
        ));
        $this->f3->reroute('/');
    }
    

    public function logout() {
        $userId = $this->f3->get('SESSION.uid');
        $user = new user($this->f3, $userId);
        $user->clearUserSession();
        $this->f3->reroute('/');
    }

    protected function autheticateUser($email, $password) {
        //0 = id, 1 = pwdhash
        $userData = $this->getUserCredentials($email);
        $result = password_verify($password, $userData[1]);
        return ($result ? $userData[0] : NULL);
    }

}
