<?php

class ConfigController extends Controller
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
                'actions' => array('view','edit','create','delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

//used to sort arrays in the print diagram view




    public function actionView($id)
    {

    $configs=$this->loadModel($id);
    $this->render('view',array('configs'=>$configs));


    }



    public function actionDelete($id)
    {

        $config=Config::model()->findByPk($id);
        $link=Projectsystem::model()->find('system_id ='.$config->system_id.' and project_id = '.Yii::App()->session['project']);
        if (!is_null($link))
            $config->deleted = 1;
        $config->save();
        $this->redirect('/project/history');


    }


    public function actionCreate()
    {
        $model = new Config;
$project = Project::model()->findbyPk(Yii::App()->session['project']);
       // print_r($project);die;

        if (isset($_POST['Config'])) {

            //echo 'system id is'.$_POST['Config']['system_id'];die;
            $model->attributes = $_POST['Config'];
            $model->create_user = Yii::App()->user->id;
            $model->number = Config::model()->getNextNumber($_POST['Config']['system_id']);
            if ($model->save())


                $this->redirect('/project/view/id/'.$project->id);


        }

        $this->render('create', array(
            'model' => $model,'project'=>$project
        ));


    }


    public function loadModel($id)
    {
        $model=Config::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
