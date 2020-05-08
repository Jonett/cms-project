<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userlog
 *
 * @author jonih
 */
class userlog extends statisticsDatabase {

    public function __construct($f3) {
        parent::__construct($f3);
    }

    public function getMessage($aid) {
        //väliaikainen debug ratkaisu logi rivien tiedoille
        $problems = [
            0 => "Käyttäjä &&&& päivitti profiilia",
            1 => "Käyttäjä &&&& kirjautui sisään",
            2 => "Käyttäjä &&&& kirjautui ulos"
        ];
        return [$problems[$aid], $aid];
    }

    public function loadPrivateLog() {
        $db = $this->db;
        $logQuery = $db->exec('SELECT * FROM userlog');
        $hash = new twoWayEncrypt($this->f3->HKEY);
        foreach($logQuery as $key => $value){
            $logQuery[$key]['hid'] = $hash->encrypt($value['id']);
        }
        return $logQuery;
    }

    public function updateUserLog($message, $userDataArray = NULL) {
        //message = array jossa 0 = logi teksti, 1 = action id
        $db = $this->db;
        $changes = array();
        $message[0] = str_replace("&&&&", $this->f3->get('SESSION.userEmail'), $message[0]);
        if ($userDataArray != NULL) {
            foreach ($userDataArray as $key => $value) {
                $changes[$key] = utf8_encode($value);
            }
            $changes = json_encode($changes);
        } else {
            $changes = json_encode([]);
        }

        $db->exec('INSERT INTO userlog (action, changes, aid, uid) VALUES ("' . $message[0] . '", "' . $changes . '",' . $message[1] . ',' . $this->f3->get('SESSION.uid') . ')');
    }

}
