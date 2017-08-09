<?php

namespace Security;

class Token{

    public $token;
    public $maxAge = 300;
    /**
     * Generates token in HEX 
     *
     * @return void
     */
    public function generateToken(){
        //if(empty($_SESSION['token']) && (empty($_SESSION['tokenAge']) || (time() - (int)$_SESSION['tokenAge']) > (int)$this->maxAge)){
            if(function_exists('random_bytes')){
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }elseif(function_exists('mcrypt_create_iv')){
                $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
            }else{
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
            $_SESSION['tokenAge'] = time();
        //}        
    }

    /**
     * Checks token and the time bewteen token created and token age after POST
     *
     * @param string $token
     * @param int $maxAge (default = 300)
     * @return bool
     */
    public function validateToken($token, $maxAge = 300){
        $this->maxAge = $maxAge;
        if($token != $_SESSION['token'] || ((time() - (int)$_SESSION['tokenAge']) > (int)$this->maxAge)){
            return false;
        }else{
            unset($_SESSION['token'], $_SESSION['tokenAge']);
            return true;
        }
    }

    /**
     * Create hidden input[name=_once | value=token] field with session token
     *
     * @return string html entity
     */
    public function createTokenInput(){
        $this->generateToken();
        return '<input type="hidden" name="_once" value="' . $_SESSION['token'] . '">';
    }

}
