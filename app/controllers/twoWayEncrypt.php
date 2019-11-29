<?php

/**
 * Description of twoWayEncrypt
 * notes: https://stackoverflow.com/questions/9262109/simplest-two-way-encryption-using-php
 * @author jonih
 */
class twoWayEncrypt {
    private 
            $securekey, 
            $iv, 
            $ivSize, 
            $method;
    
    function __construct($authKey)
    {
        //$this->method = "AES-256-CTR";
        $this->method = "AES-256-CBC";
        $this->ivSize = openssl_cipher_iv_length($this->method);
        $this->iv = openssl_random_pseudo_bytes($this->ivSize);
        $this->securekey = hash('sha256', $authKey, TRUE);
    }
    function encrypt($input)
    {
        return base64_encode($this->iv.openssl_encrypt($input, $this->method, $this->securekey, OPENSSL_RAW_DATA, $this->iv));
    }
    function decrypt($input)
    {
        return openssl_decrypt(substr(base64_decode($input), $this->ivSize), $this->method, $this->securekey, OPENSSL_RAW_DATA, substr(base64_decode($input), 0, $this->ivSize));
    }
}
