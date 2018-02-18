<?php
class wpUser extends CWebUser implements IWebUser, IApplicationComponent {
        public function init ()
        {
            parent::init();
        }
        function checkAccess ($operation, $params = array()) {
            return current_user_can($operation);
        }

        public function getId() {
            return get_current_user_id();
        }
        public function getIsGuest () {
            $is_user_logged_in = is_user_logged_in();
            return ! $is_user_logged_in;
        }

        public function getName () {
            $user = User::model()->findByPK($this->getId());
            $name = '';
            if ($user) {
                $name = $user->firstname.' '.$user->lastname;
            }
            return $name;
        }

        public function getDeveloper () {
            $user = User::model()->findByPK($this->getId());
            $developer = '';
            if ($user && isset($user->developer)) {
                $developer = $user->developer;
            }
            return $developer;
        }

    public function getCompany () {
        $user = User::model()->findByPK($this->getId());
        $company = '';
        if ($user && isset($user->company->id)) {
            $company = $user->company->id;
        }
        return $company;
    }

        public function loginRequired() {

            $url = Yii::app()->params['protocol'].Yii::app()->params['server'].'/'.Yii::app()->params['app_dir'].'site/login';
            header("Location: ".$url);
            die();
        }
    }
?>