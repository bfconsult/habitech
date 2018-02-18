<?php

echo '<h1>'.$project->name;

    echo ' <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>';

echo '<h2>'.$model->name.' - Edit</h2>';


echo $this->renderPartial('_form', array('model'=>$model,'project'=>$project)); ?>