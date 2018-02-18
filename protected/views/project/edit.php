<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
    ?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>


<h2>Edit Project</h2>



<?php 

echo $this->renderPartial('_form', array('model'=>$model)); ?>


<h2>Collaborators</h2>



<?php
$followers = Follower::model()->findAll('project_id='.Yii::App()->session['project']);
$user = User::model()->findByPk(Yii::App()->user->id);
echo $this->renderPartial('_followers', array('model'=>$model,'followers'=>$followers,'user'=>$user)); ?>

