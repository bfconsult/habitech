<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Manage Company', 'url'=>array('admin')),
);
?>

<h1>Create Company</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>



	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
        <div class="row">
	<?php echo $form->labelEx($model,'organisationtype'); ?>
        <?php echo $form->dropDownList($model,
                'organisationtype',
                CHtml::listData(Organisationtype::model()->findAll(),'id','name'));  ?>
<?php echo $form->error($model,'organisationtype'); ?>
	</div>
	
<div class="row">
		<?php echo $form->labelEx($model,'foreignid'); ?>
		<?php echo $form->textField($model,'foreignid',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'foreignid'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->