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
            $userLog = new userlog($f3);
            $f3->set('content', 'controlpanel/controlpanel.htm');
            $objectArray = array(
                "content" => array("controlpanel/controlpanel.htm"),
                "navMessage" => $this->f3->get('SESSION.userEmail'),
                "onlineCount" => $online->getCount(),
                "businessList" => $admin->getBusinessArray(),
                "usersList" => $admin->getUsersArray(),
                "fullBusinesslisting" => $business->getFullBusinesslisting(),
                "collection" => ($f3->get('SESSION.role') == '1' ? $this->getEmployees() : []),
                "privateUserlog" =>  $userLog->loadPrivateLog()
            );
            $loadstatus = $state->load($objectArray);
        }
        if ($loadstatus == "ready") {

            echo \Template::instance()->render('layout.htm');
        } else {
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
        $postEmail = $f3->clean($f3->get('POST')['email']);
        $postPassword = $user->$f3->clean($f3->get('POST')['password']);
        $postFullName = $f3->clean($f3->get('POST')['fullName']);
        $postAddressData1 = $f3->clean($f3->get('POST')['addressData1']);
        $postAddressData2 = $f3->clean($f3->get('POST')['addressData2']);
        $postPostNumber = $f3->clean($f3->get('POST')['postNumber']);
        $postPhone = $f3->clean($f3->get('POST')['phone']);
        $userDataArray = array(
            "email" => ($user->userEmail == $postEmail ? NULL : $postEmail),
            "password" => (strlen($postPassword) > 5 ? password_hash($postPassword, PASSWORD_BCRYPT) : NULL ),
            "fullName" => ($user->fullName == $postFullName ? NULL : $postFullName),
            "addressData1" => ($user->addressData1 == $postAddressData1 ? NULL : $postAddressData1),
            "addressData1" => ($user->addressData2 == $postAddressData2 ? NULL : $postAddressData2),
            "postNumber" => ($user->postNumber == $postPostNumber ? NULL : $postPostNumber),
            "phone" => ($user->phone == $postPhone ? NULL : $postPhone),
            "role" => $f3->clean($f3->get('POST')['role'])
        );
        if ($userDataArray["password"] != NULL) {
            $user->setPassword($userDataArray["password"]);
        }
        
        if ($this->f3->STATS == 'ENABLED') {
            $userLog = new userlog($f3);
            //TODO: FIX THIS CARBAGE
            $userLog->updateUserLog($userLog->getMessage(0), $userDataArray);
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
