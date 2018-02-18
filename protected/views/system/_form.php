
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-form',
	'enableAjaxValidation'=>false,
   
    
)); 

?>
 	<div class="row ">
            <p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
 	</div>      
	<div class="row ">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row ">
		<select name="System[parent_id]" id="system_id">
			<?php
			$systems= System::model()->findAll('deleted=0 and parent_id=-1 and company_id='.$project->company_id);
?>
			<option value="-1">No Parent System</option>
			<?php
			foreach ($systems as $system){
$default = ($model->parent_id==$system->id)?'default selected':'';
			?>
					<option value="<?php echo $system->id?>" <?php echo $default?>><?php echo $system->name?></option>

			<?php } ?>
		</select>
	</div>


	<div class="row">
	Shared System?	<input type="checkbox" name="System[type]" value="1">

	</div>


<br /><br />
        
       

       
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
