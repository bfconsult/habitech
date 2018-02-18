<?php
/* @var $this FollowerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Followers',
);

$this->menu=array(
	array('label'=>'Create Follower', 'url'=>UrlHelper::getPrefixLink('create')),
	array('label'=>'Manage Follower', 'url'=>UrlHelper::getPrefixLink('admin')),
);
?>

<h1>Followers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
