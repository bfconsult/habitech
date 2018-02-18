Hi, <br/>



Please use this url to confirm your account: <br/>
<?php echo Yii::app()->getBaseUrl(true).'/req/site/confirm?code='.$code; ?> 
Thank you for registering with Sakuti.com.<br/>
Please <a href="<?php echo UrlHelper::getPrefixLink('/users/confirm?code='.$code); ?>">Click here</a> to confirm your account.<br/>

<br/>
Regards
