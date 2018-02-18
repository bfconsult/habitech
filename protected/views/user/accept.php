<h1><?php echo $model->company->name; ?></h1>
<h2>Accept a Company Invitation - Create an Account </h2>

<!--<div class="form">
<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	
        <?php echo $form->passwordFieldRow($model,'password',array('size'=>60,'maxlength'=>255, 'value' => '')); ?> 
            <?php echo $form->passwordFieldRow($model,'password2',array('size'=>60,'maxlength'=>255, 'value' => '')); ?> 
   

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget();*/ ?>

</div> form -->


<div class="row">
    <div class="span8">
To access ReqFire and join <?php echo $model->company->name; ?> you first need to make an account.
You will be sent an email to confirm your email address.  <br />
Please let your company administrator know if you have any difficulties getting started.


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
                <?php echo CHtml::submitButton('Join ',array('class'=>'btn btn-success','style'=>'margin:10px 0px 0px 20px')); ?>
            </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
    <div class="clearfix"></div>
</div>