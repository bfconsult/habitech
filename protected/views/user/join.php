


     <div class="form" id="signupForm" >
         
         <?php
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'contact-form',
                'enableAjaxValidation'=>false,
        )); ?>
            <?php echo $form->errorSummary($model); ?>
            
            <?php echo $form->textFieldRow($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->textFieldRow($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->textFieldRow($model,'email',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->passwordFieldRow($model,'password',array('size'=>60,'maxlength'=>255, 'value' => '')); ?> 
            <?php echo $form->passwordFieldRow($model,'password2',array('size'=>60,'maxlength'=>255, 'value' => '')); ?> 
            
            <div class="row buttons">
                <?php echo CHtml::submitButton('Register for Free ',array('class'=>'btn btn-success','style'=>'margin:10px 0px 0px 20px')); ?>
            </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->




