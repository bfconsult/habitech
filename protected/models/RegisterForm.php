<?php
/**
 * Register form model
 */
class RegisterForm extends CFormModel
{
    /**
     * @var string - firstname
     */
    public $firstname;

    /**
     * @var string - lastname
     */
    public $lastname;

    /**
     * @var string - password
     */
    public $password;
    
    /**
     * @var string - password2
     */
    public $password2;
    
    /**
     * @var string - email
     */
    public $email;

    /**
     * @var string - captcha
     */
    //public $verifyCode;

    /**
     * table data rules
     *
     * @return array
     */
    public function rules()
    {
        return array(
            array('email', 'match', 'allowEmpty' => false, 'pattern' => '/[A-Za-z0-9\x80-\xFF]+$/' ),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'User' ),
            array('email, password, password2', 'required'),
            array('password', 'length', 'min' => 3, 'max' => 32),
            array('password2', 'compare', 'compareAttribute'=>'password'),
            array('email', 'length', 'min' => 7, 'max' => 55),
        );
    }
    
    /**
     * Attribute values
     *
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('members', 'Email'),
            'password' => Yii::t('members', 'Password'),
            'password2' => Yii::t('members', 'Password Confirmation'),
            //'verifyCode' => Yii::t('members', 'Security Code'),            
            'firstname' => Yii::t('members', 'First Name'),
            'lastname' => Yii::t('members', 'Last Name'),
        );
    }
    
}