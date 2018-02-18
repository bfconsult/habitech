<?php

class FollowerController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations

        );
    }

    public function accessRules()
    {
        return array(

            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array(
                    'accept',
                    'expired',

                ),
                'users'=>array('*'),
            ),

            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array(
                    'reinvite',
                    'SendInvite',
                    'remove',
                    'followerAction'
                ),
                'users'=>array('@'),
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */



       public function actionreactGetCollaborators()
       {

           try {
               if(!isset($_POST['follower']['project_id'])) $project=Yii::App()->session['project'];
               if(isset($_POST['follower']['project_id'])) $project=$_POST['follower']['project_id'];

               if ($project === null)
                   throw new Exception('no project');


               $status = 1;
               $message = 'success';
               $content = null;
               $content['confirmed'] = Follower::model()->getFollowers($project);
               $content['pending'] = Follower::model()->getFollowerPendingInvites($project);

           } catch (Exception $ex) {
               $status = 0;
               $message = 'exception: ' . $ex->getMessage();
               $content = null;
           }
           $this->_ajaxResponse($status, $message, $content);



   }


    public function actionFollowerAction()
    {

        try {
            $project=Project::model()->findByPk(Yii::App()->session['project']);
            if (!isset($_POST['employee'])) throw new Exception('No post');

              $existingInvite = Follower::model()->find("email = '" . $_POST['employee']['email'] . "'
                AND project_id = " . $project->id);

                if (!empty($existingInvite)) throw new Exception('Already has invite.');

                if ($_POST['employee']['email'] == '') throw new Exception('No email');
                if ($_POST['employee']['firstname'] == '') $_POST['employee']['firstname'] = 'First Name';
                if ($_POST['employee']['lastname'] == '') $_POST['employee']['lastname'] = 'Last Name';


                    $model = new Follower;

                    $model->email = $_POST['employee']['email'];
                    $model->firstname = $_POST['employee']['firstname'];
                    $model->lastname = $_POST['employee']['lastname'];
                    $model->link = uniqid('', true);
            $model->modified=Yii::App()->user->id;
                $model->project_id = $project->id;
                $model->save(false);

                Follower::model()->sendInvite($model->primaryKey);

            $response = Follower::model()->projectFollowsGrid();

        } catch (Exception $ex) {
            $response = Follower::model()->projectFollowsGrid();
            $response .= '<h3 style="color:red;">exception: ' . $ex->getMessage().'</h3>';
        }

        // format up the grid.

        echo $response;

    }

    public function actionRemove($id)
    {

        try {
            $follower=Follower::model()->find('id = '.$id.' and project_id = '.Yii::App()->session['project']);

if (is_null($follower))
    throw new CHttpException('There is no such follower.');

                $follower->delete();


        } catch (Exception $ex) {

            echo 'exception: ' . $ex->getMessage();
            die;
        }

$this->redirect('/project/edit');



    }


    public function actionReInvite($id)
    {


        try {
            $follower=Follower::model()->find('id = '.$id.' and project_id = '.Yii::App()->session['project']);

            if (is_null($follower))
                throw new CHttpException('There is no such follower.');





            Follower::model()->sendInvite($follower->id);


        } catch (Exception $ex) {

           echo 'exception: ' . $ex->getMessage();
           die;
        }
        $this->redirect('/project/edit');




    }


    public function actionExpired()
    {
        $this->layout='bootstrap';
       $this->render('expired');
    }

    public function loadModel($id)
    {
        $model=Follower::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='follower-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionreactInviteCollaborator()
    {

      try {
            $status = 1;
          $message= 'success';
          if (!isset($_POST['follower'])) throw new Exception('No post');
          if ($_POST['follower']['email']=='') throw new Exception('No email');
          if ($_POST['follower']['firstname']=='') throw new Exception('No first name');
          if ($_POST['follower']['lastname']=='') throw new Exception('No last name');
          if ($_POST['follower']['project_id']=='')
          {
              $project = Yii::App()->session['project'];
          } ELSE {
              $project = $_POST['follower']['project_id'];
          }


          $existingInvite = Follower::model()->find("email = '".$_POST['follower']['email']."'
          AND project_id = ".$project);
          if (!empty($existingInvite))  throw new Exception('Already has invite.');

          // does the current user belong to the owner company
        $projectModel=Project::model()->findByPk($project);
          $inviter = User::model()->findByPk(Yii::App()->user->id);

         if ($inviter->company_id != $projectModel->company_id)
              throw new Exception('This is not your project, your company: '. $inviter->company_id .' project owner company'. $projectModel->company_id);

           $model = new Follower;
           $model->project_id = $project;
           $model->email = $_POST['follower']['email'];
           $model->firstname = $_POST['follower']['firstname'];
           $model->lastname = $_POST['follower']['lastname'];
           $model->confirmed = 0;
           $model->modified = Yii::app()->user->id;
           $model->modified_date = date("Y-m-d H:i:s", time());
           $model->link = uniqid('', true);

          $model->save(false);

          $this->sendInvite($model->primaryKey);

          $content['confirmed'] = Follower::model()->getFollowers($project);
          $content['pending'] = Follower::model()->getFollowerPendingInvites($project);


        } catch (Exception $ex) {
            $status = 0;
            $message = 'exception: ' . $ex->getMessage();
            $content = null;
        }

        $this->_ajaxResponse($status, $message, $content);
    }


    public function actionSendInvite($id)
    {

$follower=Follower::model()->findByPk($id);
        $mail = new YiiMailer();
        $mail->setFrom('test@billson.com','test mailer');
        $mail->AddAddress('jamesb@reqfire.com','weird beard');
        //$mail->setLayout('mail');
        $mail->setSubject('You have been invited to follow a project (new)');
        //$mail->setView('follow_newuser');
       // $mail->setData(array('follower'=>$follower,'extlink'=>'mylink@@@@@@@#######'));


        $mail->Body = "Hi! How are you?";
        $mail->WordWrap = 50;

        if(!$mail->Send()) {
            echo 'Message was not sent.';
            echo 'Mailer error: ' . $mail->ErrorInfo;
            exit;
        } else {
            echo 'Message has been sent.';
        }
    }




    public function convertModelToArray($models) {
        if (is_array($models))
            $arrayMode = TRUE;
        else {
            $models = array($models);
            $arrayMode = FALSE;
        }

        $result = array();
        foreach ($models as $model) {
            $attributes = $model->getAttributes();
            $relations = array();
            foreach ($model->relations() as $key => $related) {
                if ($model->hasRelated($key)) {
                    if ($related[0] == "CStatRelation")
                        $relations[$key] = $model->$key;
                    else
                        $relations[$key] = $this->convertModelToArray($model->$key);
                }
            }
            $all = array_merge(array_filter($attributes,'count'), array_filter($relations,'count'));

            if ($arrayMode)
                array_push($result, $all);
            else
                $result = $all;
        }
        return $result;
    }



    public function actionAccept($id)
    {
        try {
        // unencode the link, and see if it matches.
        $link = urldecode($id);
        $criteria = new CDbCriteria;
        $criteria->condition = 'link =  "' . $link . '" AND confirmed = 0';
        $follower = Follower::model()->find($criteria);

        if (!isset($follower->id)) {
            $this->redirect('/follower/expired');
        }


        // Confirm the follower and cancel the link.

        $follower->link = '0';
        $follower->confirmed = 1;
        $follower->save(false);

         //see what kind of contact they are

        $matchuser = User::model()->find("username = '" . $follower->email . "'");


        //if they don't have an account
        //give them a join form.
        if (!isset($matchuser->id)) {
            Yii::app()->user->logout();
            $joinfollowerUrl = '/user/joinfollower/id/' . $follower->id;
            $this->redirect($joinfollowerUrl);
        }
    } catch  (Exception $ex) {


    $status = 0;
    $message = 'exception: '.$ex->getMessage();
    $content = null;
    }
        $this->redirect('/app');



    }

    public function actionReactAccept()
    {

        try {
            $status = 1;
            $message = 'success';
            if (!isset($_POST['follower']['follower_id']))
                throw new Exception('no id');
            $id=$_POST['follower']['follower_id'];

            $user=User::model()->findByPk(Yii::App()->user->id);
            $criteria = new CDbCriteria;
            $criteria->condition = 'id =  "' . $id . '" AND confirmed = 0 AND email="'.$user->email.'"';
            $follower = Follower::model()->find($criteria);

            if (!isset($follower->id))
                throw new Exception('no such valid invitation');



            //if they have an account then just confirm them as a follower,
            // set link = 0, set confirmed = 1, set contact.user_id to user.id
            $follower->link = '0';
            $follower->confirmed = 1;

            if(!($follower->save(FALSE))) throw new Exception('update failed');


            $content['releases']= Release::model()->getProjectReleases($follower->project_id);


        } catch  (Exception $ex) {


            $status = 0;
            $message = 'exception: '.$ex->getMessage();
            $content = null;
        }

        $this->_ajaxResponse($status, $message,$content);

}

    private function _ajaxResponse($status, $message, $content = '')
    {
        $returnData = array();
        $returnData['status'] = $status;
        $returnData['message'] = $message;
        $returnData['content'] = $content;
        echo json_encode($returnData, JSON_HEX_APOS);
        exit;
    }

}
