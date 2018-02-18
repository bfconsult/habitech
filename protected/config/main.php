<?php

require 'local/local.php';




Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable'); 
Yii::app()->params['server'] = $options['server'];
Yii::app()->params['app_dir'] = $options['app_dir'];
Yii::app()->params['protocol'] = $options['protocol'];
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>$options['app_name'],
    'defaultController' => 'site/login',
    
    // preloading 'log' component
    'preload'=>array('bootstrap','log'),
    

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        //'application.modules.rights.*',  // adding rights module
        //'application.modules.rights.components.*', // adding rights module
        'application.modules.*', 
              //  'application.extensions.EAjaxUpload.*',
              //  'application.extensions.coco.*',
              //  'application.extensions.easymap.*',
              //  'application.extensions.easyimage.EasyImage',
              //  'application.extensions.iwi.*',
                'application.widgets.bootstrap.*',
                'application.modules.auth.components.*',
				'application.controllers.*',
                'ext.YiiMailer.YiiMailer',
				'editable.*',
			//	'application.extensions.imperavi-redactor-widget.*',
    ),
    'aliases' => array(
       'xupload' => 'ext.xupload' //assuming you extracted the files to the extensions folder
    ),

    'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
        'modules'=>array(
            'gii'=>array(
            'generatorPaths'=>array(
            'bootstrap.gii',
            ),
                
        ),
    ),
    'modules'=>array(
        // uncomment the following to enable the Gii tool
        
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'root',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1','naild'),
                        'generatorPaths' => array(
                        'bootstrap.gii'),
            ),

// 'admins' => array('admin', 'foo', 'bar'), // users with full access
        'auth' => array(
                        'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
                        'userClass' => 'User', // the name of the user model class.
                        'userIdColumn' => 'id', // the name of the user id column.
                        'userNameColumn' => 'username', // the name of the user name column.
                        'defaultLayout' => 'application.views.layouts.main', // the layout used by the module.
                        'viewDir' => null, // the path to view files to use with this module.
            ),
    ),

    // application components
    'components'=>array(
           // 'cache' => array('class' => 'system.caching.CDummyCache'),
            'bootstrap' => array(
                       'class' => 'ext.bootstrap.components.Bootstrap',
                       'responsiveCss' => true,
                       'fontAwesomeCss' => false,
                        ),
		    'editable' => array(
						'class'     => 'editable.EditableConfig',
						'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain' 
						'mode'      => 'popup',            //mode: 'popup' or 'inline'  
						'defaults'  => array(              //default settings for all editable elements
						'emptytext' => 'Click to edit'
										)
						),
  
                /*
            'authManager'=>array(
                        'class' => 'CDbAuthManager',
                        'connectionID' => 'db',
                        'behaviors' => array(
                            'auth.components.AuthBehavior',
                            ),   
                        ),
*/
			'easyImage' => array(
						'class' => 'ext.easyimage.EasyImage',
			),
            'dompdf'=>array(
                'class'=>'ext.yiidompdf.yiidompdf'
            ),
        // uncomment the following to enable URLs in path-format

         'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            'appendParams' => true,
            'urlSuffix' => '',
            'rules'=>array(
                '/'=>'site/index',
                'auth/<controller:\w+>/<action:\w+>/<id:\d+>'=>'auth/<controller>/<action>',
                '<controller:\w+>'=>'<controller>/index',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>/',
            ),

        ),
        /*      
        'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        ),
        */
        // uncomment the following to use a MySQL database
        'session' => array(
                'sessionName' => 'SiteSession',
                'class' => 'CHttpSession',
                'autoStart' => true,
                ),
        'db'=>array(
            'connectionString' => 'mysql:host='.$options['db_host'].';dbname='.$options['db_name'],
            'emulatePrepare' => true,
            'username' => $options['db_user'],
            'password' => $options['db_pass'],
            'charset' => 'utf8',
            'tablePrefix' => '',


        ),
		   'user' => array(
                        'class' => 'auth.components.AuthWebUser',
                      
            ),
     
            
        'yexcel' => array(
                'class' => 'ext.yexcel.Yexcel'
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages #################################
                
             array(
                    'class'=>'CWebLogRoute',
               ),
            ),
        ),
        'easyImage' => array(
            'class' => 'ext.easyimage.EasyImage',
        ),
        

    ),
    
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'ReqFire <info@reqfire.com>',
        'photo_folder'=>'/uploads/images/',
        // load the two arrays from the en language files included above

    ),
    
);