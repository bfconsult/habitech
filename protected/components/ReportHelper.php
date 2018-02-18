<?php
class ReportHelper {
	public static function processError($message, $url = null) {
           // var_dump($message); exit;
		if (User::model()->isDeveloper()) {

			/*
			if (is_object($message) || is_array($message)) {
				echo "<pre>";	
			 	print_r($message);
	            echo "</pre>";
			}  else {
				echo $message;
			}
			*/
			echo "<h1>DEVELOPER VIEW</h1>";
			var_dump($message);
	    } else {
			if (is_array($message)) {
				if(isset($message['message'])) {
					$message = $message['message'];
				} else {
					$message = implode("<br />", $message);
				}
			} 
			if(is_object($message)) {
				$message = $message->getMessage();
			}
			if(!Yii::app()->user->id) {
				$urlreferrer=Yii::app()->request->urlReferrer;
				$company = User::model()->myCompany();
				$model = Company::model()->findbyPK($company);	
				$user =  User::model()->findbyPK(Yii::app()->user->id);
				$username=$user->firstname." ".$user->lastname."(".Yii::app()->user->id.")";       
				$urlrequest=Yii::app()->controller->id."/".Yii::app()->controller->action->id;
				$message ="URL Referrer: ".$urlreferrer."<br />"
				    ."URL Requested: ".$urlrequest."<br />"
				    ."Company: ".$model->name."<br />"
				    . "User: ".$username."<br /><br /> Error: ".$message;
			}
			$mail = new YiiMailer();
			$mail->setFrom('info@reqfire.com', 'ReqFire Error Monitor');
			$mail->setTo('errors@reqfire.com');
			$mail->setCc('vanlan228@gmail.com');
			$mail->setSubject('ReqFire Errors');
			$mail->setBody($message);
			$mail->Send();

	       if ($url == NULL) {
	       	Yii::app()->controller->redirect('/req/site/fail/report/helper');
		   } else {
		 	Yii::app()->controller->redirect($url);
		   }
	    }
	}

}