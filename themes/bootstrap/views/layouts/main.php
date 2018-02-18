<?php /* @var $this Controller */


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>



    <meta name="language" content="en"/>

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />


    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/bootstrap.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/font-awesome.min.css'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styles.css'); ?>
	<link rel="stylesheet" id="tp-nunitoall-css" href="https://fonts.googleapis.com/css?family=Nunito%3A400%2C600%2C700&amp;ver=4.1" type="text/css" media="all">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php Yii::app()->bootstrap->register(); ?>
    <script type="text/javascript" src="/themes/bootstrap/js/jquery.tmpl.min.js"></script>
</head>

<body class="<?php echo $this->getBodyClasses(); ?>">

<?php

    $this->widget('bootstrap.widgets.TbNavbar', 
            array(
                    'brand'=>'',
                    'brandOptions' => array('style'=>'padding:0'),
                    'type'=>'',
                    'fluid'=>false,
                    'collapse'=>true,
	'items'=>array(
            
		array(
			'class'=>'bootstrap.widgets.TbMenu','encodeLabel'=>false,
			'items'=>array(
                                    array(
                                       'label'=>'Squirrel',
                                        'visible'=>Yii::app()->user->isGuest),
                                  
				                    array('label'=>'Home',
                                        'url'=> ('/'),
                                    'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Home',
                                     'url'=> ('/'),
                                    'visible'=>Yii::app()->user->isGuest),



                            
			),
		),
		
                     
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'items' => array(

                    array(
                        'label' => Yii::app()->user->name,
                        'visible' => !Yii::app()->user->isGuest > 0,
                        'items' => array(
                            array(
                                'label' => 'Logout (' . Yii::app()->user->name . ')',
                                'url' => '/site/logout',
                                'visible' => !Yii::app()->user->isGuest
                            ),
                            array(
                                'label' => 'My Account',
                                'url' => UrlHelper::getPrefixLink('user/update')
                            ),
							 array(
                                'label' => 'My Organisation',
                                'url' => UrlHelper::getPrefixLink('company')
                            ),


                        )
                    ),
                    array(
                        'label' => 'Login',
                        'url' => (UrlHelper::getPrefixLink('site/login')),
                        'visible' => Yii::app()->user->isGuest
                    ),
                ),

            ),
            '<span class="pull-right"><img src="/images/small_logo.png"></span>',

        ),
    )
);

?>

<div class="container" id="page">

   

    <br/>
    <?php echo $content; ?>

    <div class="clear"></div>
    <div id="footernav" style="text-align:center;margin-top:50px; font-size: small;">

        <a href="<?php echo UrlHelper::getPrefixLink('site/terms'); ?>">Term of Use</a> |
        <a href="<?php echo UrlHelper::getPrefixLink('site/privacy') ?>">Privacy</a> | <a
            href="/contact-us">Contact</a>

    </div>
    <div id="footer" style="text-align:center">


        <br/>

        Copyright &copy; <?php echo date('Y'); ?> by BFC P/L.<br/>
        All Rights Reserved.<br/>
        </font>
    </div>
    <!-- footer -->

</div>
<!-- page -->




</body>

</html>
