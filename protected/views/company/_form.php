<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */
?>

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


		<?php echo $form->hiddenField($model,'owner_id',array('value'=>$model->owner_id)); ?>
		<?php echo $form->hiddenField($model,'organisationtype',array('value'=>$model->organisationtype)); ?>
		<?php echo $form->hiddenField($model,'trade_id',array('value'=>$model->trade_id)); ?>


	<div class="row">
        <div class="span11">

             <?php
//echo Company::$companytypestatus[$model->type];

 if($model->logo_id!=''){
    $src = Yii::app()->easyImage->thumbSrcOf(
    Yii::app()->params['photo_folder'].$model->logo_id,
    array('resize' => array('width' => 150,'height'=>150)));


 echo '<img src="'.$src.'">';
 }
    ?>
                    <h4>Logo Upload</h4>
            <?php


           //$photo = new Photo;
$this->widget('ext.EAjaxUpload.EAjaxUpload',
array(
        'id'=>'uploadFile',
        'config'=>array(
               'action'=>Yii::app()->createUrl("/company/logoupload",array('id'=>$model->id)),
               'allowedExtensions'=>array("jpg", "jpeg", "gif", "png", "PNG", "JPG", "GIF", "JPEG"),//array("jpg","jpeg","gif","exe","mov" and etc...
               'sizeLimit'=>2*1024*1024,// maximum file size in bytes
            'onComplete'=>"js:function(){window.location.href='/req/company/update/id/$model->id' }",
            )));
        ?>

        </div>
 </div>




	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
