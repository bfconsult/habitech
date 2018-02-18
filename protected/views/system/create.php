<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
    ?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>


<h2>Create a New System</h2>


<h3>Add an existing shared system</h3>

<?php

echo $this->renderPartial('_link', array('model'=>$model)); ?>


<h3>Add a custom system for this Project.</h3>
<?php 

echo $this->renderPartial('_form', array('model'=>$model,'project'=>$project)); ?>