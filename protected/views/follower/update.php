<?php
/* @var $this FollowerController */
/* @var $model Follower */

$this->breadcrumbs=array(
	'Followers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Follower', 'url'=>UrlHelper::getPrefixLink('index')),
	array('label'=>'Create Follower', 'url'=>UrlHelper::getPrefixLink('create')),
	array('label'=>'View Follower', 'url'=>UrlHelper::getPrefixLink('view/?id=').$model->id),
	array('label'=>'Manage Follower', 'url'=>UrlHelper::getPrefixLink('admin')),
);
?>

<h1>Update Follower <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>