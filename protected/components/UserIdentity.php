<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    protected $_isMd5Password = true;
        /**
         * Authenticates a user.
         * The example implementation makes sure if the username and password
         * are both 'demo'.
         * In practical applications, this should be changed to authenticate
         * against some persistent user identity storage (e.g. database).
         * @return boolean whether authentication succeeds.
         */
    
     public function setUpUser($user_id)
    {
        $this->_id=$user_id;
    }
    
    
    public function authenticate() {

            $users = User::model()->findByAttributes(array('username'=>$this->username));
            if($users === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;                
            }
            else if(!$users->validatePassword($this->password, $this->getIsMd5Password())) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {           
                $this->errorCode = self::ERROR_NONE;
                $this->_id = $users->id;
                $this->username = $users->username;
                $this->setState('id', $this->_id);
             
            }
            
            return !$this->errorCode;
        }
        
        public function getId() {
            return $this->_id;
        }

        public function setId($id){
            return $this->_id = $id;
        }

        public function setIsMd5Password($isMd5Password) {
            $this->_isMd5Password = $isMd5Password;
        }

        public function getIsMd5Password() {
            return $this->_isMd5Password;
        }
}