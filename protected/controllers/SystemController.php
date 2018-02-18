<?php

class SystemController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('extview'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('view','edit','create'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

//used to sort arrays in the print diagram view




    public function actionView($id)
    {

   $system=$this->loadModel($id);

        $this->render('view',array('system'=>$system));


    }



    public function actionCreate()
    {
        $model = new System;


        if (isset($_POST['System'])) {
            $project=Project::model()->findByPk(Yii::App()->session['project']);
            $model->attributes = $_POST['System'];
            $model->create_user = Yii::App()->user->id;
            $model->company_id = $project->company_id;
            $model->number = System::model()->getNextNumber();
            if ($model->save()) {
                $link = new Projectsystem;
                $link->project_id = $project->id;
                $link->create_user = Yii::App()->user->id;
                $link->description = '';
                $link->system_id = $model->getPrimaryKey();
                if ($link->save()) $this->redirect('/project/view');
            }

        }

        if (isset($_POST['Link'])) {
            $link = new Projectsystem;
            $link->project_id =    Yii::app()->session['project'];
            $link->create_user = Yii::App()->user->id;
            $link->description = $_POST['Link']['description'];
            $link->system_id = $_POST['Link']['system_id'];
            if ($link->save())

                $this->redirect('/project/view');


        }

        $this->render('create', array(
            'model' => $model,

        ));


    }

    public function actionEdit($id)
    {
        $model = $this->loadModel($id);

        $project=Project::model()->findbyPK(Yii::App()->session['project']);


        if (isset($_POST['System'])) {
            $model->attributes = $_POST['System'];

            $model->create_user = Yii::App()->user->id;
            $model->number = System::model()->getNextNumber();
            if ($model->save())

                $this->redirect('/system/view/id/'.$id);


        }

        $this->render('edit', array(
            'model' => $model,'project'=>$project

        ));


    }

    public function loadModel($id)
    {
        $model=System::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
