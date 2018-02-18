<?php

class SiteController extends Controller
{

    private $uploadFolder = '/uploads/';

    /**
     * Declares class-based actions.
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', // deny all users
                'users' => array(
                    'terms'
                )
            ),
            array(
                'allow', // allow all users to perform '' actions
                'actions' => array(
                    'forgotpassword',
                    'newpassword'
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'verify',
                    'view',
                    'create',
                    'quickaddvintage',
                    'update',
                    'inlineupdate',
                    'addvintage',
                    'addvariety',
                    'addregion',
                    'uploadimage',
                    'gettingstarted',
                    'first'
                ),
                // 'roles'=>array('@'),
                'users' => array(
                    '@'
                )
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'admin',
                    'delete'
                ),
                // 'roles'=>array('admin'),
                'users' => array(
                    'admin'
                )
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            )
        );
    }

    public function actions() {
        return array('upload' => array('class' => 'xupload.actions.XUploadAction',
            'path' => Yii::app() -> getBasePath() . "/../uploads",
            "publicPath" => Yii::app()->getBaseUrl()."/uploads" ), );
    }



    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
$this->layout='main';
        $this -> render('index');
    }




    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app() -> errorHandler -> error) {
            if (Yii::app() -> request -> isAjaxRequest)
                echo $error['message'];
            else
                $this -> render('error', $error);
        }
    }




public function actionFirst()
    {
        /**
         * @var Project $project for wizard
         */
        $project = new Project();

        $company = User::model()->myCompany();
        $model = Company::model()->findbyPK($company);
        $type = User::model()->myCompanyType();
        $recentProjects = Project::model()->myRecentProjects(1);
        $recents = Project::model()->myActivity();
        $series = $this->_getSeries($recentProjects);
        $this->render('index', array(
            'company' => $company,
            'model' => $model,
            'type' => $type,
            'project' => $project,
            'recents'=>$recents,
            'series' => $series
        ));
    }

    public function actionVerify()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('verify');
    }

    /**
     * Get series data for chart on homepage
     *
     * @author vanlan228@gmail.com
     * @param array $project
     * @return boolean | array
     */
    private function _getSeries($projects) {
        if(empty($projects))
            return false;
        $currentdate = date('Y-m-d H:i:s');
        $startdate =  date("Y-m-d H:i:s", strtotime("-28 days", strtotime($currentdate)));
        $loopstart = strtotime($startdate);
        $loopend = strtotime ($currentdate);
        foreach ($projects as $project) {
            for ( $i = $loopstart; $i <= $loopend; $i = $i + 86400 ) {
              $thisdate = date( 'd', $i );
              $days[$project['id']][$thisdate] = 0;
            }
        }

        $chartdata = Project::model()->myProjectActivity($projects);
        foreach ($chartdata as $datapoint){
            $days[$datapoint['project_id']][$datapoint['day']]= floatval($datapoint['changes']);
        }
       // echo "<pre>";
        //print_r($chartdata);
        //die;
        $series = array();
        foreach ($projects as $project) {
            $project_data = array();
            $project_data['name'] = $project['name'];
            $project_data['data'] = array();
            $tempProject = array();
            for ( $i = $loopstart; $i <= $loopend; $i = $i + 86400 )
            {
                $thisdate = date( 'd', $i );
                array_push($tempProject,$days[$project['id']][$thisdate]);
            }
            $project_data['data'] = array_reverse($tempProject);
            array_push($series, $project_data);
        }



        return $series;
    }



    public function actionGettingStarted()
    {
        $model = new ContactForm();
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" . "Reply-To: {$model->email}\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('gettingstarted', array(
            'model' => $model
        ));
    }

    public function actionAdmin()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('admin');
    }


    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" . "Reply-To: {$model->email}\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array(
            'model' => $model
        ));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {

            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())


                $this->redirect(Yii::app()->params['protocol'] . Yii::app()->params['server'] . '/' . Yii::app()->params['app_dir'] . 'site/index');
        }

        // display the login form
        // CHECK IF A USER IS LOGGED IN AND REDIRECT TO INDEX IF NOT, REDIRECT TO LOGIN
        if (Yii::app()->user->isGuest) { // not logged in
            $this->render('login', array(
                'model' => $model
            )); //
                                                                  // $this->redirect(array('site/login')); /// redirect to target page
        } else {
            $this->redirect(Yii::app()->params['protocol'] . Yii::app()->params['server'] . '/' . Yii::app()->params['app_dir'] . 'site/index');
            // $this->render('index'); /// redirect to target page
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();

        $this->redirect('/site/login/');
    }

    public function actionForgotPassword()
    {
        $model = new User('resendConfirmation');

        if (isset($_POST['LoginForm'])) {

            $model->attributes = $_POST['LoginForm'];

            $errors = CActiveForm::validate($model);
            if ($errors == '[]') {
                $model = User::model()->find('email = :email', array(
                    ':email' => $model->email
                ));
                if ($model) {
                    // send the email
                    $model->verification_code = substr(sha1($model->email . time()), 0, 10);
                    $model->save(false);

                    $mail = new YiiMailer();
                    $mail->setFrom('info@reqFire.com', 'ReqFire Password Support');
                    $mail->setTo($model->email);
                    $mail->setSubject('ReqFire Password Reset');
                    $mail->setBody($model->firstname . ',<br/>
              We got a request to change your password. <br/>
                Please
                <a href="' . Yii::app()->getBaseUrl(true) . '/site/newpassword?code=' . $model->verification_code . '">
                Click here</a> to reset you password.<br/>
                <br/>
                Alternatively you can copy this URL into your web browser:<br />
                ' . Yii::app()->getBaseUrl(true) . '/site/newpassword?code=' . $model->verification_code . '

                ');
                    $mail->Send();

                    $errors = CJSON::encode(array(
                        'success' => 'true',
                        'message' => 'Reset Password link sent to your email'
                    ));
                } else {
                    $errors = CJSON::encode(array(
                        'success' => 'true',
                        'message' => 'Reset Password link sent to your email'
                    ));
                }
            }

            echo $errors;
            Yii::app()->end();
        }
    }

    public function actionNewPassword()
    {
        if (empty($_GET['code']))
            $this->redirect('/req/site/login');

        $model = new User('newPassword');

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];
            $errors = CActiveForm::validate($model);

            if ($errors == '[]') {

                $user = $model->find('verification_code = :vc', array(
                    ':vc' => $_GET['code']
                ));

                if ($user) {

                    $user->verification_code = '';
                    $user->password = $model->password;

                    $user->save(false);

                    $errors = CJSON::encode(array(
                        'success' => 'true',
                        'message' => 'Password updated successfully'
                    ));
                } else
                    $errors = CJSON::encode(array(
                        'success' => 'true',
                        'message' => 'Code expired, please try again'
                    ));
            }

            echo $errors;
            Yii::app()->end();
        }

        $this->render('new_password', array(
            'model' => $model
        ));
    }

}
