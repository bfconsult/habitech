
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

	<div class="row ">
		<select name="Config[system_id]" id="system_id">
			<?php
			$systems= $project->systems;

			foreach ($systems as $system){
				if ($system->deleted == 0){

				?>

				<option value="<?php echo $system->id?>"><?php echo $system->name?></option>
			<?php
				}
			}

		?>

		</select>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>


        
       

       
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
