<?php

class UserController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('promote','demote','sack','index','invite','view','create','update','admin','delete'),
                'roles'=>array('@'),
                /*'users'=>array('@'),*/
            ),
            /*array('allow',
                'actions'=>array(),
                'users'=>array('admin'),
            ),*/
            array('allow',
                'actions'=>array('join','accept','active','success'),
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {

        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionmyaccount()
    {

        $this->render('myaccount',array(
            'model'=>$this->loadModel(Yii::App()->user->id),
        ));
    }
    public function actionJoinSuccess()
    {

        $this->render('joinsuccess');
    }
    public function actionWelcome()
    {

        $this->render('welcome');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
            //        'users'=>$users,
        ));
    }


    public function actionJoin()
    {


        $model = new RegisterForm;

        if(isset($_POST['RegisterForm'])){
            $model->attributes = $_POST['RegisterForm'];

            if($model->validate()){
                $user = new User;
                $user->attributes = $_POST['RegisterForm'];

                $user->username = $user->email;

                if($user->save()){
                    /*
                                       $link = urlencode($user->salt);
                                    /*
                                       $mail = new YiiMailer();

                                       $mail->setFrom(Yii::app()->params['adminEmail']);
                                       $mail->setTo($user->email);
                                       $mail->setSubject('You have registered an account on Naild');
                                       $mail->setBody('Dear '.$user->firstname.',
                                       <br />
                                       Hi, it looks like you\'ve created an account on Naild, the
                                       online construction management system.<br />
                                       To confirm your email address and activate your account follow the link below and complete the join form.
                                       <br />
                                       Click here to accept <a href="http://'.Yii::app()->params['server'].'/user/active/verifycode/'.$link.'">'.Yii::app()->params['server'].'/user/active/verifycode/'.$link.'</a>
                                       <br />   <br />.
                                       Thanks,
                                       from the Naild Team.
                                       ');

                                       $mail->Send();
                                       Yii::app()->user->logout();
                                       */
                    $this->redirect('/');
                    /**/
                }
            }
        }

        $this->render('join',array(
            'model'=>$model,
        ));
    }


    public function actionJoinfollower($id)
    {
        // version of join that is used for followers
        $this->layout='main';
        $follower=Follower::model()->findByPk($id);
        //print_r($follower); die;

        $model = new RegisterForm;

        if(isset($_POST['RegisterForm'])){
            $model->attributes = $_POST['RegisterForm'];
            $model->email=$follower->email;

            if($model->validate()){
                $user = new User;

                $user->attributes = $_POST['RegisterForm'];

                $user->username=$follower->email;
                $user->email=$follower->email;
                if($user->firstSave()){



                    $company = new Company;
                    $company->name="My Company";
                    $company->description="a new company";
                    $company->owner_id=$user->getPrimaryKey();
                    $company->save();

                    $user->company_id=$company->getPrimaryKey();
                    $user->save();


                    $mail = new YiiMailer();
                    $mail->setFrom('info@billson.com' , 'Squirrel Configuration Manager');
                    $mail->AddAddress($user->email,$user->firstname.' '.$user->lastname);
                    $mail->setLayout('mail');
                    $mail->setData(array('user'=>$user));
                    $mail->setSubject('Welcome from the Squirrel');
                    $mail->setView('welcome');
                    if (!$mail->send()){
                        echo 'did not send';
                        echo $mail->ErrorInfo;
                        die;
                    }
                    Yii::app()->user->logout();

                    $this->redirect(array('/site/login','id'=>$user->id));
                    /**/
                }
                echo 'User did not save<pre>';
                print_r($user);
            }
        }

        $this->render('joinfollower',array(
            'model'=>$model,
        ));
    }

    public function actionActive(){

        if(isset($_GET['verifycode']) && $user = User::model()->findByAttributes(array('salt'=>$_GET['verifycode'])) ){
            if(isset($user)) {
                $user->active = 1;
                $user->type = 1;
                User::model()->activate($user->id);
                //if($user->save()){

                $identity = new UserIdentity($user->email, $user->password);
                $identity->setId($user->id);
                $identity->errorCode = UserIdentity::ERROR_NONE;
                Yii::app()->user->login($identity, (Yii::app()->params['loggedInDays'] * 60 * 60 * 24 ));

                $this->redirect(array('/user/welcome'));
                //return;
                //}
            }
        }
        $this->redirect(array('site/fail'));
    }

    public function actionInvite()
    {
        $model=new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            $model->password ='temp';
            $model->username = $model->email ;
            $model->company_id = User::model()->myCompany();
            $sender=User::model()->findbyPK(Yii::app()->user->id);
            // print_r($sender);


            if($model->save())
            {

                $message=User::model()->findByPk($model->id);
                $link = urlencode($message->salt);
                $mail = new YiiMailer();
                $mail->setFrom($sender->email, $sender->firstname.' '.$sender->lastname);
                $mail->setTo($message->email);
                $mail->setSubject('You have been invited to join '.$sender->company->name.' on Naild');
                $mail->setBody($message->firstname.',
                    <br />
                    You\'ve been invited to join '.$sender->company->name.' on Naild, the
                    online construction management system.<br />
                    To create your account follow the link below and complete the join form.
                    <br />
                    Click here to accept <a href="http://'.Yii::app()->params['server'].'/user/accept/id/'.$link.'">'.Yii::app()->params['server'].'/user/accept/id/'.$link.'</a>
                    <br />   <br />
                    If you don\'t know why you got this email then check with '.$sender->firstname.' '.$sender->lastname.'
                    <br />
                    If you have received this email in error, simply ignore it.
                    ');
                $mail->Send();



                $this->redirect(array('view','id'=>$model->id));
            }

        }

        $this->render('invite',array(
            'model'=>$model,
            //        'users'=>$users,
        ));


    }

    public function actionAccept($id)
    {
        Yii::app()->user->logout();
        //check the uuencoded password string.
        $salt = urldecode($id);
        $newaccount = User::model()->find("salt = '".$salt."'");
        if (!isset($newaccount->id))  $this->redirect(array('site/fail'));

        $model=$this->loadModel($newaccount->id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if(isset($_POST['User']))
        {
            $model->scenario = 'update';
            if(empty($_POST['User']['password'])){
                $data = array(  'firstname'=>$_POST['User']['firstname'],
                    'lastname'=>$_POST['User']['lastname'],
                    'email'=>$_POST['User']['email'],
                    'username'=>'',

                    'password'=>$model->password,
                    'salt'      =>  $model->generateSalt()
                );
                if($model->saveAttributes($data))
                    $this->redirect(array('view','id'=>$model->id));
            }else{
                $model->attributes=$_POST['User'];
                $model->password = $_POST['User']['password'];
                $model->type = 1; // set the type to member so contact links can be made
                if($model->save())
                {
                    //find anywhere where a contact with this email address
                    //is also a follower
                    // and update those contacts with this user.

                    Contact::model()->connectUser($model->id);
                    /*
                       $identity = new UserIdentity($model->username, $model->password);
                       $identity->authenticate();
                       //$identity->setStateMember($model);
                       Yii::app()->user->login($identity);
                      */

                    $identity=new UserIdentity($model->email,'');
                    $identity->setUpUser($model->id); // id of user
                    Yii::app()->user->login($identity);

                    $this->redirect(array('site/index'));
                }

                $this->redirect(array('view','id'=>$model->id));
            }


        }


        $this->render('accept',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate()
    {
        $id=yii::app()->user->id;
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if(isset($_POST['User']))
        {
            $model->scenario = 'update';
            if(empty($_POST['User']['password'])){
                $model->firstname=$_POST['User']['firstname'];
                $model->lastname=$_POST['User']['lastname'];
                $model->email=$_POST['User']['email'];
                $model->username=$_POST['User']['email'];
                $model->password=$model->password;
                $model->salt =  $model->generateSalt();
                if($model->save())
                    $this->redirect(array('view','id'=>$model->id));
            }else{
                $model->attributes=$_POST['User'];
                $model->password = $_POST['User']['password'];
                if($model->save())
                    $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }



    public function actionPromote($id)
    {

        //check ownership
        if (Company::model()->checkOwnershipUser($id))
        {
            $model=$this->loadModel($id);
            $model->admin=1;
            if($model->save())
                $this->redirect(array('user/view','id'=>$model->id));

        }

    }
    public function actionDemote($id)
    {
        if (Company::model()->checkOwnershipUser($id))
        {
            $model=$this->loadModel($id);
            $model->admin=0;
            if($model->save())
                $this->redirect(array('user/view','id'=>$model->id));

        }


    }

    public function actionSack($id)
    {
        if (Company::model()->checkOwnershipUser($id))
        {
            $model=$this->loadModel($id);
            $model->company_id=0;
            if($model->save())
                $this->redirect(array('user/view','id'=>$model->id));

        }


    }
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('User');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.', 'load_model');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }







}
