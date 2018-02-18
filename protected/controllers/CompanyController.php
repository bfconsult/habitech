<?php

class CompanyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'getresetcss'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('lang','termUpdate','Logoupload','mycreate','mycompanies','create','update','mycompany', 'addmeta','Typeahead'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed

	 public function actionLang($id)
	{
			User::model()->MetaStore('lang',array('id'=>$id));
			Yii::app()->session['lang']=$id;
			$vocab=Yii::App()->params['vocab']['en'];
			$terms=Yii::App()->params['terms']['en'];
			$vocab=Yii::App()->params['vocab'][$id];
			$terms=Yii::App()->params['terms'][$id];
			foreach($vocab as $term=>$word){ // PUT EDITABLE TERMS INTO PARAMETErs
					Yii::App()->params[$term]=$word;
			}
			foreach($terms as $term=>$word){// PUT FIXED TERMS INTO PARAMETER
					Yii::App()->params[$term]=$word;
			}
			$this->redirect('/req/company/mycompany');
	}
*/
	public function actionView($id) {

        $model = $this->loadModel($id);
        $mycompany = User::model()->myCompany();

		if ($mycompany == $id) {
	            $this->render('mycompany',array(
				'model'=>$model,
			));
		} else if ($model->companyowner_id == $mycompany) {
	        $this->render('view',array(
				'model'=>$model,
			));
	    } else {
	    	ReportHelper::processError('Company Controller, View Action Error');
	    }
    }
/*
		    public function actiontermUpdate($term) {
		        if ( isset($_POST['termUpdate']) ) {
		            $data = $_POST['termUpdate'];
		            $terms = Company::model()->metaLoad('terms', Yii::App()->params['terms']);
		            foreach ($data as $term => $title) {
		                $terms[$term] = $title;
		            }
		            if (Company::model()->MetaSave('terms', $terms)) {
		                Yii::App()->session['setting_tab']='terms';
		                $this->redirect(UrlHelper::getPrefixLink('project/project'));
		            } ELSE {
		                echo "Nope";
		                die;
		            }
		        }
		        $this->render('termUpdate',array('term'=>$term));
		    }

*/

	public function actionCreate()
	{
		$model=new Company;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
                        $model->owner_id=Yii::app()->user->id;
                        $model->type=2;
                        $model->companyowner_id=User::model()->myCompany();
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionmyCreate()
	{
		$model=new Company;
		$user = User::model()->findbyPK(Yii::app()->user->id);
		if ($user != NULL && $user->active==0)$this->redirect(array('/site/verify'));

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
                        $model->owner_id=Yii::app()->user->id;
                        $model->type=1; // hard code all to be type 1

			if($model->save()){
                            $cid=$model->primaryKey;
                            //need to update the user so they own this company
                        User::model()->setcompanyowner($cid);
                            //setup the trades .

                        Documenttype::model()->preload();

                //$user=User::model()->findbyPK($model->owner_id);
                //$user->admin=1;
                //$user->save();
// PRIME THE HELP META STORE
				User::model()->MetaLoad('help');

			$this->redirect(UrlHelper::getPrefixLink('site/index'));
                }}

		$this->render('mycreate',array(
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
	$id=User::model()->myCompany();
            $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Company']))
		{

			$model->attributes=$_POST['Company'];
      $model->type=1; // hard coded for now
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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



	public function actionAdmin()
	{
		$model=new Company('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Company']))
			$model->attributes=$_GET['Company'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function loadModel($id)
	{
		$model=Company::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='company-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

        	public function actionindex()
	{
        $user= User::model()->findByPk(Yii::App()->user->id);
        $data = User::model()->findAll('company_id = '.$user->company_id);
        $admin = User::model()->findAll('company_id = '.$user->company_id.' and admin=1');

        $this->render('mycompany',array(
			'user'=>$user,'data'=>$data,'admin'=>$admin
		));
	}

    public function actionLogoupload($id) {
    	if (isset($id) && Company::model()->findByPk($id)) {

			Yii::import("ext.EAjaxUpload.qqFileUploader");
			$folder = Yii::getPathOfAlias("webroot") . Yii::app()->params['photo_folder'];
			if (!file_exists($folder)) {
				if (mkdir($folder, 0755, true)) {
				  return false;
				}
			}
			$allowedExtensions = array("jpg", "jpeg", "gif", "png", "PNG", "JPG", "GIF", "JPEG"); //array("jpg","jpeg","gif","exe","mov" and etc...
			$sizeLimit = 2 * 1024 * 1024; // maximum file size in bytes
			$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
			$result = $uploader->handleUpload($folder);
			if ($result) {
			$project = Yii::App()->session['project'];
			$release = Yii::App()->session['release'];
			$mycompany = User::model()->myCompany();
			$file_name = Utils::uniqueFile($result['filename']);
			$file_name = 'logo'.$mycompany.'-'.$file_name;
			$path = Yii::getPathOfAlias("webroot").Yii::app()->params['photo_folder'];
			rename($path.$result['filename'], $path.$file_name);
			//persist into database
			$model=$this->loadModel($id);
			$model->logo_id = $file_name;
			if ($model->save()) {
			  // Add image to interface
			}
			}
			$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
			echo $return;

    }
  }

  public function actionGetResetCss() {
  	$defaultCss = file_get_contents(Yii::getPathOfAlias('webroot').'/css/default_print.css');
  	echo $defaultCss;
  }

  public function actionAddmeta() {
  	if ( isset($_POST) && isset($_POST['Companymetaform']) ) {
  		$data = $_POST['Companymetaform'];
  		$id   = $data['company_id'];
  		foreach ($data as $key => $meta) {
  			if ( $key != 'company_id') {
  				$companyMeta = Company::model()->findByPk($id);
  				$companyMeta->setEavAttribute($key, $meta);
  				$companyMeta->save();
  			}
  		}
  	}
  	$this->redirect(UrlHelper::getPrefixLink('company/mycompany'));
  }



    public function actiontermUpdate($term) {




        if ( isset($_POST['termUpdate']) ) {
            $data = $_POST['termUpdate'];

            $terms = Company::model()->metaLoad('terms'.Yii::App()->session['lang'], Yii::App()->params['terms'][Yii::App()->session['lang']]);
            foreach ($data as $term => $title) {

               $terms[$term] = $title;

            }


            if (Company::model()->MetaSave('terms'.Yii::App()->session['lang'], $terms)) {
                Yii::App()->session['setting_tab']='terms';
                $this->redirect(UrlHelper::getPrefixLink('project/project'));
            } ELSE {
                $this->redirect(UrlHelper::getPrefixLink('site/fail'));
            }
        }
        $this->render('termUpdate',array('term'=>$term));
    }


  public function actionTypeahead()
  {
	  if($_POST['keyword'])
	  {

	  	echo json_encode(array_values(CHtml::listData(Company::model()->findAll('type=2 AND name like "'.$_POST['keyword'].'%" and companyowner_id='.User::model()->myCompany()),'id', 'name')));die;
	  }
  }
}
