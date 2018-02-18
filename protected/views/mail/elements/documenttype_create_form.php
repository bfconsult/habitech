<div class="row">
	<h4 class="row offset2" style="margin-bottom:30px"> Add New Document Type </h4>
	<?php echo $form->errorSummary($model,array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model, 'name', array('class'=>'span3')); ?>
	<?php echo $form->textAreaRow($model,'description',array('class'=>'span5', 'rows'=>5)); ?>
	<?php echo $form->hiddenField($model,'company_id',array('value'=>$company_id)); ?>
</div>
	