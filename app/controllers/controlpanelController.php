<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controlpanelController
 *
 * @author jonih
 */
class controlpanelController extends controlpanelModel{
    public function __construct($f3) {
        parent::__construct($f3);
    }
    
    public function controlpanel(){
        $f3 = $this->f3;
        if($f3->get('SESSION.organisationAdmin') == 1){
            $f3->set('employees', $this->getEmployees());
            $f3->set('tools', $this->getTools());
        }
        $f3->set('navMessage', $this->f3->get('SESSION.userEmail'));
        $f3->set('content', 'controlpanel/controlpanel.htm');
        echo \Template::instance()->render('layout.htm');
    }
    
    public function updateUserStatus(){
        $f3 = $this->f3;
        $userIdHash = $f3->clean($f3->get('POST')['uid']);
        $currentStatus = $f3->clean($f3->get('POST')['current']);
        if($currentStatus != 0 && $currentStatus != 1){
            $f3->reroute('/logout');
            exit();
        }
        $twoWayEncryption = new twoWayEncrypt($f3->HKEY);
        $userId = $twoWayEncryption->decrypt($userIdHash);
        $status = ($currentStatus == 0 ? 1 : 0);
        $user = new user($f3, $userId);
        $user->setStatus($status);
        $f3->reroute('/controlpanel');
    }
    
    public function updateUserPassword(){
        $f3 = $this->f3;
        $userIdHash = $f3->clean($f3->get('POST')['uid']);
        $newPassword = $f3->clean($f3->get('POST')['newPassword']);
        $twoWayEncryption = new twoWayEncrypt($f3->HKEY);
        $userId = $twoWayEncryption->decrypt($userIdHash);
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $user = new user($f3, $userId);
        $user->setPassword($passwordHash);
        $f3->reroute('/controlpanel');
    }
    
    public function updateUser(){
        $f3 = $this->f3;
        $userId = $this->f3->get('SESSION.uid');
        $user = new user($f3, $userId);
        
        $email= $f3->clean($f3->get('POST')['email']);
        $password = $f3->clean($f3->get('POST')['password']);
        
        if($email != $user->userEmail){
            $user->setEmail($email);
        }
        if(strlen($password) > 5){
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $user->setPassword($passwordHash);
        }
        $f3->reroute('/logout');
    }
    
    public function updateToolName(){
        $f3 = $this->f3;
        $toolName = $f3->clean($f3->get('POST')['name']);
        $toolHashId = $f3->clean($f3->get('POST')['tool']);
        $this->setToolName($toolName, $toolHashId);
        $f3->reroute('/controlpanel');
    }
    
    public function updateToolpph(){
        $f3 = $this->f3;
        $toolpph = $f3->clean($f3->get('POST')['pph']);
        $toolHashId = $f3->clean($f3->get('POST')['tool']);
        $this->setToolpph($toolpph, $toolHashId);
        $f3->reroute('/controlpanel');
    }
    
    public function updateToolStatus(){
        $f3 = $this->f3;
        $toolHashId = $f3->clean($f3->get('POST')['tool']);
        $currentStatus = $f3->clean($f3->get('POST')['current']);
        if($currentStatus != 0 && $currentStatus != 1){
            $f3->reroute('/logout');
            exit();
        }
        $this->setToolStatus($currentStatus, $toolHashId);
        $f3->reroute('/controlpanel');
    }
    
    public function newTool(){
        $f3 = $this->f3;
        $toolName = $f3->clean($f3->get('POST')['newtoolname']);
        $toolpph = $f3->clean($f3->get('POST')['newtoolpph']);
        $oid = $f3->get('SESSION.oid');
        $this->setNewTool($toolName, $toolpph, $oid);
        $f3->reroute('/controlpanel');
    }
    
    private function getEmployees(){
        $organisationId = $this->f3->get('SESSION.oid');
        return $this->getEmployeeArray($organisationId);
    }
    private function getTools(){
        $organisationId = $this->f3->get('SESSION.oid');
        return $this->getToolsArray($organisationId);
    
    }
    
    
}
