<?php

class business extends database {

    public $id;
    public $hashedId;
    public $owner_id;
    public $status;
    public $name;
    public $addressData1;
    public $addressData2;
    public $postNumber;
    public $email;
    

    
    public function __construct($f3, $id) {
        parent::__construct($f3);
        $this->id = $id;
        if ($id != NULL && gettype($id) == 'integer') {
            $twoWayEncryption = new twoWayEncrypt($f3->HKEY);
            $hashedId = $twoWayEncryption->decrypt($id);
            $this->hashedId = $hashedId;
            $this->setBusiness();
        }else if($id == NULL){
            $this->getFullBusinesslisting();
        }
    }

    private function setBusiness() {
        $database = $this->db;
        $businessQuery = $database->exec('SELECT * FROM business WHERE id = ' . $this->id);
        $this->id = $businessQuery[0]['id'];
        $this->owner_id = $businessQuery[0]['owner_id'];
        $this->status = $businessQuery[0]['status'];
        $this->name = $businessQuery[0]['name'];
        $this->addressData1 = $businessQuery[0]['addressData1'];
        $this->addressData2 = $businessQuery[0]['addressData2'];
        $this->postNumber = $businessQuery[0]['postNumber'];
        $this->email = $businessQuery[0]['email'];
        
       
    }
    
    public function getFullBusinesslisting(){
        if($this->f3->get('SESSION.role') != '1'){
            return [0=>'Fuck you'];
        }
        
        $database = $this->db;
        $twoWayEncryption = new twoWayEncrypt($this->f3->HKEY);
        $businessList = $database->exec('SELECT * FROM business');
        foreach($businessList as $key => $value){
            $user = new user($this->f3, $value['owner_id']);
            $businessList[$key]['owner_email'] = $user->userEmail;
            $businessList[$key]['owner_fullname'] = $user->fullName;
            $businessList[$key]['owner_id'] = $user->userId;
            $businessList[$key]['hashOwner'] = $twoWayEncryption->encrypt($user->userId);
            $businessList[$key]['owner_addressData1'] = $user->addressData1;
            $businessList[$key]['owner_addressData2'] = $user->addressData2;
            $businessList[$key]['owner_postNumber'] = $user->postNumber;
            $businessList[$key]['owner_phone'] = $user->phone;
            $businessList[$key]['owner_phone'] = $user->phone;
            $businessList[$key]['employees'] = $this->getEmployeeListById($value['id']);
            $businessList[$key]['clients'] = $this->getClientsListById($value['id']);
        }
        return $businessList;
    }

    public function getEmployeeListById($id){
        $database = $this->db;
        $employeeQuery = $database->exec('SELECT id, fullName, adressData1, adressData2, postNumber, phone FROM users WHERE oid = '.$id);
        return $employeeQuery;
        
    }
    public function getClientsListById($id){
        $database = $this->db;
        $clientQuery = $database->exec('SELECT id, name FROM clients WHERE oid = '.$id);
        return $clientQuery;
    }
    public function getBusinessTemplate() {
        $this->f3->set('businessName', $this->name);
        $this->f3->set('businessOwnerId', $this->owner_id);
        $this->f3->set('businessStatus', $this->status);
        $template = \Template::instance()->render('/controlpanel/businessTemplate.htm');
        return $template;
    }

}
