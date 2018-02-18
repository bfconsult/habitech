<div class="row">
    <div class="span1"><h2><i class="icon-ok-circle"></i></h2></div>
        <div class="span5">
<h3>Create Your Company</h3>
</div></div>




<?php 
Yii::app()->user->setFlash('success', ''
        . '<h4>Thanks for joining ReqFire!</h4>To get the most out of the system, you need to create a company, this allows you to invite others to
collaborate on your projects.
<br />
You can change the details any time by going to the My Company settings.
<br />'
        . '');
$this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); 
?>


<br />
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>

	
	<?php
             echo $form->errorSummary($model); ?>



	<div class="row">
		Company Name<br />
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		A brief description<br />
		<?php
		if (empty($model->description))$model->description='A developer of great web applications.';
		echo $form->textArea($model,'description',array('rows'=>6, 'class'=>'span8')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>



	<div class="row buttons">
 <?php echo CHtml::submitButton('Create',array('class'=>'btn btn-success','style'=>'margin:10px 0px 0px 20px')); ?>
           
	</div>

<?php $this->endWidget();



?>

</div><!-- form -->
<?php
User::model()->zapierMailchimp();
?>