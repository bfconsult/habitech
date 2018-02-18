<?php

class NoteController extends Controller {

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column2';

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
   
  
  public function accessRules() {
    return array(
        array('allow', // allow all users to perform 'index' and 'view' actions
            'actions' => array('index', 'view'),
            'users' => array('*'),
        ),
        array('allow', // allow authenticated user to perform 'create' and 'update' actions
            'actions' => array('create', 'list', 'update', 'ajaxSave', 'ajaxDelete', 'admin', 'upload', 'singleupload'),
            'users' => array('@'),
        ),
        array('allow', // allow admin user to perform 'admin' and 'delete' actions
            'actions' => array('delete'),
            'users' => array('admin'),
        ),
        array('deny', // deny all users
            'users' => array('*'),
        ),
    );
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id) {
    
       $link=explode('_',$id);
       $model=Note::model()->findAll('release_id='.$link[0]." AND object=".$link[1]."
            AND instance=".$link[2]);
      
      
    //  $model = Note::model()->getNotes($id);
    
    
    
    
    $this->render('view', array('model' => $model,'link'=>$link ));
  }

  public function actionList() {

    $this->render('list');
  }

public function actionCreate($id)
	{
            $release=Yii::app()->session['release'];
                $model=new Note;
		if(isset($_POST['Note']))
		{
                   $model->attributes=$_POST['Note'];     
                   $model->release_id=$release;
                    if($model->save())
                    {
                    if($model->object == 0) $this->redirect(('/req/project/view/tab/usecases'));    
                        if($model->object >0) {
                            if($model->instance == 0) 
                            {    
                            $this->redirect(('/req/project/view/tab/'.Version::$objects[$model->object].'s'));
                            } 
                        $this->redirect(('/req/'.Version::$objects[$model->object].'/view/id/'.$model->instance));
                        }
                    
                    }
                }
                $this->render('create',array(
			'model'=>$model,'id'=>$id,
		));
	}


  public function actionUpdate($id) {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['Note'])) {
      $model->attributes = $_POST['Note'];
      if ($model->save())
        $this->redirect(array('list'));
    }

    $this->render('update', array(
        'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id) 
          {
    $release=Yii::App()->session['release'];
    $model=$this->loadModel($id);
    $object=$model->object;
    $instance=$model->instance;
    $model->delete();
    
        $this->redirect('/req/project/project/',array('tab'=>'notes'));
    
  }

  /**
   * Lists all models.
   */
  public function actionIndex() {
    $dataProvider = new CActiveDataProvider('Note');
    $this->render('index', array(
        'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin() {
    $model = new Note('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Note']))
      $model->attributes = $_GET['Note'];

    $this->render('admin', array(
        'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Note the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    $model = Note::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function loadVersion($id) {
    $model = Note::model()->findByPk(Version::model()->getVersion($id, 11));
    if ($model === null)
      throw new CHttpException(404, 'The requested version does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Note $model the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'difference-images-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionAjaxSave() {

    if (isset($_POST['Note'])) {
      $id = $_POST['Note']['id'];
      if (isset($id) && $model = $this->loadModel($id)) {
        $model->attributes = $_POST['Note'];
        if ($model->save(false))
          return true;
      }
    }
    return false;
  }

  public function actionAjaxDelete() {
    if (isset($_GET['note_id']) && $model = $this->loadModel($_GET['note_id'])) {
      $_img = $model->file;

      if ($model->delete()) {
        Utils::deleteFile(Yii::getPathOfAlias("webroot") . Yii::app()->params['note_folder'], $_img);
        return true;
      }
    }
    return false;
  }

  

}
