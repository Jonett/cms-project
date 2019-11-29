<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboardController
 *
 * @author jonih
 */
class dashboardController extends dashboardModel {
    
    private $user;
    
    public function __construct($f3) {
        parent::__construct($f3);
        $userId = $f3->get('SESSION.uid');
        $this->user = new user($f3, $userId);
    }
    
    public function dashboard(){
        $f3 = $this->f3;
        $f3->set('navMessage', 'Tervetuloa '.$this->user->userEmail);
        $f3->set('content', 'dashboard/dashboard.htm');
        echo \Template::instance()->render('layout.htm');
    }
    
}
