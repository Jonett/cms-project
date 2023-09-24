<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class state extends statisticsDatabase {

    public function __construct($f3) {
        parent::__construct($f3);
    }

    public function load($objectArray) {
        foreach ($objectArray as $key => $value) {
            $this->f3->set("state." . $key, $value);
        }
        foreach ($this->f3->get('SESSION') as $key => $value) {
            $this->f3->set("state." . $key, $value);
        }
        return "ready";
    }

    public function getState() {
        return $this->f3->get('state');
    }

}
