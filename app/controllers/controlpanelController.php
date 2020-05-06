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
class controlpanelController extends controlpanelModel {

    public function __construct($f3) {
        parent::__construct($f3);
    }

    public function controlpanel() {
        $f3 = $this->f3;
        $user = new user($f3, $f3->get('SESSION.uid'));
        if ($this->f3->get('SESSION.role') == '1') {
            $admin = new admin($f3); 
            $online = new onlineCount($f3);
            $business = new business($f3, NULL); 
            $state = new state($f3);
            $f3->set('content', 'controlpanel/controlpanel.htm');
            $objectArray = array(
                "content" => array("controlpanel/controlpanel.htm"),
                "navMessage" => $this->f3->get('SESSION.userEmail'),
                "onlineCount" => $online->getCount(),
                "businessList" => $admin->getBusinessArray(),
                "usersList" => $admin->getUsersArray(),
                "fullBusinesslisting" => $business->getFullBusinesslisting(),
                "collection" => ($f3->get('SESSION.role') == '1' ? $this->getEmployees() : [])
            );
            $loadstatus = $state->load($objectArray);
        }
            if($loadstatus == "ready"){
                
                echo \Template::instance()->render('layout.htm');
            }else{
                $user->clearUserSession();
                $f3->reroute('/');
            }
        
    }

    public function updateUserStatus() {
        $f3 = $this->f3;
        $userIdHash = $f3->clean($f3->get('POST')['uid']);
        $currentStatus = $f3->clean($f3->get('POST')['current']);
        if ($currentStatus != 0 && $currentStatus != 1) {
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

    public function updateUserPassword() {
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

    public function updateUser() {
        $f3 = $this->f3;
        $userId = $this->f3->get('SESSION.uid');
        $user = new user($f3, $userId);

        $email = $f3->clean($f3->get('POST')['email']);
        $password = $f3->clean($f3->get('POST')['password']);

        if ($email != $user->userEmail) {
            $user->setEmail($email);
        }
        if (strlen($password) > 5) {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $user->setPassword($passwordHash);
        }
        $f3->reroute('/logout');
    }

    private function getEmployees() {
        $organisationId = $this->f3->get('SESSION.oid');
        return $this->getEmployeeArray($organisationId);
    }

    private function getTools() {
        $organisationId = $this->f3->get('SESSION.oid');
        return $this->getToolsArray($organisationId);
    }

}
