<div class="row">
    <div class="span8">
To access Squirrel and join the project you have been invited to, you first need to make an account.
Its free, and only takes a minute.  You will be sent an email to confirm your email address, after that
you'll be asked to enter your company name.  <br />
Please let us know if you have any difficulties getting started.


    </div>
    <div class="form" id="signupForm" style="max-width: 320px">
        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'contact-form',
                'enableAjaxValidation'=>false,
        )); ?>
            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->textFieldRow($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
            <?php // echo $form->textFieldRow($model,'email',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->passwordFieldRow($model,'password',array('size'=>60,'maxlength'=>255, 'value' => '')); ?> 
            <?php echo $form->passwordFieldRow($model,'password2',array('size'=>60,'maxlength'=>255, 'value' => '')); ?> 
            
            <div class="row buttons">
                <?php echo CHtml::submitButton('Register for Free ',array('class'=>'btn btn-success','style'=>'margin:10px 0px 0px 20px')); ?>
            </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
    <div class="clearfix"></div>
</div>


