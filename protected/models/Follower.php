<?php

class Follower extends CActiveRecord
{


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'follower';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project_id, email, confirmed, firstname, lastname, modified, modified_date', 'required'),
            array('email', 'email'),
            array('firstname,lastname', 'text'),
            array('id,project_id, confirmed, modified', 'numerical', 'integerOnly' => true),
            array('id, email, project_id, link, confirmed, firstname, lastname, modified, modified_date', 'safe'),
            array('id, email, project_id, link, confirmed, firstname, lastname, modified, modified_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'project' => array(self::BELONGS_TO, 'Project', 'id'),

            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.


        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'link' => 'Link',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'project_id' => 'Project',
            'confirmed' => 'Confirmed',
            'modified' => 'Modified',
            'modified_date' => 'Modified Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->contact_id);
        $criteria->compare('confirmed', $this->confirmed);
        $criteria->compare('modified', $this->modified);
        $criteria->compare('link', $this->modified);

        $criteria->compare('modified_date', $this->modified_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getFollowers($fk = -1)
    {
        if ($fk == -1) Yii::app()->session['project'];
        $sql = "SELECT  `u`.`firstname` ,  `u`.`lastname` ,  
                `f`.`email` ,  `f`.`confirmed` ,  `f`.`id` AS follower_id,
                `u`.`id` AS user_id
            FROM  `follower`  `f` 
                
                JOIN  `user`  `u` ON  `u`.`username` =  `f`.`email`
            WHERE
             
                 `f`.`confirmed`=1

            AND
                `f`.`project_id`=" . $fk;


        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $contacts = $command->queryAll();

        return $contacts;
    }

    public function projectFollowsGrid()
    {
       echo '<table>
	<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Actions</th>
	</tr>';

        $followers = Follower::model()->findAll('project_id=' . Yii::App()->session['project']);
        foreach ($followers as $follower) {
            echo '<tr><td >' . $follower->firstname . ' '.$follower->lastname.'</td>
            <td >'. $follower->email . '</td>
            <td > ' . $follower->confirmed . '</td>
            <td >
            <a href="/follower/reinvite/id/'.$follower->id.'">Resend invite</a><br> 
            <a href="/follower/remove/id/'.$follower->id.'">Remove</a>
            </td>
            </tr>';



        }

echo '</table>';


}



    public function getFollowerPendingInvites($fk=-1)
    {
        if($fk==-1) Yii::app()->session['project'];
        $sql="SELECT 
            `f`.`email` ,  `f`.`confirmed` ,  `f`.`id` AS follower_id,
            `f`.`firstname`,`f`.`lastname`
            FROM    `follower`  `f` 
    
            WHERE
           `f`.`confirmed`=0
            AND
           `f`.`project_id`=".$fk;

        $connection=Yii::app()->db;
        $command = $connection->createCommand($sql);
        $contacts = $command->queryAll();

        return $contacts;
    }



    public function sendInvite($id)
    {


        $follower = Follower::model()->findByPk($id);
        $creator = User::model()->findbyPk(Yii::app()->user->id);
        $project = Project::model()->findByPk(Yii::App()->session['project']);
        $matchuser = User::model()->find("username = '".$follower->email."'");

        $mail = new YiiMailer();
        $mail->setFrom($creator->username,$creator->firstname.' '.$creator->lastname);
        $mail->AddAddress($follower->email,$follower->firstname.' '.$follower->lastname);
        $mail->setLayout('mail');
        $mail->setData(array('follower'=>$follower,'extlink'=>$project->extlink));
        $mail->setSubject('You have been invited to follow a project on Squirrel');
        if (!empty($matchuser))
        {
            //if the user has an account send an email saying they've been invite to follow


            $mail->setView('follow_existuser');



        } else {
            //if the user has no account send an instruction to join.


            $mail->setView('follow_newuser');

        }
        $mail->send();
    }


    public function sendAcceptConfirm($id)
    {
        try {

            $follower = $this->findByPk($id);
            if($follower->type == 1) {
                $project=Project::model ()->findbyPK($follower->foreign_key);
                $projectName=$project->name;
                $companyName=$project->company->name;
                $extlink=$project->extlink;
            }

            if($follower->type == 2) {
               $package=Package::model()->findbyPK($follower->foreign_key);
               $extlink=$package->project->extlink;
               $projectName=$package->project->name;
               $companyName=$package->project->company->name;
            }
            $contact = Contact::model()->findbyPk($follower->contact_id);
            $creator = User::model()->findbyPK($follower->modified);
            $mail = new YiiMailer();
            $mail->setFrom($creator->email,$creator->firstname.' '.$creator->lastname);
            $mail->setTo($contact->email);
            $mail->setSubject('You are now following '.$projectName);
            $mail->setBody($contact->firstname.',
            <br /><br />
            You\'ve accepted the invitation to follow '.$projectName.' managed by '.$companyName.'.
            <br />The system will send you notifications when documents are updated by default,
            but you can change the settings whenever you like by going to your account page.
             <a href="https://www.ReqFire.com/app/user/myaccount/">https://www.ReqFire.com/app/user/myaccount/</a>
            <br />
            Don\'t forget you can access the draft requirements without logging in directly here:
            <a href="'.Yii::app()->params['server'].Yii::app()->params['server'].'/app/project/extview/id/'.$extlink.'">'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/app/project/extview/id/'.$extlink.'</a>
               <br />
                  <br />
                  Thanks for using ReqFire.

            ');
            $mail->Send();
            $mail = new YiiMailer();
            $mail->setFrom('info@reqFire.com','ReqFire System - '.$companyName);
            $mail->setTo($creator->email);
            $mail->setSubject($contact->firstname.' '.$contact->lastname.' is now following '.$projectName);
            $mail->setBody($creator->firstname.',
            <br /><br />
            Hi, this is to notify you that your contact '.$contact->firstname.'  from
                '.$contact->worksfor->name.' has accepted the invitation to follow your project '.$projectName.'.
            <br />
            <br />
            Thanks for using ReqFire.
            ');

            $mail->Send();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

    }


      public function sendNewDocumentNotification($id)// PROJECT ID
    {


          // Find all followers of the project and its child packages who have notification set on.
          //loop through the array of followers
          // create an email for each one.






       $follower = $this->findByPk($id);
       if($follower->type == 1) {
           $project=Project::model ()->findbyPK($follower->foreign_key);
           $projectName=$project->name;
           $companyName=$project->company->name;
           $extlink=$project->extlink;
            }
       if($follower->type == 2) {
           $package=Package::model()->findbyPK($follower->foreign_key);
           $extlink=$package->project->extlink;
           $projectName=$package->project->name;
           $companyName=$package->project->company->name;
                             }
       $contact = Contact::model()->findbyPk($follower->contact_id);
       $creator=User::model()->findbyPK($follower->modified);
       $mail = new YiiMailer();
       $mail->setFrom($creator->username,$creator->firstname.' '.$creator->lastname);
       $mail->setTo($contact->email);

            $mail->setSubject('New Documents for '.$projectName);
            $mail->setBody($contact->firstname.',
            <br /><br />
            New documents have been uploaded to the document repository
            for '.$projectName.' managed by '.$companyName.'.
            <br />
            Don\'t forget you can access the draft requirements without logging in directly here:
            <a href="'.	Yii::app()->params['protocol'].Yii::app()->params['server'].'/app/project/extview/id/'.$extlink.'">
            '.Yii::app()->params['protocol'].Yii::app()->params['server'].'/app/project/extview/id/'.$extlink.'</a>
            <br />
            <br />
            Thanks for using ReqFire.<br />
            Note: The system will send you notifications when documents are updated by default,
            but you can change the settings whenever you like by going to your account page.
            <a href="'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/app/user/myaccount/">'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/app/user/myaccount/</a>
            <br />
            ');

        $mail->Send();

    }


    public function getMyProjectFollows($status)
    {
        //$id is the accepted state where 0=invite, 1=follow
        $sql="SELECT  `u`.`firstname` ,
              `u`.`lastname` ,  
              `f`.`email` , 
              `f`.`confirmed` , 
              `f`.`id` AS follower_id,
              `f`.`project_id` as id
              FROM  `follower`  `f` 
              JOIN `user` `u`
              ON `u`.`username`=`f`.`email`
               WHERE
               `f`.`confirmed`=".$status."
               AND `u`.`id`=".Yii::App()->user->id;

            $connection=Yii::app()->db;
            $command = $connection->createCommand($sql);
            $invites = $command->queryAll();

            return $invites;
    }



    public function getProjectFollowerDetails($project_id)
    {
         //$id is the accepted state where 0=invite, 1=follow
        $sql="SELECT  `f`.*
            FROM  `follower`  `f`
                JOIN  `contact`  `c` ON  `f`.`contact_id` =  `c`.`id`
                JOIN  `user`  `u` ON  `u`.`username` =  `c`.`email`
            WHERE
                `f`.`confirmed` =1
            AND `f`.`foreign_key` = ".$project_id."
                AND  `u`.`id` =".Yii::app()->user->id;
        $connection=Yii::app()->db;
        $command = $connection->createCommand($sql);
        $details = $command->queryAll();
        if(isset ($details[0]))        return $details[0];

    }

}
