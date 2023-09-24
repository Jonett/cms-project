<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class onlineCount extends statisticsDatabase {
    public function __construct($f3) {
        parent::__construct($f3);
    }
    public function reduce($uid){
        $timeStamp = date('Y-m-d H:m:s');
        $count = $this->getCount();
        $reduced = $count - 1; 
        $this->db->exec('INSERT INTO onlinecount (timestamp, count, uid) VALUES ("'.$timeStamp.'", '.$reduced.', '.$uid.')');
    }
    public function increase($uid){
        $timeStamp = date('Y-m-d H:M:S');
        $count = $this->getCount();
        $increased = $count + 1; 
        $this->db->exec('INSERT INTO onlinecount (timestamp, count, uid) VALUES ("'.$timeStamp.'", '.$increased.', '.$uid.')');
    }
    public function getCount(){
        $onlineCountQuery = $this->db->exec('SELECT count FROM onlinecount ORDER BY id DESC LIMIT 1');
        return $onlineCountQuery[0]['count'];
    }
}