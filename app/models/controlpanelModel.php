<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controlpanelModel
 *
 * @author jonih
 */
class controlpanelModel extends database{
    public function __construct($f3) {
        parent::__construct($f3);
    }
    
    public function getEmployeeArray($organisationId){
        $database = $this->db;
        $usersQuery = $database->exec('SELECT id, email, status FROM users WHERE oid = '.$organisationId);
        $usersArray = array();
        $twoWayEncrypt = new twoWayEncrypt($this->f3->HKEY);
        $count = 0;
        foreach($usersQuery as $key => $value){
            $usersArray[$count]['hid'] = $twoWayEncrypt->encrypt($value['id']);
            $usersArray[$count]['id'] = $value['id'];
            $usersArray[$count]['email'] = $value['email'];
            $usersArray[$count]['status'] = $value['status'];
            $count++;
        }
        return $usersArray;
    }
    public function getToolsArray($organisationId){
        $database = $this->db;
        $toolsQuery = $database->exec('SELECT * FROM punchtools WHERE oid = '.$organisationId);
        $toolsArray = array();
        $twoWayEncrypt = new twoWayEncrypt($this->f3->HKEY);
        $count = 0;
        foreach($toolsQuery as $key => $value){
            $toolsArray[$count]['hid'] =  $twoWayEncrypt->encrypt($value['id']);
            $toolsArray[$count]['id'] = $value['id'];
            $toolsArray[$count]['name'] = $value['name'];
            $toolsArray[$count]['pph'] = $value['priceperhour'];
            $toolsArray[$count]['status'] = $value['status'];
            $count++;
        }
        return $toolsArray;
    }
    
    public function setToolName($toolName, $toolHashId){
        $twoWayEncrypt = new twoWayEncrypt($this->f3->HKEY);
        $database = $this->db;
        $toolId = $twoWayEncrypt->decrypt($toolHashId);
        $database->exec('UPDATE punchtools SET name = "'.$toolName.'" WHERE id = '.$toolId);
    }
    
    public function setToolpph($toolpph, $toolHashId){
        $twoWayEncrypt = new twoWayEncrypt($this->f3->HKEY);
        $database = $this->db;
        $toolId = $twoWayEncrypt->decrypt($toolHashId);
        $database->exec('UPDATE punchtools SET priceperhour = "'.$toolpph.'" WHERE id = '.$toolId);
    }
    public function setToolStatus($currentStatus, $toolHashId){
        $twoWayEncrypt = new twoWayEncrypt($this->f3->HKEY);
        $database = $this->db;
        $toolId = $twoWayEncrypt->decrypt($toolHashId);
        $status = ($currentStatus == 0 ? 1 : 0);
        $database->exec('UPDATE punchtools SET status = "'.$status.'" WHERE id = '.$toolId);
    }
    public function setNewTool($toolName, $toolpph, $oid){
        $database = $this->db;
        $database->exec('INSERT INTO punchtools ( name, oid, priceperhour ) VALUES( "'.$toolName.'", "'.$oid.'", "'.$toolpph.'" )');
    }
    public function getClientsArray($organisationId){
        $database = $this->db;
        $twoWayEncrypt = new twoWayEncrypt($this->f3->HKEY);
        $clientsQuery = $database->exec('SELECT * FROM organisationclients WHERE oid = '.$organisationId);
        $clientsArray = array();
        $count = 0;
        foreach($clientsQuery as $key => $value){
            $clientsArray[$count]['hid'] = $twoWayEncrypt->encrypt($value['id']);
            $clientsArray[$count]['name'] = $value['name'];
            $clientsArray[$count]['streetaddress'] = $value['streetaddress'];
            $clientsArray[$count]['postcode'] = $value['postcode'];
            $clientsArray[$count]['postarea'] = $value['postarea'];
            $clientsArray[$count]['email'] = $value['email'];
            $clientsArray[$count]['phonenumber'] = $value['phonenumber'];
            $count++;
        }
        return $clientsArray;
    }
}
