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
class registerationModel extends database{
    public function __construct($f3) {
        parent::__construct($f3);

    }
    public function validateRegisteration($registerationCode){
        $cleanCode = $this->f3->clean($registerationCode);
        if($cleanCode){
            $database = $this->db;
            $queryResults = $database->exec('SELECT * FROM registerationcodes WHERE code = "'.$cleanCode.'"');
        }else{
            $queryResults = array();
        }
        if(count($queryResults) > 0){
            $this->f3->set('SESSION.organisationId', $queryResults[0]['oid']);
            return TRUE;
        }
    }
    public function saveNewUser($userEmail, $userPasswordHash, $organisationId){
        $database = $this->db;
        $database->exec('INSERT INTO users (email, password, oid) VALUES ("'.$userEmail.'","'.$userPasswordHash.'","'.$organisationId.'")');
    }
    

}
