Hi, <br/>

We got a request to change your password. <br/>
<?php echo Yii::app()->getBaseUrl(true).'/site/newpassword?code='.$code; ?>.<br/> 
Thank you for registering with reger.com .<br/>
Please <a href="<?php echo UrlHelper::getPrefixLink('/site/newpassword?code='.$code); ?>">Click here</a> to reset you password.<br/>
<br/>
Regards
