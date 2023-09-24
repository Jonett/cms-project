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
class homeController extends homeControllerModel{
    
    public function __construct($f3) {
        parent::__construct($f3);
    }
    
    public function home(){
        $f3 = $this->f3;
        if($f3->get('SESSION.uid')){
            $f3->reroute('/controlpanel');
        }
        $f3->set('content', 'home/home.htm');
        echo \Template::instance()->render('layout.htm');
    }
    
}
